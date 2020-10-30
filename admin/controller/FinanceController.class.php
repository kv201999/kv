<?php
!defined('ROOT_PATH') && exit;
class FinanceController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	
	//#############################收款银行卡#############################
	public function _bank(){
		$pageuser=checkPower();
		$province_arr=$this->mysql->fetchRows("select * from cnf_pc where pid=0");
		$bank_arr=$this->mysql->fetchRows("select * from cnf_bank");
		$data=array(
			'user'=>$pageuser,
			'province_arr'=>$province_arr,
			'bank_arr'=>$bank_arr
		);
		display('Finance/bank.html',$data);
	}
	
	public function _bank_list(){
		$pageuser=checkLogin();
		$params=$this->params;
		$params['s_status']=intval($params['s_status']);
		$params['s_bank_id']=intval($params['s_bank_id']);
		$where="where log.status<99";
		if($pageuser['gid']!=1){
			$where.=" and log.uid={$pageuser['id']}";
		}
		$where.=empty($params['s_status'])?'':" and log.status={$params['s_status']}";
		$where.=empty($params['s_bank_id'])?'':" and log.bank_id={$params['s_bank_id']}";
		$where.=empty($params['s_keyword'])?'':" and (u.account='{$params['s_keyword']}' or log.bank_account like '%{$params['s_keyword']}%' or log.bank_realname like '%{$params['s_keyword']}%')";
		$count_sql="select count(1) 
		from sk_bank log 
		left join sys_user u on log.uid=u.id 
		left join cnf_bank bk on log.bank_id=bk.id 
		left join cnf_pc pc on log.province_id=pc.id 
		left join cnf_pc pc2 on log.city_id=pc2.id 
		{$where}";
		$count=$this->mysql->fetchResult($count_sql);
		$sql="select log.*,u.account,u.nickname,pc.cname as province_name,pc2.cname as city_name,bk.bank_name 
		from sk_bank log 
		left join sys_user u on log.uid=u.id 
		left join cnf_bank bk on log.bank_id=bk.id 
		left join cnf_pc pc on log.province_id=pc.id 
		left join cnf_pc pc2 on log.city_id=pc2.id 
		{$where} order by log.sort desc,log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		$cnf_skbank_status=getConfig('cnf_skbank_status');
		$now_day=date('Ymd');
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i',$item['create_time']);
			$item['status_flag']=$cnf_skbank_status[$item['status']];
			$pay_sql="select sum(money) as money from cnf_paylog where skbank_id={$item['id']} and FROM_UNIXTIME(create_time,'%Y%m%d')={$now_day} and pay_status=3";
			$pay_item=$this->mysql->fetchRow($pay_sql);
			$item['today_money']=floatval($pay_item['money']);
			
			$item['max_tmoney']=floatval($item['max_tmoney']);
			$item['max_nmoney']=floatval($item['max_nmoney']);
		}
		$data=array(
			'list'=>$list,
			'count'=>$count,
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _bank_update(){
		$pageuser=checkPower();
		$params=$this->params;
		$params['province_id']=intval($params['province_id']);
		$params['city_id']=intval($params['city_id']);
		$params['bank_id']=intval($params['bank_id']);
		$params['sort']=intval($params['sort']);
		$params['status']=intval($params['status']);
		$params['max_tmoney']=floatval($params['max_tmoney']);
		$item_id=intval($params['item_id']);
		
		if($params['account']){
			$user=$this->mysql->fetchRow("select * from sys_user where account='{$params['account']}'");
			if($user['gid']!=85){
				jReturn('-1','所属账号不是码商代理');
			}
			$uid=$user['id'];
		}else{
			$uid=0;
		}
		
//		if($params['province_id']<1||$params['city_id']<1){
//			jReturn('-1','请选择银行卡开户所属省市');
//		}
//		if(!$params['bank_id']){
//			jReturn('-1','请选择开户行');
//		}else{
//			$check_bank=$this->mysql->fetchRow("select * from cnf_bank where id={$params['bank_id']}");
//			if(!$check_bank){
//				jReturn('-1','不存在相应的开户行');
//			}
//		}
		if(!$params['bank_account']){
			jReturn('-1','请填USDT地址');
		}
		if(!$params['bank_realname']){
			jReturn('-1','请填写备注');
		}
//		if($params['max_tmoney']<0){
//			jReturn('-1','累计最大收款额度不正确');
//		}
//		if(!$params['cover']){
//			jReturn('-1','请上传图标');
//		}
		$sk_bank=array(
			'uid'=>$uid,
			'province_id'=>$params['province_id'],
			'city_id'=>$params['city_id'],
			'bank_id'=>$params['bank_id'],
			'branch_name'=>$params['branch_name'],
			'bank_account'=>$params['bank_account'],
			'bank_realname'=>$params['bank_realname'],
			'max_tmoney'=>$params['max_tmoney'],
			'sort'=>$params['sort'],
			'status'=>$params['status'],
			'cover'=>$params['cover']
		);
		if($item_id){
			if($pageuser['gid']>41){
				if($uid!=$pageuser['id']){
					jReturn('-1','没有权限更换所属代理');
				}
				$item=$this->mysql->fetchRow("select * from sk_bank where id={$item_id}");
				if($item['uid']!=$pageuser['id']){
					jReturn('-1','没有权限操作该记录');
				}
			}
			$res=$this->mysql->update($sk_bank,"id={$item_id}",'sk_bank');
		}else{
			$sk_bank['create_time']=NOW_TIME;
			$res=$this->mysql->insert($sk_bank,'sk_bank');
			$item_id=$res;
		}
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$sk_bank['id']=$item_id;
		actionLog(['opt_name'=>'更新收款银行卡','sql_str'=>json_encode($sk_bank,256)],$this->mysql);
		$return_data=[];
		if($user){
			$return_data['account']=$user['account'];
			$return_data['nickname']=$user['nickname'];
		}
		jReturn('1','操作成功',$return_data);
	}
	
	//删除
	public function _bank_delete(){
		$pageuser=checkLogin();
		$item_id=intval($this->params['item_id']);
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$skbank=$this->mysql->fetchRow("select * from sk_bank where id={$item_id} and status<99");
		if(!$skbank){
			jReturn('-1','操作成功');
		}
		if($pageuser['gid']>41){
			if($skbank['uid']!=$pageuser['id']){
				jReturn('-1','没有该记录的操作权限');
			}
		}
		$sk_bank=['status'=>99];
		$res=$this->mysql->update($sk_bank,"id={$item_id}",'sk_bank');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		actionLog(['opt_name'=>'删除收款银行卡','sql_str'=>json_encode($skbank,256)],$this->mysql);
		jReturn('1','操作成功');
	}
	
	
	//#############################充值记录#############################
	public function _paylog(){
		checkPower();
		$data=[];
		display('Finance/paylog.html',$data);
	}
	
	public function _paylog_list(){
		$pageuser=checkLogin();
		$is_download=intval($this->params['is_download']);
		if($is_download){
			$pageSize=5000;
		}else{
			$pageSize=$this->pageSize;
		}
		$params=$this->params;
		$params['s_pay_status']=intval($params['s_pay_status']);
		$where="where log.pay_status<99";
		
		if($pageuser['gid']>41){
			/*
			$uid_arr=getDownUser($pageuser['id']);
			$uid_arr[]=$pageuser['id'];
			$uid_str=implode(',',$uid_arr);
			$where.=" and log.uid in({$uid_str})";
			*/
			$where.=" and log.aid={$pageuser['id']}";
		}
		
		$s_start_time=$params['s_start_time'];
		$s_end_time=$params['s_end_time'];
		if($s_start_time&&$s_end_time){
			$s_start_time=strtotime($s_start_time.' 00:00:01');
			$s_end_time=strtotime($s_end_time.' 23:59:59');
			if($s_start_time>$s_end_time){
				jReturn('-98','开始时间不能大于结束时间');
			}
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		$where.=empty($params['s_pay_status'])?'':" and log.pay_status={$params['s_pay_status']}";
		$where.=empty($params['s_keyword'])?'':" and (u.account='{$params['s_keyword']}' or au.account='{$params['s_keyword']}' or u.phone='{$params['s_keyword']}' or log.order_sn='{$params['s_keyword']}' or log.pay_order_sn='{$params['s_keyword']}' or u.realname like '%{$params['s_keyword']}%' or u.nickname like '%{$params['s_keyword']}%')";
		$count_item=$this->mysql->fetchRow("select count(1) as cnt,sum(log.money) as sum_money 
		from cnf_paylog log left join sys_user u on log.uid=u.id 
		left join sys_user au on log.aid=au.id 
		{$where}");
		$sql="select log.*,bk.bank_name,skbk.bank_account,skbk.bank_realname,
		u.account,u.nickname,u.headimgurl,au.account as a_account,au.nickname as a_nickname  
		from cnf_paylog log left join sys_user u on log.uid=u.id 
		left join sys_user au on log.aid=au.id 
		left join sk_bank skbk on log.skbank_id=skbk.id 
		left join cnf_bank bk on skbk.bank_id=bk.id 
		{$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		$cnf_paylog_status=getConfig('cnf_paylog_status');
		foreach($list as &$item){
			$item['banners']=json_decode($item['banners'],true);
			$item['pay_status_flag']=$cnf_paylog_status[$item['pay_status']];
			$item['create_time']=date('m-d H:i:s',$item['create_time']);
			if($item['tj_time']){
				$item['tj_time']=date('m-d H:i:s',$item['tj_time']);
			}else{
				$item['tj_time']='';
			}
			if($item['pay_time']){
				$item['pay_time']=date('m-d H:i:s',$item['pay_time']);
			}else{
				$item['pay_time']='';
			}
			if($item['pay_status']==1){
				if($item['ori_balance']<0.01){
					$item['ori_balance']='';
				}
				if($item['new_balance']<0.01){
					$item['new_balance']='';
				}	
			}
			$item['check']=hasPower($pageuser,'Finance_paylog_check')?1:0;
		}
		/*
		if($is_download){
			$str="账号,昵称,订单号,支付方式,订单金额,原余额,现余额,创建时间,备注说明,支付状态,支付时间\n";
			foreach($list as $row){
				$str.="\t{$row['phone']},{$row['realname']},\t{$row['order_sn']},{$row['pay_type_flag']},{$row['money']},{$row['ori_balance']},{$row['new_balance']},\t{$row['create_time']},{$row['remark']},{$row['pay_status_flag']},\t{$row['pay_time']}\n";
			}
			$filename=NOW_TIME.'.csv';
			downloadCsv($filename,$str);
			exit;
		}*/
		
		$data=[
			'list'=>$list,
			'count'=>intval($count_item['cnt']),
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$pageSize
		];
		jReturn('1','ok',$data);
	}
	
	//充值记录审核
	public function _paylog_check(){
		$pageuser=checkPower();
		$params=$this->params;
		$item_id=intval($params['item_id']);
		$params['pay_status']=intval($params['pay_status']);
		$cnf_paylog_status=getConfig('cnf_paylog_status');
		$cnf_paylog_status['99']='删除';
		if(!array_key_exists($params['pay_status'],$cnf_paylog_status)){
			jReturn('-1','未知支付状态');
		}
		$this->mysql->startTrans();
		$paylog=$this->mysql->fetchRow("select * from cnf_paylog where id={$item_id} for update");
		if(!$paylog||$paylog['pay_status']>2){
			jReturn('-1','该订单当前状态不可操作');
		}
		
		if($pageuser['gid']>41){
			if($paylog['aid']!=$pageuser['id']){
				jReturn('-1','没有权限操作该记录');
			}
		}
		
		$cnf_paylog=[
			'check_id'=>$pageuser['id'],
			'check_time'=>NOW_TIME,
			'pay_status'=>$params['pay_status']
		];
		if($params['pay_status']==3){
			if($paylog['aid']&&$paylog['aid']!=$pageuser['id']){
				jReturn('-1','不是所属代理无法审核');
			}
			
			//扣除审核者的接单余额
			if($paylog['aid']){
				$user2=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']} for update");
				$sys_user2=[
					'sx_balance'=>$user2['sx_balance']-$paylog['money']
				];
				if($sys_user2['sx_balance']<0){
					jReturn('-1','您的接单余额不足，无法审核该订单');
				}
				$res2=$this->mysql->update($sys_user2,"id={$user2['id']}",'sys_user');
				$res3=balanceLog($user2,3,53,-$paylog['money'],$paylog['id'],'审核充值订单:'.$paylog['order_sn'],$this->mysql);	
			}else{
				$res2=true;
				$res3=true;
			}
			
			//增加充值者的接单余额
			$user=$this->mysql->fetchRow("select * from sys_user where id={$paylog['uid']} for update");
			$sys_user=[
				'sx_balance'=>$user['sx_balance']+$paylog['money']
			];
			$res4=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
			$res5=balanceLog($user,3,53,$paylog['money'],$paylog['id'],$paylog['order_sn'],$this->mysql);
			
			$cnf_paylog['pay_time']=NOW_TIME;
			$cnf_paylog['ori_balance']=$user['sx_balance'];
			$cnf_paylog['new_balance']=$sys_user['sx_balance'];
		}else{
			$res2=true;
			$res3=true;
			$res4=true;
			$res5=true;
		}
		$res=$this->mysql->update($cnf_paylog,"id={$paylog['id']}",'cnf_paylog');
		if($res===false||!$res2||!$res3||!$res4||!$res5){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试'.$res.'-'.$res2.'-'.$res3.'-'.$res4.'-'.$res5);
		}
		$this->mysql->commit();
		
		//累计到卡的已收款金额
		if($params['pay_status']==3){
			$skbank=$this->mysql->fetchRow("select * from sk_bank where id={$paylog['skbank_id']}");
			$sk_bank=[
				'last_money'=>$paylog['money'],
				'now_tmoney'=>$skbank['now_tmoney']+$paylog['money']
			];
			if($sk_bank['now_tmoney']>=$skbank['max_tmoney']){
				$sk_bank['status']=1;
			}
			$this->mysql->update($sk_bank,"id={$skbank['id']}",'sk_bank');
		}
		
		$return_data=[
			'ori_balance'=>$cnf_paylog['ori_balance'],
			'new_balance'=>$cnf_paylog['new_balance'],
			'pay_status'=>$params['pay_status'],
			'pay_status_flag'=>$cnf_paylog_status[$params['pay_status']],
			'pay_time'=>date('m-d H:i:s',$cnf_paylog['pay_time'])
		];
		jReturn('1','操作成功',$return_data);
	}
	

	//#############################提现记录#############################
	
	//提现记录
	public function _cashlog(){
		checkPower();
		$agent_arr=$this->mysql->fetchRows("select * from sys_user where gid=85 and status=2 and kb_balance>0 order by kb_balance desc");
		$data=[
			'agent_arr'=>$agent_arr
		];
		display('Finance/cashlog.html',$data);
	}
	
	//码商提现记录
	public function _cashlogMs(){
		checkPower();
		$agent_arr=$this->mysql->fetchRows("select * from sys_user where gid=85 and status=2 and kb_balance>0 order by kb_balance desc");
		$data=[
			'agent_arr'=>$agent_arr
		];
		display('Finance/cashlog_ms.html',$data);
	}
	
	public function _cashlog_list(){
		$pageuser=checkLogin();
		$is_download=intval($this->params['is_download']);
		if($is_download){
			$pageSize=5000;
		}else{
			$pageSize=$this->pageSize;
		}
		$params=$this->params;
		$params['s_status']=intval($params['s_status']);
		$params['s_pay_status']=intval($params['s_pay_status']);
		$params['s_gid']=intval($params['s_gid']);
		$params['s_ctype']=intval($params['s_ctype']);//2是码商的 其他是商户的
		$where="where log.status<99";
		$where.=empty($params['s_gid'])?'':" and u.gid={$params['s_gid']}";
		if($params['s_ctype']==2){
			$where.=" and u.gid>=85";
		}else{
			$where.=" and u.gid<85";
		}
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			$uid_arr[]=$pageuser['id'];
			$uid_str=implode(',',$uid_arr);
			$where.=" and log.uid in({$uid_str})";
		}
		
		$s_start_time=$params['s_start_time'];
		$s_end_time=$params['s_end_time'];
		if($s_start_time&&$s_end_time){
			$s_start_time=strtotime($s_start_time.' 00:00:01');
			$s_end_time=strtotime($s_end_time.' 23:59:59');
			if($s_start_time>$s_end_time){
				jReturn('-98','开始时间不能大于结束时间');
			}
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		$where.=empty($params['s_status'])?'':" and log.status={$params['s_status']}";
		$where.=empty($params['s_pay_status'])?'':" and log.pay_status={$params['s_pay_status']}";
		$where.=empty($params['s_keyword'])?'':" and (log.csn='{$params['s_keyword']}' or u.account='{$params['s_keyword']}' or u.phone='{$params['s_keyword']}' or u.nickname like '%{$params['s_keyword']}%')";
		
		$sql_cnt="select count(1) as cnt,sum(log.money) as sum_money,sum(log.fee) as sum_fee 
		from cnf_cashlog log 
		left join cnf_banklog blog on log.blog_id=blog.id 
		left join cnf_bank bk on blog.bank_id=bk.id 
		left join sys_user u on log.uid=u.id {$where}";
		$count_item=$this->mysql->fetchRow($sql_cnt);
		$sql="select log.*,bk.bank_name,u.gid,u.account,u.nickname,u.headimgurl 
		from cnf_cashlog log 
		left join cnf_banklog blog on log.blog_id=blog.id 
		left join cnf_bank bk on blog.bank_id=bk.id 
		left join sys_user u on log.uid=u.id {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		$sys_group=getConfig('sys_group');
		$user_cash_status=getConfig('user_cash_status');
		$cnf_pay_status=getConfig('cnf_pay_status');
		$cnf_xyhk_model=getConfig('cnf_xyhk_model');
		foreach($list as &$item){
			$item['group_name']=$sys_group[$item['gid']];
			$item['status_flag']=$user_cash_status[$item['status']];
			$item['pay_status_flag']=$cnf_pay_status[$item['pay_status']];
			$item['create_time']=date('m-d H:i:s',$item['create_time']);
			if($item['check_time']){
				$item['check_time']=date('m-d H:i:s',$item['check_time']);
			}else{
				$item['check_time']='';
			}
			if($item['pay_time']){
				$item['pay_time']=date('m-d H:i:s',$item['pay_time']);
			}else{
				$item['pay_time']='';
			}
			
			$banklog=json_decode($item['banklog'],true);
			$item['bank_name']=$banklog['bank_name'];
			
			$item['check']=hasPower($pageuser,'Finance_cashlog_check')?1:0;
			if($cnf_xyhk_model=='是'){
				$item['bkcf']=hasPower($pageuser,'Finance_cashlog_bkcf')?1:0;
			}else{
				$item['bkcf']=0;
			}
			
		}
		/*
		if($is_download){
			$str="账号,昵称,提现金额,手续费,实际到账,提现前,提现后,	申请时间,账户信息,审核时间,代付状态,备注,审核状态\n";
			foreach($list as $row){
				$account_info="【{$row['bank_name']}】{$row['branch_name']} 账号：{$row['bank_account']} 姓名：{$row['realname']}";
				$str.="\t{$row['phone']},{$row['realname']},\t{$row['money']},{$row['fee']},{$row['real_money']},{$row['ori_balance']},{$row['new_balance']},\t{$row['create_time']},{$account_info},\t{$row['check_time']},{$row['pay_status_flag']},{$row['remark']},{$row['status_flag']}\n";
			}
			$filename=NOW_TIME.'.csv';
			downloadCsv($filename,$str);
			exit;
		}
		*/
		$data=[
			'list'=>$list,
			'count'=>intval($count_item['cnt']),
			'sum_money'=>floatval($count_item['sum_money']),
			'sum_fee'=>floatval($count_item['sum_fee']),
			'limit'=>$pageSize
		];
		jReturn('1','ok',$data);
	}
	
	public function _cashlog_check(){
		$pageuser=checkPower();
		$params=$this->params;
		$status=intval($params['status']);
		$item_id=intval($params['item_id']);
		$remark=$params['remark'];
		$this->mysql->startTrans();
		$cashlog=$this->mysql->fetchRow("select * from cnf_cashlog where id={$item_id} for update");
		if(!$cashlog||$cashlog['status']>=99){
			jReturn('-1','不存在该提现记录');
		}
		if($cashlog['status']!=1){
			jReturn('-1','该提现申请当前状态不可操作');
		}
		
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			if(!in_array($cashlog['uid'],$uid_arr)){
				jReturn('-1','提现用户不是您的下级无法审核');
			}
		}
		
		if($cashlog['dpay_money']>0){
			jReturn('-1','已经采用拨款方式支付，不可再直接审核');
		}
		
		$user_cash_status=getConfig('user_cash_status');
		if(!array_key_exists($status,$user_cash_status)){
			jReturn('-1','未知审核状态');
		}
		$cashlog_data=[
			'status'=>$status,
			'check_time'=>NOW_TIME,
			'check_id'=>$pageuser['id'],
			'remark'=>$remark
		];
		$res=$this->mysql->update($cashlog_data,"id={$cashlog['id']}",'cnf_cashlog');
		if($status==3){//退还
			$user=$this->mysql->fetchRow("select id,balance from sys_user where id={$cashlog['uid']} for update");
			$user_data=array('balance'=>$user['balance']+$cashlog['money']);
			$res2=$this->mysql->update($user_data,"id={$user['id']}",'sys_user');
			$res3=balanceLog($user,1,12,$cashlog['money'],$cashlog['id'],$cashlog['csn'],$this->mysql);
		}else{
			$res2=true;
			$res3=true;
		}
		//api接口
		if($status==2){
			$cnf_cashlog_data=[
				//'csn'=>'C'.date('YmdHis').mt_rand(1000,9999),
				'pay_status'=>3,
				'pay_time'=>NOW_TIME
			];
			$res4=$this->mysql->update($cnf_cashlog_data,"id={$cashlog['id']}",'cnf_cashlog');
			/*
			$cnf_cashlog_data=array(
				'csn'=>'C'.date('YmdHis').mt_rand(1000,9999)
			);
			$res11=$this->mysql->update($cnf_cashlog_data,"id={$cashlog['id']}",'cnf_cashlog');
			if(!$res11){
				jReturn('-1','提现单号更新失败');
			}
			$cashlog['csn']=$cnf_cashlog_data['csn'];
			$result=$this->doDf($cashlog);
			if($result['code']!=1){
				echo json_encode($result);exit;
			}else{
				$res4=true;
				$cashlog_data2=array('pay_status'=>2);
				$this->mysql->update($cashlog_data2,"id={$cashlog['id']}",'cnf_cashlog');
			}*/
		}else{
			$res4=true;
		}
		if($res&&$res2&&$res3&&$res4){
			$this->mysql->commit();
			
			$return_data=[
				'check_time'=>date('m-d H:i:s',$cashlog_data['check_time']),
				'csn'=>$cashlog['csn']
			];
			if($cashlog_data2['pay_status']){
				$cnf_cashpay_status=getConfig('cnf_cashpay_status');
				$return_data['pay_status']=$cashlog_data2['pay_status'];
				$return_data['pay_status_flag']=$cnf_cashpay_status[$cashlog_data2['pay_status']];
			}
			jReturn('1','操作成功',$return_data);
		}
		$this->mysql->rollback();
		jReturn('-1','操作失败');
	}
	
	private function doDf($cashlog){
		$df_type='_df1';
		$df_file=ROOT_PATH.'pay/'.$df_type.'/df.php';
		if(!is_file($df_file)){
			return array('code'=>'-1','msg'=>'不存在代付接口');
		}
		return include($df_file);
	}
	
	
	//##################提现银行卡开始##################
	
	public function _banklog(){
		checkLogin();
		$province_arr=$this->mysql->fetchRows("select * from cnf_pc where pid=0");
		$data=[
			'bank_arr'=>$this->mysql->fetchRows("select * from cnf_bank"),
			'province_arr'=>$province_arr
		];
		display('Finance/banklog.html',$data);
	}
	
	public function _banklog_list(){
		$pageuser=checkLogin();
		$params=$this->params;
		$params['s_bank_id']=intval($params['s_bank_id']);
		$where="where 1";
		if($pageuser['gid']>41){
			$where.=" and log.uid={$pageuser['id']}";
		}
		$where.=empty($params['s_bank_id'])?'':" and log.bank_id={$params['s_bank_id']}";
		$where.=empty($params['s_keyword'])?'':" and (log.bank_account='{$params['s_keyword']}' or log.bank_realname='{$params['s_keyword']}')";
		$count=$this->mysql->fetchResult("select count(1) from cnf_banklog log {$where}");
		$sql="select log.*,b.bank_name,b.bank_code,pc.cname as province_name,
		pc2.cname as city_name,u.nickname,u.account from cnf_banklog log 
		left join cnf_bank b on log.bank_id=b.id 
		left join cnf_pc pc on log.province_id=pc.id
		left join cnf_pc pc2 on log.city_id=pc2.id
		left join sys_user u on log.uid=u.id {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i',$item['create_time']);
		}
		$data=array(
			'list'=>$list,
			'count'=>$count,
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _banklog_update(){
		$pageuser=checkLogin();
		$params=$this->params;
		$item_id=intval($params['item_id']);
		$bank_id=intval($params['bank_id']);
		$province_id=intval($params['province_id']);
		$city_id=intval($params['city_id']);
		if($province_id<1){
			jReturn('-1','请选择省份');
		}
		if($city_id<1){
			jReturn('-1','请选择城市');
		}
		$data=array(
			'bank_account'=>$params['bank_account'],
			'bank_realname'=>$params['bank_realname'],
			'bank_id'=>$bank_id,
			'province_id'=>$province_id,
			'city_id'=>$city_id
		);
		$bank=$this->mysql->fetchRow("select * from cnf_bank where id={$bank_id}");
		if(!$bank||!$bank['status']){
			jReturn('-1','不存在该银行或者未启用');
		}
		if($item_id){
			if($pageuser['gid']>41){
				$banklog=$this->mysql->fetchRow("select * from cnf_banklog where id={$item_id}");
				if($banklog['uid']!=$pageuser['id']){
					jReturn('-1','您没有权限操作该记录');
				}
			}
			$res=$this->mysql->update($data,"id={$item_id}",'cnf_banklog');
		}else{
			$data['uid']=$pageuser['id'];
			$data['create_time']=NOW_TIME;
			$res=$this->mysql->insert($data,'cnf_banklog');
		}
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$return_data=[];
		jReturn('1','操作成功',$return_data);
	}
	
	public function _banklog_delete(){
		$pageuser=checkLogin();
		$item_id=intval($this->_param('item_id'));
		$banklog=$this->mysql->fetchRow("select * from cnf_banklog where id={$item_id}");
		if(!$banklog){
			jReturn('-1','不存在该记录');
		}
		if($pageuser['gid']>41){
			if($banklog['uid']!=$pageuser['id']){
				jReturn('-1','您没有权限操作该记录');
			}
		}
		$res=$this->mysql->delete("id={$item_id}",'cnf_banklog');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','操作成功');
	}
	
	//##################提现银行卡结束##################
	
	//##################账户余额开始##################
	public function _balance(){
		$pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$user['balance']=floatval($user['balance']);
		$user['fz_balance']=floatval($user['fz_balance']);
		$user['sx_balance']=floatval($user['sx_balance']);
		$user['kb_balance']=floatval($user['kb_balance']);
		
		$banklog_arr=$this->mysql->fetchRows("select log.*,b.bank_name,b.bank_code from cnf_banklog log left join cnf_bank b on log.bank_id=b.id where log.uid={$pageuser['id']}");
		$cash_cnf=getConfig('cash_cnf');
		$day_time_arr=explode('-',$cash_cnf['day_time']);
		if(!$cash_cnf['weekend']){
			$cash_time_str="提现时间：周一至周五 {$day_time_arr[0]} - {$day_time_arr[1]}";
		}else{
			$cash_time_str="提现时间：周一至周日 {$day_time_arr[0]} - {$day_time_arr[1]}";
		}
		$djs_item=$this->mysql->fetchRow("select count(1) as cnt,sum(real_money) as money from pay_order where suid={$user['id']} and pay_status=9 and js_status=1");
		$cash_shcharge_money=getConfig('cash_shcharge_money');
		$fee_str="提现金额 × {$cash_shcharge_money[1]} + {$cash_shcharge_money[2]}";
		$data=[
			'user'=>$user,
			'banklog_arr'=>$banklog_arr,
			'cash_time_str'=>$cash_time_str,
			'fee_str'=>$fee_str,
			'djs_balance'=>floatval($djs_item['money'])
		];
		display('Finance/balance.html',$data);
	}
	
	public function _balance_cash(){
        $params=$this->params;
	    if($params['autotx']=="shtx"){
            $money=floatval($params['money']);
            $blog_id=intval($params['blog_id']);
            $bank=$this->mysql->fetchRow("select log.*,b.bank_name,b.bank_code from cnf_banklog log left join cnf_bank b on log.bank_id=b.id where log.id={$blog_id}");
            $this->mysql->startTrans();
            $user=$this->mysql->fetchRow("select * from sys_user where id={$bank['uid']} for update");
        }else{
            $pageuser=checkLogin();
            $money=floatval($params['money']);
            $blog_id=intval($params['blog_id']);
            if(!$money||!$blog_id){
                jReturn('-1','缺少参数');
            }
            //检测最低最高提现金额，可提现时间
            $cash_cnf=getConfig('cash_cnf');
            $day_time_arr=explode('-',$cash_cnf['day_time']);
            $min_cash_money=getConfig('min_cash_money');
            $max_cash_money=getConfig('max_cash_money');
            $max_day_cash_money=getConfig('max_day_cash_money');
            $start_time=date('Y-m-d ').$day_time_arr[0].':01';
            $end_time=date('Y-m-d ').$day_time_arr[1].':59';
            if(NOW_DATE<$start_time||NOW_DATE>$end_time){
                jReturn('-1','当前时间不可提现');
            }
            if(!$cash_cnf['weekend']){
                $date_w=date('w',NOW_TIME);
                if($date_w==6||$date_w==0){
                    jReturn('-1','抱歉周末不可提现');
                }
            }

            if($money<$min_cash_money){
                jReturn('-1',"单笔最小可提现金额{$min_cash_money}");
            }
            if($money>$max_cash_money){
                jReturn('-1',"单笔最大可提现金额{$max_cash_money}");
            }
            $now_day=date('Ymd');
            $day_sum_money=$this->mysql->fetchResult("select sum(money) from cnf_cashlog where uid={$pageuser['id']} and create_day={$now_day} and status in(1,2)");
            if($day_sum_money+$money>$max_day_cash_money){
                jReturn('-1','每天累计可提现金额'.$max_day_cash_money);
            }
            $bank=$this->mysql->fetchRow("select log.*,b.bank_name,b.bank_code from cnf_banklog log left join cnf_bank b on log.bank_id=b.id where log.id={$blog_id}");
            if(!$bank||$bank['uid']!=$pageuser['id']){
                jReturn('-1','未知提现银行卡');
            }
            $this->mysql->startTrans();
            $user=$this->mysql->fetchRow("select * from sys_user where id={$bank['uid']} for update");
            if(!$user||$user['status']!=2){
                jReturn('-1','账号被禁用，暂时无法提现');
            }else{
                $password2=getPassword($params['password2']);
                if($user['password2']!=$password2){
                    jReturn('-1','二级密码不正确');
                }
            }

        }

		$new_balance=$user['balance']-$money;
		if($new_balance<0){
			jReturn('-1','可提现余额不足');
		}
		$user_data=['balance'=>$new_balance];
		$cash_shcharge_money=getConfig('cash_shcharge_money');
		$fee=$money*$cash_shcharge_money[1]+$cash_shcharge_money[2];
		$cnf_cashlog=[
			'uid'=>$user['id'],
			'csn'=>'C'.date('YmdHis').mt_rand(1000,9999),
			//'province_id'=>$bank['province_id'],
			//'city_id'=>$bank['city_id'],
			'blog_id'=>$bank['id'],
			'bank_account'=>$bank['bank_account'],
			'bank_realname'=>$bank['bank_realname'],
			'money'=>$money,
			'fee'=>$fee,
			'real_money'=>$money-$fee,
			'ori_balance'=>$user['balance'],
			'new_balance'=>$new_balance,
			'create_time'=>NOW_TIME,
			'create_day'=>date('Ymd',NOW_TIME),
			'banklog'=>json_encode($bank,256)
		];
		if($cnf_cashlog['real_money']<0.01){
			jReturn('-1','扣除手续费后实际到账金额不足0.01');
		}
		$res=$this->mysql->update($user_data,"id={$user['id']}",'sys_user');
		$res2=$this->mysql->insert($cnf_cashlog,'cnf_cashlog');
		$res3=balanceLog($user,1,11,-$money,$res2,$cnf_cashlog['csn'],$this->mysql);
		if($res&&$res2&&$res3){
			$this->mysql->commit();
			
			//$url="{$_ENV['SOCKET']['HTTP_URL']}/?c=Admin&a=noticeCash&csn={$cnf_cashlog['csn']}";
			//curl_get($url);
			
			jReturn('1','提交申请成功，请耐心等待审核');
		}
		$this->mysql->rollback();
		jReturn('-1','系统繁忙请稍后再试');
	}
	
	//余额互转
	public function _balanceTrans(){
		$pageuser=checkLogin();
		$params=$this->params;
		$ptype=intval($params['ptype']);
		$money=floatval($params['money']);
		if($money<0.01){
			jReturn('-1','转出额度不正确');
		}
		if(!in_array($ptype,[1,2])){
			jReturn('-1','转出类型不正确');
		}
		$this->mysql->startTrans();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']} for update");
		if($ptype==1){
			$sys_user=[
				'balance'=>$user['balance']-$money,
				'sx_balance'=>$user['sx_balance']+$money
			];
			if($sys_user['balance']<0){
				jReturn('-1','您的可提余额不足');
			}
			$res2=balanceLog($user,1,55,-$money,'','可提余额转出',$this->mysql);
			$res3=balanceLog($user,3,55,$money,'','接单余额转入',$this->mysql);
		}elseif($ptype==2){
			$sys_user=[
				'balance'=>$user['balance']+$money,
				'sx_balance'=>$user['sx_balance']-$money
			];
			if($sys_user['sx_balance']<0){
				jReturn('-1','您的接单余额不足');
			}
			$res2=balanceLog($user,3,55,-$money,'','接单余额转出',$this->mysql);
			$res3=balanceLog($user,1,55,$money,'','可提余额转入',$this->mysql);
		}
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if($res&&$res2&&$res3){
			$this->mysql->commit();
			jReturn('1','操作成功');
		}
		$this->mysql->rollback();
		jReturn('-1','系统繁忙请稍后再试');
	}
	
	////////////////////////资金变动明细///////////////////////////
	public function _balancelog(){
		checkPower();
		$data=[];
		display('Finance/balancelog.html',$data);
	}
	
	public function _balancelog_list(){
		$pageuser=checkPower();
		$params=$this->params;
		$params['s_type']=intval($params['s_type']);
		$where="where 1";
		if($pageuser['gid']>41){
			$where.=" and log.uid={$pageuser['id']}";
		}
		$s_start_time=$params['s_start_time'];
		$s_end_time=$params['s_end_time'];
		if($s_start_time&&$s_end_time){
			$s_start_time=strtotime($s_start_time.' 00:00:01');
			$s_end_time=strtotime($s_end_time.' 23:59:59');
			if($s_start_time>$s_end_time){
				jReturn('-98','开始时间不能大于结束时间');
			}
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		$where.=empty($params['s_type'])?'':" and log.type={$params['s_type']}";
		$where.=empty($params['s_keyword'])?'':" and (u.account='{$params['s_keyword']}' or u.nickname='{$params['s_keyword']}')";
		$count_item=$this->mysql->fetchRow("select count(1) as cnt,sum(log.money) as sum_money from cnf_balance_log log left join sys_user u on log.uid=u.id {$where}");
		$sql="select log.*,u.nickname,u.account,u.gid from cnf_balance_log log 
		left join sys_user u on log.uid=u.id {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		$sys_group=getConfig('sys_group');
		$cnf_balance_type=getConfig('cnf_balance_type');
		foreach($list as &$item){
			$item['gname']=$sys_group[$item['gid']];
			$item['create_time']=date('m-d H:i',$item['create_time']);
			$item['type_flag']=$cnf_balance_type[$item['type']];
		}
		$data=[
			'list'=>$list,
			'count'=>intval($count_item['cnt']),
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$this->pageSize
		];
		jReturn('1','ok',$data);
	}
	
	//////////////////////////////////////////////////////
	//应回款查询
	public function _cashlog_check_ubalance(){
		checkLogin();
		$params=$this->params;
		$user=$this->mysql->fetchRow("select * from sys_user where account='{$params['account']}'");
		if(!$user){
			jReturn('-1','不存在相应的账号');
		}
		$return_data=[
			'kb_balance'=>$user['kb_balance']
		];
		jReturn('1','ok',$return_data);
	}
	
	//拨款拆分
	public function _cashlog_bkcf(){
		$pageuser=checkPower();
		$params=$this->params;
		$item_id=intval($params['item_id']);
		$account_id=intval($params['account_id']);
		$money=floatval($params['money']);
		if(!$account_id){
			if(!$params['account']){
				jReturn('-1','请填写指定码商代理账号');
			}else{
				$user=$this->mysql->fetchRow("select * from sys_user where account='{$params['account']}'");
			}	
		}else{
			$user=$this->mysql->fetchRow("select * from sys_user where id={$account_id}");
		}
		if($user['gid']!=85){
			jReturn('-1','不存在相应码商代理账号');
		}
		if($money<0.01){
			jReturn('-1','拨款额度不正确');
		}
		$this->mysql->startTrans();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$user['id']} for update");
		if($user['kb_balance']<$money){
			jReturn('-1','可拨款余额不足');
		}
		$cashlog=$this->mysql->fetchRow("select * from cnf_cashlog where id={$item_id} for update");
		$sys_user=[
			'kb_balance'=>$user['kb_balance']-$money
		];
		$cnf_cashlog=[
			'dpay_money'=>$cashlog['dpay_money']+$money
		];
		if($cnf_cashlog['dpay_money']>$cashlog['real_money']){
			jReturn('-1','累计拨款额度已超过提现实际到账');
		}
		$cnf_cashlog_bklog=[
			'cash_id'=>$cashlog['id'],
			'aid'=>$user['id'],
			'money'=>$money,
			'create_time'=>NOW_TIME
		];
			
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		$res2=$this->mysql->update($cnf_cashlog,"id={$cashlog['id']}",'cnf_cashlog');
		$res3=$this->mysql->insert($cnf_cashlog_bklog,'cnf_cashlog_bklog');
		$res4=balanceLog($user,4,31,-$money,$res3,$cashlog['csn'],$this->mysql);
		if(!$res||!$res2||!$res3||!$res4){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		jReturn('1','操作成功');
	}
	
	public function _cashlog_bkcf_list(){
		$pageuser=checkLogin();
		$pageSize=100;
		$params=$this->params;
		$item_id=intval($this->params['item_id']);
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$where="where log.cash_id={$item_id} and log.status<=3";
		/*
		if($pageuser['gid']!=1){
			$where.=" and log.aid={$pageuser['id']}";
		}*/
		$count_item=$this->mysql->fetchRow("select count(1) as cnt from cnf_cashlog_bklog log {$where}");
		$sql="select log.*,u.account,u.nickname from cnf_cashlog_bklog log left join sys_user u on log.aid=u.id {$where}";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		$cnf_bklog_status=getConfig('cnf_bklog_status');
		foreach($list as &$item){
			$item['status_flag']=$cnf_bklog_status[$item['status']];
			$item['create_time']=date('m-d H:i',$item['create_time']);
			if($item['check_time']){
				$item['check_time']=date('m-d H:i',$item['check_time']);
			}else{
				$item['check_time']='/';
			}
			if($item['banners']){
				$item['banners']=json_decode($item['banners'],true);
			}else{
				$item['banners']=[];
			}
		}
		$data=[
			'list'=>$list,
			'count'=>intval($count_item['cnt']),
			'limit'=>$pageSize
		];
		jReturn('1','ok',$data);
	}
	
	//##################提现拨款明细开始##################
	public function _bklog(){
		$pageuser=checkPower();
		$data=[];
		display('Finance/bklog.html',$data);
	}
	
	public function _bklog_list(){
		$pageuser=checkLogin();
		$pageSize=$this->pageSize;
		$params=$this->params;
		$params['s_status']=intval($params['s_status']);
		$where="where 1";
		if($pageuser['gid']!=1){
			$where.=" and log.aid={$pageuser['id']}";
		}
		$s_start_time=$params['s_start_time'];
		$s_end_time=$params['s_end_time'];
		if($s_start_time&&$s_end_time){
			$s_start_time=strtotime($s_start_time.' 00:00:01');
			$s_end_time=strtotime($s_end_time.' 23:59:59');
			if($s_start_time>$s_end_time){
				jReturn('-98','开始时间不能大于结束时间');
			}
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		$where.=empty($params['s_status'])?'':" and log.status={$params['s_status']}";
		$where.=empty($params['s_keyword'])?'':" and (au.account='{$params['s_keyword']}' or clog.csn='{$params['s_keyword']}')";
		$count_sql="select count(1) as cnt,sum(log.money) as sum_money 
		from cnf_cashlog_bklog log 
		left join sys_user au on log.aid=au.id 
		left join cnf_cashlog clog on log.cash_id=clog.id 
		left join sys_user u on clog.uid=u.id 
		{$where}";
		$count_item=$this->mysql->fetchRow($count_sql);
		$sql="select log.*,clog.csn,u.account,clog.bank_account,clog.bank_realname,clog.branch_name,clog.banklog,
		u.nickname,au.account as a_account,au.nickname as a_nickname from cnf_cashlog_bklog log 
		left join sys_user au on log.aid=au.id 
		left join cnf_cashlog clog on log.cash_id=clog.id 
		left join sys_user u on clog.uid=u.id 
		{$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		$cnf_bklog_status=getConfig('cnf_bklog_status');
		foreach($list as &$item){
			$item['status_flag']=$cnf_bklog_status[$item['status']];
			$item['create_time']=date('m-d H:i',$item['create_time']);
			if($item['check_time']){
				$item['check_time']=date('m-d H:i',$item['check_time']);
			}else{
				$item['check_time']='/';
			}
			if($item['banners']){
				$item['banners']=json_decode($item['banners'],true);
			}else{
				$item['banners']=[];
			}
			$banklog=json_decode($item['banklog'],true);
			$item['bank_name']=$banklog['bank_name'];
			
			$item['check']=hasPower($pageuser,'Finance_bklog_check')?1:0;
		}
		$data=[
			'list'=>$list,
			'count'=>intval($count_item['cnt']),
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$pageSize
		];
		jReturn('1','ok',$data);
	}
	
	public function _bklog_update(){
		$pageuser=checkLogin();
		$params=$this->params;
		$item_id=intval($params['item_id']);
		if(!$params['cover']){
			jReturn('-1','请上传拨款凭证');
		}
		$bklog=$this->mysql->fetchRow("select * from cnf_cashlog_bklog where id={$item_id}");
		if($pageuser['gid']>41){
			if($bklog['aid']!=$pageuser['id']){
				jReturn('-1','没有权限操作该记录');
			}
		}
		if(!in_array($bklog['status'],[1,4])){
			jReturn('-1','该拨款记录当前状态不可提交');
		}
		$cnf_cashlog_bklog=[
			'submit_time'=>NOW_TIME,
			'remark'=>$params['remark'],
			'banners'=>json_encode([$params['cover']]),
			'status'=>2
		];
		$res=$this->mysql->update($cnf_cashlog_bklog,"id={$bklog['id']}",'cnf_cashlog_bklog');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$cnf_bklog_status=getConfig('cnf_bklog_status');
		$return_data=[
			'status'=>2,
			'status_flag'=>$cnf_bklog_status[2]
		];
		jReturn('1','提交成功',$return_data);
	}
	
	//审核拨款明细
	public function _bklog_check(){
		$pageuser=checkPower();
		$params=$this->params;
		$item_id=intval($params['item_id']);
		$status=intval($params['status']);
		$this->mysql->startTrans();
		$bklog=$this->mysql->fetchRow("select * from cnf_cashlog_bklog where id={$item_id} for update");
		if(!in_array($bklog['status'],[2,4])){
			jReturn('-1','该记录当前状态不可审核');
		}
		$cnf_cashlog_bklog=[
			'check_time'=>NOW_TIME,
			'status'=>$status
		];
		$res=$this->mysql->update($cnf_cashlog_bklog,"id={$item_id}",'cnf_cashlog_bklog');
		
		if($status==7){
			$user=$this->mysql->fetchRow("select * from sys_user where id={$bklog['aid']} for update");
			$cashlog=$this->mysql->fetchRow("select * from cnf_cashlog where id={$bklog['cash_id']} for update");
			$sys_user=[
				'kb_balance'=>$user['kb_balance']+$bklog['money']
			];
			$cnf_cashlog=[
				'dpay_money'=>$cashlog['dpay_money']-$bklog['money']
			];
			if($cnf_cashlog['dpay_money']<0){
				jReturn('-1','拨款金额错误');
			}
			$res2=balanceLog($user,4,23,$bklog['money'],$bklog['id'],'',$this->mysql);
			$res3=$this->mysql->update($cnf_cashlog,"id={$cashlog['id']}",'cnf_cashlog');
			$res4=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		}else{
			$res2=true;
			$res3=true;
			$res4=true;
		}
		
		if(!$res||!$res2||!$res3||!$res4){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		
		if($status==3){
			$cashlog=$this->mysql->fetchRow("select * from cnf_cashlog where id={$bklog['cash_id']} for update");
			$cnf_cashlog_bklog2=[
				'fpay_money'=>$cashlog['fpay_money']+$bklog['money']
			];
			$res11=$this->mysql->update($cnf_cashlog_bklog2,"id={$cashlog['id']}",'cnf_cashlog');
			if($res11&&$cnf_cashlog_bklog2['fpay_money']>=$cashlog['real_money']){
				$cashlog_data=array(
					'status'=>2,
					'check_time'=>NOW_TIME,
					'check_id'=>$pageuser['id'],
					'remark'=>'拨款完成'
				);
				$this->mysql->update($cashlog_data,"id={$cashlog['id']}",'cnf_cashlog');
			}
		}
		
		$cnf_bklog_status=getConfig('cnf_bklog_status');
		$return_data=[
			'check_time'=>date('m-d H:i',NOW_TIME),
			'status'=>$status,
			'status_flag'=>$cnf_bklog_status[$status]
		];
		jReturn('1','提交成功',$return_data);
	}
	
	
	//////////////////////////////回款记录////////////////////////////////
	//获取上级收款银行卡
	private function getSkbank($topAgent=false){
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
		
		$sql="select log.*,bk.bank_name,u.account,u.nickname from sk_bank log 
		left join cnf_bank bk on log.bank_id=bk.id 
		left join sys_user u on log.uid=u.id {$where}";
		$bank_arr=$this->mysql->fetchRows($sql);
		return $bank_arr;
	}
	
	//回款记录
	public function _agenthk(){
		$pageuser=checkPower();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$hkload=hasPower($pageuser,'Finance_agenthk_csv')?1:0;
		$data=[
			'user'=>$user,
			'hkload'=>$hkload,
			'bank_arr'=>$this->getSkbank(true)
		];
		display('Finance/agenthk.html',$data);
	}
	
	public function _agenthk_list(){
		$pageuser=checkLogin();
		$pageSize=$this->pageSize;
		$params=$this->params;
		$params['s_status']=intval($params['s_status']);
		$where="where log.status<99";
		if($pageuser['gid']!=1){
			$where.=" and log.uid={$pageuser['id']} or log.aid={$pageuser['id']}";
		}
		$s_start_time=$params['s_start_time'];
		$s_end_time=$params['s_end_time'];
		if($s_start_time&&$s_end_time){
			$s_start_time=strtotime($s_start_time.' 00:00:01');
			$s_end_time=strtotime($s_end_time.' 23:59:59');
			if($s_start_time>$s_end_time){
				jReturn('-98','开始时间不能大于结束时间');
			}
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		$where.=empty($params['s_status'])?'':" and log.status={$params['s_status']}";
		$where.=empty($params['s_keyword'])?'':" and (u.account='{$params['s_keyword']}' or log.osn='{$params['s_keyword']}')";
		$count_sql="select count(1) as cnt,sum(log.money) as sum_money 
		from sk_agent_hklog log 
		left join sys_user u on log.uid=u.id 
		left join sys_user au on log.aid=au.id {$where}";
		$count_item=$this->mysql->fetchRow($count_sql);
		$sql="select log.*,u.account,u.nickname,au.account as a_account,au.nickname as a_nickname  
		from sk_agent_hklog log 
		left join sys_user u on log.uid=u.id 
		left join sys_user au on log.aid=au.id 
		{$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		$cnf_agent_hkstatus=getConfig('cnf_agent_hkstatus');
		foreach($list as &$item){
			$item['status_flag']=$cnf_agent_hkstatus[$item['status']];
			$item['create_time']=date('m-d H:i',$item['create_time']);
			if($item['check_time']){
				$item['check_time']=date('m-d H:i',$item['check_time']);
			}else{
				$item['check_time']='/';
			}
			$banners=json_decode($item['banners'],true);
			if(!$banners){
				$banners=[];
			}
			$item['banners']=$banners;
			$item['cover']=$banners[0];
			
			$item['remark']=nl2br($item['remark']);
			$item['skbank']=json_decode($item['skbank'],true);
			
			$item['edit']=0;
			if($pageuser['id']==$item['uid']){
				$item['edit']=1;
			}
			$item['check']=hasPower($pageuser,'Finance_agenthk_check')?1:0;
			if($pageuser['id']>41){
				if($item['aid']!=$pageuser['id']){
					$item['check']=0;
				}
			}else{
				if($item['aid']&&$item['aid']!=$pageuser['id']){
					$item['check']=0;
				}
			}
		}
		$data=array(
			'list'=>$list,
			'count'=>intval($count_item['cnt']),
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _agenthk_update(){
		$pageuser=checkLogin();
		$params=$this->params;
		$params['money']=floatval($params['money']);
		$item_id=intval($params['item_id']);
		$bk_id=intval($params['skbank_id']);
		if(!$params['cover']){
			jReturn('-1','请上传回款凭证');
		}
		$sk_agent_hklog=[
			'remark'=>$params['remark'],
			'cover'=>$params['cover'],
			'banners'=>json_encode([$params['cover']]),
			'update_time'=>NOW_TIME
		];
		$this->mysql->startTrans();
		if($item_id){
			$item=$this->mysql->fetchRow("select * from sk_agent_hklog where id={$item_id} for update");
			if(!$item||$item['status']>=99){
				jReturn('-1','不存在相应记录');
			}
			if($pageuser['id']!=$item['uid']){
				jReturn('-1','没有权限操作该记录');
			}
			if(!in_array($item['status'],[1,2])){
				jReturn('-1','当前状态不可编辑');
			}
			$res=$this->mysql->update($sk_agent_hklog,"id={$item['id']}",'sk_agent_hklog');
			$res2=true;
			$res3=true;
		}else{
			if(!$bk_id){
				jReturn('-1','请选择上级收款账户');
			}
			$skbank=$this->mysql->fetchRow("select log.*,bk.bank_name from sk_bank log left join cnf_bank bk on log.bank_id=bk.id where log.id={$bk_id} and log.status=2");
			if(!$skbank){
				jReturn('-1','不存在该收款账户或该账户已下线');
			}
			if($params['money']<0.01){
				jReturn('-1','回款金额不正确');
			}
			$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']} for update");
			if($user['kb_balance']<$params['money']){
				jReturn('-1','应回款金额不足');
			}
			$sys_user=[
				'kb_balance'=>$user['kb_balance']-$params['money']
			];
			$sk_agent_hklog['aid']=intval($skbank['uid']);
			$sk_agent_hklog['uid']=$user['id'];
			$sk_agent_hklog['skbank_id']=$bk_id;
			$sk_agent_hklog['order_sn']='H'.date('YmdHis').mt_rand(11111,99999);
			$sk_agent_hklog['money']=$params['money'];
			$sk_agent_hklog['create_time']=NOW_TIME;
			$sk_agent_hklog['ori_balance']=$user['kb_balance'];
			$sk_agent_hklog['new_balance']=$sys_user['kb_balance'];
			$sk_agent_hklog['skbank']=json_encode($skbank,256);
			
			$res=$this->mysql->insert($sk_agent_hklog,'sk_agent_hklog');
			$res2=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
			$res3=balanceLog($user,4,22,-$params['money'],$res,$sk_agent_hklog['order_sn'],$this->mysql);
		}
		if(!$res||!$res2||!$res3){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		$return_data=[
			'kb_balance'=>floatval($sys_user['kb_balance'])
		];
		jReturn('1','操作成功',$return_data);
	}
	
	//审核回款
	public function _agenthk_check(){
		$pageuser=checkPower();
		$params=$this->params;
		$item_id=intval($params['item_id']);
		$status=intval($params['status']);
		if(!$item_id||!$status){
			jReturn('-1','缺少参数');
		}
		$cnf_agent_hkstatus=getConfig('cnf_agent_hkstatus');
		$cnf_agent_hkstatus[99]='已删除';
		if(!array_key_exists($status,$cnf_agent_hkstatus)){
			jReturn('-1','未知审核状态');
		}
		$this->mysql->startTrans();
		$item=$this->mysql->fetchRow("select * from sk_agent_hklog where id={$item_id} for update");
		if(!$item||$item['status']>=99){
			jReturn('-1','不存在相应记录');
		}
		if($item['status']>=3){
			jReturn('-1','当前状态不可操作');
		}
		if($item['aid']){
			if($item['aid']!=$pageuser['id']){
				jReturn('-1','您没有权限审核该记录');
			}
		}else{
			if($pageuser['gid']>41){
				jReturn('-1','您没有权限审核该记录');
			}
		}
		$sk_agent_hklog=[
			'status'=>$status,
			'check_time'=>NOW_TIME,
			'check_id'=>$pageuser['id']
		];
		$res=$this->mysql->update($sk_agent_hklog,"id={$item['id']}",'sk_agent_hklog');
		//退还
		if(in_array($status,[4,99])){
			$user=$this->mysql->fetchRow("select * from sys_user where id={$item['uid']} for update");
			$sys_user=[
				'kb_balance'=>$user['kb_balance']+$item['money']
			];
			$res2=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
			$res3=balanceLog($user,4,23,$item['money'],$item['id'],$item['order_sn'],$this->mysql);
			$res4=true;
			$res5=true;
			if($item['oid']){
				$sk_order=[
					'hk_status'=>4
				];
				$res6=$this->mysql->update($sk_order,"id={$item['oid']}",'sk_order');	
			}else{
				$res6=true;
			}
		}elseif($status==3){
			if($item['aid']){
				//增加审核者应回款
				$user=$this->mysql->fetchRow("select * from sys_user where id={$item['aid']} for update");
				$sys_user=[
					'kb_balance'=>$user['kb_balance']+$item['money']
				];
				$res2=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
				$res3=balanceLog($user,4,24,$item['money'],$item['id'],$item['order_sn'],$this->mysql);
			}else{
				$res2=true;
				$res3=true;
			}
			//需要恢复码商接单余额
			if($item['need_recover']){
				$user2=$this->mysql->fetchRow("select * from sys_user where id={$item['uid']} for update");
				$sys_user2=[
					'sx_balance'=>$user2['sx_balance']+$item['money']
				];
				$res4=$this->mysql->update($sys_user2,"id={$user2['id']}",'sys_user');
				$res5=balanceLog($user2,3,20,$item['money'],$item['id'],'审核回款记录恢复接单余额',$this->mysql);
			}else{
				$res4=true;
				$res5=true;
			}
			//单个订单提交的回款需要更新订单记录的回款状态
			if($item['oid']){
				$sk_order=[
					'hk_status'=>3
				];
				$res6=$this->mysql->update($sk_order,"id={$item['oid']}",'sk_order');
			}else{
				$res6=true;
			}
		}else{
			$res2=true;
			$res3=true;
			$res4=true;
			$res5=true;
			$res6=true;
		}
		if($res===false||!$res2||!$res3||!$res4||!$res5||!$res6){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		$return_data=[
			'kb_balance'=>$sys_user['kb_balance'],
			'status'=>$status,
			'status_flag'=>$cnf_agent_hkstatus[$status],
			'check_time'=>date('m-d H:i',$sk_agent_hklog['check_time'])
		];
		jReturn('1','操作成功',$return_data);
	}
	

	//回款批量文件导入
	public function _agenthk_csv(){
		$pageuser=checkPower();
		$csv=$this->params['csv'];
		if(!$csv){
			jReturn('-1','请上传csv文件');
		}
		$sk_order_hkcsv=[
			'csv'=>$csv,
			'is_load'=>0,
			'create_gid'=>$pageuser['gid'],
			'create_id'=>$pageuser['id'],
			'create_time'=>NOW_TIME
		];
		$res=$this->mysql->insert($sk_order_hkcsv,'sk_order_hkcsv');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','保存成功，即将自动处理');
	}
	
	
}
?>