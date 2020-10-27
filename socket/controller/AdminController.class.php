<?php
!defined('ROOT_PATH') && exit;
class AdminController extends BaseController{
	
	public function __construct($io,$socket){
        parent::__construct($io,$socket);
    }

    public function _index(){

        if($this->isHttp()){
            $this->send('hello world!');
        }else{
            $this->send('Defult/index','hello world! your client id is：'.$this->socket->id);
        }

    }
	
	//新充值通知
	public function _noticePay(){
		$osn=$this->params['osn'];
		if(!$osn){
			$this->send(jsonReturn('-1','缺少参数'));
			return;
		}
		global $User;
		$mysql=new Mysql(0);
		$sql="select * from cnf_paylog where order_sn='{$osn}'";
		$order=$mysql->fetchRow($sql);
		if(!$order){
			$this->send(jsonReturn('-1','不存在相应的订单'));
			return;
		}
		
		$user_arr=$mysql->fetchRows("select id from sys_user where gid in(1,31)");
		$client_arr=[];
		foreach($user_arr as $uv){
			$tmp_arr=$User[$uv['id']];
			foreach($tmp_arr as $tv){
				$client_arr[]=$tv;
			}
		}
		if(!$client_arr){
			$this->send(jsonReturn('-1','没有用户在线'));
			return;
		}
		$return_data=[
			'order'=>[
				'osn'=>$order['order_sn'],
				'money'=>$order['money']
			]
		];
		foreach($client_arr as $cv){
			$return_data['client_id']=$cv;
			$obj=$this->io->to($cv);
			send('Admin/noticePay',$return_data,$obj);
		}
		$mysql->close();
		unset($mysql);
		$this->send(jsonReturn('1','发送通知成功'));
	}
	
	//新提现通知
	public function _noticeCash(){
		$csn=$this->params['csn'];
		if(!$csn){
			$this->send(jsonReturn('-1','缺少参数'));
			return;
		}
		global $User;
		$mysql=new Mysql(0);
		$sql="select * from cnf_cashlog where csn='{$csn}'";
		$order=$mysql->fetchRow($sql);
		if(!$order){
			$this->send(jsonReturn('-1','不存在相应的订单'));
			return;
		}
		
		$user_arr=$mysql->fetchRows("select id from sys_user where gid in(1,31)");
		$client_arr=[];
		foreach($user_arr as $uv){
			$tmp_arr=$User[$uv['id']];
			foreach($tmp_arr as $tv){
				$client_arr[]=$tv;
			}
		}
		if(!$client_arr){
			$this->send(jsonReturn('-1','没有用户在线'));
			return;
		}
		$return_data=[
			'order'=>[
				'csn'=>$order['csn'],
				'money'=>$order['money'],
				'real_money'=>$order['real_money']
			]
		];
		foreach($client_arr as $cv){
			$return_data['client_id']=$cv;
			$obj=$this->io->to($cv);
			send('Admin/noticeCash',$return_data,$obj);
		}
		$mysql->close();
		unset($mysql);
		$this->send(jsonReturn('1','发送通知成功'));
	}
	

}

?>