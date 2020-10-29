<?php
//用户管理模块
!defined('ROOT_PATH') && exit;
class UserController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	
	//##################用户管理开始##################
	public function _user(){
		$pageuser=checkPower();
		$sys_group=getConfig('sys_group');		
		$sys_group_arr=[];
		foreach($sys_group as $key=>$value){
			if($key>=85){
				continue;
			}
			if($pageuser['gid']>41){
				if($key<$pageuser['gid']){
					continue;
				}
			}
			$sys_group_arr[$key]=$value;
		}
		
		$data=[
			'user'=>$pageuser,
			'sys_group'=>$sys_group_arr
		];
		display('User/user.html',$data);
	}
	
	public function _userms(){
		$pageuser=checkPower();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$sys_group=getConfig('sys_group');
		$sys_group_arr=[];
		foreach($sys_group as $key=>$value){
			if(!in_array($key,[85,91])){
				continue;
			}
			if($key>=$user['gid']){
				$sys_group_arr[$key]=$value;
			}
		}
		$data=[
			'user'=>$user,
			'sys_group'=>$sys_group_arr
		];
		display('User/userms.html',$data);
	}
	
	public function _user_list(){
		$pageuser=checkPower();
		$params=$this->_param();
		$params['s_msgid']=intval($params['s_msgid']);
		$where="where status<99";
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			$uid_str=implode(',',$uid_arr);
			$where.=" and id in({$uid_str})";
		}
		$where.=empty($params['s_gid'])?'':" and gid={$params['s_gid']}";
		$where.=empty($params['s_msgid'])?' and gid<85':" and gid in (85,91)";
		
		if($params['s_keyword2']){
			$s_user=$this->mysql->fetchRow("select * from sys_user where account='{$params['s_keyword2']}' or phone='{$params['s_keyword2']}' or nickname='{$params['s_keyword2']}'");
			$uid_arr=getDownUser($s_user['id']);
			$uid_str=implode(',',$uid_arr);
			$where.=" and id in({$uid_str})";
		}
		
		if(isset($params['s_is_online'])&&$params['s_is_online']!='all'){
			$params['s_is_online']=intval($params['s_is_online']);
			$where.=" and is_online={$params['s_is_online']}";
		}
		
		$where.=empty($params['s_keyword'])?'':" and (id='{$params['s_keyword']}' or account='{$params['s_keyword']}' or phone='{$params['s_keyword']}' or realname like '%{$params['s_keyword']}%' or nickname like '%{$params['s_keyword']}%')";
		
		$sql_cnt="select count(1) as cnt,sum(balance) as balance,sum(sx_balance) as sx_balance,
		sum(fz_balance) as fz_balance,sum(kb_balance) as kb_balance from sys_user {$where}";
		$count_item=$this->mysql->fetchRow($sql_cnt);
		$sql="select * from sys_user {$where} order by id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		$sys_group=getConfig('sys_group');
		$account_status=getConfig('account_status');
		$yes_or_no=getConfig('yes_or_no');
		$now_day=date('Ymd');
		foreach($list as &$item){
			unset($item['password'],$item['password2']);
			$item['gname']=$sys_group[$item['gid']];
			$item['status_flag']=$account_status[$item['status']];
			$item['is_online_flag']=$yes_or_no[$item['is_online']];
			$item['reg_time']=date('m-d H:i:s',$item['reg_time']);
			if($item['login_time']){
				$item['login_time']=date('m-d H:i:s',$item['login_time']);
			}
			if($item['pid']){
				$p_user=$this->mysql->fetchRow("select account,nickname,realname from sys_user where id={$item['pid']}");
				$item['paccount']=$p_user['account'];
				$item['prealname']=$p_user['realname']?$p_user['realname']:$p_user['nickname'];
			}
			
			//统计码商今日/累计收款
			$all_sql="select count(1) as cnt,sum(log.money) as money from sk_order log where 1";
			if(in_array($item['gid'],[85,91])){
				$all_sql.=" and log.muid={$item['id']}";
				
				//统计一下码商或码商代理的佣金
				$yong_sql="select sum(money) as money from sk_yong where uid={$item['id']} and type=1 and level>0";
				$yong_item=$this->mysql->fetchRow($yong_sql);
				$item['yong_money']=floatval($yong_item['money']);

			}elseif(in_array($item['gid'],[61,81])){
				$all_sql.=" and log.suid={$item['id']}";
				
				//统计一下商户或商户代理的佣金
				$yong_sql="select sum(money) as money from sk_yong where uid={$item['id']} and type=2 and level>0";
				$yong_item=$this->mysql->fetchRow($yong_sql);
				$item['yong_money']=floatval($yong_item['money']);
			}
			if($item['gid']>=61){
				$all_item=$this->mysql->fetchRow($all_sql);
				$td_sql=$all_sql." and log.create_day={$now_day}";
				$td_item=$this->mysql->fetchRow($td_sql);
				
				$all_sql_ok=$all_sql." and log.pay_status=9";
				$all_item_ok=$this->mysql->fetchRow($all_sql_ok);
				$td_sql_ok=$all_sql_ok." and log.create_day={$now_day}";
				$td_item_ok=$this->mysql->fetchRow($td_sql_ok);
				
				$item['all_money']=floatval($all_item['money']);
				$item['all_cnt']=intval($all_item['cnt']);
				$item['td_money']=floatval($td_item['money']);
				$item['td_cnt']=intval($td_item['cnt']);
				
				$item['all_money_ok']=floatval($all_item_ok['money']);
				$item['all_cnt_ok']=intval($all_item_ok['cnt']);
				$item['td_money_ok']=floatval($td_item_ok['money']);
				$item['td_cnt_ok']=intval($td_item_ok['cnt']);
				
				$all_percent='0%';
				if($item['all_cnt']>0){
					$all_percent=round(($item['all_cnt_ok']/$item['all_cnt'])*100,2).'%';
				}
				$td_percent='0%';
				if($item['td_cnt']>0){
					$td_percent=round(($item['td_cnt_ok']/$item['td_cnt'])*100,2).'%';
				}
				$item['all_percent']=$all_percent;
				$item['td_percent']=$td_percent;
			}
			
			$item['edit']=hasPower($pageuser,'User_user_update')?1:0;
			$item['kick']=hasPower($pageuser,'User_user_kick')?1:0;
			$item['del']=hasPower($pageuser,'User_user_delete')?1:0;
			$item['pay']=hasPower($pageuser,'User_pay_balance')?1:0;
		}
		$data=array(
			'list'=>$list,
			'count'=>intval($count_item['cnt']),
			'limit'=>$this->pageSize,
			'balance'=>(float)$count_item['balance'],
			'sx_balance'=>(float)$count_item['sx_balance'],
			'fz_balance'=>(float)$count_item['fz_balance'],
			'kb_balance'=>(float)$count_item['kb_balance']
		);
		jReturn('1','ok',$data);
	}
	
	public function _user_update(){
		$pageuser=checkPower();
		$params=$this->_param();
		$item_id=intval($params['item_id']);
		if(!$params['address']){
			jReturn('-1','请填写钱包地址');
		}
		if(!$params['nickname']){
			jReturn('-1','请填写昵称');
		}
		$data=array(
			'address'=>$params['address'],
			'nickname'=>$params['nickname']
		);

		if($params['phone']){
			if(!isPhone($params['phone'])){
				jReturn('-1','请填写正确的手机号');
			}
			$check_phone=$this->mysql->fetchRow("select * from sys_user where phone='{$params['phone']}'");
			if($check_phone){
				if(!$item_id||($item_id&&$item_id!=$check_phone['id'])){
					jReturn('-1','手机号已存在请更换');
				}
			}
		}
		if($pageuser['gid']==1){
			$is_google=intval($params['is_google']);
			if($is_google>1){
				$data['is_online']=0;
				$data['google_hide']=0;
				$data['google_secret']='';
			}else{
				$data['is_google']=$is_google;
			}
		}
		
			$data['is_online']=intval($params['is_online']);
			$data['status']=intval($params['status']);
			if(!$params['forbid_time_flag']){
				$params['forbid_time_flag']='max';
			}
			if($params['forbid_time_flag']=='max'){
				$data['forbid_time']=NOW_TIME*2;
			}else{
				$data['forbid_time']=NOW_TIME+$params['forbid_time_flag']*60;
			}
			$data['forbid_time_flag']=$params['forbid_time_flag'];
			$data['forbid_msg']=$params['forbid_msg'];
		
		$data['phone']=$params['phone'];
		$data['gid']=intval($params['gid']);
		if($pageuser['gid']!=1){
			if($data['gid']<$pageuser['gid']){
				jReturn('-1','您的级别不足以设置该所属分组');
			}
		}

		if($params['password']){
			$data['password']=getPassword($params['password']);
		}
		if($params['password2']){
			$data['password2']=getPassword($params['password2']);
		}
		
		//邀请人判断
		if($pageuser['gid']==1){
			if($params['paccount']){
				$p_user=$this->mysql->fetchRow("select id,account,realname from sys_user where account='{$params['paccount']}' or phone='{$params['paccount']}'");
				if($p_user['id']){
					//被编辑者的下级
					if($item_id){
						$down_ids=getDownUser($item_id);
						if(in_array($p_user['id'],$down_ids)){
							jReturn('-1','邀请人不能是该用户的下级');
						}
					}
					$data['pid']=$p_user['id'];
				}else{
					jReturn('-1','不存在该邀请人账号：'.$params['paccount']);
				}
			}
		}else{
			if(!$item_id){
				$data['pid']=$pageuser['id'];
			}
		}
		
		if(!$item_id){
			if(!$params['account']){
				jReturn('-1','请填写账号');
			}
			if(utf8_strlen($params['account'])<3||utf8_strlen($params['account'])>15){
				jReturn('-1','请输入3-15个字符的账号');
			}
			//检查帐号是否已经存在
			$account=$this->mysql->fetchRow("select id from sys_user where account='{$params['account']}'");
			if($account['id']){
				jReturn('-1',"账号{$params['account']}已经存在");
			}
			$data['icode']=genIcode($this->mysql);
			$data['account']=$params['account'];
			$data['openid']=$params['account'];
			$data['reg_time']=NOW_TIME;
			$data['reg_ip']=CLIENT_IP;
			$data['headimgurl']='public/images/head.png';
		}else{
			if($pageuser['gid']>41){
				$uid_arr=getDownUser($pageuser['id']);
				if(!in_array($item_id,$uid_arr)){
					jReturn('-1','不是自己的用户无法编辑');
				}
			}
			if($item_id==1){
				$data['gid']=1;
				$data['status']=2;
			}else{
				//用户被禁用同时踢下线
				if($data['status']==1){
					kickUser($item_id,$this->mysql);
				}
			}
		}
		
		if($item_id){
			$res=$this->mysql->update($data,"id={$item_id}",'sys_user');
			$user=$this->mysql->fetchRow("select * from sys_user where id={$item_id}");
			$data['account']=$user['account'];
		}else{
			$res=$this->mysql->insert($data,'sys_user');
			$data['id']=$res;
		}
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		actionLog(['opt_name'=>'更新用户','sql_str'=>json_encode($data,256)],$this->mysql);
		$return_data=[];
		if($p_user){
			$return_data['paccount']=$p_user['account'];
			$return_data['prealname']=$p_user['realname'];
		}
		jReturn('1','操作成功',$return_data);
	}
	
	//删除
	public function _user_delete(){
		$pageuser=checkPower();
		$item_id=intval($this->_param('item_id'));
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		if($item_id==1){
			jReturn('-1','管理员不能删除');
		}
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			if(!in_array($item_id,$uid_arr)){
				jReturn('-1','不是自己的用户无法删除');
			}
		}
		$data=['status'=>99];
		$res=$this->mysql->update($data,"id={$item_id}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		kickUser($item_id,$this->mysql);
		actionLog(['opt_name'=>'删除用户','sql_str'=>$this->mysql->lastSql],$this->mysql);
		jReturn('1','操作成功');
	}
	
	//踢下线
	public function _user_kick(){
		$pageuser=checkPower();
		$item_id=intval($this->_param('item_id'));
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		if($pageuser['gid']!=1){
			$uid_arr=getDownUser($pageuser['id']);
			if(!in_array($item_id,$uid_arr)){
				jReturn('-1','不是自己的用户无法踢下线');
			}
		}
		$sys_user=['is_online'=>0];
		$this->mysql->update($sys_user,"id={$item_id}",'sys_user');
		$res=kickUser($item_id,$this->mysql);
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','成功踢下线');
	}
	
	//后台统一充值余
	public function _pay_balance(){
		$pageuser=checkPower();
		$params=getParam();
		$params['uid']=intval($params['uid']);
		$money=floatval($params['money']);
		if($money==0){
			jReturn('-1','填写的额度不正确');
		}
		$pageuser=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$password2=getPassword($params['password2']);
		if($pageuser['password2']!=$password2){
			jReturn('-1','二级密码不正确');
		}
		$this->mysql->startTrans();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$params['uid']} for update");
		if(!$user){
			jReturn('-1','不存在要操作的用户');
		}
		if($pageuser['gid']>41){
			if($params['ptype']!=3){
				jReturn('-1','未开放充值类型');
			}else{
				$cnf_xyhk_model=getConfig('cnf_xyhk_model');
				if($cnf_xyhk_model!='是'){
					jReturn('-1','未开放充值类型.');
				}
			}
			if($money<0){
				jReturn('-1','充值额度不能是负数');
			}
			$uid_arr=getDownUser($pageuser['id']);
			if(!in_array($user['id'],$uid_arr)){
				jReturn('-1','不是您的下级用户无法充值');
			}
		}
		$sys_user=[];
		$res3=true;
		$res4=true;
		if($params['ptype']==1){
			$sys_user['balance']=$user['balance']+$money;
			if($sys_user['balance']<0){
				jReturn('-1','用户可用余额不足');
			}
			$res2=balanceLog($user,1,50,$money,$user['id'],$params['remark'],$this->mysql);
		}elseif($params['ptype']==2){
			$sys_user['fz_balance']=$user['fz_balance']+$money;
			if($sys_user['fz_balance']<0){
				jReturn('-1','用户可用冻结不足');
			}
			$res2=balanceLog($user,2,52,$money,$user['id'],$params['remark'],$this->mysql);
		}elseif($params['ptype']==3){
			$sys_user['sx_balance']=$user['sx_balance']+$money;
			if($sys_user['sx_balance']<0){
				jReturn('-1','用户接单余额不足');
			}
			if($pageuser['gid']>41){
				$from_user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']} for update");
				$from_sys_user=[
					'sx_balance'=>$from_user['sx_balance']-$money
				];
				if($from_sys_user['sx_balance']<0){
					jReturn('-1','您的接单余额不足，无法为下级充值');
				}
				$res3=$this->mysql->update($from_sys_user,"id={$from_user['id']}",'sys_user');
				$res4=balanceLog($from_user,3,53,-$money,$from_user['id'],$params['remark'],$this->mysql);
			}
			$res2=balanceLog($user,3,53,$money,$user['id'],$params['remark'],$this->mysql);
		}elseif($params['ptype']==4){
			$sys_user['kb_balance']=$user['kb_balance']+$money;
			if($sys_user['kb_balance']<0){
				jReturn('-1','用户应回款余额不足');
			}
			$res2=balanceLog($user,4,54,$money,$user['id'],$params['remark'],$this->mysql);
		}else{
			jReturn('-1','未知操作类型');
		}
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if(!$res||!$res2||!$res2||!$res4){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		$return_data=[
			'balance'=>$sys_user['balance'],
			'fz_balance'=>$sys_user['fz_balance'],
			'sx_balance'=>$sys_user['sx_balance'],
			'kb_balance'=>$sys_user['kb_balance']
		];
		jReturn('1','操作成功',$return_data);
	}
	
	//##################用户管理结束##################
	
	//代理列表
	public function _agent(){
		$pageuser=checkPower();
		$data=[
			'user'=>$pageuser
		];
		display('User/agent.html',$data);
	}
	
	public function _agent_list(){
		$pageuser=checkLogin();
		$params=$this->_param();
		$where="where gid in(85) and status<99";
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			$uid_arr[]=$pageuser['id'];
			$uid_str=implode(',',$uid_arr);
			$where.=" and id in({$uid_str})";
		}
		$where.=empty($params['s_keyword'])?'':" and (account='{$params['s_keyword']}' or phone='{$params['s_keyword']}' or realname like '%{$params['s_keyword']}%' or nickname like '%{$params['s_keyword']}%')";
		
		$count_item=$this->mysql->fetchRow("select count(1) as cnt,sum(balance) as balance,sum(sx_balance) as sx_balance,sum(kb_balance) as kb_balance from sys_user {$where}");
		$list=$this->mysql->fetchRows("select * from sys_user {$where} order by id desc",$params['page'],$this->pageSize);
		//echo $this->mysql->lastSql;exit;
		$sys_group=getConfig('sys_group');
		$cnf_du_open=getConfig('cnf_du_open');
		$cnf_kjdhesx_min_money=floatval(getConfig('cnf_kjdhesx_min_money'));
		foreach($list as &$item){
			unset($item['password'],$item['password2']);
			$item['gname']=$sys_group[$item['gid']];
			$item['du_open_flag']=$cnf_du_open[$item['du_open']];
			
			if($item['pid']){
				$p_user=$this->mysql->fetchRow("select account,nickname,realname from sys_user where id={$item['pid']}");
				$item['paccount']=$p_user['account'];
				$item['prealname']=$p_user['realname']?$p_user['realname']:$p_user['nickname'];
			}
			
			//统计一下码商代理的佣金
			$yong_sql="select sum(money) as money from sk_yong where uid={$item['id']} and type=1 and level>0";
			$yong_item=$this->mysql->fetchRow($yong_sql);
			$item['yong_money']=floatval($yong_item['money']);
			
			$down_users=getDownUser($item['id']);
			$down_ids=implode(',',$down_users);
			$d_sql="select count(1) as cnt,sum(money) as money from sk_order where muid in({$down_ids}) and pay_status=9";
			$d_item=$this->mysql->fetchRow($d_sql);
			$item['duser_cnt']=count($down_users);
			$item['duser_order_money']=floatval($d_item['money']);
			
			//统计下级应回款
			$xj_item=$this->mysql->fetchRow("select sum(kb_balance) as kb_balance from sys_user where id in({$down_ids})");
			$item['xj_kb_balance']=floatval($xj_item['kb_balance']);
			
			$item['duopen']=hasPower($pageuser,'User_duopen_update')?1:0;
			if($item['id']==$pageuser['id']){
				$item['duopen']=0;
			}
		}
		
		$data=array(
			'list'=>$list,
			'count'=>intval($count_item['cnt']),
			'limit'=>$this->pageSize,
			'balance'=>floatval($count_item['balance']),
			'kb_balance'=>floatval($count_item['kb_balance']),
			'sx_balance'=>floatval($count_item['sx_balance'])
		);
		jReturn('1','ok',$data);
	}
	
	//下级接单开关
	public function _duopen_update(){
		$pageuser=checkPower();
		$item_id=intval($this->params['item_id']);
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$user=$this->mysql->fetchRow("select id,du_open from sys_user where id={$item_id} and gid=85");
		if(!$user){
			jReturn('-1','不存在相应的码商代理');
		}
		$down_ids=getDownUser($user['id']);
		$down_ids[]=$user['id'];
		$uids_str=implode(',',$down_ids);
		$sys_user=[];
		if($user['du_open']){
			$sys_user['du_open']=0;
			$sys_user['forbid_day']=date('Ymd');//关闭下级
			$sys_user['is_online']=0;
		}else{
			$sys_user['du_open']=1;
			$sys_user['forbid_day']=0;//开放下级
		}
		$res=$this->mysql->update($sys_user,"id in ({$uids_str})",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$cnf_du_open=getConfig('cnf_du_open');
		$return_data=[
			'du_open'=>$sys_user['du_open'],
			'du_open_flag'=>$cnf_du_open[$sys_user['du_open']]
		];
		jReturn('1','操作成功',$return_data);
	}
	
	////////////////////////////码商代理结束/////////////////////////////
	
	public function _rate(){
		$pageuser=checkPower();
		$mtype_arr=rows2arr($this->mysql->fetchRows("select id,is_open,name from sk_mtype where 1"));
		$data=[
			'mtype_arr'=>$mtype_arr
		];
		display('User/rate.html',$data);
	}
	
	public function _rate_list(){
		$pageuser=checkPower();
		$params=$this->params;
		$where="where log.gid in(85,91) and log.status<99";
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			$uid_arr[]=$pageuser['id'];
			$uid_str=implode(',',$uid_arr);
			$where.=" and log.id in({$uid_str})";
		}
		//$where.=empty($params['s_gid'])?'':" and gid={$params['s_gid']}";
		$where.=empty($params['s_keyword'])?'':" and (log.account='{$params['s_keyword']}' or log.phone='{$params['s_keyword']}' or log.realname like '%{$params['s_keyword']}%' or log.nickname like '%{$params['s_keyword']}%')";
		$count=$this->mysql->fetchResult("select count(1) from sys_user log {$where}");
		$sql="select log.*,u.account as up_account,u.nickname as up_nickname,u.fy_rate as up_fy_rate from sys_user log left join sys_user u on log.pid=u.id {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$up_td_switch=json_decode($user['td_switch'],true);
		if(!$up_td_switch){
			$up_td_switch=[];
		}
		if($pageuser['gid']<=41){
			$mtype_arr=$this->mysql->fetchRows("select * from sk_mtype where 1");
			foreach($mtype_arr as $mv){
				$up_td_switch[$mv['id']]=1;
			}
		}
		
		$sys_group=getConfig('sys_group');
		foreach($list as &$item){
			$item['gname']=$sys_group[$item['gid']];
			if($item['fy_rate']){
				$item['fy_rate']=json_decode($item['fy_rate'],true);
			}
			if(!$item['fy_rate']){
				$item['fy_rate']=[];
			}
			if($item['up_fy_rate']){
				$item['up_fy_rate']=json_decode($item['up_fy_rate'],true);
			}
			if(!$item['up_fy_rate']){
				$item['up_fy_rate']=[];
			}
			$item['td_switch']=json_decode($item['td_switch'],true);
			if(!$item['td_switch']){
				$item['td_switch']=[];
			}
			$item['up_td_switch']=$up_td_switch;
			
			$item['setrate']=hasPower($pageuser,'User_rate_update')&&($pageuser['gid']==1||$item['id']!=$pageuser['id'])?1:0;
			$item['switch']=hasPower($pageuser,'User_tdswitch2_update')&&($pageuser['gid']==1||$item['id']!=$pageuser['id'])?1:0;
		}
		$data=array(
			'list'=>$list,
			'count'=>$count,
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	//设置分成比例
	public function _rate_update(){
		$pageuser=checkPower();
		$item_id=intval($this->params['item_id']);
		$fy_rate=$this->params['fy_rate'];
		
		if(!$item_id||!$fy_rate){
			jReturn('-1','缺少参数');
		}
		
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			if(!in_array($item_id,$uid_arr)){
				jReturn('-1','不是自己的用户无法设置');
			}
		}
		
		$setuser=$this->mysql->fetchRow("select * from sys_user where id={$item_id}");
		if(!$setuser){
			jReturn('-1','设置的用户不存在');
		}
		if($setuser['pid']){
			$upuser=$this->mysql->fetchRow("select * from sys_user where id={$setuser['pid']}");
			$upuser['fy_rate']=json_decode($upuser['fy_rate'],true);
		}
		
		$cnf_msmin_fyrate=getConfig('cnf_msmin_fyrate');
		$mtype_arr=rows2arr($this->mysql->fetchRows("select id,name from sk_mtype where 1"));
		$fy_rate_arr=[];
		foreach($mtype_arr as $mtype){
			$mval=floatval($fy_rate[$mtype['id']]);
			if($mtype['is_open']){
				if(!isset($mval)||$mval===''||$mval===null||$mval>1||$mval<0){
					jReturn('-1',"【{$mtype['name']}】设置的分成比例不正确");
				}
				//检测最小设置
				$min_val=$cnf_msmin_fyrate[$mtype['id']];
				if($mval<$min_val){
					//$min_val_flag=$min_val*100;
					jReturn('-1',"【{$mtype['name']}】分成比例不可小于{$min_val}");
				}
				if($upuser&&$mval>$upuser['fy_rate'][$mtype['id']]){
					jReturn('-1',"【{$mtype['name']}】设置的分成比例不能超过上级的比例");
				}
			}
			$fy_rate_arr[$mtype['id']]=$mval;
		}

		$sys_user=[
			'fy_rate'=>json_encode($fy_rate_arr,256)
		];
		$res=$this->mysql->update($sys_user,"id={$setuser['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','设置成功');
	}
	
	//码商通道开关
	public function _tdswitch2_update(){
		$pageuser=checkPower();
		$is_open=intval($this->params['is_open']);
		if(!$is_open){
			$is_open=0;
		}else{
			$is_open=1;
		}
		$uid_ptype=$this->params['uid_ptype'];
		$up_arr=explode('_',$uid_ptype);
		$uid=intval($up_arr[0]);
		$ptype=intval($up_arr[1]);
		if(!$uid||!$ptype){
			jReturn('-1','参数错误');
		}
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			if(!in_array($uid,$uid_arr)){
				jReturn('-1','不是自己的下级无法设置');
			}
		}
		$mtype=$this->mysql->fetchRow("select * from sk_mtype where id={$ptype}");
		if(!$mtype){
			jReturn('-1','支付通道不存在');
		}
		$user=$this->mysql->fetchRow("select id,td_switch from sys_user where id={$uid}");
		if(!$user){
			jReturn('-1','码商不存在');
		}
		$td_switch=json_decode($user['td_switch'],true);
		if(!$td_switch){
			$td_switch=[];
		}
		$td_switch[$ptype]=$is_open;
		$sys_user=[
			'td_switch'=>json_encode($td_switch,256)
		];
		$res=$this->mysql->update($sys_user,"id={$uid}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		//设置下级的开关保持一致
		$uid_arr2=getDownUser($uid);
		$uid_arr2_str=implode(',',$uid_arr2);
		$this->mysql->update($sys_user,"id in ({$uid_arr2_str})",'sys_user');
		
		$return_data=[
			'uid'=>$uid,
			'td_switch'=>$td_switch
		];
		jReturn('1','操作成功',$return_data);
	}
	
	//##################码商分成比例结束##################
	
	public function _apikey(){
		$pageuser=checkPower();
		$sys_group=getConfig('sys_group');
		$sys_group_arr=array();
		foreach($sys_group as $key=>$value){
			if($key>$pageuser['gid']&&in_array($key,[61,81])){
				$sys_group_arr[$key]=$value;
			}
		}
		$mtype_arr=rows2arr($this->mysql->fetchRows("select id,name,is_open from sk_mtype"));
		$data=[
			'user'=>$pageuser,
			'sys_group'=>$sys_group_arr,
			'mtype_arr'=>$mtype_arr
		];
		display('User/apikey.html',$data);
	}
	
	public function _apikey_list(){
		$pageuser=checkPower();
		$params=$this->params;
		$params['s_gid']=intval($params['s_gid']);
		$where="where log.gid in(61,81) and log.status<99";
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			$uid_arr[]=$pageuser['id'];
			$uid_str=implode(',',$uid_arr);
			$where.=" and log.id in({$uid_str})";
		}
		$where.=empty($params['s_gid'])?'':" and log.gid={$params['s_gid']}";
		$where.=empty($params['s_keyword'])?'':" and (log.account='{$params['s_keyword']}' or log.phone='{$params['s_keyword']}' or log.realname like '%{$params['s_keyword']}%' or log.nickname like '%{$params['s_keyword']}%')";
		$count=$this->mysql->fetchResult("select count(1) from sys_user log {$where}");
		$sql="select log.*,u.account as up_account,u.nickname as up_nickname,u.td_rate as up_td_rate from sys_user log left join sys_user u on log.pid=u.id {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$this->pageSize);
		$sys_group=getConfig('sys_group');
		foreach($list as &$item){
			$item['gname']=$sys_group[$item['gid']];
			if($item['td_rate']){
				$item['td_rate']=json_decode($item['td_rate'],true);
			}
			if(!$item['td_rate']){
				$item['td_rate']=[];
			}
			if($item['up_td_rate']){
				$item['up_td_rate']=json_decode($item['up_td_rate'],true);
			}
			if(!$item['up_td_rate']){
				$item['up_td_rate']=[];
			}
			if($pageuser['gid']==1||$item['id']!=$pageuser['id']){
				$item['setrate']=1;
			}else{
				$item['setrate']=0;
			}
			$item['td_switch']=json_decode($item['td_switch'],true);
			if(!$item['td_switch']){
				$item['td_switch']=[];
			}
			
			$appoint_agent_flag='';
			if($item['appoint_agent']){
				$users=$this->mysql->fetchRows("select account from sys_user where id in ({$item['appoint_agent']})");
				$users_accounts=[];
				foreach($users as $uv){
					$users_accounts[]=$uv['account'];
				}
				$appoint_agent_flag=implode(',',$users_accounts);
			}
			$item['appoint_agent_flag']=$appoint_agent_flag;
			
			$appoint_ms_flag='';
			if($item['appoint_ms']){
				$users=$this->mysql->fetchRows("select account from sys_user where id in ({$item['appoint_ms']})");
				$users_accounts=[];
				foreach($users as $uv){
					$users_accounts[]=$uv['account'];
				}
				$appoint_ms_flag=implode(',',$users_accounts);
			}
			$item['appoint_ms_flag']=$appoint_ms_flag;
			
			$item['switch']=hasPower($pageuser,'User_tdswitch_update')&&($pageuser['gid']==1||$item['id']!=$pageuser['id'])?1:0;
			$item['tdupdate']=hasPower($pageuser,'User_tdrate_update')?1:0;
			$item['appoint']=hasPower($pageuser,'User_appoint_update')?1:0;
		}
		$data=array(
			'list'=>$list,
			'count'=>$count,
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _apikey_update(){
		$pageuser=checkPower();
		$uid=intval($this->params['uid']);
		if(!$uid){
			jReturn('-1','缺少参数');
		}
		$user=$this->mysql->fetchRow("select id,gid,account from sys_user where id={$uid}");
		if(!$user['id']){
			jReturn('-1','不存在对应账号');
		}else{
			if(!in_array($user['gid'],[61,81])){
				jReturn('-1','非商户或代理无法生成');
			}
		}
		if($pageuser['gid']!=1){
			$uid_arr=getDownUser($pageuser['id']);
			$uid_arr[]=$pageuser['id'];
			if(!in_array($uid,$uid_arr)){
				jReturn('-1','不是自己的商户无法生成');
			}
		}
		$data=array(
			'apikey'=>sha1(md5($user['id'].'_'.$user['account'].'_'.time().'_'.SYS_KEY))
		);
		$res=$this->mysql->update($data,"id={$uid}",'sys_user');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		//actionLog(array('opt_name'=>'生成apikey','sql_str'=>json_encode($user)),$this->mysql);
		$return_data=['apikey'=>$data['apikey']];
		jReturn('1','操作成功',$return_data);
	}
	
	//设置通道费率
	public function _tdrate_update(){
		$pageuser=checkPower();
		$item_id=intval($this->params['item_id']);
		$td_rate=$this->params['td_rate'];
		
		if(!$item_id||!$td_rate){
			jReturn('-1','缺少参数');
		}
		
		if($pageuser['gid']!=1){
			$uid_arr=getDownUser($pageuser['id']);
			if(!in_array($item_id,$uid_arr)){
				jReturn('-1','不是自己的用户无法设置');
			}
		}
		
		$setuser=$this->mysql->fetchRow("select * from sys_user where id={$item_id}");
		if(!$setuser){
			jReturn('-1','设置的用户不存在');
		}
		if($setuser['pid']){
			$upuser=$this->mysql->fetchRow("select * from sys_user where id={$setuser['pid']}");
			$upuser['td_rate']=json_decode($upuser['td_rate'],true);
		}
		$mtype_arr=rows2arr($this->mysql->fetchRows("select * from sk_mtype"));
		$td_rate_arr=[];
		foreach($mtype_arr as $mtype){
			$mval=$td_rate[$mtype['id']];
			if(!$mtype['is_open']){
				continue;
			}
			if(!isset($mval)||$mval===''||$mval===null||$mval>1||$mval<0){
				jReturn('-1',"【{$mtype['name']}】设置的通道费率不正确");
			}
			if($upuser&&$mval<$upuser['td_rate'][$mtype['id']]){
				jReturn('-1',"【{$mtype['name']}】设置的通道费率不能小于上级的费率");
			}
			$td_rate_arr[$mtype['id']]=$mval;
		}

		$sys_user=[
			'td_rate'=>json_encode($td_rate_arr,256)
		];
		$res=$this->mysql->update($sys_user,"id={$setuser['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','设置成功');
	}
	
	//通道开关
	public function _tdswitch_update(){
		$pageuser=checkPower();
		$is_open=intval($this->params['is_open']);
		if(!$is_open){
			$is_open=0;
		}else{
			$is_open=1;
		}
		$uid_ptype=$this->params['uid_ptype'];
		$up_arr=explode('_',$uid_ptype);
		$uid=intval($up_arr[0]);
		$ptype=intval($up_arr[1]);
		if(!$uid||!$ptype){
			jReturn('-1','参数错误');
		}
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			if(!in_array($uid,$uid_arr)){
				jReturn('-1','不是自己的商户无法设置');
			}
		}
		$mtype=$this->mysql->fetchRow("select * from sk_mtype where id={$ptype}");
		if(!$mtype){
			jReturn('-1','支付通道不存在');
		}
		$user=$this->mysql->fetchRow("select id,td_switch from sys_user where id={$uid}");
		if(!$user){
			jReturn('-1','商户不存在');
		}
		$td_switch=json_decode($user['td_switch'],true);
		if(!$td_switch){
			$td_switch=[];
		}
		$td_switch[$ptype]=$is_open;
		$sys_user=[
			'td_switch'=>json_encode($td_switch,256)
		];
		$res=$this->mysql->update($sys_user,"id={$uid}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','操作成功');
	}
	
	//设置指定代理/码商账号
	public function _appoint_update(){
		$pageuser=checkPower();
		$params=$this->params;
		$item_id=intval($params['item_id']);
		$appoint_type=$params['appoint_type'];
		$appoint_accounts=$params['appoint_accounts'];
		
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		if(!in_array($appoint_type,[1,2])){
			jReturn('-1','未知指定类型');
		}
		
		$user=$this->mysql->fetchRow("select * from sys_user where id={$item_id} and status>0");
		if(!$user){
			jReturn('-1','不存在相应的商户');
		}
		$accounts=str_replace('，',',',trim($params['appoint_accounts']));
		$accounts=trim($accounts,',');
		$accounts_arr=explode(',',$accounts);
		$accounts_item=[];
		foreach($accounts_arr as $mv){
			if($mv==$user['account']){
				continue;
			}
			$mv=trim($mv);
			$where="where account='{$mv}'";
			if($appoint_type==1){
				$where.=" and gid=85";
			}elseif($appoint_type==2){
				$where.=" and gid=91";
			}
			$item=$this->mysql->fetchRow("select * from sys_user {$where}");
			if($item){
				$accounts_item[]=$item;
			}
		}
		
		$accounts_ids=[];
		$accounts_acs=[];
		foreach($accounts_item as $av){
			$accounts_ids[]=$av['id'];
			$accounts_acs[]=$av['account'];
		}
		
		if($accounts_ids){
			$accounts_ids=array_unique($accounts_ids);
			$accounts_acs=array_unique($accounts_acs);
			$appoint_ids_str=implode(',',$accounts_ids);
		}else{
			$appoint_ids_str='';
		}
		if($appoint_type==1){
			$sys_user=['appoint_agent'=>$appoint_ids_str];
		}elseif($appoint_type==2){
			$sys_user=['appoint_ms'=>$appoint_ids_str];
		}
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$return_data=[
			'accounts_acs'=>$accounts_acs,
			'accounts_str'=>implode(',',$accounts_acs)
		];
		jReturn('1','操作成功',$return_data);
	}
	
	//####################################
	//数据统计
	public function _datatj(){
		$pageuser=checkLogin();
		$mtype_arr=rows2arr($this->mysql->fetchRows("select * from sk_mtype where is_open=1"));
		$data=[
			'user'=>$pageuser,
			'mtype_arr'=>$mtype_arr,
			's'=>[
				's_start_time'=>date('Y-m-d',strtotime('-7 days')),
				's_end_time'=>date('Y-m-d')
			]
		];
		display('User/datatj.html',$data);
	}
	
	public function _datatj_list(){
		$pageuser=checkLogin();
		$params=$this->params;
		$params['s_mtype_id']=intval($params['s_mtype_id']);
		
		$od_where='where 1';
		$ok_where='where 1';
		$pay_where='where 1';
		$cash_where='where 1';
		$user_where='where 1';
		$fc_where='where 1';
		if($params['s_start_time']&&$params['s_end_time']&&$params['s_start_time']<=$params['s_end_time']){
			$s_start_time=strtotime($params['s_start_time'].' 00:00:01');
			$s_end_time=strtotime($params['s_end_time'].' 23:59:59');
			$od_where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
			$ok_where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
			$pay_where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
			$cash_where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
			$fc_where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		if($pageuser['gid']>41){
			$uid_arr=getDownUser($pageuser['id']);
			//$uid_arr[]=$pageuser['id'];
			$uid_str=implode(',',$uid_arr);
			$od_where.=" and (log.suid in({$uid_str}) or log.muid in({$uid_str}))";
			$ok_where.=" and (log.suid in({$uid_str}) or log.muid in({$uid_str}))";
			$pay_where.=" and log.uid in({$uid_str})";
			$cash_where.=" and log.uid in({$uid_str})";
			$user_where.=" and log.id in({$uid_str})";
			$fc_where.=" and log.uid in({$uid_str})";
		}
		
		if($params['s_mtype_id']){
			$od_where.=" and log.ptype={$params['s_mtype_id']}";
			$ok_where.=" and log.ptype={$params['s_mtype_id']}";
		}
		
		if($params['s_keyword']){
			$od_where.=" and (su.account='{$params['s_keyword']}' or u.account='{$params['s_keyword']}')";
			$ok_where.=" and (su.account='{$params['s_keyword']}' or u.account='{$params['s_keyword']}')";
		}
		
		if($params['s_keyword2']){
			$s_user=$this->mysql->fetchRow("select id from sys_user where account='{$params['s_keyword2']}'");
			$uid_arr2=[];
			if($s_user){
				$uid_arr2=getDownUser($s_user['id']);
			}
			$uid_str2=implode(',',$uid_arr2);
			$od_where.=" and (log.suid in({$uid_str2}) or log.muid in({$uid_str2}))";
			$ok_where.=" and (log.suid in({$uid_str2}) or log.muid in({$uid_str2}))";
		}
		
		$od_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$od_where}";
		$order_tj=$this->mysql->fetchRow($od_sql);
		
		$ok_where.=" and log.pay_status=9";
		
		$ok_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$ok_where}";
		$order_ok=$this->mysql->fetchRow($ok_sql);
		
		//今日订单统计
		$today_start_time=strtotime(date('Y-m-d 00:00:00'));
		$today_end_time=strtotime(date('Y-m-d 23:59:59'));
		$oktd_where=$ok_where." and log.create_time between {$today_start_time} and {$today_end_time}";
		$odtd_where=$od_where." and log.create_time between {$today_start_time} and {$today_end_time}";
		$odtd_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$odtd_where}";
		$order_alltd=$this->mysql->fetchRow($odtd_sql);
		
		$oktd_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$oktd_where}";
		$order_oktd=$this->mysql->fetchRow($oktd_sql);
		$od_tdpercent='0%';
		if($order_alltd['cnt']>0){
			$od_tdpercent=round(($order_oktd['cnt']/$order_alltd['cnt'])*100,2).'%';
		}
		
		//昨日订单统计
		$yestd_start_time=strtotime(date('Y-m-d 00:00:01',strtotime("-1 day")));
		$yestd_end_time=strtotime(date('Y-m-d 23:59:59',strtotime("-1 day")));
		$okytd_where=$ok_where." and log.create_time between {$yestd_start_time} and {$yestd_end_time}";
		$odytd_where=$od_where." and log.create_time between {$yestd_start_time} and {$yestd_end_time}";
		
		$odytd_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$odytd_where}";
		$order_allytd=$this->mysql->fetchRow($odytd_sql);
		
		$okytd_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$okytd_where}";
		$order_okytd=$this->mysql->fetchRow($okytd_sql);
		
		$od_ytdpercent='0%';
		if($order_allytd['cnt']>0){
			$od_ytdpercent=round(($order_okytd['cnt']/$order_allytd['cnt'])*100,2).'%';
		}
		
		////////////////////////15分钟////////////////////////////
		$m15_start_time=NOW_TIME-15*60;
		$m15_end_time=NOW_TIME;
		$okm15_where=$ok_where." and log.create_time between {$m15_start_time} and {$m15_end_time}";
		$odm15_where=$od_where." and log.create_time between {$m15_start_time} and {$m15_end_time}";
		
		$odm15_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$odm15_where}";
		$order_allm15=$this->mysql->fetchRow($odm15_sql);
		
		$okm15_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$okm15_where}";
		$order_okm15=$this->mysql->fetchRow($okm15_sql);
		
		$m15_percent='0%';
		if($order_allm15['cnt']>0){
			$m15_percent=round(($order_okm15['cnt']/$order_allm15['cnt'])*100,2).'%';
		}
		
		////////////////////////30分钟////////////////////////////
		$m30_start_time=NOW_TIME-30*60;
		$m30_end_time=NOW_TIME;
		$okm30_where=$ok_where." and log.create_time between {$m30_start_time} and {$m30_end_time}";
		$odm30_where=$od_where." and log.create_time between {$m30_start_time} and {$m30_end_time}";
		
		$odm30_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$odm30_where}";
		$order_allm30=$this->mysql->fetchRow($odm30_sql);
		
		$okm30_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$okm30_where}";
		$order_okm30=$this->mysql->fetchRow($okm30_sql);
		
		$m30_percent='0%';
		if($order_allm30['cnt']>0){
			$m30_percent=round(($order_okm30['cnt']/$order_allm30['cnt'])*100,2).'%';
		}
		
		////////////////////////60分钟////////////////////////////
		
		$m60_start_time=NOW_TIME-60*60;
		$m60_end_time=NOW_TIME;
		$okm60_where=$ok_where." and log.create_time between {$m60_start_time} and {$m60_end_time}";
		$odm60_where=$od_where." and log.create_time between {$m60_start_time} and {$m60_end_time}";
		
		$odm60_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$odm60_where}";
		$order_allm60=$this->mysql->fetchRow($odm60_sql);
		
		$okm60_sql="select count(1) as cnt,sum(log.money) as money,sum(log.fee) as fee from sk_order log 
		left join sys_user su on log.suid=su.id 
		left join sys_user u on log.muid=u.id 
		{$okm60_where}";
		$order_okm60=$this->mysql->fetchRow($okm60_sql);
		
		$m60_percent='0%';
		if($order_allm60['cnt']>0){
			$m60_percent=round(($order_okm60['cnt']/$order_allm60['cnt'])*100,2).'%';
		}
		
		////////////////////////60分钟结束////////////////////////////
		
		//码商充值
		$pay_where.=" and log.pay_status=3";
		$pay_item=$this->mysql->fetchRow("select count(1) as cnt,sum(log.money) as money from cnf_paylog log {$pay_where}");
		
		$ms_cash_sql="select sum(log.money) as money from cnf_cashlog log left join sys_user u on log.uid=u.id {$cash_where} and log.status=1 and u.gid in(85,91)";
		$ms_cash=$this->mysql->fetchRow($ms_cash_sql);
		
		$sh_cash_sql="select sum(log.money) as money from cnf_cashlog log left join sys_user u on log.uid=u.id {$cash_where} and log.status=1 and u.gid in (61,81)";
		$sh_cash=$this->mysql->fetchRow($sh_cash_sql);
		
		$ms_user_sql="select sum(log.balance) as balance,sum(log.fz_balance) as fz_balance from sys_user log {$user_where} and log.gid in (85,91)";
		$ms_user=$this->mysql->fetchRow($ms_user_sql);
		
		$sh_user_sql="select sum(log.balance) as balance,sum(log.fz_balance) as fz_balance from sys_user log {$user_where} and log.gid in (61,81)";
		$sh_user=$this->mysql->fetchRow($sh_user_sql);
		
		//利润
		if($pageuser['gid']==1){
			if($params['s_mtype_id']||$params['s_keyword']||$params['s_keyword2']){
				$profit=0;
			}else{
				$fc_sql="select sum(log.money) as money from cnf_balance_log log {$fc_where} and log.type=6";
				$fc_sql2="select sum(log.money) as money from sk_yong log {$fc_where}";
				$fencheng=$this->mysql->fetchRow($fc_sql);
				$fencheng2=$this->mysql->fetchRow($fc_sql2);
				$profit=$order_ok['fee']-$fencheng['money']-$fencheng2['money'];
			}
		}else{
			$profit=0;
		}
		
		$card_money=$ms_user['balance']+$ms_user['fz_balance']+$sh_user['balance']+$sh_user['fz_balance']+$ms_cash['money']+$sh_cash['money'];
		
		$return_data=[
			'od_sum_cnt'=>intval($order_tj['cnt']),
			'od_sum_money'=>floatval($order_tj['money']),
			'od_sum_fee'=>floatval($order_tj['fee']),
			'od_ok_cnt'=>intval($order_ok['cnt']),
			'od_ok_money'=>floatval($order_ok['money']),
			'od_ok_fee'=>floatval($order_ok['fee']),
			'ms_pay_money'=>floatval($pay_item['money']),
			'ms_cash_money'=>floatval($ms_cash['money']),
			'sh_cash_money'=>floatval($sh_cash['money']),
			'ms_balance'=>floatval($ms_user['balance']),
			'ms_fz_balance'=>floatval($ms_user['fz_balance']),
			'sh_balance'=>floatval($sh_user['balance']),
			'sh_fz_balance'=>floatval($sh_user['fz_balance']),
			'profit'=>floatval($profit),
			'card_money'=>floatval($card_money),
			'od_ok_money_today'=>floatval($order_oktd['money']),
			'od_all_money_today'=>floatval($order_alltd['money']),
			'od_ok_cnt_today'=>intval($order_oktd['cnt']),
			'od_all_cnt_today'=>intval($order_alltd['cnt']),
			'od_ok_money_ytoday'=>floatval($order_okytd['money']),
			'od_all_money_ytoday'=>floatval($order_allytd['money']),
			'od_ok_cnt_ytoday'=>intval($order_okytd['cnt']),
			'od_all_cnt_ytoday'=>intval($order_allytd['cnt']),
			'od_tdpercent'=>$od_tdpercent,
			'od_ytdpercent'=>$od_ytdpercent,
			'm15_all'=>$order_allm15,
			'm15_ok'=>$order_okm15,
			'm15_percent'=>$m15_percent,
			'm30_all'=>$order_allm30,
			'm30_ok'=>$order_okm30,
			'm30_percent'=>$m30_percent,
			'm60_all'=>$order_allm60,
			'm60_ok'=>$order_okm60,
			'm60_percent'=>$m60_percent
		];
		$return_data['od_ok_percent']=$return_data['od_sum_cnt']>0?round(($return_data['od_ok_cnt']/$return_data['od_sum_cnt'])*100,2):0;
		
		jReturn('1','ok',$return_data);
	}
	
	//////////////////////////数据统计结束///////////////////////////////
	//查询上级
	public function _sjuser(){
		$pageuser=checkPower();
		$data=[
			'user'=>$pageuser
		];
		display('User/sjuser.html',$data);
	}
	
	public function _sjuser_list(){
		$pageuser=checkPower();
		$account=$this->params['s_keyword'];
		if(!$account){
			jReturn('-1','请填写查询账号');
		}
		$user=$this->mysql->fetchRow("select * from sys_user where (account='{$account}' or phone='{$account}') and status>0");
		if(!$user){
			jReturn('-1','不存在相应的账号');
		}
		$up_users=getUpUser($user['id'],true);
		$sys_group=getConfig('sys_group');
		$user['agent_level']='当前查询账号';
		$list=[$user];
		foreach($up_users as $uv){
			$list[]=$uv;
		}
		foreach($list as &$item){
			if(!$item['realname']){
				$item['realname']='';
			}
			$item['gname']=$sys_group[$item['gid']];
		}
		$return_data=[
			'list'=>$list
		];
		jReturn('1','ok',$return_data);
	}
	
	//////////////////////////RSA设置///////////////////////////////
	public function _rsaset(){
		$pageuser=checkPower();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$data=[
			'user'=>$user
		];
		display('User/rsaset.html',$data);
	}
	
	public function _rsaset_update(){
		$pageuser=checkLogin();
		$params=$this->params;
		$is_rsa=intval($params['is_rsa']);
		if($is_rsa){
			if(!$params['rsa_public']){
				jReturn('-1','请填写您的RSA公钥');
			}
		}
		$password2=getPassword($params['password2']);
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		if($password2!=$user['password2']){
			jReturn('-1','二级密码不正确');
		}
		$sys_user=[
			'is_rsa'=>$is_rsa
		];
		if($is_rsa){
			$sys_user['rsa_public']=trim($params['rsa_public']);
		}
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','保存成功');
	}
	
}
?>