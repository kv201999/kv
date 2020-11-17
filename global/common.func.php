<?php
include ROOT_PATH.'global/lib.php';
require ROOT_PATH.'vendor/autoload.php';
use Zxing\QrReader;
//公共函数
define('ACCOUNT_ID', '14917665'); // your account ID
define('ACCESS_KEY','75450f5c-3ed1a1a8-bewr5drtmh-82c1e'); // your ACCESS_KEY
define('SECRET_KEY', '99003dd5-ed5f058d-6948a56f-44010'); // your SECRET_KEY
///////////////////////////////////////////////////////////////////////////
//获取二维码内容
function getQrContent($qrfile){
	if(!file_exists($qrfile)){
		return false;
	}
	$mem_key='file_'.md5($qrfile);
	$memcache=new MyMemcache();
	$text=$memcache->get($mem_key);
	if($text){
		$memcache->close();
		unset($memcache);
		return $text;
	}
	
	$thumb_img='uploads/thumb/'.date('Ymd').'/'.getRsn().'.jpg';
	$thumb_path=ROOT_PATH.$thumb_img;
	if(!is_dir(dirname($thumb_path))){
		mkdir(dirname($thumb_path),0755,true);
	}
	$image = new Imagick($qrfile);
	$width = $image->getImageWidth();
	$height= $image->getImageHeight();
	$new_width=300;
	$new_height=($new_width/$width)*$height;
	$image->thumbnailImage($new_width,$new_height);
	if(!is_dir(dirname($thumb_path))){
		mkdir(dirname($thumb_path),0755,true);
	}
	file_put_contents($thumb_path,$image->getImageBlob());
	unset($image);
	$qrcode=new QrReader($thumb_path);
	$text=$qrcode->text();
	unset($qrcode);
	if(!$text){
		return false;
	}
	$memcache->set($mem_key,$text,86400*20);
	$memcache->close();
	unset($memcache);
	return $text;
}
///////////////////////////////////////////////////////////////////////////
//重新生成二维码
function getNewQrcode($qrfile,$flush=false,$tplName=''){
	$mem_key='qr_'.md5($qrfile);
	$memcache=new MyMemcache();
	$new_qrcode=$memcache->get($mem_key);
	if($new_qrcode&&!$flush){
		if(file_exists(ROOT_PATH.$new_qrcode)){
			$memcache->close();
			unset($memcache);
			return $new_qrcode;	
		}
	}

	if(!file_exists(ROOT_PATH.$qrfile)){
		return false;
	}

	$new_qrcode='uploads/qr/'.date('Ymd').'/'.getRsn().'.jpg';	
	$new_qrcode_path=ROOT_PATH.$new_qrcode;
	if(!file_exists($new_qrcode_path)){
		if(!is_dir(dirname($new_qrcode_path))){
			mkdir(dirname($new_qrcode_path),0755,true);
		}
		$text=getQrContent($qrfile);
		if(!$text){
			return false;
		}
		QRcode::png($text,$new_qrcode_path,'H',14,0);
	}
	
	/*
	if($tplName){
		$tpl=ROOT_PATH.'public/images/'.$tplName;
		$image = new \Imagick($tpl);
		$width = $image->getImageWidth();
		$height= $image->getImageHeight();
		$newImg = new \Imagick($new_qrcode_path);
		$qwidth = $newImg->getImageWidth();
		$qheight= $newImg->getImageHeight();
		$need_cover=false;
		if($tplName=='p1.png'){
			$image->compositeImage($newImg, Imagick::COMPOSITE_OVER, ($width-$qwidth)/2,144);
			$need_cover=true;
		}elseif($tplName=='p2.png'){
			$image->compositeImage($newImg, Imagick::COMPOSITE_OVER, ($width-$qwidth)/2,140);
			$need_cover=true;
		}
		if($need_cover){
			file_put_contents($new_qrcode_path,$image->getImageBlob());
		}
	}*/
	
	$memcache->set($mem_key,$new_qrcode,86400*20);
	$memcache->close();
	unset($memcache);
	return $new_qrcode;
}

///////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////

//金额账变记录
function balanceLog($user,$balanceType,$subType,$money,$fkey='',$remark='',$mysql=null){
	if(!$user['id']){
		return false;
	}
	$cnf_balance_type=getConfig('cnf_balance_type');
	$subType=intval($subType);
	if(!array_key_exists($subType,$cnf_balance_type)){
		return false;
	}
	$pageuser=isLogin();
	$cnf_balance_log=[
		'uid'=>intval($user['id']),
		'type'=>$subType,
		'fkey'=>$fkey,
		'money'=>$money,
		'create_time'=>time(),
		'create_day'=>date('Ymd'),
		'create_id'=>intval($pageuser['id']),
		'remark'=>$remark
	];
	if($balanceType==1){
		$cnf_balance_log['ori_balance']=$user['balance'];
		$cnf_balance_log['new_balance']=$user['balance']+$money;
	}elseif($balanceType==2){
		$cnf_balance_log['ori_balance']=$user['fz_balance'];
		$cnf_balance_log['new_balance']=$user['fz_balance']+$money;
	}elseif($balanceType==3){
		$cnf_balance_log['ori_balance']=$user['sx_balance'];
		$cnf_balance_log['new_balance']=$user['sx_balance']+$money;
	}elseif($balanceType==4){
		$cnf_balance_log['ori_balance']=$user['kb_balance'];
		$cnf_balance_log['new_balance']=$user['kb_balance']+$money;
	}else{
		return false;
	}
	$need_close=false;
	if(!$mysql){
		$mysql=new Mysql(0);
		$need_close=true;
	}
	$res=$mysql->insert($cnf_balance_log,'cnf_balance_log');
	if($need_close){
		closeDb($mysql);
	}
	if(!$res){
		return false;
	}
	$cnf_balance_log['id']=$res;
	return $cnf_balance_log;
}

//新订单通知给码商
function orderNoticeMs($order_sn){
	$url="{$_ENV['SOCKET']['HTTP_URL']}/?a=notice&osn={$order_sn}";
	$result=curl_get($url);
	$resultArr=json_decode($result['output'],true);
	return $resultArr;
}

//订单异步回调，返回最新订单数据
function orderNotify($order_id,$mysql){
	$order=$mysql->fetchRow("select * from sk_order where id={$order_id}");
	if(!$order||$order['pay_status']!=9){
		return false;
	}
	$merchant=$mysql->fetchRow("select * from sys_user where id={$order['suid']}");
	if(!$merchant){
		return false;
	}
	$url=urldecode($order['notify_url']);
	$p_data=[
		'pt_order'=>$order['order_sn'],
		'sh_order'=>$order['out_order_sn'],
		'status'=>'success',
		'money'=>$order['money'],
		'time'=>$order['pay_time']
	];
	
	ksort($p_data);
	$sign_str='';
	foreach($p_data as $pk=>$pv){
		$sign_str.="{$pk}={$pv}&";
	}
	$sign_str.="key={$merchant['apikey']}";
	$p_data['sign']=md5($sign_str);
	
	//判断是否需要加密传输
	if($merchant['is_rsa']){
		if(!$merchant['rsa_public']){
			return false;
		}
		$p_json=base64_encode(json_encode($p_data,256));
		$resultArr=encryptRsa($p_json,$merchant['rsa_public']);
		
		if($resultArr['code']!='1'){
			return false;
		}
		$p_data=[
			'crypted'=>$resultArr['data']
		];
	}
	
	$result=curl_post($url,$p_data,30);
	$resultMsg=$result['output'];
	$sk_order=[
		'notice_msg'=>htmlspecialchars(addslashes($resultMsg))
	];
	if(!$resultMsg){
		$sk_order['notice_status']=2;
	}else{
		if(strtolower($resultMsg)=='success'){
			$sk_order['notice_status']=4;
		}else{
			$sk_order['notice_status']=3;
		}
	}
	$res=$mysql->update($sk_order,"id={$order['id']}",'sk_order');
	if(!$res){
		return false;
	}
	$order=array_merge($order,$sk_order);
	$cnf_notice_status=getConfig('cnf_notice_status');
	$cnf_pay_status=getConfig('cnf_pay_status');
	$order['pay_status_flag']=$cnf_pay_status[$order['pay_status']];
	$order['notice_status_flag']=$cnf_notice_status[$order['notice_status']];
	return $order;
}

//订单分成
function orderRebate($order_id){
	$mysql=new Mysql(0);
	$mysql->startTrans();
	$sql="select * from sk_order where id={$order_id} for update";
	$order=$mysql->fetchRow($sql);
	if(!$order||$order['pay_status']!=9||$order['is_rebate']){
		closeDb($mysql,'rollback');
		return false;
	}
	
	$sk_order=['is_rebate'=>2,'rebate_time'=>time()];
	
	//##################码商分成##################
	$sql="select id from sys_user where id={$order['muid']}";
	$now_user=$mysql->fetchRow($sql);
	if(!$now_user){
		closeDb($mysql,'commit');
		return false;
	}
	$user_arr=[$now_user];
	$up_users=getUpUser($order['muid'],true);
	foreach($up_users as $upv){
		$user_arr[]=$upv;
	}
	
	$ms_res=true;
	$now_fy_rate=null;
	foreach($user_arr as $uv){
		$agent_level=intval($uv['agent_level']);
		$uv=$mysql->fetchRow("select id,balance,kb_balance,sx_balance,fy_rate from sys_user where id={$uv['id']} for update");
		$fy_rate_arr=json_decode($uv['fy_rate'],true);
		$fyrItem=$fy_rate_arr[$order['ptype']];
		if($now_fy_rate===null){
			$fy_rate=$fyrItem;
		}else{
			$fy_rate=$fyrItem-$now_fy_rate;
		}
		$now_fy_rate=$fyrItem;
		$fy_rate=floatval($fy_rate);
		if($fy_rate<0){
			break;
		}
		$money=$order['money']*$fy_rate;
		$sk_yong=[
			'type'=>1,
			'uid'=>$uv['id'],
			'money'=>$money,
			'level'=>$agent_level,
			'rate'=>$fy_rate,
			'ori_balance'=>$uv['balance'],
			'new_balance'=>$uv['balance']+$money,
			'fkey'=>$order['id'],
			'create_time'=>time()
		];
		
		//更新码商对应订单的回款和码商的应回款金额
		if($uv['id']==$now_user['id']){
			$hk_money=$order['money']-$money;
			$sk_order['hk_money']=$hk_money;
			
			$sys_user=[];			
			//判断是否是信用回款模式
			$cnf_xyhk_model=getConfig('cnf_xyhk_model');
			if($cnf_xyhk_model=='是'){
				$sys_user['kb_balance']=$uv['kb_balance']+$hk_money;//扣除分成后，订单金额累计到应回款
				$sys_user['sx_balance']=$uv['sx_balance']+$money;//恢复手续费-订单回款
				$res22=balanceLog($uv,3,20,$money,$order['id'],$order['order_sn'],$mysql);
				$res23=balanceLog($uv,4,21,$hk_money,$order['id'],$order['order_sn'],$mysql);
			}else{
				$sys_user['balance']=$uv['balance']+$money;//分成累计到可提余额
				$res22=balanceLog($uv,1,4,$money,$order['id'],$order['order_sn'],$mysql);
				$res23=true;
			}
		}else{
			//上级的分成全部累计到可提余额
			$sys_user=[
				'balance'=>$uv['balance']+$money
			];
			$res22=balanceLog($uv,1,4,$money,$order['id'],$order['order_sn'],$mysql);
			$res23=true;
		}
		$res21=$mysql->update($sys_user,"id={$uv['id']}",'sys_user');
		$res24=$mysql->insert($sk_yong,'sk_yong');
		if(!$res21||!$res22||!$res23||!$res24){
			$ms_res=false;
			break;
		}
	}
	
	//##################商户分成##################
	$up_merchants=getUpUser($order['suid'],true);
	$sh_res=true;
	$now_td_rate=$order['rate'];
	foreach($up_merchants as $mv){
		$agent_level=intval($mv['agent_level']);
		$mv=$mysql->fetchRow("select id,balance,td_rate from sys_user where id={$mv['id']} for update");
		$td_rate_arr=json_decode($mv['td_rate'],true);
		$tdrItem=$td_rate_arr[$order['ptype']];
		if(!isset($tdrItem)||$tdrItem===''){
			continue;
		}
		$td_rate=$now_td_rate-$tdrItem;
		$now_td_rate=$tdrItem;
		$money=$order['money']*$td_rate;
		$sk_yong=[
			'type'=>2,
			'uid'=>$mv['id'],
			'money'=>$money,
			'level'=>$agent_level,
			'rate'=>$td_rate,
			'ori_balance'=>$mv['balance'],
			'new_balance'=>$mv['balance']+$money,
			'fkey'=>$order['id'],
			'create_time'=>time()
		];
		//商户的分成全部累计到可提余额
		$sys_user=[
			'balance'=>$mv['balance']+$money
		];
		$res31=$mysql->update($sys_user,"id={$mv['id']}",'sys_user');
		$res32=$mysql->insert($sk_yong,'sk_yong');
		$res33=balanceLog($mv,1,5,$money,$order['id'],$order['order_sn'],$mysql);
		
		if(!$res31||!$res32||!$res33){
			$sh_res=false;
			break;
		}
		
	}
	
	$res=$mysql->update($sk_order,"id={$order['id']}",'sk_order');
	if($res&&$ms_res&&$sh_res){
		closeDb($mysql,'commit');
		return true;
	}
	
	//回滚
	$mysql->rollback();
	
	$sk_order=['is_rebate'=>1,'rebate_time'=>time()];
	$mysql->update($sk_order,"id={$order['id']}",'sk_order');
	closeDb($mysql);
	return false;
}
//获取商品价格
function getxyprice($shangpin_id){
    $ch = curl_init('https://h5api.m.taobao.com/h5/mtop.taobao.idle.mach.advertise.batch.output/1.0/?jsv=2.4.5&appKey=12574478&t=1605369102554&sign=e1612caa14af69526c7d67d23793923f&api=mtop.taobao.idle.mach.advertise.batch.output&v=1.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
    $cookies = array();
    foreach($matches[1] as $item) {
        parse_str($item, $cookie);
        $cookies = array_merge($cookies, $cookie);
    }
    $token=substr($cookies["_m_h5_tk"],0,32);
    $t=time()*1000;
    $appKey="12574478";
    $data='{"itemId":"'.$shangpin_id.'"}';
    $sign=md5($token.'&'.$t.'&'.$appKey.'&'.$data);
//    var_dump($token);
//    var_dump($t);
//    var_dump($sign);
    $setcookies="_m_h5_tk=".$cookies["_m_h5_tk"].";"."_m_h5_tk_enc=".$cookies["_m_h5_tk_enc"];

    $xyurl='https://h5api.m.taobao.com/h5/mtop.taobao.idle.awesome.detail/1.0/?jsv=2.4.5&appKey=12574478&t='.$t.'&sign='.$sign.'&api=mtop.taobao.idle.awesome.detail&v=1.0&data='.$data;
    $url = curl_init($xyurl);

    curl_setopt ($url, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($url, CURLOPT_COOKIE, $setcookies);
    $file_contents = json_decode(curl_exec($url));
    $shangpin_status=$file_contents->data->itemDO->itemStatus;
    $shangpin_price=$file_contents->data->itemDO->soldPrice;
    $xyinfo=[
        'status'=>$shangpin_status,
        'price'=>$shangpin_price
    ];
    curl_close($url);
    return $xyinfo;

}

?>