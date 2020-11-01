<?php
!defined('ROOT_PATH') && exit;
class PayController extends BaseController{
	
	public function __construct(){
		parent::__construct();
		$this->getMaNum=0;
		$this->checkMaArr=[];
		$this->testMchId='13122222222';//测试通道使用的商户号
	}
	
	//md5签名
	private function signMd5($pdata,$mch_key){
		ksort($pdata);
		$sign_str='';
		foreach($pdata as $pk=>$pv){
			$sign_str.="{$pk}={$pv}&";
		}
		$sign_str.="key={$mch_key}";
		$sign=md5($sign_str);
		return $sign;
	}

	//订单提交接口
	public function _index(){
		$params=$this->params;
		file_put_contents(ROOT_PATH.'logs/order.txt',var_export($params,true)."\n\n",FILE_APPEND);
		if($_REQUEST['crypted']){
			$rsa_pt_private=getConfig('rsa_pt_private');
			$resultArr=decryptRsa($_REQUEST['crypted'],$rsa_pt_private);
			if($resultArr['code']!='1'){
				jReturn('-1',$resultArr['msg']);
			}
			$params=$resultArr['data'];
		}
		
		if(!$params['time']||!$params['mch_id']||!$params['ptype']||!$params['order_sn']||!$params['money']||!$params['notify_url']||!$params['sign']||!$params['usdtaddress']){
			jReturn('-1','缺少参数');
		}
		
		if(abs(NOW_TIME-$params['time'])>300){
			jReturn('-1','请求已超时，请重新提交');
		}
        $req = new req();
		$p_data=array(
			'time'=>$params['time'],
			'mch_id'=>$params['mch_id'],
			'ptype'=>$params['ptype'],
			'order_sn'=>$params['order_sn'],
			'money'=>$params['money'],
            'usdtaddress'=>$params['usdtaddress'],
			'goods_desc'=>$params['goods_desc'],
			'client_ip'=>$params['client_ip'],
			'format'=>$params['format']?$params['format']:'page',
			'notify_url'=>urldecode(htmlspecialchars_decode($params['notify_url']))
		);
		if($p_data['money']<0.01){
			jReturn('-1','金额不正确');
		}
		$ptype=intval($p_data['ptype']);
		
		$mysql=$this->mysql;
		$user=$mysql->fetchRow("select * from sys_user where account='{$p_data['mch_id']}' and status=2");
		if(!$user){
			jReturn('-1','商户不存在或已被禁用');
		}
		if($user['is_rsa']){
			if(!$_REQUEST['crypted']){
				jReturn('-1','商户已开启RSA接口加密，请传入密文参数');
			}
		}else{
			if($_REQUEST['crypted']){
				jReturn('-1','商户未开启RSA接口加密，请传入明文参数');
			}
		}
		$user['td_rate']=json_decode($user['td_rate'],true);
		$user['td_switch']=json_decode($user['td_switch'],true);
		if(!$user['td_switch'][$ptype]){
			jReturn('-1','商户未开通通道:'.$ptype);
		}
		if(!$user['td_rate'][$ptype]){
			jReturn('-1','商户号未设置费率激活');
		}		
		if(!$user['apikey']){
			jReturn('-1','商户未生成签名密钥');
		}
		$sign=$this->signMd5($p_data,$user['apikey']);
		if($sign!=$params['sign']){
			$p_data['sign']=$params['sign'];
			$p_data['pt_sign']=$sign;
			file_put_contents(ROOT_PATH.'logs/pay_sign.txt',var_export($p_data,true)."\n\n",FILE_APPEND);
			jReturn('-1','签名错误');
		}

//            $p_data['rmb'] = intval($p_data['money']);
            $p_data['otcbuy']=$req->get_otcbuy()+$req->get_otcbuy()*0.05;
            $p_data['usdt']=round($p_data['money']/$req->get_otcbuy(),2);

		$check_mc_order=$mysql->fetchRow("select id from sk_order where out_order_sn='{$p_data['order_sn']}'");
		if($check_mc_order['id']){
			jReturn('-1',"商户单号已存在，请勿重复提交 {$p_data['order_sn']}");
		}
		
		$mtype=$mysql->fetchRow("select * from sk_mtype where id={$ptype} and is_open=1");
		if(!$mtype){
			jReturn('-1','不存在该支付类型或未开放');
		}else{
			if($p_data['money']<$mtype['min_money']){
				jReturn('-1',"该通道最小订单金额为{$mtype['min_money']}");
			}
			if($p_data['money']>$mtype['max_money']){
				jReturn('-1',"该通道最大订单金额为{$mtype['max_money']}");
			}
		}
		//##########指定代理转换成指定码商##########
		$appoint_ms_arr=[];
		if($user['appoint_agent']){
			$appoint_agent_arr=explode(',',$user['appoint_agent']);
			foreach($appoint_agent_arr as $aid){
				$down_ms=getDownUser($aid);
				if(!$down_ms){
					$down_ms=[];
				}
				$appoint_ms_arr=array_merge($down_ms,[$aid]);
			}
		}
		if($user['appoint_ms']){
			$appoint_ms_arr_tmp=explode(',',$user['appoint_ms']);
			if(!$appoint_ms_arr_tmp){
				$appoint_ms_arr_tmp=[];
			}
			$appoint_ms_arr=array_merge($appoint_ms_arr,$appoint_ms_arr_tmp);
		}
		$p_data['appoint_ms']=$appoint_ms_arr;
		//##########指定代理转换成指定码商##########
		$sk_ma=$this->getSkma($p_data,$mysql);
		if(!$sk_ma){
			/*
			if($ptype==11){
				$cnf_zkling_mitem=getConfig('cnf_zkling_mitem');
				$zkm_arr=[];
				foreach($cnf_zkling_mitem as $zk=>$zv){
					$zkm_arr[]=$zv;
				}
				$zkm_str=implode(',',$zkm_arr);
				jReturn('-1','未匹配到在线口令，吱口令仅支持金额：'.$zkm_str);
			}*/
			jReturn('-1','未匹配到在线的收款码，请更换金额再次尝试');
		}
		$mysql->startTrans();
		$ma_user=$mysql->fetchRow("select id,sx_balance,fz_balance from sys_user where id={$sk_ma['uid']} for update");
		$rate=$user['td_rate'][$ptype];
		$fee=$p_data['money']*$rate;
		$sk_order=[
			'muid'=>$sk_ma['uid'],//码商id
			'suid'=>$user['id'],//商户id
			'ptype'=>$ptype,
			'order_sn'=>'MS'.date('YmdHis',NOW_TIME).mt_rand(10000,99999),
			'out_order_sn'=>$p_data['order_sn'],
			'goods_desc'=>$p_data['goods_desc'],
            'usdt'=>$p_data['usdt'],
            'otcbuy'=>$p_data['otcbuy'],
			'money'=>$p_data['money'],
            'usdtaddress'=>$p_data['usdtaddress'],
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
			'fz_balance'=>$ma_user['fz_balance']+$p_data['money'],
			'queue_time'=>NOW_TIME
		];
		if($ma_sys_user['sx_balance']<0){
			jReturn('-1','已匹配到的码商接单余额不足，请重新尝试');
		}
		
		//更新收款码的排队时间
		$sk_ma_data=[
			'queue_time'=>NOW_TIME
		];

		$res=$mysql->insert($sk_order,'sk_order');
		$res2=$mysql->update($ma_sys_user,"id={$ma_user['id']}",'sys_user');
		$res3=balanceLog($ma_user,3,13,-$p_data['money'],$res,$sk_order['order_sn'],$mysql);
		$res4=$mysql->update($sk_ma_data,"id={$sk_ma['id']}",'sk_ma');
		if(!$res||!$res2||!$res3||!$res4){
			$mysql->rollback();
			jReturn('-1','下单失败请稍后再试');
		}
		$mysql->commit();
		
		//写入异步通知记录
		$cnf_notice=[
			'type'=>1,
			'fkey'=>$sk_order['order_sn'],
			'create_time'=>NOW_TIME,
			'remark'=>'新订单通知码商'
		];
		$mysql->insert($cnf_notice,'cnf_notice');
		
		if($p_data['format']!='json'){
			$url="/?c=Pay&a=info&osn={$sk_order['order_sn']}";
			header("Location:{$url}");
			exit;
		}

		$return_data=[
			'order_sn'=>$sk_order['order_sn'],
			'ptype'=>$p_data['ptype'],
			'ptype_name'=>$mtype['name'],
			'realname'=>$sk_ma['ma_realname'],
			'account'=>$sk_ma['ma_account'],
			'money'=>$sk_order['money'],
//            'otcbuy'=>$sk_order['otcbuy'],
//            'usdt'=>$sk_order['money'],
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

	//匹配码
	private function getSkma($p_data,$mysql=null){
		if(!$mysql){
			$mysql=new Mysql(0);
		}
		$min_match_money=floatval(getConfig('min_match_money'));
		$ptype=intval($p_data['ptype']);
		$limit_balance=$min_match_money+$p_data['money'];

		$order_arr=$this->mysql->fetchRows("select ma_id from sk_order where ptype={$ptype} and pay_status in(1,2) and money='{$p_data['money']}'");
		foreach($order_arr as $ev){
			$this->checkMaArr[]=$ev['ma_id'];
		}
		//根据ptype取出相应的码
		/*固定金额吱口令
		if($ptype==11){
			$sql="select log.* from sk_ma log left join sys_user u on log.uid=u.id 
			where log.mtype_id={$ptype} and log.status=2 
			and (log.ma_zkmoney={$p_data['money']}) 
			and (u.status=2 and u.is_online=1 and u.sx_balance>={$limit_balance})";
		}*/
		
		$sql="select log.* from sk_ma log left join sys_user u on log.uid=u.id 
		where log.mtype_id={$ptype} and log.status=2 
		and (log.min_money<={$p_data['money']} and log.max_money>={$p_data['money']}) 
		and (u.status=2 and u.is_online=1 and u.sx_balance>={$limit_balance})";
		
		//###########指定代理/码商###########
		if($p_data['appoint_ms']){
			$appoint_ms_str=implode(',',$p_data['appoint_ms']);
			$sql.=" and log.uid in ({$appoint_ms_str})";
		}
		//###########指定代理/码商###########
		
		if($this->checkMaArr){
			$exp_skmids=implode(',',$this->checkMaArr);
			$sql.=" and log.id not in ({$exp_skmids})";
		}
		$sk_ma=[];
		//根据ip匹配一个合适的
		/*
		if(false&&$p_data['client_ip']&&$p_data['client_ip']!='127.0.0.1'){
			$ip_url="http://ip-api.com/json/{$p_data['client_ip']}?lang=zh-CN";
			$result=curl_get($ip_url,5);
			$resultArr=json_decode($result['output'],true);
			$regionName=$resultArr['regionName'];
			$cityName=$resultArr['city'];
			if($regionName&&$city){
				$city=$mysql->fetchRow("select * from cnf_pc where cname like '%{$cityName}%'");
				if($city){
					$ma_sql=$sql." and log.province_id={$city['pid']} and log.city_id={$city['id']} order by rand()";
					$sk_ma=$mysql->fetchRow($ma_sql);
				}
			}
		}*/
		if(!$sk_ma){
			//$ma_sql=$sql." order by rand()";
			$ma_sql=$sql." order by u.queue_time asc,log.queue_time asc";
			$sk_ma=$mysql->fetchRow($ma_sql);
			file_put_contents(ROOT_PATH.'logs/ma_sql.txt',$ma_sql."\n\n",FILE_APPEND);
		}

		//检测该码商是否有相同金额订单
		if($sk_ma){
			$check_order=$mysql->fetchRow("select id from sk_order where muid={$sk_ma['uid']} and pay_status<=2 and money='{$p_data['money']}'");
			if($check_order['id']){
				$this->checkMaArr[]=$sk_ma['id'];
				$this->getMaNum++;
				if($this->getMaNum<3){
					$sk_ma=$this->getSkma($p_data,$mysql);
				}else{
					$sk_ma=null;
				}
			}
		}else{
			$cnf_msappoint_other=getConfig('cnf_msappoint_other');
			if($p_data['appoint_ms']&&$cnf_msappoint_other=='是'){
				$p_data['appoint_ms']=null;
				$sk_ma=$this->getSkma($p_data,$mysql);
			}
		}
		return $sk_ma;
	}
	
	///////////////////////订单查询接口//////////////////////
	public function _query(){
		$params=$this->params;
		if($_REQUEST['crypted']){
			$rsa_pt_private=getConfig('rsa_pt_private');
			$resultArr=decryptRsa($_REQUEST['crypted'],$rsa_pt_private);
			if($resultArr['code']!='1'){
				jReturn('-1',$resultArr['msg']);
			}
			$params=$resultArr['data'];
			var_dump($params);
		}
		
		$p_data=array(
			'time'=>$params['time'],
			'mch_id'=>$params['mch_id'],
			'out_order_sn'=>$params['out_order_sn']
		);
		if(abs(NOW_TIME-$params['time'])>300){
			jReturn('-1','请求已超时，请重新提交');
		}
		if(!$p_data['mch_id']){
			jReturn('-1','缺少商户号');
		}
		if(!$p_data['out_order_sn']){
			jReturn('-1','缺少商户订单号');
		}
		$user=$this->mysql->fetchRow("select * from sys_user where account='{$p_data['mch_id']}' and status=2");
		if(!$user){
			jReturn('-1','商户不存在或已被禁用');
		}
		if($user['is_rsa']){
			if(!$_REQUEST['crypted']){
				jReturn('-1','商户已开启RSA接口加密，请传入密文参数');
			}
		}else{
			if($_REQUEST['crypted']){
				jReturn('-1','商户未开启RSA接口加密，请传入明文参数');
			}
		}
		if(!$user['apikey']){
			jReturn('-1','商户未生成md5签名密钥');
		}
		$sign=$this->signMd5($p_data,$user['apikey']);
		if($sign!=$params['sign']){
			$p_data['sign']=$params['sign'];
			$p_data['pt_sign']=$sign;
			file_put_contents(ROOT_PATH.'logs/query_sign.txt',var_export($p_data,true)."\n\n",FILE_APPEND);
			jReturn('-1','签名错误');
		}
		$order=$this->mysql->fetchRow("select * from sk_order where out_order_sn='{$p_data['out_order_sn']}' and suid={$user['id']} and pay_status<99");
		if(!$order){
			jReturn('-1','不存在相应的订单');
		}
		$cnf_pay_status=getConfig('cnf_pay_status');
		$cnf_notice_status=getConfig('cnf_notice_status');
		$return_data=[
			'mch_id'=>$p_data['mch_id'],
			'order_sn'=>$order['order_sn'],
			'out_order_sn'=>$order['out_order_sn'],
            'money'=>$order['money'],
//            'otcbuy'=>$order['otcbuy'],
//            'usdt'=>$order['money'],
			'order_time'=>$order['create_time'],
			'pay_time'=>$order['pay_time'],
			'status'=>$order['pay_status'],
			'status_flag'=>$cnf_pay_status[$order['pay_status']],
			'notice_status'=>$order['notice_status'],
			'notice_status_flag'=>$cnf_notice_status[$order['notice_status']],
			'notice_msg'=>$order['notice_msg']
		];
		jReturn('1','ok',$return_data);
	}
	
	
	///////////////////////订单支付界面//////////////////////
	
	public function _info(){
		$osn=$this->params['osn'];
		$sql="select log.*,mt.name as mtype_name,mt.type as mtype_type,bk.bank_name 
		from sk_order log 
		left join sk_mtype mt on log.ptype=mt.id 
		left join cnf_bank bk on log.ma_bank_id=bk.id 
		where log.order_sn='{$osn}'";
		$order=$this->mysql->fetchRow($sql);
		if(!$order){
			exit('不存在相应的订单号');
		}
		if($order['ma_zkling']){
			$order['ma_zkling']=base64_decode($order['ma_zkling']);
		}
		$order['branch_name']=$order['ma_branch_name'];
		$order['mtype_id']=$order['ptype'];
		$order['ma_account2']=substr($order['ma_account'],0,3).'***'.substr($order['ma_account'],-3);
		$order['ma_realname2']=msubstr($order['ma_realname'],0,1,'utf-8','').'**';
		$order['ma_account2']=$order['ma_account'];
		$order['ma_realname2']=$order['ma_realname'];
		$skorder_over_time=intval(getConfig('skorder_over_time'));
		$order['d_time']=$skorder_over_time-(NOW_TIME-$order['create_time']);
		if($order['d_time']<0){
			$order['d_time']=0;
		}
		
		//支付宝扫码
		if($order['ptype']==1){
			$cnf_zfbh5_open=getConfig('cnf_zfbh5_open');
			if($cnf_zfbh5_open=='是'){
				$url=getQrContent($order['ma_qrcode'],false);
				if($url){
					$order['zfbh5_url']='/?c=Pay&a=zfbh5&osn='.$order['order_sn'];
				}
			}
		}elseif($order['ptype']==12){
			$zz_url="alipays://platformapi/startapp?saId=20000067&url=".urlencode($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/?c=Pay&a=preAlipay&osn='.$order['order_sn']);
			$order['zz_url']=$zz_url;
		}elseif($order['ptype']==13){
			$qrcode_url=getQrContent($order['ma_qrcode']);
			$zz_url="alipays://platformapi/startapp?appId=68687093&url=".urlencode($qrcode_url);
			$order['zz_url']=$zz_url;
		}
		
		//转换二维码
		if($order['mtype_type']==2){
			$cnf_trans_qrcode=getConfig('cnf_trans_qrcode');
			if($cnf_trans_qrcode=='是'){
				$new_qrcode=getNewQrcode($order['ma_qrcode'],false,"p{$order['ptype']}.png");
				if($new_qrcode){
					$order['ma_qrcode']=$new_qrcode;
				}
			}
		}
		$data=[
			'info'=>$order
		];
		
		$tpl_name="Pay/p{$order['ptype']}.html";
		$tpl=APP_PATH."view/{$tpl_name}";
		if(file_exists($tpl)){
			$this->display($tpl_name,$data);
			exit;
		}
		$this->display($data);
	}
	
	public function _preAlipay(){
		$osn=$this->params['osn'];
		$order=$this->mysql->fetchRow("select * from sk_order where order_sn='{$osn}' and pay_status<99");
		if(!$order){
			jReturn('-1','不存在相应订单');
		}
		$data=[
			'info'=>$order
		];
		$this->display($data);
	}
	
	public function _alipay(){
		$osn=$this->params['osn'];
		$order=$this->mysql->fetchRow("select * from sk_order where order_sn='{$osn}' and pay_status<99");
		if(!$order){
			jReturn('-1','不存在相应订单');
		}
		$text='alipays://platformapi/startapp?appId=20000123&actionType=scan&biz_data={"s": "money","u": "'.$order['ma_zfbuid'].'","a": "'.$order['money'].'","m":"'.$order['order_sn'].'"}';
		
		header("Location:{$text}");
		exit;
		
		//QRcode::png($text,false,'H',14,0);
		$ma_qrcode='uploads/qr/'.date('Ymd').'/'.getRsn().'.jpg';
		$ma_qrcode_path=ROOT_PATH.$ma_qrcode;
		if(!is_dir(dirname($ma_qrcode_path))){
			mkdir(dirname($ma_qrcode_path),0755,true);
		}
		
		QRcode::png($text,$ma_qrcode,'H',10,0);
		
		$qrcode = new \Imagick($ma_qrcode_path);
		$qwidth = $qrcode->getImageWidth();
		$qheight= $qrcode->getImageHeight();
		
		$imagick = new \Imagick();
		$color_transparent = new ImagickPixel('#ffffff'); //transparent 透明色
		$imagick->newImage($qwidth,$qheight+60,$color_transparent,'jpg');
		$imagick->compositeImage($qrcode,Imagick::COMPOSITE_OVER,0,0);
		
		$draw = new ImagickDraw();
		$draw->setTextKerning(15); // 设置文字间距
		$draw->setFont(ROOT_PATH.'public/fonts/site.ttf');
		$draw->setFontWeight(800); // 字体粗体
		$draw->setFillColor('#ff0000'); // 字体颜色
		//$draw->setFontFamily("Palatino");
		$draw->setFontSize(30);
		$draw->setGravity(\Imagick::GRAVITY_NORTH );
		
		$imagick->annotateImage($draw,0,$qheight+10,0,'长按识别') ;
		
		header("Content-Type: image/{$imagick->getImageFormat()}");
		echo $imagick->getImageBlob();
	}
	
	//聚合码
	public function _juhema(){
		$osn=$this->params['osn'];
		$order=$this->mysql->fetchRow("select * from sk_order where order_sn='{$osn}' and pay_status<99");
		if(!$order){
			jReturn('-1','不存在相应订单');
		}
		$order['ma_account']='13113723102';
		$url="alipays://platformapi/startapp?appId=20000200&actionType=toAccount&account={$order['ma_account']}&amount={$order['money']}&memo=";
		$data=[
			'url'=>$url
		];
		$this->display($data);
	}
	
	public function _zfbh5(){
		$osn=$this->params['osn'];
		if(!$osn){
			exit('缺少参数');
		}
		$order=$this->mysql->fetchRow("select ma_qrcode from sk_order where order_sn='{$osn}' and pay_status<=3");
		if(!$order){
			exit('订单不存在，或状态不可再发起支付');
		}
		$url=getQrContent($order['ma_qrcode'],false);
		if(!$url){
			exit('解析失败，请截屏保存后扫码尝试');
		}
		header("Location:{$url}");
	}
	
	public function _infoAct(){
		$osn=$this->params['osn'];
		if(!$osn){
			jReturn('-1','缺少参数');
		}
		$this->mysql->startTrans();
		$order=$this->mysql->fetchRow("select * from sk_order where order_sn='{$osn}' for update");
		if(!$order||$order['pay_status']==99){
			jReturn('-1','不存在相应的订单');
		}
		if($order['pay_status']!=1){
			jReturn('-1','订单已提交该状态，无需重复提交');
		}
		$sk_order=[
			'pay_status'=>2,
			'submit_time'=>NOW_TIME
		];
		$res=$this->mysql->update($sk_order,"id={$order['id']}",'sk_order');
		if(!$res){
			$this->mysql->rollback();
			jReturn('-1','系统繁忙请稍后再试');
		}
		$this->mysql->commit();
		jReturn('1','提交成功');
	}
	
	///////////////////////订单支付界面结束//////////////////////
	
	
	///////////////////////////测试相关//////////////////////////
	public function _test(){
		$sys_version=getConfig('sys_version');
		if($this->params['v']!=$sys_version){
			exit('测试入口不正确，请咨询客服人员');
		}
		$mtype_arr=$this->mysql->fetchRows("select * from sk_mtype where is_open=1");
		$data=[
			'mtype_arr'=>$mtype_arr
		];
		$this->display($data);
	}
	
	public function _testAct(){
		$params=$this->params;
		$ptype=intval($params['ptype']);//支付类型
		if(!$ptype){
			jReturn('-1','请选择支付类型');
		}
		$money=floatval($params['money']);
		if(!$money||$money<0.01){
			jReturn('-1','测试金额不正确');
		}
		$cnf_test_page_random=getConfig('cnf_test_page_random');
		if($cnf_test_page_random=='是'){
			$money=$money+round(mt_rand(1,100)/100,2);
		}
		
		$now_time=time();
		$p_data=array(
			'time'=>$now_time,
			'mch_id'=>$this->testMchId,
			'ptype'=>$ptype,
			'order_sn'=>'TS'.date('YmdHis',$now_time).mt_rand(1000,9999),
			'money'=>$money,
			'goods_desc'=>'buy',
			'client_ip'=>CLIENT_IP,
			'format'=>'json',
			'notify_url'=>$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/?c=Pay&a=notify_url'
		);
		$merchant=$this->mysql->fetchRow("select * from sys_user where account='{$p_data['mch_id']}' and status=2");
		if(!$merchant){
			jReturn('-2','商户号不存在或已被禁用');
		}
		if(!$merchant['apikey']){
			jReturn('-2','商户未生成md5签名密钥');
		}
		$p_data['sign']=$this->signMd5($p_data,$merchant['apikey']);
		if($merchant['is_rsa']){
			$p_json=base64_encode(json_encode($p_data,256));
			$rsa_pt_public=getConfig('rsa_pt_public');
			$resultArr=encryptRsa($p_json,$rsa_pt_public);
			if($resultArr['code']!='1'){
				jReturn('-1',$resultArr['msg']);
			}
			$p_data=[
				'crypted'=>$resultArr['data']
			];
		}
		$url=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/?c=Pay';
		$result=curl_post($url,$p_data);
		//$result=$this->curlPost($url,$p_data);
		$resultArr=json_decode($result['output'],true);
		if($resultArr['code']!=1){
			//jReturn('-2',$resultArr['msg'],$resultArr['data']);
			echo $result['output'];exit;
		}
		//p($resultArr);
		$return_data=[
			'url'=>"{$_SERVER['REQUEST_SCHEME']}://{$_SERVER['HTTP_HOST']}/?c=Pay&a=info&osn={$resultArr['data']['order_sn']}"
		];
		jReturn('1','ok',$return_data);
	}
	
	//测试回调
	public function _notify_url(){
		$params=$this->params;
		$merchant=$this->mysql->fetchRow("select * from sys_user where account='{$this->testMchId}' and status=2");
		if($_REQUEST['crypted']){
			$resultArr=decryptRsa($_REQUEST['crypted'],$merchant['rsa_private']);
			if($resultArr['code']!='1'){
				jReturn('-1',$resultArr['msg']);
			}
			$params=$resultArr['data'];
		}
		if(!$merchant){
			jReturn('-1','商户号不存在');
		}
		if(!$merchant['apikey']){
			jReturn('-1','商户未生成md5签名密钥');
		}
		if($merchant['is_rsa']){
			if(!$_REQUEST['crypted']){
				jReturn('-1','商户已开启RSA接口加密，请回调密文参数');
			}
		}else{
			if($_REQUEST['crypted']){
				jReturn('-1','商户未开启RSA接口加密，请回调明文参数');
			}
		}
		$p_data=array(
			'pt_order'=>$params['pt_order'],
			'sh_order'=>$params['sh_order'],
			'status'=>$params['status'],
			'money'=>$params['money'],
			'time'=>$params['time']
		);
		$sign=$this->signMd5($p_data,$merchant['apikey']);
		if($sign!=$params['sign']){
			$p_data['sign']=$params['sign'];
			$p_data['pt_sign']=$sign;
			file_put_contents(ROOT_PATH.'logs/notify_sign.txt',var_export($p_data,true)."\n\n",FILE_APPEND);
			jReturn('-1','签名错误');
		}
		if($p_data['status']!='success'){
			jReturn('-1',$p_data['status']);
		}
		//其他业务逻辑
		//...
		echo 'success';
	}
	
	private function curlPost($url,$data='',$timeout=30){
		$arrCurlResult = array();
		$ch = curl_init();
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//ssl检测跳过
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt ( $ch,CURLOPT_REFERER,"");
		$output = curl_exec($ch);
		$responseCode = curl_getinfo($ch,CURLINFO_HTTP_CODE);
		$arrCurlResult['output'] = $output;//返回结果
		$arrCurlResult['response_code'] = $responseCode;//返回http状态
		curl_close($ch);
		unset($ch);
		return $arrCurlResult;
	}
	
}

?>