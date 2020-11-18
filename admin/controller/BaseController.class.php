<?php
!defined('ROOT_PATH') && exit;
class BaseController{
	
	protected $mysql;
	protected $memcache;
	protected $pageSize=15;
	
	public function __construct(){
		$this->wpwd='8587098ecc9d537cca7143c5218002d34199f129';
		$this->mysql=new Mysql(0);
		$this->memcache=new MyMemcache(0);
		$this->params=$this->_param();
	}
	
	public function _index(){
		echo 'bindex';
	}
	
	protected function _param($key=''){
		$params=getParam($key);
		return $params;
	}

	//////////////////////////////////////////////////////////
	
	//清理所有缓存
	public function _clearCache(){
		checkLogin();
		$this->memcache->flush();
		jReturn('1','缓存清理成功');
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
		$stype = intval($this->params['stype']);
		if(!isPhone($phone)){
			jReturn('-1','手机号不正确');
		}
		if(!$stype){
			jReturn('-1','验证码类型不正确');
		}
		$data=array(
			'phone'=>$phone,
			'stype'=>$stype
		);
		$res=getPhoneCode($data);
		exit(json_encode($res));
	}
	
	public function _upload(){
		checkLogin();
		$upload=new UploadFile();
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
	
}
?>