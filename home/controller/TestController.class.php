<?php
!defined('ROOT_PATH') && exit;
include GLOBAL_PATH.'wb.func.php';
class TestController extends BaseController{

    public function __construct(){
        parent::__construct();
		error_reporting(7);
    }

	public function _index(){
		exit('hello world!');
	}
	
	public function _rebate(){
		$order_id=40;
		$res=orderRebate($order_id);
		var_dump($res);
	}
	
	public function _test(){
		echo 'hello!';
	}
	
	//测试sokcet
	public function _socket(){
		$pageuser=checkLogin();
		$data=[
			'user'=>[
				'id'=>$pageuser['id'],
				'nickname'=>$pageuser['nickname']
			]
		];
		$this->display($data);
	}

}

?>