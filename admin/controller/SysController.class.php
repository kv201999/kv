<?php
//系统基础模块
!defined('ROOT_PATH') && exit;
include GLOBAL_PATH.'library/GoogleAuthenticator.php';
class SysController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	
	//##################日志管理开始##################
	public function _log(){
		checkPower();
		$data=[];
		display('Sys/log.html',$data);
	}
	
	public function _log_list(){
		checkPower();
		$params=getParam();
		$where="where 1";
		if($params['s_start_time']&&$params['s_end_time']&&$params['s_start_time']<=$params['s_end_time']){
			$s_start_time=strtotime($params['s_start_time'].' 00:00:01');
			$s_end_time=strtotime($params['s_end_time'].' 23:59:59');
			$where.=" and log.create_time between {$s_start_time} and {$s_end_time}";
		}
		$where.=empty($params['s_keyword'])?'':" and (create_ip='{$params['s_keyword']}' or opt_name like '%{$params['s_keyword']}%' or sql_str like '%{$params['s_keyword']}%')";
		$count=$this->mysql->fetchResult("select count(1) from sys_log log {$where}");
		$list=$this->mysql->fetchRows("select log.*,u.nickname from sys_log log left join sys_user u on log.uid=u.id {$where} order by log.id desc",$params['page'],$this->pageSize);
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
	
	//##################日志管理结束##################
	
	
	//##################节点管理##################
	public function _node(){
		checkPower();
		$top_node_arr=$this->mysql->fetchRows("select id,name from sys_node where pid=0");
		$data=[
			'top_node_arr'=>$top_node_arr
		];
		display('Sys/node.html',$data);
	}
	
	public function _node_list(){
		checkPower();
		$params=getParam();
		$pageSize=20;
		$where="where 1";
		if($params['s_type']&&$params['s_type']!='all'){
			$where.=" and type='{$params['s_type']}'";
		}
		if($params['s_public']&&$params['s_public']!='all'){
			$where.=" and public='{$params['s_public']}'";
		}
		
		$where.=empty($params['s_keyword'])?'':" and name like '%{$params['s_keyword']}%'";
		$top_node=rows2arr($this->mysql->fetchRows("select id,name from sys_node where pid=0"));
		$count=$this->mysql->fetchResult("select count(1) from sys_node {$where}");
		$list=$this->mysql->fetchRows("select * from sys_node {$where} order by CONCAT(pre_path,'-',id)",$params['page'],$pageSize);
		$yes_no=getConfig('yes_or_no');
		foreach($list as &$item){
			if($item['create_time']){
				$item['create_time']=date('m-d H:i',$item['create_time']);
			}
			$item['pname']=$top_node[$item['pid']]['name'];
			$item['type_flag']=$yes_no[$item['type']];
			$item['public_flag']=$yes_no[$item['public']];
		}
		$data=array(
			'list'=>$list,
			'count'=>$count,
			'limit'=>$pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _node_update(){
		$pageuser=checkPower();
		if($pageuser['id']!=1){
			jReturn('-1','没有权限操作');
		}
		$params=getParam();
		$item_id=intval($params['item_id']);
		$pid=intval($params['pid']);
		if(!$params['nkey']){
			jReturn('-1','请填写NKEY');
		}
		if(!$params['name']){
			jReturn('-1','请填写节点名称');
		}
		$data=array(
			'name'=>$params['name'],
			'pid'=>intval($params['pid']),
			'type'=>intval($params['type']),
			'public'=>intval($params['public']),
			'sort'=>intval($params['sort']),
			'nkey'=>$params['nkey'],
			'ico'=>$_POST['ico'],
			'url'=>$_POST['url'],
			'remark'=>$params['remark']
		);
		$pre_path='0';
		if($pid){
			$p_node=$this->mysql->fetchRow("select id,pre_path from sys_node where id={$pid}");
			$pre_path=$p_node['pre_path'].'-'.$pid;
		}
		$data['pre_path']=$pre_path;
		if($item_id){
			if($pid==$item_id){
				jReturn('-1','父节点不能设置成自己');
			}else{
				if($pid){
					//检查自己是否有子节点，如果有子节点不允许直接将自己设置成其他节点的子节点
					$check_sub=$this->mysql->fetchRow("select id from sys_node where pid={$item_id}");
					if($check_sub){
						jReturn('-1','该节点下面有子节点，请先清除');
					}
				}
			}
			$res=$this->mysql->update($data,"id={$item_id}",'sys_node');
		}else{
			$data['create_time']=NOW_TIME;
			$res=$this->mysql->insert($data,'sys_node');
		}
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		actionLog(array('opt_name'=>'更新节点','sql_str'=>$this->mysql->lastSql),$this->mysql);
		jReturn('1','操作成功');
	}
	
	public function _node_delete(){
		$pageuser=checkPower();
		if($pageuser['id']!=1){
			jReturn('-1','没有权限操作');
		}
		$item_id=intval($this->_param('item_id'));
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		if($item_id<50){
			jReturn('-1','系统基础节点不能删除');
		}
		$this->mysql->startTrans();
		$item=$this->mysql->fetchRow("select * from sys_node where id={$item_id} for update");
		if(!$item){
			jReturn('-1','该节点已经删除');
		}
		$res=$this->mysql->delete("id={$item_id}",'sys_node');
		$res2=$this->mysql->delete("pid={$item_id}",'sys_node');
		if(!$res||$res2===false){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		actionLog(array('opt_name'=>'删除节点','sql_str'=>json_encode($item)),$this->mysql);
		jReturn('1','操作成功');
	}
	//##################节点管理结束##################
	
	
	//##################配置管理开始##################
	public function _bset(){
		checkPower();
		$data=[];
		display('Sys/bset.html',$data);
	}
	
	public function _bset_list(){
		checkPower();
		$params=getParam();
		$where="where is_show=1";
		$where.=empty($params['s_keyword'])?'':" and (skey like '{$params['s_keyword']}' or name like '%{$params['s_keyword']}%')";
		$count=$this->mysql->fetchResult("select count(1) from sys_config {$where}");
		$list=$this->mysql->fetchRows("select * from sys_config {$where} order by id desc",$params['page'],$this->pageSize);
		$yes_no=getConfig('yes_or_no');
		foreach($list as &$item){
			$item['single_flag']=$yes_no[$item['single']];
			$item['config_flag']=nl2br($item['config']);
		}
		$data=array(
			'list'=>$list,
			'count'=>$count,
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _bset_update(){
		$pageuser=checkPower();
		if($pageuser['id']!=1){
			jReturn('-1','没有权限操作');
		}
		$params=getParam();
		$params['name']=$_POST['name'];
		$item_id=intval($params['item_id']);
		if(!$params['skey']){
			jReturn('-1','请填写SKEY');
		}
		if(!$params['name']){
			jReturn('-1','请填写配置名称');
		}
		$data=array(
			'name'=>$params['name'],
			'single'=>intval($params['single']),
			'skey'=>$params['skey'],
			'config'=>$_POST['config'],
			'update_time'=>NOW_TIME
		);
		if($item_id){
			$res=$this->mysql->update($data,"id={$item_id}",'sys_config');
		}else{
			$res=$this->mysql->insert($data,'sys_config');
		}
		if(!$res){
			jReturn('-1','没有修改或系统繁忙!请检查SKEY是否有重复！');
		}
		$this->flushBset($params['skey']);
		//actionLog(array('opt_name'=>'更新配置','sql_str'=>$this->mysql->lastSql),$this->mysql);

		if($params['skey']=='wx_gzh_config'){
			$wx_gzh_config=getConfig('wx_gzh_config');
			$gzh_data=array(
				'appid'=>$wx_gzh_config['appid'],
				'appsecret'=>$wx_gzh_config['appsecret'],
				'access_token_time'=>NOW_TIME-7200,
				'jsapi_ticket_time'=>NOW_TIME-7200
			);
			$this->mysql->update($gzh_data,"id=1",'sys_gzh');
		}
		jReturn('1','操作成功');
	}
	
	public function _bset_delete(){
		$pageuser=checkPower();
		if($pageuser['id']!=1){
			jReturn('-1','没有权限操作');
		}
		$item_id=intval($this->_param('item_id'));
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		if($item_id<13){
			jReturn('-1','系统基础配置不能删除');
		}
		$item=$this->mysql->fetchRow("select * from sys_config where id={$item_id}");
		if(!$item){
			jReturn('-1','该节点已经删除');
		}
		$res=$this->mysql->delete("id={$item_id}",'sys_config');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->flushBset($item['skey']);
		actionLog(array('opt_name'=>'删除配置','sql_str'=>json_encode($item)),$this->mysql);
		jReturn('1','操作成功');
	}
	
	//刷新配置
	private function flushBset($skey){
		$mem_key=$_ENV['CONFIG']['MEMCACHE']['PREFIX'].'sys_config_'.$skey;
		$memcache=new MyMemcache(0);
		return $memcache->delete($mem_key);
	}

	
	//##################配置管理结束##################
	
	//##################权限管理开始##################
	public function _oauth(){
		checkPower();
		$data=[];
		display('Sys/oauth.html',$data);
	}
	
	public function _oauth_list(){
		$pageuser=checkPower();
		$params=getParam();
		$account=$params['s_account'];
		$gid=intval($params['s_gid']);
		
		$mysql=new Mysql(0);
		if($account){
			$user=$mysql->fetchRow("select id,gid from sys_user where account='{$account}'");
			if(!$user){
				jReturn('-1','不存在账号：'.$account);
			}	
			$access=$mysql->fetchRows("select node_ids from sys_access where uid={$user['id']} or gid={$user['gid']}");
		}else{
			if($gid){
				$access=$mysql->fetchRows("select node_ids from sys_access where gid={$gid}");
			}else{
				$access=array();
			}
		}

		$access_ids_arr=array();
		foreach($access as $acv){
			if(!$acv['node_ids']){
				continue;
			}
			$tmp_node_ids=explode(',',$acv['node_ids']);
			foreach($tmp_node_ids as $tv){
				$i_tv=intval($tv);
				if($i_tv){
					$access_ids_arr[]=$i_tv;
				}
			}
		}
		if($access_ids_arr){
			$access_ids_arr=array_unique($access_ids_arr);
		}
		
		$node_arr=$this->mysql->fetchRows("select id,pid,nkey,name,type,public from sys_node order by CONCAT(pre_path,'-',id),pid asc,sort,id");
		$list=array();
		foreach($node_arr as $node){
			if($node['type']){
				$node['type_flag']=' [菜]';
			}else{
				$node['type_flag']='';
			}
			if($node['public']){
				$node['public_flag']=' [公]';
			}else{
				$node['public_flag']='';
			}
			if(in_array($node['id'],$access_ids_arr)){
				$node['oauth']=1;
			}else{
				$node['oauth']=0;
			}
			if(!$node['pid']){
				$list[$node['id']]=$node;
			}else{
				$list[$node['pid']]['sub_node'][]=$node;
			}
		}
		$data=array(
			'list'=>$list,
			'count'=>count($node_arr),
			'limit'=>count($node_arr),
			'access_ids'=>$access_ids_arr
		);
		jReturn('1','ok',$data);
	}
	
	public function _oauth_update(){
		$pageuser=checkPower();
		if($pageuser['id']!=1){
			jReturn('-1','没有权限操作');
		}
		$params=getParam();
		$account=$params['account'];
		$gid=intval($params['gid']);
		$oauth=$params['oauth'];
		if(!$oauth){
			$oauth=array();
		}
		$oauth_arr=array();
		foreach($oauth as $nid){
			$t_nid=intval($nid);
			if($t_nid){
				$oauth_arr[]=$t_nid;
			}
		}
		$node_ids=implode(',',$oauth_arr);
		$data=array('node_ids'=>$node_ids);
		$mysql=new Mysql(0);
		if($account){
			$user=$mysql->fetchRow("select id,gid from sys_user where account='{$account}'");
			if(!$user){
				jReturn('-1','不存在账号：'.$account);
			}
			$check_user=$this->mysql->fetchRow("select id from sys_access where uid={$user['id']}");
			if($check_user){
				$res=$mysql->update($data,"id={$check_user['id']}",'sys_access');
			}else{
				$data['uid']=$user['id'];
				$res=$mysql->insert($data,'sys_access');
			}
		}else{
			$sys_group=getConfig('sys_group');
			if(!array_key_exists($gid,$sys_group)){
				jReturn('-1','不存在系统分组：'.$gid);
			}
			$check_group=$this->mysql->fetchRow("select id from sys_access where gid={$gid}");
			if($check_group){
				$res=$mysql->update($data,"id={$check_group['id']}",'sys_access');
			}else{
				$data['gid']=$gid;
				$res=$mysql->insert($data,'sys_access');
			}
		}
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		if($user){
			$memcache=new MyMemcache(0);
			$mem_key=$_ENV['CONFIG']['MEMCACHE']['PREFIX'].'menu_arr_'.$user['id'];
			$mem_key2=$_ENV['CONFIG']['MEMCACHE']['PREFIX'].'access_ids_'.$user['id'];
			$memcache->delete($mem_key);
			$memcache->delete($mem_key2);
		}
		unset($this->mysql,$memcache);
		jReturn('1','操作成功');
	}
	
	
	//基本资料
	public function _userinfo(){
		checkPower();
		$data=[
			'sys_group'=>getConfig('sys_group')
		];
		display('Sys/userinfo.html',$data);
	}
	
	//安全设置
	public function _safety(){
		$pageuser=checkPower();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		
		$ga=new PHPGangsta_GoogleAuthenticator();
		if(!$user['google_secret']){
			$secret=$ga->createSecret();
			$sys_user=['google_secret'=>$secret];
			$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
			$user['google_secret']=$secret;
		}
		$google_qrcode=$ga->getQRCodeGoogleUrl($user['account'],$user['google_secret']);
		$data=[
			'user'=>$user,
			'google_qrcode'=>$google_qrcode
		];
		display('Sys/safety.html',$data);
	}
	
	public function _safety_update(){
		$pageuser=checkLogin();
		$params=getParam();
		$data=array();
		if($params['phone']){
			if(!isPhone($params['phone'])){
				jReturn('-1','手机号格式不正确');
			}
			if($params['phone']==$pageuser['phone']){
					jReturn('-1','新手机号没有变化');
			}
			if(!$params['pcode']){
				jReturn('-1','请填写短信验证码');
			}
			$user=$this->mysql->fetchRow("select id from sys_user where phone='{$params['phone']}'");
			if($user&&$user['id']!=$pageuser['id']){
				jReturn('-1','该手机号已被占用');
			}
			$check_res=checkPhoneCode(array('stype'=>$params['stype'],'phone'=>$params['phone'],'code'=>$params['pcode']));
			if($check_res['code']!='1'){
				exit(json_encode($check_res));
			}
			$data['phone']=$params['phone'];
		}
		if($params['password']){
			$data['password']=getPassword($params['password']);
		}
		if($params['password2']){
			$data['password2']=getPassword($params['password2']);
		}
		
		$data['is_google']=intval($params['is_google']);
		if(!$data){
			jReturn('-1','没有任何修改');
		}
		
		$res=$this->mysql->update($data,"id={$pageuser['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		//踢所有端下线
		//$this->mysql->update(array('status'=>1),"uid={$pageuser['id']}",'sys_session');
		jReturn('1','操作成功');
	}
	
	//隐藏谷歌配置信息
	public function _google_hide(){
		$pageuser=checkLogin();
		$sys_user=['google_hide'=>1];
		$res=$this->mysql->update($sys_user,"id={$pageuser['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','操作成功');
	}
	
	//##################数据清理开始##################
	public function _cdata(){
		checkPower();
		$data=[];
		display('Sys/cdata.html',$data);
	}
	
	public function _cdata_act(){
		$pageuser=checkPower();
		if($pageuser['id']!=1){
			jReturn('-1','没有权限操作');
		}
		$params=$this->params;
		if(!$params['table']){
			jReturn('-1','请选择要清理的数据项');
		}
		if(!$params['s_start_time']){
			jReturn('-1','请选择开始时间');
		}
		if(!$params['s_end_time']){
			jReturn('-1','请选择截止时间');
		}
		if($params['s_start_time']>$params['s_end_time']){
			jReturn('-1','开始时间不能超过截止时间');
		}
		$start_time=strtotime($params['s_start_time']);
		$end_time=strtotime($params['s_end_time']);
		if(!$params['password2']){
			jReturn('-1','请填写二级密码');
		}
		$password2=getPassword($params['password2']);
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		if($user['password2']!=$password2){
			jReturn('-1','二级密码不正确');
		}
		$sql_arr=[];
		foreach($params['table'] as $table){
			if(!$table){
				continue;
			}
			$sql='';
			switch($table){
				case 'sk_ma':
					$sql="delete from sk_ma where status=99 and create_time between {$start_time} and {$end_time}";
					break;
				case 'sk_order':
					$sql="delete from sk_order where pay_status!=2 and create_time between {$start_time} and {$end_time}";
					break;
				case 'sk_yong':
					$sql="delete from sk_yong where create_time between {$start_time} and {$end_time}";
					break;
				case 'cnf_paylog':
					$sql="delete from cnf_paylog where create_time between {$start_time} and {$end_time}";
					break;
				case 'cnf_cashlog':
					$sql="delete from cnf_cashlog where status>1 and create_time between {$start_time} and {$end_time}";
					break;
				case 'cnf_balance_log':
					$sql="delete from cnf_balance_log where create_time between {$start_time} and {$end_time}";
					break;
				case 'cnf_cashlog_bklog':
					$sql="delete from cnf_cashlog_bklog where status in(3,7) and create_time between {$start_time} and {$end_time}";
					break;
				case 'sys_log':
					$sql="delete from sys_log where create_time between {$start_time} and {$end_time}";
					break;
				case 'sk_agent_hklog':
					$sql="delete from sk_agent_hklog where create_time between {$start_time} and {$end_time}";
					break;
				default:
					break;
			}
			if($sql){
				$sql_arr[]=$sql;
			}
		}
		
		foreach($sql_arr as $sv){
			$this->mysql->db->query($sv);
			$this->mysql->db->query('reset master');
		}
		
		$sql_arr['act_uid']=$pageuser['id'];
		$sql_arr['act_time']=NOW_TIME;
		file_put_contents(ROOT_PATH.'logs/clear.txt',var_export($sql_arr,true)."\n\n",FILE_APPEND);
		jReturn('1','清理完毕');
	}
	
}
?>