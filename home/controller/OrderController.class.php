<?php
!defined('ROOT_PATH') && exit;
class OrderController extends BaseController{

    public function __construct(){
        parent::__construct();
    }

    public function _index(){
        $pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select id,is_online from sys_user where id={$pageuser['id']}");
		$cnf_user_online=getConfig('cnf_user_online');
		$user['is_online_flag']=$cnf_user_online[$user['is_online']];
		
		$is_msdbhk=0;
		$cnf_xyhk_model=getConfig('cnf_xyhk_model');
		if($cnf_xyhk_model=='是'){
			$cnf_mshk_signle=getConfig('cnf_mshk_signle');
			if($cnf_mshk_signle=='是'){
				$is_msdbhk=1;
			}
		}
		
		$bank_arr=$this->getSkbank(true);
		$bank=[];
		foreach($bank_arr as $bv){
			if($bv['gid']==85){
				$bank=$bv;
			}
		}
		if(!$bank){
			$bank=$bank_arr[0];
		}
		
        $data=[
			'title'=>'订单管理',
			'user'=>$user,
			'bank'=>$bank,
			'is_msdbhk'=>$is_msdbhk
        ];
        $this->display($data);
    }
	
	public function _order_list(){
		$pageuser=checkLogin();
		$pageSize=10;
		$params=$this->params;
		$params['s_pay_status']=intval($params['s_pay_status']);
		$params['page']=intval($params['page']);
		if(!$params['page']){
			$params['page']=1;
		}

		$where="where log.muid={$pageuser['id']} and log.pay_status<99";
		
		if($params['s_start_time']&&$params['s_end_time']&&$params['s_start_time']<=$params['s_end_time']){
			$s_start_time=strtotime($params['s_start_time'].' 00:00:01');
			$s_end_time=strtotime($params['s_end_time'].' 23:59:59');
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		//回款-已支付待回款
		if($params['s_hk_type']==1){
			$where.=" and (log.pay_status=9 and (log.hk_status=0 or log.hk_status=4))";
		}
		$where.=empty($params['s_pay_status'])?'':" and log.pay_status={$params['s_pay_status']}";
		$where.=empty($params['s_keyword'])?'':" and (log.order_sn='{$params['s_keyword']}' or log.out_order_sn='{$params['s_keyword']}' or log.ma_account='{$params['s_keyword']}')";

		$sql_cnt="select count(1) as cnt from sk_order log 
		left join sk_mtype mt on log.ptype=mt.id 
		{$where}";
		$count_item=$this->mysql->fetchRow($sql_cnt);
		$sql="select log.id,log.order_sn,log.out_order_sn,log.money,log.rmb,log.otcbuy,log.pay_status,log.js_status,
		log.hk_money,log.hk_status,log.notice_status,log.create_time,log.pay_time,log.ma_account,log.ma_realname,
		mt.name as mtype_name,mt.type as mtype_type 	
		from sk_order log 
		left join sk_mtype mt on log.ptype=mt.id 
		{$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		//echo $sql;exit;
		$cnf_pay_status=getConfig('cnf_pay_status');
		$cnf_notice_status=getConfig('cnf_notice_status');
		foreach($list as &$item){
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
				$item['pay_time']='--';
			}
			$item['money']=floatval($item['money']);
		}
		
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'limit'=>$pageSize,
			'page'=>$params['page']+1,
			'pages'=>ceil($count_item['cnt']/$pageSize)
		);
		jReturn('1','ok',$data);
	}
	
	//确认收款/超时补单
	public function _order_check(){
		
		/*
		$cnf_pay_status=getConfig('cnf_pay_status');
		$return_data=[
			'pay_time'=>date('Y-m-d H:i'),
			'pay_status'=>3,
			'pay_status_flag'=>$cnf_pay_status[3]
			
		];
		jReturn('1','Ceshi',$return_data);*/
		
		$pageuser=checkLogin();
		$order_sn=$this->params['osn'];
		$sql="select * from sk_order where order_sn='{$order_sn}' and pay_status<99";
		$order=$this->mysql->fetchRow($sql);
		if(!$order){
			jReturn('-1','不存在相应的订单');
		}
		if($order['muid']!=$pageuser['id']){
			jReturn('-1','您没有权限操作该订单');
		}
		if($order['pay_status']==9){
			jReturn('-1','该订单已确认，请不要重复确认');
		}
		$this->mysql->startTrans();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']} for update");
		$cnf_mscheck_needpwd=getConfig('cnf_mscheck_needpwd');
		if($cnf_mscheck_needpwd=='是'){
			$password2=getPassword($this->params['password2']);
			if($password2!=$user['password2']){
				jReturn('-1','二级密码不正确');
			}
		}
		if($order['pay_status']==3){
			if($user['sx_balance']<$order['money']){
				jReturn('-2','您的可用接单余额不足，无法补单');
			}
			$sys_user=[
				'sx_balance'=>$user['sx_balance']-$order['money']
			];
			$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
			$res2=balanceLog($user,3,16,-$order['money'],$order['id'],$order['order_sn'],$this->mysql);
		}elseif(in_array($order['pay_status'],[1,2])){
			if($user['fz_balance']<$order['money']){
				jReturn('-1','您的冻结余额不足，无法确认');
			}
			$sys_user=[
				'fz_balance'=>$user['fz_balance']-$order['money']
			];
			$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
			$res2=balanceLog($user,2,14,-$order['money'],$order['id'],$order['order_sn'],$this->mysql);
		}else{
			jReturn('-1','该订单当前状态不可操作');
		}
		$sk_order=[
			'check_id'=>$pageuser['id'],
			'pay_status'=>9,
			'pay_time'=>NOW_TIME,
			'pay_day'=>date('Ymd',NOW_TIME)
		];
		//如果是吱口令直接删除码
	
		if($order['ptype']==1){
			$sk_ma=[
				'status'=>99,
				'fz_time'=>NOW_TIME+90*86400
			];
			$res3=$this->mysql->update($sk_ma,"id={$order['ma_id']}",'sk_ma');
		}else{
			$res3=true;
		}
		$res3=true;
		$res4=$this->mysql->update($sk_order,"id={$order['id']}",'sk_order');
		if(!$res||!$res2||!$res3||!$res4){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		//发起回调给商户
		orderNotify($order['id'],$this->mysql);
        curl_get("https://api.telegram.org/bot1296230416:AAHAuPEccOk-KIPp7S3K7oFD6__m1zPEcgQ/sendMessage?chat_id=-386042225&text=订单已完成，请尽快打款给商户");
		//写入异步通知记录
		$cnf_notice=[
			'type'=>2,
			'fkey'=>$order['order_sn'],
			'create_time'=>NOW_TIME,
			'remark'=>'确认成功通知支付用户'
		];
		$this->mysql->insert($cnf_notice,'cnf_notice');
		
		//如果是超时补单下线该码
		if($order['pay_status']==3){
			if(!$order['is_test']){
				$sk_ma=[
					'status'=>1,
					'fz_time'=>NOW_TIME+86400*90
				];
				$this->mysql->update($sk_ma,"id={$order['ma_id']}",'sk_ma');
			}
		}elseif(in_array($order['pay_status'],[1,2])){
			if($order['is_test']){
				$sk_ma=[
					'fz_time'=>0
				];
				$this->mysql->update($sk_ma,"id={$order['ma_id']}",'sk_ma');	
			}
		}
		
		$cnf_pay_status=getConfig('cnf_pay_status');
		$return_data=[
			'pay_time'=>date('Y-m-d H:i',$sk_order['pay_time']),
			'pay_status'=>$sk_order['pay_status'],
			'pay_status_flag'=>$cnf_pay_status[$sk_order['pay_status']]
			
		];
		jReturn('1','操作成功',$return_data);
	}
	
	//提交订单回款
	public function _orderhk(){
		$pageuser=checkLogin();
		$params=$this->params;
		$bk_id=intval($params['bk_id']);
		$order_sn=$params['osn'];
		$this->mysql->startTrans();
		$sql="select * from sk_order where order_sn='{$order_sn}' for update";
		$order=$this->mysql->fetchRow($sql);
		if(!$order){
			jReturn('-1','不存在相应的订单');
		}
		if($order['muid']!=$pageuser['id']){
			jReturn('-1','您没有权限操作该订单');
		}
		if($order['pay_status']!=9){
			jReturn('-1','订单未确认支付无须回款');
		}
		if($order['js_status']!=2){
			jReturn('-1','订单未结算请稍后回款');
		}
		if($order['hk_status']!=0&&$order['hk_status']!=4){
			jReturn('-1','当前状态不可提交回款信息');
		}
		if(!$params['hk_remark']){
			jReturn('-1','请填写回款备注');
		}
		if(!$params['hk_cover']){
			jReturn('-1','请上传回款凭证');
		}
		
		$skbank=$this->mysql->fetchRow("select log.*,bk.bank_name from sk_bank log left join cnf_bank bk on log.bank_id=bk.id where log.id={$bk_id}");
		if(!$skbank){
			jReturn('-1','不存在该收款账户');
		}
		$money=$order['hk_money'];
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']} for update");
		if($user['kb_balance']<$money){
			jReturn('-1','您的应回款不足');
		}
		$sys_user=[
			'kb_balance'=>$user['kb_balance']-$money
		];
		$sk_agent_hklog=[
			'aid'=>intval($skbank['uid']),
			'uid'=>$pageuser['id'],
			'need_recover'=>1,
			'money'=>$money,
			'ori_balance'=>$user['kb_balance'],
			'new_balance'=>$sys_user['kb_balance'],
			'order_sn'=>'H'.date('YmdHis').mt_rand(11111,99999),
			'skbank_id'=>$bk_id,
			'create_time'=>NOW_TIME,
			'update_time'=>NOW_TIME,
			'status'=>2,
			'tj_time'=>NOW_TIME,
			'oid'=>$order['id'],
			'osn'=>$order['order_sn'],
			'remark'=>$params['hk_remark'],
			'pay_account'=>$params['hk_account'],
			'pay_realname'=>$params['hk_realname'],
			'cover'=>$params['hk_cover'],
			'banners'=>json_encode([$params['hk_cover']]),
			'skbank'=>json_encode($skbank,256)
		];
		$res=$this->mysql->insert($sk_agent_hklog,'sk_agent_hklog');
		$res2=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		$res3=balanceLog($user,4,20,-$money,$order['id'],$order['order_sn'],$this->mysql);
		$sk_order=[
			'hk_status'=>1,
			'hk_time'=>NOW_TIME
		];
		$res4=$this->mysql->update($sk_order,"id={$order['id']}",'sk_order');
		if(!$res||!$res2||!$res3||!$res4){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		jReturn('1','提交成功');
	}

}

?>