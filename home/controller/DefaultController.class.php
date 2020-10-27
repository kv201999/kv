<?php
!defined('ROOT_PATH') && exit;
class DefaultController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function _index(){
		$pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
        $user['balance']=floatval($user['balance']);
        $user['sx_balance']=floatval($user['sx_balance']);
        $user['fz_balance']=floatval($user['fz_balance']);
		$cnf_user_offline_time=intval(getConfig('cnf_user_offline_time'));
		$d_time=$user['online_time']+$cnf_user_offline_time-NOW_TIME;
		if($d_time<0){
			$d_time=0;
		}
		
		$order_sql="select count(1) as cnt,sum(log.money) as sum_money from sk_order log where log.muid={$user['id']}";
		$oitem=$this->mysql->fetchRow($order_sql);
		$fitem=$this->mysql->fetchRow($order_sql." and log.pay_status=9");
		
		$y_sql="select count(1) as cnt,sum(money) as sum_money from sk_yong where uid={$user['id']} and type=1";
		$yitem=$this->mysql->fetchRow($y_sql);
		
		if(!$oitem['cnt']){
			$forder_rate=0;
		}else{
			$forder_rate=floatval(number_format(($fitem['cnt']/$oitem['cnt'])*100,2));
		}
		
		//前面排队人数
		$queue_num=$this->mysql->fetchResult("select count(1) from sys_user where is_online=1 and queue_time<{$user['queue_time']}");
		$total_num=$this->mysql->fetchResult("select count(1) from sys_user where is_online=1");
		
		$data=[
			'title'=>'抢单',
			'user'=>$user,
			'order_num'=>intval($oitem['cnt']),
			'order_money'=>floatval($oitem['sum_money']),
			'forder_num'=>intval($fitem['cnt']),
			'forder_money'=>floatval($fitem['sum_money']),
			'forder_rate'=>$forder_rate,
			'yong_money'=>floatval($yitem['sum_money']),
			'd_time'=>$d_time,
			'queue_num'=>intval($queue_num),
			'total_num'=>intval($total_num),
			'notify_url'=>$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/?c=Notify&mid='.$user['id']
		];
		$this->display($data);
	}
	
}

?>