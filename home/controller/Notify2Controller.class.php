<?php
!defined('ROOT_PATH') && exit;
class Notify2Controller extends BaseController{

    public function __construct(){
        parent::__construct();
    }

	public function _index(){
		$params=$this->params;
		$maid=intval($params['maid']);
		if(!$maid){
			jReturn('-1','缺少收款码参数');
		}
		$str=file_get_contents('php://input');
		file_put_contents(ROOT_PATH.'logs/notify.txt',$str."\n\n",FILE_APPEND);
		$params2=json_decode($str,true);
		if(!$params2){
			jReturn('-1','回调数据异常');
		}
		$skma=$this->mysql->fetchRow("select * from sk_ma where id={$maid}");
		if(!$skma){
			jReturn('-1','不存在相应的收款码');
		}else{
			if(!$skma['apikey']){
				jReturn('-1','收款码未生成签名密钥');
			}
		}
		$this->mysql->startTrans();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$skma['uid']} for update");
		if(!$user){
			jReturn('-1','码商不存在');
		}else{
			if($user['status']!=2){
				jReturn('-1','码商已被禁用');
			}
		}
		
		//校验签名
		$pdata=[
			'deviceid'=>$params2['deviceid'],
			'type'=>$params2['type'],
			'time'=>$params2['time'],
			'content'=>$params2['content'],
			'money'=>$params2['money'],
			'title'=>$params2['title']
		];
		ksort($pdata);
		$sign_str=urldecode(http_build_query($pdata))."&&key={$skma['apikey']}";
		$sign=md5($sign_str);
		if($params2['sign']!=$sign){
			file_put_contents(ROOT_PATH.'logs/notify_m.txt',$sign.'||'.$sign_str."||签名校验失败\n\n",FILE_APPEND);
			jReturn('-1','签名校验失败');
		}
		
		if($params['type']=='sms'){
			$money=parseMoney($params2);
		}else{
			$reg='/(\d{1,}(\.\d+)?)/is';
			preg_match_all($reg,$params2['content'],$resultArr);
			$number_arr=$resultArr[0];
			$money=floatval($number_arr[count($number_arr)-1]);	
		}

		if($money<0.01){
			file_put_contents(ROOT_PATH.'logs/notify_m.txt',var_export($params2,true)."\n\n",FILE_APPEND);
			jReturn('-1','匹配金额失败');
		}
		
		//$money=$params2['money'];
		
		$sql="select log.id from sk_order log where log.ma_id={$skma['id']} and log.money='{$money}' and log.pay_status<3";
		$item=$this->mysql->fetchRow($sql);
		if(!$item){
			jReturn('-1','不存在相应订单或订单已完结');
		}
		$order=$this->mysql->fetchRow("select * from sk_order where id={$item['id']} for update");
		if($order['pay_status']==3){
			if($user['sx_balance']<$order['money']){
				jReturn('-1','码商的接单余额不足，无法补单');
			}
			$sys_user=[
				'sx_balance'=>$user['sx_balance']-$order['money']
			];
			$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
			$res2=balanceLog($user,3,16,-$order['money'],$order['id'],$order['order_sn'],$this->mysql);
		}elseif($order['pay_status']==1||$order['pay_status']==2){
			if($user['fz_balance']<$order['money']){
				jReturn('-1','码商冻结的金额不足，无法确认');
			}
			$sys_user=[
				'fz_balance'=>$user['fz_balance']-$order['money']
			];
			$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
			$res2=balanceLog($user,2,14,-$order['money'],$order['id'],$order['order_sn'],$this->mysql);
		}else{
			jReturn('-1','该订单当前状态不可再确认');
		}
		$sk_order=[
			'check_id'=>'-1',
			'pay_status'=>9,
			'pay_time'=>NOW_TIME,
			'pay_day'=>date('Ymd',NOW_TIME)
		];
		$res3=$this->mysql->update($sk_order,"id={$order['id']}",'sk_order');
		if(!$res||!$res2||!$res3){
			$this->mysql->rollback();
			jReturn('-1',"确认失败:{$res}-{$res2}-{$res3}");
		}
		$this->mysql->commit();
		//发起回调给商户
		orderNotify($order['id'],$this->mysql);
		
		//写入异步通知记录
		$cnf_notice=[
			'type'=>2,
			'fkey'=>$order['order_sn'],
			'create_time'=>NOW_TIME,
			'remark'=>'支付成功通知支付用户'
		];
		$this->mysql->insert($cnf_notice,'cnf_notice');

		jReturn('1','success');
	}

}

?>