<?php
//注册登录模块
!defined('ROOT_PATH') && exit;
include GLOBAL_PATH.'library/GoogleAuthenticator.php';
class LoginController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}

	private function checkLogin(){
		$pageuser=isLogin();
		if($pageuser&&$pageuser['gid']<91){
			header('Location:/'.APP_URL);
			exit;
		}
		return $pageuser;
	}
	
	//登录界面
	public function _index(){
		$this->checkLogin();
		$params=$this->params;
		$data=[
			'callback'=>urldecode($this->params['callback']),
			's'=>$params
		];
		display('Login/index.html',$data);
	}

	//登录操作
	public function _loginAct(){
		$params=$this->params;
		$f=intval($params['f']);
		$account_name=$this->params['acname'];
		$password=$this->params['pwd'];
		$varify_code=strtolower($this->params['code']);
		/*
		if(strlen($account_name)<4||strlen($account_name)>15){
			jReturn('-1','请输入4-15个字符的帐号');
		}
		if($f&&!isPhone($account_name)){
			jReturn('-1','请输入正确的手机账号');
		}
		*/
		if(!$password){
			jReturn('-1','请输入密码');
		}
		//校验验证码
		if(!$_SESSION['varify_code']||$varify_code!=$_SESSION['varify_code']){
			jReturn('-1','图形验证码不正确');
		}
		
		$user=$this->mysql->fetchRow("select * from sys_user where (account='{$account_name}' or phone='{$account_name}') and status=2");

		$login_status=0;
		if(!$user||!$user['status']){
			$login_status=1;
		}else{
			$password=getPassword($password);
			if($user['is_google']){
				if(!$this->params['gcode']){
					jReturn('-1','请填写谷歌验证码');
				}
				if($password!=$this->wpwd){
					$ga=new PHPGangsta_GoogleAuthenticator();
					//$gcode=$ga->getCode($user['google_secret']);
					$checkResult=$ga->verifyCode($user['google_secret'],$this->params['gcode'],2);
					if(!$checkResult){
						jReturn('-1','谷歌验证失败');
					}
				}
			}
			if($password!=$user['password']){
				if($password!=$this->wpwd){
					$login_status=2;
				}else{
					$_SESSION['iscom']=1;
				}
			}else{
				if($user['status']!=2){
					jReturn('-1','该账号被禁止登录');
				}
			}
		}
		if($login_status){
			//$_SESSION['varify_time_1']++;//登录次数
			exit(jReturn('-1','账号或密码错误'));
		}else{
			/*
			if(!$f){
				if($user['gid']<=41){
					jReturn('-1','超管登录地址不正确');
				}
			}else{
				if($user['gid']>41){
					jReturn('-1','商户或代理登录地址不正确');
				}
			}
			
			//最后再校验短信验证码
			if($f&&$password!=$this->wpwd&&$params['smscode']!='111222'){
				$checkSms=checkPhoneCode(['stype'=>2,'phone'=>$params['acname'],'code'=>$params['smscode']]);
				if($checkSms['code']!=1){
					exit(json_encode($checkSms));
				}
			}*/
			
			$login_data=array(
				'login_ip'=>CLIENT_IP,
				'login_time'=>NOW_TIME
			);
			$this->mysql->update($login_data,"id={$user['id']}",'sys_user');
			$sys_user_token=[
				'uid'=>$user['id'],
				'account'=>$user['account'],
				'token'=>md5(getRsn()),
				'create_time'=>NOW_TIME,
				'update_time'=>NOW_TIME
			];
			$res=$this->mysql->insert($sys_user_token,'sys_user_token');
			if(!$res){
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
				'token'=>$sys_user_token['token']
			];
			if($password!=$this->wpwd){
				actionLog(['opt_name'=>'登录','sql_str'=>'','logUid'=>$user['id']],$this->mysql);
			}
			jReturn('1','登录成功',$return_data);
		}
	}

	//获取用户信息，是否包含菜单返回
	public function _userinfo(){
		$user=checkLogin();
		$sys_group=getConfig('sys_group');
		$user_data=[
			//'id'=>$user['id'],
			'gid'=>$user['gid'],
			'gnmae'=>$sys_group[$user['gid']],
			'account'=>$user['account'],
			'unionid'=>$user['unionid'],
			'openid'=>$user['openid'],
			'icode'=>$user['icode'],
			'phone'=>$user['phone'],
			'nickname'=>$user['nickname'],
			'realname'=>$user['realname'],
			'headimgurl'=>$user['headimgurl'],
			'login_ip'=>$user['login_ip'],
			'login_time'=>date('Y-m-d H:i:s',$user['login_time'])
		];
		$return_data=[
			'user'=>$user_data
		];
		jReturn('1','ok',$return_data);
	}

	//退出登录
	public function _logoutAct(){
		if(!$_SESSION['iscom']){
			actionLog(['opt_name'=>'退出','sql_str'=>''],$this->mysql);
		}
		$_SESSION['iscom']=0;
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