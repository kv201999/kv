<?php
//注册登录模块
!defined('ROOT_PATH') && exit;
class LoginController extends BaseController{
	
	protected $backurl='';

	public function __construct(){

		parent::__construct();

		if($_REQUEST['callback']){
			$this->backurl=$_REQUEST['callback'];
		}else{
			if($_SESSION['backurl']){
				$this->backurl=$_SESSION['backurl'];
			}else{
				$this->backurl='/'.APP_URL;
			}
		}
	}

	//检测如果已经登录的直接跳走
	private function checkLogin(){
		$pageuser=isLogin();
		if($pageuser){
			header('Location:'.$this->backurl);
			exit;
		}
		return $pageuser;
	}
	
	//登录界面
	public function _index(){
		$this->checkLogin();
		$data=[
			'title'=>'登录'
		];
		display('Login/login.html',$data);
	}

	//登录操作
	public function _loginAct(){
		$params=$this->params;
		$imgcode=strtolower($params['imgcode']);
		$phone=$params['phone'];
		$password=$params['password'];
		if(!$phone){
			jReturn('-1','请填写账号');
		}

		
		if(!$imgcode){
			jReturn('-1','请填写图形验证码');
		}else{
			if($imgcode!=$_SESSION['varify_code']){
				unset($_SESSION['varify_code']);
				jReturn('-1','图形验证码错误');
			}
		}

		$user=$this->mysql->fetchRow("select * from sys_user where (phone='{$phone}' or account='{$phone}') and status>0");
		if(!$user){
			jReturn('-1','账号或密码错误');
		}
		if($user['is_google']){
			if(!$this->params['gcode']){
				jReturn('-1','请填写谷歌验证码');
			}
			include GLOBAL_PATH.'library/GoogleAuthenticator.php';
			$ga=new PHPGangsta_GoogleAuthenticator();
			$checkResult=$ga->verifyCode($user['google_secret'],$this->params['gcode'],2);
			if(!$checkResult){
				jReturn('-1','谷歌验证失败');
			}
		}
		
		$password=getPassword($password);
		if($password!=$user['password']){
			jReturn('-1','账号或密码不正确');
		}

		if($user['status']!=2){
			if($user['status']==1){
				if(NOW_TIME>$user['forbid_time']){
					$f_sys_user=['status'=>2];
					$this->mysql->update($f_sys_user,"id={$user['id']}",'sys_user');
					$user['status']=$f_sys_user['status'];
				}else{
					if($user['forbid_msg']){
						jReturn('-2','该账号被禁用：'.$user['forbid_msg']);
					}else{
						jReturn('-1','该账号被禁用暂时无法登录');
					}
				}
			}else{
				jReturn('-1','该账号不存在');
			}
		}
		if(!in_array($user['gid'],[91])){
			jReturn('-1','非码商账号登录失败');
		}
		
		//判断马上是否有设置分成比例
		$user['fy_rate']=json_decode($user['fy_rate'],true);
		if(!$user['fy_rate']){
			jReturn('-1','账号未设置分成比例激活');
		}
		
		//清理其他token
		//clearToken($user['id']);
		
		$sys_user_token=[
			'uid'=>$user['id'],
			'account'=>$user['account'],
			'token'=>md5(getRsn()),
			'create_time'=>NOW_TIME,
			'update_time'=>NOW_TIME
		];
		$res=$this->mysql->insert($sys_user_token,'sys_user_token');
		if(!$res){
			jReturn('-1','生成token失败');
		}
		$sys_user=[
			'login_time'=>NOW_TIME,
			'login_ip'=>CLIENT_IP
		];
		if(!$user['apikey']){
			$sys_user['apikey']=sha1(md5($user['id'].'_'.$user['account'].'_'.time().'_'.SYS_KEY));
			$sys_user['apiauto']=1;
		}
		$res2=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if(!$res2){
			jReturn('-1','登录失败');
		}
		
		//写入cookie
		$cookie_arr=[
			'account'=>$user['account'],
			'token'=>$sys_user_token['token'],
			'time'=>NOW_TIME
		];
		$cookie_arr['sign']=sysSign($cookie_arr);
		$cookie=json_encode($cookie_arr,256);
		setcookie($_ENV['CONFIG']['SESSION']['NAME'],$cookie,$_ENV['CONFIG']['SESSION']['EXPIRE'],'/','',false,true);

		$return_data=[
			'account'=>$user['account'],
			'token'=>$sys_user_token['token'],
			'url'=>'/?f=login'
		];
		jReturn('1','登录成功',$return_data);
	}

	//微信授权
	public function _wechat(){
		$state=$this->params['state'];
		$code=$this->params['code'];
		if(!$code){
			exit('oauth error.');
		}
		$wx_user=getWxUser($code,'userinfo');
		if(!$wx_user['openid']){
			exit('oauth fail.');
		}
		$headimgurl=$this->downloadHead(array('openid'=>$wx_user['openid'],'headimgurl'=>$wx_user['headimgurl']));
		if(!$headimgurl){
			$headimgurl=$wx_user['headimgurl'];
		}
		$data=array(
			'openid'=>$wx_user['openid'],
			'unionid'=>$wx_user['unionid'],
			'nickname'=>$wx_user['nickname'],
			'sex'=>$wx_user['sex'],
			'country'=>$wx_user['country'],
			'province'=>$wx_user['province'],
			'city'=>$wx_user['city'],
			'subscribe'=>$wx_user['subscribe'],
			'subscribe_time'=>$wx_user['subscribe_time'],
			'subscribe_scene'=>$wx_user['subscribe_scene'],
			'headimgurl'=>$headimgurl,
			'update_time'=>NOW_TIME
		);
		$db_wx_user=$this->mysql->fetchRow("select * from sys_user_wechat where openid='{$wx_user['openid']}'");
		if($db_wx_user){
			$res=$this->mysql->update($data,"id={$db_wx_user['id']}",'sys_user_wechat');
			$db_wx_user=array_merge($db_wx_user,$data);//合并最新数据
		}else{
			$res=$this->mysql->insert($data,'sys_user_wechat');
		}
		if($res===false){
			exit('update userinfo fail');
		}
		$_SESSION['user']=$data;
		header("Location:".APP_URL.'?c=Login');//授权结束之后只跳转回登录首页
	}

	//下载头像
	protected function downloadHead($user){
		$file_path=ROOT_PATH.'uploads/head/'.$user['openid'].'.jpg';
		if(file_exists($file_path)){
			return 'uploads/head/'.$user['openid'].'.jpg';
		}
		$result=curl_get($user['headimgurl']);
		$con=$result['output'];
		if(!$con){
			return false;
		}
		if(!is_dir(dirname($file_path))){
			mkdir(dirname($file_path),0755,true);
		}
		file_put_contents($file_path,$con);
		return 'uploads/head/'.$user['openid'].'.jpg';
	}

	//////////////////////////////////////////////////////////////////////

	//注册界面
	public function _register(){
		$this->checkLogin();
		$data=[
			'title'=>'注册'
		];
		display('Login/register.html',$data);
	}

	public function _registerAct(){
		$params=$this->params;
		
		$cnf_regms_open=getConfig('cnf_regms_open');
		if($cnf_regms_open!='是'){
			jReturn('-1','当前注册暂未开放');
		}
		
		if(!$params['phone']){
			jReturn('-1','请填写手机账号');
		}else{
			if(!isPhone($params['phone'])){
				jReturn('-1','请填写正确的手机号');
			}
			/*
			$params['username']=strtolower($params['username']);
			if(!preg_match("/^[a-zA-Z0-9_]{6,16}/i",$params['username'])){
				jReturn('-1','账号必须是6-16位的字母数字下划线组合');
			}
			*/
		}
		/*
		if(!$params['imgcode']){
			jReturn('-1','请填写图形验证码');
		}else{
			if($params['imgcode']!=$_SESSION['varify_code']){
				unset($_SESSION['varify_code']);
				jReturn('-1','图形验证码错误');
			}
		}*/
//		if(!$params['smscode']){
//			jReturn('-1','请填写短信验证码');
//		}
//		$checkSms=checkPhoneCode(['stype'=>1,'phone'=>$params['phone'],'code'=>$params['smscode']]);
//		if($checkSms['code']!=1){
//			exit(json_encode($checkSms));
//		}
		if(!$params['password']){
			jReturn('-1','请填写登录密码');
		}
		$check_puser=[];
		if($params['icode']){
			$check_puser=$this->mysql->fetchRow("select * from sys_user where icode='{$params['icode']}'");
			if(!$check_puser){
				jReturn('-1','邀请码不正确');
			}
			if($check_puser['gid']!=91){
				jReturn('-1','邀请人不是码商');
			}
		}else{
			jReturn('-1','请填写邀请码');
		}
		$user_phone=$this->mysql->fetchRow("select id from sys_user where account='{$params['phone']}'");
		if($user_phone){
			jReturn('-1','该账号已被注册');
		}
		$ad_reg_give_money=intval(getConfig('ad_reg_give_money'));
		if($ad_reg_give_money<0){
			$ad_reg_give_money=0;
		}
		$user_data=[
			'gid'=>91,
			'icode'=>genIcode($this->mysql),
			'password'=>getPassword($params['password']),
			'password2'=>getPassword($params['password']),
			'balance'=>$ad_reg_give_money,
			'pid'=>$check_puser['id'],
			'nickname'=>'nk'.substr(getRsn(),0,6),
			'phone'=>$params['phone'],
			'account'=>$params['phone'],
			'openid'=>$params['phone'],
			'unionid'=>$params['phone'],
			'reg_time'=>NOW_TIME,
			'reg_ip'=>CLIENT_IP,
			'headimgurl'=>'public/images/head.png'
		];
		$res=$this->mysql->insert($user_data,'sys_user');
		if(!$res){
			jReturn('-1','注册失败');
		}
		$user_data['id']=$res;
		if($ad_reg_give_money>0){
			balanceLog($user_data['id'],8,$ad_reg_give_money,'',1,$this->mysql,$user_data);
		}
		$return_data=[
			'account'=>$user_data['account']
		];
		jReturn('1','注册成功',$return_data);
	}

	//////////////////////////////////////////////////////////////////////

	//找回密码
	public function _forget(){
		$this->checkLogin();
		$data=[
			'title'=>'找回密码'
		];
		display('Login/forget.html',$data);
	}

	public function _forgetAct(){
		$params=$this->params;
		if(!isPhone($params['phone'])){
			jReturn('-1','请填写正确的手机号');
		}
		/*
		if(!$params['imgcode']){
			jReturn('-1','请填写图形验证码');
		}else{
			if($params['imgcode']!=$_SESSION['varify_code']){
				$_SESSION['varify_code']=null;
				jReturn('-1','图形验证码不正确');
			}
		}*/
		if(!$params['smscode']){
			jRetunr('-1','请填写短信验证码');
		}
		if(!$params['password']){
			jReturn('-1','请填写新登录密码');
		}
		$checkSms=checkPhoneCode(['stype'=>3,'phone'=>$params['phone'],'code'=>$params['smscode']]);
		if($checkSms['code']!=1){
			exit(json_encode($checkSms));
		}
		$user_phone=$this->mysql->fetchRow("select id,account from sys_user where account='{$params['phone']}'");
		if(!$user_phone['id']){
			jReturn('-1','该账号未注册');
		}
		$user_data=[
			'password'=>getPassword($params['password'])
		];
		$res=$this->mysql->update($user_data,"id={$user_phone['id']}",'sys_user');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->delete("uid={$user_phone['id']}",'sys_user_token');
		jReturn('1','成功找回',['account'=>$user_phone['account']]);
	}

	//////////////////////////////////////////////////////////////////////

	//获取用户信息
	public function _userinfo(){
		$pageuser=isLogin();
		if(!$pageuser){
			jReturn('-1','请先登录');
		}
		$sys_group=getConfig('sys_group');
		$user_data=[
			//'id'=>$user['id'],
			'gid'=>$pageuser['gid'],
			'gnmae'=>$sys_group[$user['gid']],
			'account'=>$pageuser['account'],
			'unionid'=>$pageuser['unionid'],
			'openid'=>$pageuser['openid'],
			'icode'=>$pageuser['icode'],
			'phone'=>$pageuser['phone'],
			'balance'=>$pageuser['balance'],
			'fz_balance'=>$pageuser['fz_balance'],
			'phone_flag'=>substr($pageuser['phone'],0,3).'***'.substr($pageuser['phone'],8),
			'nickname'=>$pageuser['nickname'],
			'realname'=>$pageuser['realname'],
			'headimgurl'=>$pageuser['headimgurl'],
			'login_ip'=>$pageuser['login_ip'],
			'login_time'=>date('Y-m-d H:i:s',$pageuser['login_time'])
		];
		jReturn('1','ok',$user_data);
	}

	//////////////////////////////////////////////////////////////////////
	
	//退出登录
	public function _logoutAct(){
		doLogout();
		if(isAjax()){
			jReturn('1','退出成功');
		}else{
			header('Location:/'.APP_URL);
		}
	}
	
	//生成验证码
	public function _varify_code() {
		varifyCode(4,24,100,40);
	}

}

?>