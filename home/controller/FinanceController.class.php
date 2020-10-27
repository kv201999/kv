<?php
!defined('ROOT_PATH') && exit;
class FinanceController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	//充值
	public function _pay(){
		$pageuser=checkLogin();
		$data=[
			'user'=>$pageuser,
			'bank_arr'=>$this->getSkbank(true)
		];
		$this->display($data);
	}
	
	public function _payAct(){
		$pageuser=checkLogin();
		$bk_id=intval($this->params['skbank_id']);
		$money=floatval($this->params['money']);
		$cnf_pay_min_money=getConfig('cnf_pay_min_money');
		$cnf_pay_max_money=getConfig('cnf_pay_max_money');
		if($money<$cnf_pay_min_money){
			jReturn('-1',"单笔最小充值金额{$cnf_pay_min_money}");
		}
		if($money>$cnf_pay_max_money){
			jReturn('-1',"单笔最大充值金额{$cnf_pay_max_money}");
		}
		if(!$bk_id){
			jReturn('-1','请选择支付方式');
		}
		$skbank=$this->mysql->fetchRow("select log.*,bk.bank_name from sk_bank log left join cnf_bank bk on log.bank_id=bk.id where log.id={$bk_id} and log.status=2");
		if(!$skbank){
			jReturn('-1','不存在该收款账户或该账户已下线');
		}
		$check_paylog=$this->mysql->fetchRow("select * from cnf_paylog where uid={$pageuser['id']} and pay_status<3");
		if($check_paylog){
			jReturn('-1','当前有待审核订单，请耐心等待审核');
		}
		$cnf_paylog=[
			'aid'=>intval($skbank['uid']),
			'uid'=>$pageuser['id'],
			'money'=>$money,
			'order_sn'=>'H'.date('YmdHis').mt_rand(11111,99999),
			'skbank_id'=>$bk_id,
			'create_time'=>NOW_TIME,
			'skbank'=>json_encode($skbank,256)
		];
		$res=$this->mysql->insert($cnf_paylog,'cnf_paylog');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$return_data=['order_sn'=>$cnf_paylog['order_sn']];
		jReturn('1','订单提交成功',$return_data);
	}
	
	//充值订单详情
	public function _payInfo(){
		$pageuser=checkLogin();
		$order_sn=$this->params['osn'];
		if(!$order_sn){
			header("Location:/?c=Finance&a=pay");
			exit;
		}
		$sql="select log.*,u.account,au.account as a_account,au.nickname as a_nickname from cnf_paylog log 
		left join sys_user u on log.uid=u.id 
		left join sys_user au on log.aid=au.id 
		where log.order_sn='{$order_sn}'";
		$paylog=$this->mysql->fetchRow($sql);
		if(!$paylog){
			header("Location:/?c=Finance&a=pay");
			exit;
		}
		if($pageuser['gid']!=1){
			if($paylog['uid']!=$pageuser['id']){
				header("Location:/?c=Finance&a=pay");
				exit;
			}
		}
		$cnf_paylog_status=getConfig('cnf_paylog_status');
		$paylog['pay_status_flag']=$cnf_paylog_status[$paylog['pay_status']];
		$paylog['create_time']=date('Y-m-d H:i:s',$paylog['create_time']);
		$paylog['banners']=json_decode($paylog['banners'],true);
		if(!$paylog['banners']){
			$paylog['banners']=[];
		}
		$paylog['skbank']=json_decode($paylog['skbank'],true);
		$data=[
			'paylog'=>$paylog
		];
		$this->display($data);
	}
	
	//已支付提交凭证
	public function _payUpdate(){
		$pageuser=checkLogin();
		$order_sn=$this->params['osn'];
		$this->mysql->startTrans();
		$paylog=$this->mysql->fetchRow("select * from cnf_paylog where order_sn='{$order_sn}' for update");
		if(!$paylog){
			jReturn('-1','不存在相应订单');
		}else{
			if($paylog['pay_status']!=1){
				jReturn('-1','该订单当前状态不可操作');
			}
		}
		if($pageuser['gid']!=1){
			if($paylog['uid']!=$pageuser['id']){
				jReturn('-1','您没有该订单的操作权限');
			}
		}
		$banners=$this->params['banners'];
		$remark=$this->params['remark'];
		$cnf_paylog=[
			'pay_status'=>2,
			'tj_time'=>NOW_TIME,
			'pay_realname'=>$this->params['pay_realname'],
			'pay_account'=>$this->params['pay_account'],
			'remark'=>$remark,
			'banners'=>json_encode($banners,256)
		];
		$res=$this->mysql->update($cnf_paylog,"id={$paylog['id']}",'cnf_paylog');
		if(!$res){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		
		//$url="{$_ENV['SOCKET']['HTTP_URL']}/?c=Admin&a=noticePay&osn={$paylog['order_sn']}";
		//curl_get($url);
		
		jReturn('1','提交成功');
	}
	
	//充值记录
	public function _paylog(){
		checkLogin();
		$data=[];
		$this->display($data);
	}
	
	public function _paylog_list(){
		$pageuser=checkLogin();
		$pageSize=10;
		$params=$this->params;
		$params['page']=intval($params['page']);
		if(!$params['page']){
			$params['page']=1;
		}

		$where="where log.uid={$pageuser['id']}";
		$count_item=$this->mysql->fetchRow("select count(1) as cnt,sum(log.money) as sum_money from cnf_paylog log {$where}");
		$sql="select log.create_time,log.order_sn,log.money,log.pay_status from cnf_paylog log {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		//echo $sql;exit;
		$cnf_paylog_status=getConfig('cnf_paylog_status');
		foreach($list as &$item){
			$item['money']=floatval($item['money']);
			if($item['pay_time']){
				$item['pay_time_flag']=date('m-d H:i',$item['pay_time']);
			}else{
				$item['check_time_flag']='';
			}
			//$item['order_sn']='***'.substr($item['order_sn'],-6);
			$item['pay_status_flag']=$cnf_paylog_status[$item['pay_status']];
			$item['create_time_flag']=date('m-d H:i',$item['create_time']);
		}
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$pageSize,
			'page'=>$params['page']+1,
			'pages'=>ceil($count_item['cnt']/$pageSize)
		);
		jReturn('1','ok',$data);
	}
	
	////////////////////充值结束/////////////////////
	
	
	////////////////////提现开始/////////////////////
	
	//提现
	public function _cash(){
		$pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$banklog=$this->mysql->fetchRow("select log.*,bk.bank_name from cnf_banklog log left join cnf_bank bk on log.bank_id=bk.id where log.uid={$user['id']}");
		if($banklog){
			$banklog['bank_account']='***'.substr($banklog['bank_account'],-4);
		}
		$user['balance']=floatval($user['balance']);
		$user['fz_balance']=floatval($user['fz_balance']);
		$user['sx_balance']=floatval($user['sx_balance']);
		$user['phone']=substr($user['phone'],0,3).'***'.substr($user['phone'],-4);
		
		$cash_cnf=getConfig('cash_cnf');
		$day_time_arr=explode('-',$cash_cnf['day_time']);
		if(!$cash_cnf['weekend']){
			$cash_time_str="可提现时间：周一至周五 {$day_time_arr[0]} - {$day_time_arr[1]}";
		}else{
			$cash_time_str="可提现时间：周一至周日 {$day_time_arr[0]} - {$day_time_arr[1]}";
		}
		$cash_charge_money=getConfig('cash_charge_money');
		$fee_str="提现金额 × {$cash_charge_money[1]}";
		if($cash_charge_money[2]>0){
			$fee_str.=" + {$cash_charge_money[2]}";
		}
		
		$data=[
			'title'=>'提现',
			'user'=>$user,
			'banklog'=>$banklog,
			'cash_time_str'=>$cash_time_str,
			'fee_str'=>$fee_str
		];
		$this->display($data);
	}

	//提现操作
	public function _cashAct(){
		$pageuser=checkLogin();
		$params=$this->params;
		$money=floatval($params['money']);
		
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
		
		
		$bank=$this->mysql->fetchRow("select log.*,bk.bank_name from cnf_banklog log left join cnf_bank bk on log.bank_id=bk.id where log.uid={$pageuser['id']}");
		if(!$bank){
			jReturn('-1','请先绑定银行卡');
		}
		
		$this->mysql->startTrans();
		$user=$this->mysql->fetchRow("select id,balance from sys_user where id={$pageuser['id']} for update");
		
		$new_balance=$user['balance']-$money;
		if($new_balance<0){
			jReturn('-1','可提现余额不足');
		}
		$user_data=['balance'=>$new_balance];
		$cash_charge_money=getConfig('cash_charge_money');
		$fee=$money*$cash_charge_money[1]+$cash_charge_money[2];
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

	//提现记录
	public function _cashlog_list(){
		$pageuser=checkLogin();
		$pageSize=10;
		$params=$this->params;
		$params['page']=intval($params['page']);
		if(!$params['page']){
			$params['page']=1;
		}

		$where="where log.uid={$pageuser['id']}";
		$count_item=$this->mysql->fetchRow("select count(1) as cnt,sum(log.money) as sum_money from cnf_cashlog log {$where}");
		$sql="select log.create_time,log.csn,log.money,log.real_money,log.fee,log.remark,
		log.ori_balance,log.new_balance,log.status,log.bank_idcard,bk.bank_name,
		log.bank_phone,log.branch_name,log.bank_account,log.bank_realname,log.check_time 
		from cnf_cashlog log left join cnf_banklog blog on log.blog_id=blog.id 
		left join cnf_bank bk on blog.bank_id=bk.id {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		//echo $sql;exit;
		$user_cash_status=getConfig('user_cash_status');
		foreach($list as &$item){
			if($item['check_time']){
				$item['check_time_flag']=date('m-d H:i',$item['check_time']);
			}else{
				$item['check_time_flag']='';
			}
			$item['status_flag']=$user_cash_status[$item['status']];
			$item['create_time_flag']=date('m-d H:i',$item['create_time']);
		}
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$pageSize,
			'page'=>$params['page']+1,
			'pages'=>ceil($count_item['cnt']/$pageSize)
		);
		jReturn('1','ok',$data);
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

	////////////////////提现结束/////////////////////
	
	////////////////////我要回款开始/////////////////////
	public function _hkuan(){
		$pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$data=[
			'user'=>$user,
			'bank_arr'=>$this->getSkbank(true)
		];
		$this->display($data);
	}
	
	public function _hkuanAct(){
		$pageuser=checkLogin();
		$cnf_mshk_signle=getConfig('cnf_mshk_signle');
		if($cnf_mshk_signle=='是'){
			jReturn('-1','已开启单笔回款模式，请到订单列表里面操作回款');
		}
		$bk_id=intval($this->params['skbank_id']);
		$money=floatval($this->params['money']);
		if(!$bk_id){
			jReturn('-1','请选择上级收款账户');
		}
		$skbank=$this->mysql->fetchRow("select log.*,bk.bank_name from sk_bank log left join cnf_bank bk on log.bank_id=bk.id where log.id={$bk_id} and log.status=2");
		if(!$skbank){
			jReturn('-1','不存在该收款账户或该账户已下线');
		}
		$check_item=$this->mysql->fetchRow("select * from sk_agent_hklog where uid={$pageuser['id']} and status=1");
		if($check_item){
			jReturn('-1','当前有待审核回款订单，请耐心等待审核');
		}
		$this->mysql->startTrans();
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
			'skbank'=>json_encode($skbank,256)
		];
		$res=$this->mysql->insert($sk_agent_hklog,'sk_agent_hklog');
		$res2=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		$res3=balanceLog($user,4,22,-$money,$res,$sk_agent_hklog['order_sn'],$this->mysql);
		if(!$res||!$res2||!$res3){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		$return_data=['order_sn'=>$sk_agent_hklog['order_sn']];
		jReturn('1','回款订单提交成功',$return_data);
	}
	
	//回款订单详情
	public function _hkuanInfo(){
		$pageuser=checkLogin();
		$order_sn=$this->params['osn'];
		if(!$order_sn){
			header("Location:/?c=Finance&a=hkuan");
			exit;
		}
		$sql="select log.*,u.account,au.account as a_account,au.nickname as a_nickname from sk_agent_hklog log 
		left join sys_user u on log.uid=u.id 
		left join sys_user au on log.aid=au.id 
		where log.order_sn='{$order_sn}'";
		$item=$this->mysql->fetchRow($sql);
		if(!$item){
			header("Location:/?c=Finance&a=hkuan");
			exit;
		}
		if($pageuser['gid']!=1){
			if($item['uid']!=$pageuser['id']){
				header("Location:/?c=Finance&a=pay");
				exit;
			}
		}
		$cnf_agent_hkstatus=getConfig('cnf_agent_hkstatus');
		$item['status_flag']=$cnf_agent_hkstatus[$item['status']];
		$item['create_time']=date('Y-m-d H:i:s',$item['create_time']);
		$item['banners']=json_decode($item['banners'],true);
		if(!$item['banners']){
			$item['banners']=[];
		}
		$item['skbank']=json_decode($item['skbank'],true);
		$data=[
			'info'=>$item
		];
		$this->display($data);
	}
	
	//已支付提交凭证
	public function _hkuanUpdate(){
		$pageuser=checkLogin();
		$order_sn=$this->params['osn'];
		$this->mysql->startTrans();
		$item=$this->mysql->fetchRow("select * from sk_agent_hklog where order_sn='{$order_sn}' for update");
		if(!$item){
			jReturn('-1','不存在相应订单');
		}else{
			if($item['status']!=1){
				jReturn('-1','该订单当前状态不可操作');
			}
		}
		if($pageuser['gid']!=1){
			if($item['uid']!=$pageuser['id']){
				jReturn('-1','您没有该订单的操作权限');
			}
		}
		$banners=$this->params['banners'];
		$remark=$this->params['remark'];
		$sk_agent_hklog=[
			'status'=>2,
			'tj_time'=>NOW_TIME,
			'pay_realname'=>$this->params['pay_realname'],
			'pay_account'=>$this->params['pay_account'],
			'remark'=>$remark,
			'banners'=>json_encode($banners,256)
		];
		$res=$this->mysql->update($sk_agent_hklog,"id={$item['id']}",'sk_agent_hklog');
		if(!$res){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		
		//$url="{$_ENV['SOCKET']['HTTP_URL']}/?c=Admin&a=noticePay&osn={$item['order_sn']}";
		//curl_get($url);
		
		jReturn('1','提交成功');
	}
	
	//回款记录
	public function _hkuanlog(){
		checkLogin();
		$data=[];
		$this->display($data);
	}
	
	public function _hkuanlog_list(){
		$pageuser=checkLogin();
		$pageSize=10;
		$params=$this->params;
		$params['page']=intval($params['page']);
		if(!$params['page']){
			$params['page']=1;
		}

		$where="where log.uid={$pageuser['id']}";
		$count_item=$this->mysql->fetchRow("select count(1) as cnt,sum(log.money) as sum_money from sk_agent_hklog log {$where}");
		$sql="select log.create_time,log.order_sn,log.money,log.status from sk_agent_hklog log {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		//echo $sql;exit;
		$cnf_agent_hkstatus=getConfig('cnf_agent_hkstatus');
		foreach($list as &$item){
			$item['money']=floatval($item['money']);
			if($item['pay_time']){
				$item['pay_time_flag']=date('m-d H:i',$item['pay_time']);
			}else{
				$item['check_time_flag']='';
			}
			//$item['order_sn']='***'.substr($item['order_sn'],-6);
			$item['status_flag']=$cnf_agent_hkstatus[$item['status']];
			$item['create_time_flag']=date('m-d H:i',$item['create_time']);
		}
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$pageSize,
			'page'=>$params['page']+1,
			'pages'=>ceil($count_item['cnt']/$pageSize)
		);
		jReturn('1','ok',$data);
	}
	
	
	////////////////////我要回款结束/////////////////////
	
	
	//返佣（分成）记录
	public function _yong(){
		checkLogin();
		$data=[];
		$this->display($data);
	}

	public function _yong_list(){
		$pageuser=checkLogin();
		$pageSize=10;
		$params=$this->params;
		$params['page']=intval($params['page']);
		if(!$params['page']){
			$params['page']=1;
		}
		$where="where log.uid={$pageuser['id']} and log.type=1";
		if($params['s_start_time']&&$params['s_end_time']&&$params['s_start_time']<=$params['s_end_time']){
			$s_start_time=strtotime($params['s_start_time'].' 00:00:01');
			$s_end_time=strtotime($params['s_end_time'].' 23:59:59');
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		//$where.=empty($params['s_type'])?'':" and log.type={$params['s_type']}";
		$where.=empty($params['s_keyword'])?'':" and (u.account='{$params['s_keyword']}' or u.nickname like '%{$params['s_keyword']}%')";
		$count_item=$this->mysql->fetchRow("select count(1) as cnt,sum(log.money) as sum_money from sk_yong log left join sys_user u on log.uid=u.id {$where}");
		$sql="select log.create_time,log.type,log.rate,log.money,od.money as order_money,u.account,u.nickname,ma.mtype_id  
		from sk_yong log 
		left join sys_user u on log.uid=u.id 
		left join sk_order od on log.fkey=od.id 
		left join sk_ma ma on od.ma_id=ma.id 
		{$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		$mtype_arr=rows2arr($this->mysql->fetchRows("select * from sk_mtype"));
		$cnf_yong_type=getConfig('cnf_yong_type');
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i',$item['create_time']);
			$item['type_flag']=$cnf_yong_type[$item['type']];
			$item['mtype_name']=$mtype_arr[$item['mtype_id']]['name'];
		}
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$pageSize,
			'page'=>$params['page']+1,
			'pages'=>ceil($count_item['cnt']/$pageSize)
		);
		jReturn('1','ok',$data);
	}
	
	////////////////////////资金变动明细///////////////////////////
	//资金记录
	public function _balancelog(){
		checkLogin();
		$data=[];
		$this->display($data);
	}
	
	public function _balancelog_list(){
		$pageuser=checkLogin();
		$params=$this->params;
		$pageSize=10;
		if($params['is_download']){
			$pageSize=500;
		}
		$params['page']=intval($params['page']);
		if(!$params['page']){
			$params['page']=1;
		}
		$where="where log.uid={$pageuser['id']}";
		if($params['s_start_time']&&$params['s_end_time']&&$params['s_start_time']<=$params['s_end_time']){
			$s_start_time=strtotime($params['s_start_time'].' 00:00:01');
			$s_end_time=strtotime($params['s_end_time'].' 23:59:59');
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		$where.=empty($params['s_type'])?'':" and log.type={$params['s_type']}";
		$where.=empty($params['s_keyword'])?'':" and (u.account='{$params['s_keyword']}' or u.nickname like '%{$params['s_keyword']}%')";
		$count_item=$this->mysql->fetchRow("select count(1) as cnt,sum(log.money) as sum_money from cnf_balance_log log {$where}");
		$sql="select log.* from cnf_balance_log log 
		{$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		$cnf_balance_type=getConfig('cnf_balance_type');
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i',$item['create_time']);
			$item['type_flag']=$cnf_balance_type[$item['type']];
			$item['money']=floatval($item['money']);
			if($item['money']>0){
				$item['money']='+'.$item['money'];
			}
			unset($item['uid']);
		}
		
		if($params['is_download']){
			$str="时间,类型,原余额,现余额,发生额度\n";
			foreach($list as $row){
				$str.="\t{$row['create_time']},{$row['type_flag']},{$row['ori_balance']},{$row['new_balance']},{$row['money']}\n";
			}
			$filename=date('YmdHis').'.csv';
			downloadCsv($filename,$str);
			exit;
		}
		
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'sum_money'=>floatval($count_item['sum_money']),
			'limit'=>$pageSize,
			'page'=>$params['page']+1,
			'pages'=>ceil($count_item['cnt']/$pageSize)
		);
		jReturn('1','ok',$data);
	}
	
}

?>