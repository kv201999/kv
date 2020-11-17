<?php
!defined('ROOT_PATH') && exit;
class SkmaController extends BaseController{

    public function __construct(){
        parent::__construct();
    }

	public function _getCity(){
		checkLogin();
		$pid=intval($this->params['pid']);
		$city_arr=$this->mysql->fetchRows("select * from cnf_pc where pid={$pid} and pid>0");
		jReturn('1','ok',$city_arr);
	}

    public function _index(){
        $pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
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
		$where.=" and id in({$td_switch_str})";
		
		$mtype_arr_tmp=rows2arr($this->mysql->fetchRows("select * from sk_mtype {$where}"));
		$mtype_arr=[
			['id'=>0,'name'=>'全部支付类型']
		];
		foreach($mtype_arr_tmp as $tv){
			$mtype_arr[]=$tv;
		}
		
		$this->params['mtype']=intval($this->params['mtype']);
		$bank_arr=$this->mysql->fetchRows("select * from cnf_bank");
		$province_arr=$this->mysql->fetchRows("select * from cnf_pc where pid=0");
        $data=[
			'user'=>$user,
            'mtype_arr'=>$mtype_arr,
			'province_arr'=>$province_arr,
			'bank_arr'=>$bank_arr,
			's'=>$this->params
        ];
        $this->display($data);
    }
	
	private function parseItem($item){
		$pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select id,fy_rate from sys_user where id={$pageuser['id']}");
		$user['fy_rate']=json_decode($user['fy_rate'],true);
		$cnf_skma_status=getConfig('cnf_skma_status');
		$ph=date('H',NOW_TIME);
		$cnf_reward_rate=0;
		if($ph>=23||($ph>=0&&$ph<=8)){
			$cnf_reward_rate=floatval(getConfig('cnf_reward_rate'));
		}
		$cnt_sql="select sum(log.money) as sum_money from sk_yong log left join sk_order od on log.fkey=od.id where log.uid={$item['uid']} and log.type=1 and od.ma_id={$item['id']}";
		$cnt_item=$this->mysql->fetchRow($cnt_sql);
		$item['min_money']=floatval($item['min_money']);
		$item['max_money']=floatval($item['max_money']);
		$item['yong_money']=floatval($cnt_item['sum_money']);
		$item['fy_rate']=floatval($user['fy_rate'][$item['mtype_id']]*100);
		$item['status_flag']=$cnf_skma_status[$item['status']];
		$item['create_time_flag']=date('m-d H:i',$item['create_time']);
		$item['reward_rate']=($cnf_reward_rate*100);
		//统计码当天收款
		$now_day=date('Ymd');
		$matj=$this->mysql->fetchRow("select count(1) as cnt,sum(money) as money from sk_order where ma_id={$item['id']} and create_day={$now_day} and pay_status=9");
		$matj2=$this->mysql->fetchRow("select count(1) as cnt,sum(money) as money from sk_order where ma_id={$item['id']} and create_day={$now_day}");
		$item['day_tcnt']=intval($matj['cnt']);
		$item['day_tcnt2']=intval($matj2['cnt']);
		$item['day_tmoney']=floatval($matj['money']);
		
		$item['day_percent']='0%';
		if($item['day_tcnt2']>0){
			$item['day_percent']=round(($item['day_tcnt']/$item['day_tcnt2'])*100,2).'%';
		}
		
		if($item['ma_zkling']){
			$item['ma_zkling']=base64_decode($item['ma_zkling']);
		}
		
		return $item;
	}
	
	public function _skma_one(){
		$pageuser=checkLogin();
		$item_id=intval($this->params['item_id']);
		$sql="select log.id,log.uid,log.mtype_id,log.min_money,log.max_money,
		log.province_id,log.city_id,log.bank_id,log.branch_name,log.shangpin_id,
		log.status,log.create_time,log.ma_account,log.ma_realname,log.ma_qrcode,log.ma_zkmoney,log.ma_zkling,log.ma_zfbuid,
		mt.name as mtpye_name,mt.type as mtype_type,bk.bank_name,pc.cname as province_name,pc2.cname as city_name 
		from sk_ma log left join sk_mtype mt on log.mtype_id=mt.id 
		left join cnf_pc pc on log.province_id=pc.id 
		left join cnf_pc pc2 on log.city_id=pc2.id 
		left join cnf_bank bk on log.bank_id=bk.id where log.id={$item_id} and log.uid={$pageuser['id']} and log.status<99";
		$item=$this->mysql->fetchRow($sql);
		if(!$item){
			jReturn('-1','不存在相应的收款码');
		}
		$item=$this->parseItem($item);
		jReturn('1','ok',$item);
	}
	
	public function _skma_list(){
		$pageuser=checkLogin();
		$pageSize=10;
		$params=$this->params;
		$params['mtype']=intval($params['mtype']);
		$params['page']=intval($params['page']);
		if(!$params['page']){
			$params['page']=1;
		}

		$where="where log.uid={$pageuser['id']} and log.status<99";
		$where.=empty($params['mtype'])?'':" and log.mtype_id={$params['mtype']}";
		if($params['keyword']){
			$where.=" and (log.ma_account='{$params['keyword']}' or log.ma_realname='{$params['keyword']}')";
		}
		$count_item=$this->mysql->fetchRow("select count(1) as cnt from sk_ma log left join sk_mtype mt on log.mtype_id=mt.id {$where}");
		$sql="select log.id,log.uid,log.mtype_id,log.min_money,log.max_money,log.province_id,log.shangpin_id,log.city_id,log.bank_id,log.branch_name,log.status,log.create_time,log.ma_account,log.ma_realname,log.ma_qrcode,
		mt.name as mtpye_name,mt.type as mtype_type,bk.bank_name,pc.cname as province_name,pc2.cname as city_name 
		from sk_ma log left join sk_mtype mt on log.mtype_id=mt.id 
		left join cnf_pc pc on log.province_id=pc.id 
		left join cnf_pc pc2 on log.city_id=pc2.id 
		left join cnf_bank bk on log.bank_id=bk.id {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		//echo $sql;exit;		
		foreach($list as $ik=>$item){
			$list[$ik]=$this->parseItem($item);
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
	
	//添加收款码
	public function _skma_update(){
		$pageuser=checkLogin();
		$params=$this->params;
		$item_id=intval($params['item_id']);
		$params['mtype_id']=intval($params['mtype_id']);
		$params['bank_id']=intval($params['bank_id']);
		$params['province_id']=intval($params['province_id']);
		$params['city_id']=intval($params['city_id']);
		$params['status']=intval($params['status']);
		$params['max_money']=floatval($params['max_money']);
		$params['min_money']=floatval($params['min_money']);
		if(!$params['mtype_id']){
			jReturn('-1','请选支付择类型');
		}else{
			$mtype=$this->mysql->fetchRow("select * from sk_mtype where id={$params['mtype_id']}");
			if(!$mtype){
				jReturn('-1','支付类型不正确');
			}elseif(!$mtype['is_open']){
				jReturn('-1','该支付类型暂未开放');
			}
		}
		
//		if(!$params['province_id']||!$params['city_id']){
//			jReturn('-1','请选择所在省份和城市');
//		}
		
//		if(!$params['ma_realname']){
//			jReturn('-1','请填写收款姓名');
//		}
//		if(!$params['ma_account']){
//			jReturn('-1','请填写收款账号');
//		}
		
		if($mtype['type']==1){
			//基本类型无需额外信息
		}elseif($mtype['type']==2){
			if(!$params['ma_qrcode']||$params['ma_qrcode']=='/public/home/images/add.png'){
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
		
		$this->mysql->startTrans();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$user['td_switch']=json_decode($user['td_switch'],true);
		if(!$user['td_switch'][$params['mtype_id']]){
			jReturn('-1','该支付类型暂未对您开放');
		}
		if(!$params['min_money']||$params['min_money']<0){
			$params['min_money']=floatval(getConfig('cnf_skm_min_money'));
		}
		if(!$params['max_money']||$params['max_money']<0){
			$params['max_money']=floatval(getConfig('cnf_skm_max_money'));
		}
		if($params['max_money']<$params['min_money']){
			jReturn('-1','最大收款不能小于最小收款');
		}
		$sk_ma=array(
			'mtype_id'=>$params['mtype_id'],
			'province_id'=>$params['province_id'],
			'city_id'=>$params['city_id'],
			'ma_account'=>$params['ma_account'],
			'ma_realname'=>$params['ma_realname'],
			'status'=>$params['status'],
			'max_money'=>$params['max_money'],
			'min_money'=>$params['min_money'],
            'shangpin_id'=>$params['shangpin_id']
			//'fz_time'=>0
			//'uid'=>$pageuser['id'],
			//'bank_id'=>$params['bank_id'],
			//'ma_qrcode'=>$params['ma_qrcode']
		);
        $xyinfo=getxyprice($params['shangpin_id']);
        if($xyinfo["status"]!=0){
            jReturn('-1','商品已售出或存在异常');
        }
		if($mtype['type']==2){
			$sk_ma['ma_qrcode']=$params['ma_qrcode'];
            $sk_ma['max_money']=$xyinfo["price"];
            $sk_ma['min_money']=$xyinfo["price"];
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
			$sk_ma['status']=2;
			//$sk_ma['fz_time']=NOW_TIME+86400*90;
			$sk_ma['uid']=$pageuser['id'];
			$sk_ma['create_time']=NOW_TIME;
			$res=$this->mysql->insert($sk_ma,'sk_ma');
			$item_id=$res;
		}else{
			$item=$this->mysql->fetchRow("select * from sk_ma where id={$item_id}");
			if(!$item||$item['uid']!=$pageuser['id']){
				jReturn('-1','抱歉，您没有权限操作该收款码');
			}
			if($sk_ma['status']==2){
				if(NOW_TIME<$item['fz_time']){
					jReturn('-1','请先在首页开启抢单');
				}
			}
			$res=$this->mysql->update($sk_ma,"id={$item_id}",'sk_ma');
		}
		
		if($res===false){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		$return_data=[
			'id'=>$item_id
		];
		jReturn('1','操作成功',$return_data);
	}
	
	public function _skma_delete(){
		$pageuser=checkLogin();
		$item_id=intval($this->params['item_id']);
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$item=$this->mysql->fetchRow("select * from sk_ma where id={$item_id} and status<99");
		if(!$item){
			jReturn('-1','不存在相应的收款码');
		}
		if($item['uid']!=$pageuser['id']){
			jReturn('-1','您没有权限操作该收款码');
		}
		$sk_ma=['status'=>99];
		$res=$this->mysql->update($sk_ma,"id={$item['id']}",'sk_ma');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','删除成功');
	}
	
	//设置收款码上下线
	public function _skma_set(){
		$pageuser=checkLogin();
		$skma_id=intval($this->params['skma_id']);
		$skma=$this->mysql->fetchRow("select * from sk_ma where id={$skma_id} and status<99");
		if(!$skma){
			jReturn('-1','不存在该收款码');
		}else{
			if($skma['uid']!=$pageuser['id']){
				jReturn('-1','您没有权限操作该收款码');
			}
		}
		$sk_ma=[];
		if($skma['status']==1){
//			if(NOW_TIME<$skma['fz_time']){
//				jReturn('-1','请先在首页开启抢单');
//			}
			$sk_ma['status']=2;
			
			$user=$this->mysql->fetchRow("select * from sys_user where id={$skma['uid']}");
			$user['td_switch']=json_decode($user['td_switch'],true);
			if(!$user['td_switch'][$skma['mtype_id']]){
				jReturn('-1','该支付类型暂未对您开放');
			}
		}else{
			$sk_ma['status']=1;
		}
		$res=$this->mysql->update($sk_ma,"id={$skma['id']}",'sk_ma');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$cnf_skma_status=getConfig('cnf_skma_status');
		$return_data=[
			'status'=>$sk_ma['status'],
			'status_flag'=>$cnf_skma_status[$sk_ma['status']]
		];
		jReturn('1','操作成功',$return_data);
	}

	//////////////////////////收款码独立回调/////////////////////////////
	public function _info(){
		$pageuser=checkLogin();
		$skma_id=intval($this->params['id']);
		$item=$this->mysql->fetchRow("select * from sk_ma where id={$skma_id} and uid={$pageuser['id']} and status<99");
		if(!$item){
			header("Location:/?c=Skma");exit;
		}
		$data=[
			'info'=>$item,
			'notify_url'=>"{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/?c=Notify2&maid={$item['id']}"
		];
		$this->display($data);
	}
	
	public function _apikeyUpdate(){
		$pageuser=checkLogin();
		$item_id=intval($this->params['item_id']);
		$password2=getPassword($this->params['password2']);
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		if($password2!=$user['password2']){
			jReturn('-1','二级密码不正确');
		}
		$item=$this->mysql->fetchRow("select * from sk_ma where id={$item_id} and uid={$pageuser['id']} and status<99");
		if(!$item){
			jReturn('-1','不存在相应的收款码');
		}
		$sk_ma=[
			'apikey'=>sha1(md5($user['id'].'_'.$user['account'].'_ma_'.$item_id.'_'.time().'_'.SYS_KEY))
		];
		$res=$this->mysql->update($sk_ma,"id={$item_id}",'sk_ma');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','更新成功');
	}
	
	////////////////////////////////////////////////////////////
	//测试收款码
	public function _skma_test(){
		$pageuser=checkLogin();
		$skma_id=intval($this->params['skma_id']);
		$money=floatval($this->params['money']);
		if($money<0.01){
			jReturn('-1','测试金额不正确');
		}
		$mysql=$this->mysql;
		$sk_ma=$mysql->fetchRow("select * from sk_ma where id={$skma_id} and uid={$pageuser['id']} and status<99");
		if(!$sk_ma){
			jReturn('-1','不存在相应的收款码');
		}
		$ptype=$sk_ma['mtype_id'];
		$p_data=[
			'ptype'=>$sk_ma['mtype_id'],
			'money'=>$money,
			'order_sn'=>'U'.date('YmdHis',NOW_TIME).mt_rand(10000,99999),
			'goods_desc'=>'test',
			'client_ip'=>'',
			'notify_url'=>$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/?c=Pay&a=notify_url'
		];
		$mysql->startTrans();
		$ma_user=$mysql->fetchRow("select id,sx_balance,fz_balance from sys_user where id={$sk_ma['uid']} for update");
		$user=$mysql->fetchRow("select * from sys_user where account='13122222222'");
		$user['td_rate']=json_decode($user['td_rate'],true);
		$rate=$user['td_rate'][$ptype];
		$fee=$p_data['money']*$rate;
		$sk_order=[
			'muid'=>$sk_ma['uid'],//码商id
			'suid'=>$user['id'],//商户id
			'ptype'=>$ptype,
			'order_sn'=>'TS'.date('YmdHis',NOW_TIME).mt_rand(10000,99999),
			'out_order_sn'=>$p_data['order_sn'],
			'goods_desc'=>$p_data['goods_desc'],
			'money'=>$p_data['money'],
			'real_money'=>$p_data['money']-$fee,
			'rate'=>$rate,
			'fee'=>$fee,
			'ma_id'=>$sk_ma['id'],//码id
			'ma_account'=>$sk_ma['ma_account'],
			'ma_realname'=>$sk_ma['ma_realname'],
			'ma_qrcode'=>$sk_ma['ma_qrcode'],
			'ma_bank_id'=>$sk_ma['bank_id'],
			'ma_branch_name'=>$sk_ma['branch_name'],
			'ma_zkling'=>$sk_ma['ma_zkling'],
			'ma_zfbuid'=>$sk_ma['ma_zfbuid'],
			'order_ip'=>$p_data['client_ip'],
			'notify_url'=>$p_data['notify_url'],
			'return_url'=>trim($_REQUEST['return_url']),
			'create_time'=>NOW_TIME,
			'create_day'=>date('Ymd',NOW_TIME),
			'reffer_url'=>$_SERVER['HTTP_REFERER']
		];
		
		if($ptype==12){
			$ma_qrcode='uploads/qr/'.date('Ymd').'/'.getRsn().'.jpg';
			$ma_qrcode_path=ROOT_PATH.$ma_qrcode;
			if(!is_dir(dirname($ma_qrcode_path))){
				mkdir(dirname($ma_qrcode_path),0755,true);
			}
			$rand=mt_rand(1111,9999);
			$text='alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money","u": "'.$sk_ma['ma_zfbuid'].'","a": "'.$p_data['money'].'","m":"'.$sk_order['order_sn'].'"}';
			QRcode::png($text,$ma_qrcode,'H',14,0);
			$sk_order['ma_qrcode']=$ma_qrcode;
		}
		
		$ma_sys_user=[
			'sx_balance'=>$ma_user['sx_balance']-$p_data['money'],
			'fz_balance'=>$ma_user['fz_balance']+$p_data['money']
		];
		if($ma_sys_user['sx_balance']<0){
			jReturn('-2','您的接单余额不足，无法完成测试');
		}
		
		$res=$mysql->insert($sk_order,'sk_order');
		$res2=$mysql->update($ma_sys_user,"id={$ma_user['id']}",'sys_user');
		$res3=balanceLog($ma_user,3,13,-$p_data['money'],$res,$sk_order['order_sn'],$mysql);
		if(!$res||!$res2||!$res3){
			$mysql->rollback();
			jReturn('-1','下单失败请稍后再试');
		}
		$mysql->commit();
		
		//写入异步通知记录
		$cnf_notice=[
			'type'=>1,
			'fkey'=>$sk_order['order_sn'],
			'create_time'=>NOW_TIME,
			'remark'=>'测试订单通知码商'
		];
		$mysql->insert($cnf_notice,'cnf_notice');
		
		$mtype=$mysql->fetchRow("select * from sk_mtype where id={$ptype}");
		
		$return_data=[
			'order_sn'=>$sk_order['order_sn'],
			'ptype'=>$p_data['ptype'],
			'ptype_name'=>$mtype['name'],
			'realname'=>$sk_ma['ma_realname'],
			'account'=>$sk_ma['ma_account'],
			'money'=>$p_data['money'],
			'bank'=>'',
			'qrcode'=>''
		];
		if($mtype['type']==3){
			$bank=$mysql->fetchRow("select * from cnf_bank where id={$sk_ma['bank_id']}");
			$return_data['bank']=$bank['bank_name'];
		}elseif($mtype['type']==2){
			$new_qrcode='';
			$cnf_trans_qrcode=getConfig('cnf_trans_qrcode');
			if($cnf_trans_qrcode=='是'){
				$new_qrcode=getNewQrcode($sk_ma['ma_qrcode'],false,"p{$sk_ma['mtype_id']}.png");
			}
			if(!$new_qrcode){
				$new_qrcode=$sk_ma['ma_qrcode'];
			}
			$return_data['qrcode']=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/'.$new_qrcode;
		}
		jReturn('1','下单成功',$return_data);
	}


}
?>