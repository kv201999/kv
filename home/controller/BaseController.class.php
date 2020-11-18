<?php
!defined('ROOT_PATH') && exit;
class BaseController{
	
	protected $mysql;
	protected $memcache;
	protected $pageSize=12;
	
	public function __construct(){
		$this->mysql=new Mysql(0);
		$this->memcache=new MyMemcache(0);
		$this->params=$this->_param();
		$_ENV['pageuser']=isLogin();
		if(isMobileReq()){
			$_ENV['mobile']=true;
		}else{
			$_ENV['mobile']=false;
		}
		$wc_arr=['Pay','Login'];
		if(!in_array(CONTROLLER_NAME,$wc_arr)){
			if($_ENV['pageuser']['gid']&&!in_array($_ENV['pageuser']['gid'],[91])){
				jReturn('-1','非码商用户无法访问');
				exit;
			}
		}
	}
	
	public function _index(){
		echo 'bindex';
	}
	
	protected function _param($key=''){
		$params=getParam($key);
		return $params;
	}

	protected function display(){
		$args=func_get_args();
		$tpl='';
		$data=[];
		if(count($args)<2){
			$tpl=CONTROLLER_NAME.'/'.ACTION_NAME.'.html';
			if($args[0]){
				$data=$args[0];
			}
		}else{
			$tpl=$args[0];
			$data=$args[1];
		}
		if(!$data['title']){
			$data['title']=getConfig('sys_name');
		}
		if(!$data['lang']){
			$data['lang']=$this->lang;
		}
		display($tpl,$data,$args[2]);
	}
	
	//获取短信验证码
	public function _getPhoneCode(){
		$phone = $this->params['phone'];
		if(!$phone){
			$user=isLogin();
			if(!$user){
				jReturn('-1','缺少手机号');
			}
			$phone=$user['phone'];
		}
		$stype = intval(getParam('stype'));
		if(!isPhone($phone)){
			jReturn('-1','手機號不正確');
		}
		if(!$stype){
			jReturn('-1','驗證碼類型不正確');
		}
		$data=array(
			'phone'=>$phone,
			'stype'=>$stype
		);
		$res=getPhoneCode($data);
		exit(json_encode($res));
	}
	
	//上传
	public function _upload(){
		checkLogin();
		$extmsg=getParam('extmsg');
		$upload=new UploadFile();
		$upload->savePath='./uploads/';
		$upload->maxSize=10240000;
		$info=$upload->upload();
		if(!$info){
			jReturn('-1',$upload->getErrorMsg());
		}else{
			$up_data=array();
			foreach($upload->getUploadFileInfo() as $file){
				$up_data[]=trim($file['savepath'].$file['savename'],'./');
			}
			$return_data=array('src'=>$up_data[0]);//'https://'.$_SERVER['HTTP_HOST'].'/'.
			jReturn('1','ok',$return_data);
		}
	}
	
	//base64图片上传
	public function _imgUpload(){
		checkLogin();
		$base64_image_content=$_POST['imgdata'];
		if(preg_match('/^(data:\s*image\/(\w+);base64,)/',$base64_image_content,$result)){
			$type='jpeg';
			$save_path='uploads/home/'.date('Ym').'/';
			$dir_path = ROOT_PATH.$save_path;
			if(!is_dir($dir_path)) {
				mkdir($dir_path,0755,true);
			}
			$filename=getRsn().".{$type}";
			$new_file = $dir_path.$filename;
			$save_res=file_put_contents($new_file, base64_decode(str_replace($result[1],'',$base64_image_content)));
			if(!$save_res){
				jReturn('-1','图片上传失败');
			}
		}else{
			jReturn('-1','参数错误');
		}
		jReturn('1','上传图片成功',['src'=>$save_path.$filename]);
	}
	/////////////////////////////控制器公共方法/////////////////////////////////
	
	//获取上级收款银行卡
	protected function getSkbank($topAgent=false){
		$pageuser=isLogin();
		$agent_id=0;
		$cnf_xyhk_model=getConfig('cnf_xyhk_model');
		if($cnf_xyhk_model=='是'){
			$up_users=getUpUser($pageuser['id'],true);
			foreach($up_users as $uv){
				if($uv['gid']==85){
					$agent_id=$uv['id'];
					if(!$topAgent){
						break;
					}
				}
			}
		}
		
		$where=" where (log.uid={$agent_id} or log.uid=0) and log.status=2";
		
		$sql="select log.*,bk.bank_name,u.account,u.nickname,u.gid from sk_bank log 
		left join cnf_bank bk on log.bank_id=bk.id 
		left join sys_user u on log.uid=u.id {$where}";
		$bank_arr=$this->mysql->fetchRows($sql);
		return $bank_arr;
	}
	
}
?>