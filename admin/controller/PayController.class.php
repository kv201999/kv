<?php
!defined('ROOT_PATH') && exit;
class PayController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	
	/////////////////////////通道管理////////////////////////////
	public function _mtype(){
		$pageuser=checkPower();
		$data=[
			'user'=>$pageuser
		];
		display('Pay/mtype.html',$data);
	}
	
	public function _mtype_list(){
		$pageuser=checkLogin();
		$params=$this->_param();
		$where='where 1';
		$where.=empty($params['s_keyword'])?'':" and (log.name like '%{$params['s_keyword']}%')";
		$sql_cnt="select count(1) as cnt from sk_mtype log {$where}";
		$count_item=$this->mysql->fetchRow($sql_cnt);
		$sql="select log.* from sk_mtype log {$where} order by log.id";
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		$yes_or_no=getConfig('yes_or_no');
		foreach($list as &$item){
			$item['is_open_flag']=$yes_or_no[$item['is_open']];
			
			$item['edit']=hasPower($pageuser,'Pay_mtype_list');
		}
		$data=array(
			'list'=>$list,
			'count'=>intval($count_item['cnt']),
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _mtype_update(){
		checkPower();
		$params=$this->_param();
		$params['is_open']=intval($params['is_open']);
		$item_id=intval($params['item_id']);
		if(!$params['name']){
			jReturn('-1','请填写通道名称');
		}
		
		if($params['min_money']>$params['max_money']){
			jReturn('-1','最小金额不能超过最大金额');
		}
		
		$sk_mtype=array(
			'name'=>$params['name'],
			'is_open'=>$params['is_open'],
			'min_money'=>floatval($params['min_money']),
			'max_money'=>floatval($params['max_money'])
		);
		if($item_id){
			$res=$this->mysql->update($sk_mtype,"id={$item_id}",'sk_mtype');
		}else{
			$res=$this->mysql->insert($sk_mtype,'sk_mtype');
		}
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','操作成功');
	}

	/////////////////////////收款码管理////////////////////////////
	public function _skma(){
		$pageuser=checkPower();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$mtype_arr=$this->getMtype($user);
		$bank_arr=rows2arr($this->mysql->fetchRows("select * from cnf_bank where status=1"));
		$province_arr=$this->mysql->fetchRows("select * from cnf_pc where pid=0");
		
		$updateall=hasPower($pageuser,'Pay_skma_allupdate');
		$data=[
			'user'=>$user,
			'mtype_arr'=>$mtype_arr,
			'bank_arr'=>$bank_arr,
			'updateall'=>$updateall,
			'province_arr'=>$province_arr,
		];
		display('Pay/skma.html',$data);
	}
	
	public function _skmaTrash(){
		$pageuser=checkPower();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$mtype_arr=$this->getMtype($user);
		$province_arr=$this->mysql->fetchRows("select * from cnf_pc where pid=0");
		$bank_arr=rows2arr($this->mysql->fetchRows("select * from cnf_bank where status=1"));
		$data=[
			'user'=>$user,
			'mtype_arr'=>$mtype_arr,
			'bank_arr'=>$bank_arr,
			'province_arr'=>$province_arr,
		];
		display('Pay/skmaTrash.html',$data);
	}
	
	//获取用户可用的通道列表
	private function getMtype($user){
		$td_switch=json_decode($user['td_switch'],true);
		$td_switch_arr=[];
		foreach($td_switch as $tk=>$tv){
			if($tv<1){
				continue;
			}
			$td_switch_arr[]=$tk;
		}
		$td_switch_str=implode(',',$td_switch_arr);
		$where="where is_open=1";
		if($pageuser['gid']>41){
			$where.=" and id in ({$td_switch_str})";
		}
		$mtype_arr=rows2arr($this->mysql->fetchRows("select * from sk_mtype {$where}"));
		return $mtype_arr;
	}
	
	public function _skma_list(){
		$pageuser=checkLogin();
		$params=$this->params;
		$params['s_status']=intval($params['s_status']);
		$params['s_mtype_id']=intval($params['s_mtype_id']);
		$params['s_spid']=intval($params['s_spid']);
		$where="where 1";
		if($params['s_status']){
			$where.=" and log.status={$params['s_status']}";
		}else{
			$where.=" and log.status<99";
		}
		if(isset($params['s_is_online'])&&$params['s_is_online']!='all'){
			$params['s_is_online']=intval($params['s_is_online']);
			$where.=" and u.is_online='{$params['s_is_online']}'";
		}
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			$uid_arr[]=$pageuser['id'];
			$uid_str=implode(',',$uid_arr);
			$where.=" and log.uid in({$uid_str})";
		}
		//$where.=empty($params['s_status'])?'':" and log.status={$params['s_status']}";
		$where.=empty($params['s_mtype_id'])?'':" and log.mtype_id={$params['s_mtype_id']}";
		$where.=empty($params['s_keyword'])?'':" and (u.account='{$params['s_keyword']}' or u.phone='{$params['s_keyword']}' or log.ma_realname like '%{$params['s_keyword']}%' or log.ma_account like '%{$params['s_keyword']}%')";
		$sql_cnt="select count(1) as cnt 
		from sk_ma log 
		left join sk_mtype mt on log.mtype_id=mt.id 
		left join sys_user u on log.uid=u.id {$where}";
		$count_item=$this->mysql->fetchRow($sql_cnt);
		$sql="select log.*,pro.cname as province_name,city.cname as city_name,
		mt.name as mtype_name,mt.type as mtype_type,
		bk.bank_name,u.account,u.nickname 
		from sk_ma log 
		left join sk_mtype mt on log.mtype_id=mt.id 
		left join cnf_bank bk on log.bank_id=bk.id 
		left join sys_user u on log.uid=u.id 
		left join cnf_pc pro on log.province_id=pro.id 
		left join cnf_pc city on log.city_id=city.id 
		{$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		
		$cnf_skma_status=getConfig('cnf_skma_status');
		$nowday=date('Ymd',NOW_TIME);
		$yestoday=date("Ymd",strtotime("-1 day"));
		$weekday=date("Ymd",strtotime("-7 day"));
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i:s',$item['create_time']);
			$item['status_flag']=$cnf_skma_status[$item['status']];
			/*
			$oitem=$this->mysql->fetchRow("select count(1)as cnt from sk_order where ma_id={$item['id']}");
			$oitem2=$this->mysql->fetchRow("select count(1)as cnt from sk_order where ma_id={$item['id']} and pay_status=9");
			$item['order_num']=intval($oitem['cnt']);
			$item['order_num2']=intval($oitem2['cnt']);*/
			$jt_item=$this->mysql->fetchRow("select count(1)as cnt,sum(money) as money from sk_order where ma_id={$item['id']} and create_day={$nowday} and pay_status=9");
			$jt_item2=$this->mysql->fetchRow("select count(1)as cnt,sum(money) as money from sk_order where ma_id={$item['id']} and create_day={$nowday}");
			$zt_item=$this->mysql->fetchRow("select count(1)as cnt,sum(money) as money from sk_order where ma_id={$item['id']} and create_day={$yestoday} and pay_status=9");
			$zt_item2=$this->mysql->fetchRow("select count(1)as cnt,sum(money) as money from sk_order where ma_id={$item['id']} and create_day={$yestoday}");
			$wt_item=$this->mysql->fetchRow("select count(1)as cnt,sum(money) as money from sk_order where ma_id={$item['id']} and create_day>={$weekday} and pay_status=9");
			$wt_item2=$this->mysql->fetchRow("select count(1)as cnt,sum(money) as money from sk_order where ma_id={$item['id']} and create_day>={$weekday}");
			$item['jt_cnt']=intval($jt_item['cnt']);
			$item['jt_cnt2']=intval($jt_item2['cnt']);
			if($item['jt_cnt2']>0){
				$item['jt_percent']=round(($item['jt_cnt']/$item['jt_cnt2'])*100,2).'%';
			}else{
				$item['jt_percent']='0%';
			}
			
			$item['jt_money']=floatval($jt_item['money']);
			$item['zt_cnt']=intval($zt_item['cnt']);
			$item['zt_cnt2']=intval($zt_item2['cnt']);
			if($item['zt_cnt2']>0){
				$item['zt_percent']=round(($item['zt_cnt']/$item['zt_cnt2'])*100,2).'%';
			}else{
				$item['zt_percent']='0%';
			}
			$item['zt_money']=floatval($zt_item['money']);
			$item['wt_cnt']=intval($wt_item['cnt']);
			$item['wt_cnt2']=intval($wt_item2['cnt']);
			if($item['wt_cnt2']>0){
				$item['wt_percent']=round(($item['wt_cnt']/$item['wt_cnt2'])*100,2).'%';
			}else{
				$item['wt_percent']='0%';
			}
			$item['wt_money']=floatval($wt_item['money']);
			
			if($item['ma_zkling']){
				$item['ma_zkling']=base64_decode($item['ma_zkling']);
			}else{
				$item['ma_zkling']='';
			}
			
			$item['edit']=hasPower($pageuser,'Pay_skma_update')?1:0;
			$item['delete']=hasPower($pageuser,'Pay_skma_delete')?1:0;
		}
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _skma_update(){
		$pageuser=checkPower();
		$params=$this->params;
		$item_id=intval($params['item_id']);
		$params['mtype_id']=intval($params['mtype_id']);
		$params['bank_id']=intval($params['bank_id']);
		$params['province_id']=intval($params['province_id']);
		$params['city_id']=intval($params['city_id']);
		$params['status']=intval($params['status']);
		$params['min_money']=floatval($params['min_money']);
		$params['max_money']=floatval($params['max_money']);
		if(!$params['mtype_id']){
			jReturn('-1','请选择支付类型');
		}else{
			$mtype=$this->mysql->fetchRow("select * from sk_mtype where id={$params['mtype_id']}");
			if(!$mtype){
				jReturn('-1','支付类型不正确');
			}elseif(!$mtype['is_open']){
				jReturn('-1','该支付类型暂未开放');
			}
		}
		
		if(!$params['province_id']||!$params['city_id']){
			jReturn('-1','请选择所在省份和城市');
		}
		
		if(!$params['account']){
			jReturn('-1','请填写所属账号');
		}else{
			$check_user=$this->mysql->fetchRow("select * from sys_user where account='{$params['account']}'");
			if(!$check_user){
				jReturn('-1','所属账号不正确');
			}
			$check_user['td_switch']=json_decode($check_user['td_switch'],true);
			if(!$check_user['td_switch'][$params['mtype_id']]){
				jReturn('-1','所属账号未开放该支付类型');
			}
		}
		if(!$params['ma_realname']){
			jReturn('-1','请填写收款姓名');
		}
		if(!$params['ma_account']){
			jReturn('-1','请填写收款账号');
		}
		
		if($mtype['type']==1){
			//基本类型无需额外信息
		}elseif($mtype['type']==2){
			if(!$params['ma_qrcode']){
				jReturn('-1','请上传收款码');
			}
		}elseif($mtype['type']==3){
			if(!$params['bank_id']){
				jReturn('-1','请选择开户行');
			}
		}elseif($mtype['type']==4){
			if(!$params['ma_zkling']){
				jReturn('-1','请填写吱口令');
			}
		}elseif($mtype['type']==5){
			$ma_zfbuid=str_replace(' ','',trim($params['ma_zfbuid']));
			$ma_zfbuid=implode('',explode(' ',$ma_zfbuid));
			if(!$ma_zfbuid){
				jReturn('-1','请填写支付宝UID');
			}
		}else{
			jReturn('-1','未知收款类型');
		}
		
		
		if(!$params['min_money']||$params['min_money']<0){
			$params['min_money']=floatval(getConfig('cnf_skm_min_money'));;
		}
		if(!$params['max_money']||$params['max_money']<0){
			$params['max_money']=floatval(getConfig('cnf_skm_max_money'));;
		}
		if($params['max_money']<$params['min_money']){
			jReturn('-1','最大收款不能小于最小收款');
		}
		$this->mysql->startTrans();
		
		$sk_ma=array(
			'mtype_id'=>$params['mtype_id'],
			'province_id'=>$params['province_id'],
			'city_id'=>$params['city_id'],
			'ma_account'=>$params['ma_account'],
			'ma_realname'=>$params['ma_realname'],
			'status'=>$params['status'],
			'uid'=>$check_user['id'],
			'min_money'=>$params['min_money'],
			'max_money'=>$params['max_money'],
			'fz_time'=>0
		);
		
		if($mtype['type']==2){
			$sk_ma['ma_qrcode']=$params['ma_qrcode'];
		}elseif($mtype['type']==3){
			$sk_ma['bank_id']=$params['bank_id'];
			$sk_ma['branch_name']=$params['branch_name'];
		}elseif($mtype['type']==4){
			$sk_ma['ma_zkmoney']=floatval($params['ma_zkmoney']);
			$sk_ma['ma_zkling']=$params['ma_zkling'];
			//$sk_ma['max_money']=floatval($params['ma_zkmoney']);
			//$sk_ma['min_money']=floatval($params['ma_zkmoney']);
		}elseif($mtype['type']==5){
			$sk_ma['ma_zfbuid']=$ma_zfbuid;
		}
		
		if(!$item_id){
			$sk_ma['create_time']=NOW_TIME;
			$res=$this->mysql->insert($sk_ma,'sk_ma');
			$item_id=$res;
		}else{
			$item=$this->mysql->fetchRow("select * from sk_ma where id={$item_id} and status<99");
			if(!$item){
				jReturn('-1','不存在相应的收款码');
			}
			if($pageuser['gid']>41){
				if($item['uid']!=$pageuser['id']){
					$down_arr=getDownUser($pageuser['id']);
					if(!in_array($item['uid'],$down_arr)){
						jReturn('-1','您没有权限操作该收款码');
					}
				}
			}
			$res=$this->mysql->update($sk_ma,"id={$item_id}",'sk_ma');
		}
		
		if($res===false){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		$sk_ma['id']=$item_id;
		actionLog(['opt_name'=>'更新收款码','sql_str'=>json_encode($sk_ma,256)],$this->mysql);
		$return_data=[
			'uid'=>$check_user['id'],
			'nickname'=>$check_user['nickname']
		];
		jReturn('1','操作成功',$return_data);
	}

	public function _skma_delete(){
		$pageuser=checkPower();
		$item_id=$this->params['item_id'];
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$item=$this->mysql->fetchRow("select * from sk_ma where id={$item_id} and status<99");
		if(!$item){
			jReturn('1','删除成功');
		}
		if($pageuser['gid']>41){
			if($item['uid']!=$pageuser['id']){
				jReturn('-1','您没有权限操作该收款码');
			}
		}
		$sk_ma=['status'=>99];
		$res=$this->mysql->update($sk_ma,"id={$item_id}",'sk_ma');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','删除成功');
	}
	
	//恢复收款码
	public function _skma_recovery(){
		$pageuser=checkPower();
		$item_id=$this->params['item_id'];
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$sk_ma=['status'=>1];
		$res=$this->mysql->update($sk_ma,"id={$item_id}",'sk_ma');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','操作成功');
	}
	
	//批量更新收款码
	public function _skma_allupdate(){
		$pageuser=checkPower();
		$params=$this->params;
		if(!$params['ms_account']){
			jReturn('-1','请填写码商账号');
		}
		$account=$this->mysql->fetchRow("select * from sys_user where account='{$params['ms_account']}' and status=2");
		if(!$account){
			jReturn('-1','不存在该账号或已被禁用');
		}
		if($pageuser['gid']>41){
			$down_arr=getDownUser($pageuser['id']);
			if(!in_array($account['id'],$down_arr)){
				jReturn('-1','该码商不是您的下级无法设置');
			}
		}
		$min_money=floatval($params['ms_min_money']);
		$max_money=floatval($params['ms_max_money']);
		if($min_money>$max_money){
			jReturn('-1','最小金额不能超过最大金额');
		}
		$sk_ma=[
			'min_money'=>$min_money,
			'max_money'=>$max_money
		];
		$res=$this->mysql->update($sk_ma,"uid={$account['id']} and status<99",'sk_ma');
		jReturn('1','操作成功');
	}
	
	public function _getCity(){
		checkLogin();
		$pid=intval($this->params['pid']);
		$city_arr=$this->mysql->fetchRows("select * from cnf_pc where pid={$pid} and pid>0");
		jReturn('1','ok',$city_arr);
	}
	
	
	/////////////////////////订单管理////////////////////////////
	/////////////////////////订单管理////////////////////////////
	
	//订单明细
	public function _order(){
		$pageuser=checkPower();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$mtype_arr=$this->getMtype($user);
		$isOrderHk=0;
		if($pageuser['gid']<42||in_array($pageuser['gid'],[85,91])){
			$cnf_mshk_signle=getConfig('cnf_mshk_signle');
			if($cnf_mshk_signle=='是'){
				$isOrderHk=1;
			}
		}
		$data=[
			'user'=>$user,
			'mtype_arr'=>$mtype_arr,
			'isOrderHk'=>$isOrderHk,
			'create'=>hasPower($pageuser,'Pay_order_create')?1:0
		];
		display('Pay/order.html',$data);
	}

	public function _order_list(){
		$pageuser=checkPower();
		$params=$this->_param();
		$params['s_mtype_id']=intval($params['s_mtype_id']);
		$params['s_pay_status']=intval($params['s_pay_status']);
		$params['s_notice_status']=intval($params['s_notice_status']);
		$params['s_is_create']=intval($params['s_is_create']);
		$where="where log.pay_status<99";
		if($params['s_start_time']&&$params['s_end_time']&&$params['s_start_time']<=$params['s_end_time']){
			$s_start_time=strtotime($params['s_start_time'].' 00:00:01');
			$s_end_time=strtotime($params['s_end_time'].' 23:59:59');
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			$uid_arr[]=$pageuser['id'];
			$uid_str=implode(',',$uid_arr);
			$where.=" and (log.suid in({$uid_str}) or log.muid in({$uid_str}))";
		}
		$where.=empty($params['s_mtype_id'])?'':" and log.ptype={$params['s_mtype_id']}";
		$where.=empty($params['s_pay_status'])?'':" and log.pay_status={$params['s_pay_status']}";
		$where.=empty($params['s_notice_status'])?'':" and log.notice_status={$params['s_notice_status']}";
		
		if($params['s_is_create']){
			if($params['s_is_create']==1){
				$where.=" and log.is_create={$params['s_is_create']}";
			}else{
				$where.=" and log.is_create=0";
			}
		}
		
		if(isset($params['s_hk_status'])&&$params['s_hk_status']!='all'){
			$params['s_hk_status']=intval($params['s_hk_status']);
			$where.=" and (log.pay_status=9 and log.hk_status={$params['s_hk_status']})";
		}
		
		if($params['s_ma_account']){
			$s_skma=$this->mysql->fetchRow("select id from sk_ma where ma_account='{$params['s_ma_account']}'");
			$s_skma_id=intval($s_skma['id']);
			$where.=" and log.ma_id={$s_skma_id}";
		}
		
		if($params['s_keyword2']){
			$s_user=$this->mysql->fetchRow("select * from sys_user where account='{$params['s_keyword2']}' or phone='{$params['s_keyword2']}' or nickname='{$params['s_keyword2']}'");
			$uid_arr2=getDownUser($s_user['id']);
			$uid_arr2[]=$s_user['id'];
			$uid_str2=implode(',',$uid_arr2);
			$where.=" and (log.suid in({$uid_str2}) or log.muid in({$uid_str2}))";
		}
		$where.=empty($params['s_keyword'])?'':" and (log.order_sn='{$params['s_keyword']}' or log.out_order_sn='{$params['s_keyword']}' or log.order_sn like '%{$params['s_keyword']}%' or su.account='{$params['s_keyword']}' or su.nickname like '%{$params['s_keyword']}%' or mu.account='{$params['s_keyword']}' or mu.nickname like '%{$params['s_keyword']}%')";
		
		$sql_cnt="select count(1) as cnt,sum(log.money) as sum_money,sum(log.fee) as sum_fee,sum(real_money) as sum_real_money  
		from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sk_mtype mt on log.ptype=mt.id
		left join sys_user mu on log.muid=mu.id {$where}";
		$count_item=$this->mysql->fetchRow($sql_cnt);
		$sql="select log.*,su.account as su_account,su.nickname as su_nickname,
		mu.account as mu_account,mu.nickname as mu_nickname,mt.name as mtype_name,bk.bank_name 
		from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sk_mtype mt on log.ptype=mt.id 
		left join sys_user mu on log.muid=mu.id 
		left join cnf_bank bk on log.ma_bank_id=bk.id 
		{$where} order by log.id desc";
		//echo $sql;exit;
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		$cnf_pay_status=getConfig('cnf_pay_status');
		$cnf_notice_status=getConfig('cnf_notice_status');
		$cnf_order_hkstatus=getConfig('cnf_order_hkstatus');
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i:s',$item['create_time']);
			if($item['pay_time']){
				$item['pay_time']=date('m-d H:i:s',$item['pay_time']);
			}else{
				$item['pay_time']='';
			}
			$item['money']=floatval($item['money']);
			$item['real_money']=floatval($item['real_money']);
			$item['fee']=floatval($item['fee']);
			$item['pay_status_flag']=$cnf_pay_status[$item['pay_status']];
			$item['notice_status_flag']=$cnf_notice_status[$item['notice_status']];
			$item['hk_status_flag']=$cnf_order_hkstatus[$item['hk_status']];
			
			$up_user=getUpUser($item['muid'],true);
			$up_arr=[];
			foreach($up_user as $uuv){
				if($uuv['gid']==85){
					$up_arr[]=[
						'account'=>$uuv['account'],
						'nickname'=>$uuv['nickname']
					];
				}
			}
			$item['up_arr']=$up_arr;
			
			$item['cancel']=hasPower($pageuser,'Pay_order_cancel')?1:0;
			$item['check']=hasPower($pageuser,'Pay_order_check')?1:0;
			$item['notice']=hasPower($pageuser,'Pay_order_notice')?1:0;
			$item['match']=hasPower($pageuser,'Pay_order_match')?1:0;
			$item['delete']=hasPower($pageuser,'Pay_order_delete')?1:0;
			$item['budan']=hasPower($pageuser,'Pay_order_budan')?1:0;
		}
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'sum_money'=>floatval($count_item['sum_money']),
			'sum_fee'=>floatval($count_item['sum_fee']),
			'sum_real_money'=>floatval($count_item['sum_real_money']),
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	//删除订单
	public function _order_delete(){
		$pageuser=checkPower();
		if($pageuser['gid']>41){
			jReturn('-1','没有权限');
		}
		$item_id=intval($this->params['item_id']);
		$order=$this->mysql->fetchRow("select * from sk_order where id={$item_id} and pay_status<99");
		if(!$order){
			jReturn('-1','订单不存在');
		}
		if($order['pay_status']<=2){
			jReturn('-1','订单当前状态不可删除');
		}
		$sk_order=['pay_status'=>99];
		$res=$this->mysql->update($sk_order,"id={$item_id}",'sk_order');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		actionLog(['opt_name'=>'删除订单','sql_str'=>json_encode($order,256)],$this->mysql);
		jReturn('1','操作成功');
	}
	
	//确认收款
	public function _order_check(){
		//$pageuser=checkPower();
		$item_id=intval($this->params['item_id']);
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$this->mysql->startTrans();
		$order=$this->mysql->fetchRow("select * from sk_order where id={$item_id} for update");
		if(!$order){
			jReturn('-1','不存在相应订单');
		}else{
			if($order['pay_status']>2){
				jReturn('-1','该订单当前状态不可操作');
			}
		}
		$user=$this->mysql->fetchRow("select id,fz_balance from sys_user where id={$order['muid']} for update");
		if($user['fz_balance']<$order['money']){
			jReturn('-1','码商的保证金不足，无法确认');
		}
		$sk_order=[
			'check_id'=>$pageuser['id'],
			'pay_status'=>9,
			'pay_time'=>NOW_TIME,
			'pay_day'=>date('Ymd',NOW_TIME)
		];
		$res=$this->mysql->update($sk_order,"id={$order['id']}",'sk_order');
		//扣掉对应的冻结保证金
		$user_data=[
			'fz_balance'=>$user['fz_balance']-$order['money']
		];
		$res2=$this->mysql->update($user_data,"id={$user['id']}",'sys_user');
		$res3=balanceLog($user,2,14,-$order['money'],$order['id'],$order['order_sn'],$this->mysql);
		if($order['ptype']==1){
			$res4=$this->delSkma($order['ma_id'],$this->mysql);
		}else{
			$res4=true;
		}
		if(!$res||!$res2||!$res3){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		
		//写入异步通知记录
		$cnf_notice=[
			'type'=>2,
			'fkey'=>$order['order_sn'],
			'create_time'=>NOW_TIME,
			'remark'=>'确认成功通知支付用户'
		];
		$this->mysql->insert($cnf_notice,'cnf_notice');
		
		$order=orderNotify($item_id,$this->mysql);
		if(!$order){
			jReturn('-1','订单已确认，但回调给商户异常');
		}
		$return_data=[
			'notice_status'=>$order['notice_status'],
			'notice_status_flag'=>$order['notice_status_flag'],
			'notice_msg'=>$order['notice_msg'],
			'pay_status'=>$order['pay_status'],
			'pay_status_flag'=>$order['pay_status_flag'],
			'pay_time'=>date('m-d H:i',$order['pay_time'])
		];
		jReturn('1','操作成功',$return_data);
	}
	
	//取消订单
	public function _order_cancel(){
		$pageuser=checkPower();
		$item_id=intval($this->params['item_id']);
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$this->mysql->startTrans();
		$order=$this->mysql->fetchRow("select * from sk_order where id={$item_id} for update");
		if(!$order){
			jReturn('-1','不存在相应订单');
		}else{
			if($order['pay_status']!=2){
				jReturn('-1','该订单当前状态不可操作');
			}
		}
		$user=$this->mysql->fetchRow("select id,sx_balance,fz_balance from sys_user where id={$order['muid']} for update");
		if($user['fz_balance']<$order['money']){
			jReturn('-1','码商的保证金不足，无法取消');
		}
		$sk_order=[
			'check_id'=>$pageuser['id'],
			'pay_status'=>4,
			'cancel_time'=>NOW_TIME
		];
		$res=$this->mysql->update($sk_order,"id={$order['id']}",'sk_order');
		//退还保证金到接单余额
		$user_data=[
			'fz_balance'=>$user['fz_balance']-$order['money'],
			'sx_balance'=>$user['sx_balance']+$order['money']
		];
		$res2=$this->mysql->update($user_data,"id={$user['id']}",'sys_user');
		$res3=balanceLog($user,2,14,-$order['money'],$order['id'],$order['order_sn'],$this->mysql);
		$res4=balanceLog($user,3,15,$order['money'],$order['id'],$order['order_sn'],$this->mysql);
		if(!$res||!$res2||!$res3||!$res4){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		
		$cnf_pay_status=getConfig('cnf_pay_status');
		$return_data=[
			'pay_status'=>$sk_order['pay_status'],
			'pay_status_flag'=>$cnf_pay_status[$sk_order['pay_status']],
			'cancel_time'=>date('m-d H:i',$sk_order['cancel_time'])
		];
		jReturn('1','操作成功',$return_data);
	}
	
	//变更匹配
	public function _order_match(){
		$pageuser=checkPower();
		$item_id=intval($this->params['item_id']);
		$account=$this->params['account'];
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		if(!$account){
			jReturn('-1','请填写新码商账号');
		}
		$new_user=$this->mysql->fetchRow("select * from sys_user where account='{$account}'");
		if(!$new_user){
			jReturn('-1','新码商账号不存在');
		}
		$this->mysql->startTrans();
		$order=$this->mysql->fetchRow("select * from sk_order where id={$item_id} for update");
		if(!$order||$order['pay_status']==99){
			jReturn('-1','操作的订单号不存在');
		}else{
			if($order['pay_status']!=1&&$order['pay_status']!=2){
				jReturn('-1','该订单当前状态不可变更匹配');
			}
		}
		if($order['muid']==$new_user['id']){
			jReturn('-1','订单已是目标码商的无需变更');
		}
		$old_user=$this->mysql->fetchRow("select * from sys_user where id={$order['muid']} for update");
		if($new_user['sx_balance']<$order['money']){
			jReturn('-1','目标码商接单余额不足，无法变更匹配');
		}
		if($old_user['fz_balance']<$order['money']){
			jReturn('-1','原码商已冻结保证金不足，无法变更匹配');
		}
		$new_skma=$this->mysql->fetchRow("select * from sk_ma where uid={$new_user['id']} and mtype_id={$order['ptype']} and status=2 and min_money<={$order['money']} and max_money>={$order['money']}");
		if(!$new_skma){
			jReturn('-1','目标码商没有符合条件的码，无法变更匹配');
		}
		$new_user=$this->mysql->fetchRow("select * from sys_user where id={$new_user['id']} for update");
		
		$sk_order=[
			'ma_id'=>$new_skma['id'],
			'muid'=>$new_skma['uid'],
			'ma_account'=>$new_skma['ma_account'],
			'ma_realname'=>$new_skma['ma_realname'],
			'ma_qrcode'=>$new_skma['ma_qrcode'],
			'ma_bank_id'=>$new_skma['bank_id'],
			'ma_branch_name'=>$new_skma['branch_name'],
			'ma_zkling'=>$new_skma['ma_zkling'],
			'ma_zfbuid'=>$new_skma['ma_zfbuid']
		];
		$new_user_data=[
			'sx_balance'=>$new_user['sx_balance']-$order['money'],
			'fz_balance'=>$new_user['fz_balance']+$order['money']
		];
		$old_user_data=[
			'fz_balance'=>$old_user['fz_balance']-$order['money'],
			'sx_balance'=>$old_user['sx_balance']+$order['money']
		];
		$sk_matchlog=[
			'oid'=>$order['id'],
			'ori_maid'=>$order['ma_id'],
			'new_maid'=>$sk_order['ma_id'],
			'create_id'=>$pageuser['id'],
			'create_time'=>NOW_TIME
		];
		$res=$this->mysql->insert($sk_matchlog,'sk_matchlog');
		$res2=$this->mysql->update($sk_order,"id={$order['id']}",'sk_order');
		$res3=$this->mysql->update($new_user_data,"id={$new_user['id']}",'sys_user');
		$res4=$this->mysql->update($old_user_data,"id={$old_user['id']}",'sys_user');
		$res5=balanceLog($new_user,3,13,-$order['money'],$res,'匹配冻结:'.$order['order_sn'],$this->mysql);
		$res6=balanceLog($new_user,2,13,$order['money'],$res,'匹配冻结:'.$order['order_sn'],$this->mysql);
		$res7=balanceLog($old_user,2,14,-$order['money'],$res,'匹配冻结退还:'.$order['order_sn'],$this->mysql);
		$res8=balanceLog($old_user,3,14,$order['money'],$res,'匹配冻结退还:'.$order['order_sn'],$this->mysql);
		if($res&&$res2&&$res3&&$res4&&$res5&&$res6&&$res7&&$res8){
			$this->mysql->commit();
			//通知码商
			orderNoticeMs($order['order_sn']);
			$return_data=[
				'mu_account'=>$new_user['account'],
				'mu_nickname'=>$new_user['nickname']
			];
			jReturn('1','变更匹配成功',$return_data);
		}
		$this->mysql->rollback();
		jReturn('-1','系统繁忙请稍后再试');
	}
	
	//创建订单-异常重新发起相同金额
	public function _order_create(){
		$pageuser=checkPower();
		$params=$this->params;
		$order=$this->mysql->fetchRow("select * from sk_order where order_sn='{$params['order_sn']}' and pay_status<99");
		if(!$order){
			jReturn('-1','不存在相应的订单');
		}else{
			if($order['pay_status']==9){
				//jReturn('-1','该订单已支付应该不是异常订单');
			}
		}
		$money=floatval($params['money']);
		if($money<0.01){
			jReturn('-1','实付金额不正确');
		}
		//商户
		$user=$this->mysql->fetchRow("select * from sys_user where id={$order['suid']}");
		$user['td_rate']=json_decode($user['td_rate'],true);
		$this->mysql->startTrans();
		//码商
		$ma_user=$this->mysql->fetchRow("select * from sys_user where id={$order['muid']} for update");
		if($ma_user['sx_balance']<$money){
			jReturn('-1','对应码商的接单余额不足');
		}
		$sys_user=[
			'sx_balance'=>$ma_user['sx_balance']-$money,
			'fz_balance'=>$ma_user['fz_balance']+$money
		];
		$rate=$user['td_rate'][$order['ptype']];
		$fee=$money*$rate;
		$sk_order=[
			'muid'=>$order['muid'],//码商id
			'suid'=>$user['id'],//商户id
			'ptype'=>$order['ptype'],
			'order_sn'=>$order['order_sn'].'_'.mt_rand(1000,9999),
			'out_order_sn'=>$order['out_order_sn'],
			'goods_desc'=>$order['goods_desc'],
			'money'=>$money,
			'real_money'=>$money-$fee,
			'rate'=>$rate,
			'fee'=>$fee,
			'ma_id'=>$order['ma_id'],//码id
			'ma_account'=>$order['ma_account'],
			'ma_realname'=>$order['ma_realname'],
			'ma_qrcode'=>$order['ma_qrcode'],
			'ma_bank_id'=>$order['ma_bank_id'],
			'ma_branch_name'=>$order['ma_branch_name'],
			'ma_zkling'=>$order['ma_zkling'],
			'order_ip'=>$order['order_ip'],
			'notify_url'=>$order['notify_url'],
			'return_url'=>$order['return_url'],
			'create_time'=>NOW_TIME,
			'is_create'=>1,
			'create_day'=>date('Ymd',NOW_TIME),
			'reffer_url'=>$order['reffer_url']
		];
		$res=$this->mysql->insert($sk_order,'sk_order');
		$res2=$this->mysql->update($sys_user,"id={$ma_user['id']}",'sys_user');
		$res3=balanceLog($ma_user,3,13,-$money,$res,$sk_order['order_sn'],$this->mysql);
		if(!$res||!$res2||!$res3){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		jReturn('1','操作成功');
	}
		
	//补单
	public function _order_budan(){
		$pageuser=checkPower();
		$item_id=intval($this->params['item_id']);
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		
		$sql="select * from sk_order where id='{$item_id}'";
		$order=$this->mysql->fetchRow($sql);
		if(!$order){
			jReturn('-1','不存在相应的订单');
		}
		if($order['pay_status']!=3){
			jReturn('-1','该订单当前状态不可补单');
		}
		$this->mysql->startTrans();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$order['muid']} for update");

		if($user['sx_balance']<$order['money']){
			jReturn('-1','码商的接单余额不足，无法补单');
		}
		$sys_user=[
			'sx_balance'=>$user['sx_balance']-$order['money']
		];
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		$res2=balanceLog($user,3,16,-$order['money'],$order['id'],$order['order_sn'],$this->mysql);

		$sk_order=[
			'check_id'=>$pageuser['id'],
			'pay_status'=>9,
			'pay_time'=>NOW_TIME,
			'pay_day'=>date('Ymd',NOW_TIME)
		];
		$res3=$this->mysql->update($sk_order,"id={$order['id']}",'sk_order');
		if($order['ptype']==11){
			$res4=$this->delSkma($order['ma_id'],$this->mysql);
		}else{
			$res4=true;
		}
		if(!$res||!$res2||!$res3||!$res4){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		//发起回调给商户
		$order=orderNotify($order['id'],$this->mysql);
			
		$return_data=[
			'pay_time'=>date('Y-m-d H:i',$order['pay_time']),
			'pay_status'=>$order['pay_status'],
			'pay_status_flag'=>$order['pay_status_flag'],
			'notice_status'=>$order['notice_status'],
			'notice_status_flag'=>$order['notice_status_flag'],
			'notice_msg'=>$order['notice_msg']
		];
		jReturn('1','操作成功',$return_data);
	}
	
	//回调
	public function _order_notice(){
		checkPower();
		$item_id=intval($this->params['item_id']);
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$order=orderNotify($item_id,$this->mysql);
		if(!$order){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$return_data=[
			'notice_status'=>$order['notice_status'],
			'notice_status_flag'=>$order['notice_status_flag'],
			'notice_msg'=>$order['notice_msg']
		];
		jReturn('1','操作成功',$return_data);
	}
	
	//删除收款码
	private function delSkma($ma_id,$mysql){
		//return true;//因为不是固定金额-所以不再删除
		$sk_ma=[
			'status'=>99,
			'fz_time'=>NOW_TIME+90*86400
		];
		$res=$mysql->update($sk_ma,"id={$ma_id}",'sk_ma');
		if($res===false){
			return false;
		}
		return true;
	}
	
	///////////////////////////分成返佣记录////////////////////////////

	//返佣分成记录
	public function _yong(){
		checkPower();
		$data=[];
		display('Pay/yong.html',$data);
	}

	public function _yong_list(){
		$pageuser=checkLogin();
		$params=$this->params;
		$params['s_type']=intval($params['s_type']);
		$where="where 1";
		if($params['s_start_time']&&$params['s_end_time']&&$params['s_start_time']<=$params['s_end_time']){
			$s_start_time=strtotime($params['s_start_time'].' 00:00:01');
			$s_end_time=strtotime($params['s_end_time'].' 23:59:59');
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			$uid_arr[]=$pageuser['id'];
			$uid_str=implode(',',$uid_arr);
			$where.=" and log.uid in({$uid_str})";
		}
		$where.=empty($params['s_type'])?'':" and log.type={$params['s_type']}";
		$where.=empty($params['s_keyword'])?'':" and (u.account='{$params['s_keyword']}' or u.nickname like '%{$params['s_keyword']}%')";
		$sql_cnt="select count(1) as cnt,sum(log.money) as sum_money 
		from sk_yong log 
		left join sys_user u on log.uid=u.id 
		left join sk_order od on log.fkey=od.id {$where}";
		$count_item=$this->mysql->fetchRow($sql_cnt);
		$sql="select log.*,od.money as order_money,u.account,u.nickname from sk_yong log 
		left join sys_user u on log.uid=u.id 
		left join sk_order od on log.fkey=od.id
		{$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		$cnf_yong_type=getConfig('cnf_yong_type');
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i',$item['create_time']);
			$item['type_flag']=$cnf_yong_type[$item['type']];
		}
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}

	///////////////////////////结束////////////////////////////
	
}

?>