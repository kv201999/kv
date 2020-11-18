<?php
!defined('ROOT_PATH') && exit;
class DefaultController extends BaseController{
	
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
	
	//新订单通知
	public function _notice(){
		$osn=$this->params['osn'];
		if(!$osn){
			$this->send(jsonReturn('-1','缺少参数'));
			return;
		}
		global $User;
		$mysql=new Mysql(0);
		$sql="select log.order_sn,log.out_order_sn,log.money,log.pay_status,log.notice_status,
		log.create_time,log.pay_time,log.muid,log.ma_account,log.ma_realname,
		mt.name as mtype_name,mt.type as mtype_type 
		from sk_order log left join sk_mtype mt on log.ptype=mt.id where log.order_sn='{$osn}'";
		$order=$mysql->fetchRow($sql);
		if(!$order){
			$this->send(jsonReturn('-1','不存在相应的订单'));
			return;
		}
		$client_arr=$User[$order['muid']];
		if(!$client_arr){
			$this->send(jsonReturn('-1','该码商不在线'));
			return;
		}
		$return_data=[
			'order'=>$this->parseOrder($order)
		];
		foreach($client_arr as $cv){
			$return_data['client_id']=$cv;
			$obj=$this->io->to($cv);
			send('Default/notice',$return_data,$obj);
		}
		$mysql->close();
		unset($mysql);
		$this->send(jsonReturn('1','发送通知成功'));
	}
	
	private function parseOrder($item){
		$cnf_pay_status=getConfig('cnf_pay_status');
		$cnf_notice_status=getConfig('cnf_notice_status');
		if($item['notice_status']){
			$item['notice_status_flag']=$cnf_notice_status[$item['notice_status']];
		}else{
			$item['notice_status_flag']='/';
		}
	
		$item['pay_status_flag']=$cnf_pay_status[$item['pay_status']];
		$item['create_time']=date('Y-m-d H:i',$item['create_time']);
		if($item['pay_time']){
			$item['pay_time']=date('Y-m-d H:i',$item['pay_time']);
		}else{
			$item['pay_time']='/';
		}
		$item['money']=floatval($item['money']);
		return $item;
	}
	
	public function _orderBind(){
		if(!$this->params['osn']){
			return;
		}
		global $Orders;
		$Orders[$this->params['osn']][]=$this->socket->id;
		send('Default/orderBindOk','绑定ok',$this->socket);
	}
	
	public function _orderNotice(){
		if(!$this->params['osn']){
			return;
		}
		global $Orders;
		$client_arr=$Orders[$this->params['osn']];
		if(!$client_arr){
			$this->send(jsonReturn('-1','该订单对应客户端已下线'));
			return;
		}
		$mysql=new Mysql(0);
		$order=$mysql->fetchRow("select * from sk_order where order_sn='{$this->params['osn']}'");
		if(!$order){
			$this->send(jsonReturn('-1','不存在相应的订单号'));
			return;
		}
		$mysql->close();
		unset($mysql);
		$cnf_pay_status=getConfig('cnf_pay_status');
		$return_data=[
			'order_sn'=>$order['order_sn'],
			'pay_status'=>$order['pay_status'],
			'pay_status_flag'=>$cnf_pay_status[$order['pay_status']]
		];
		foreach($client_arr as $cv){
			$return_data['client_id']=$cv;
			$obj=$this->io->to($cv);
			send('Default/orderNotice',$return_data,$obj);
		}
		$this->send(jsonReturn('1','通知成功'));
	}
	

}

?>