<?php

define('ACCOUNT_ID', '15139866'); // your account ID
define('ACCESS_KEY','527507fc-bg2hyw2dfg-707db7a0-2372d'); // your ACCESS_KEYs
define('SECRET_KEY', '0297281b-62cf32e9-3f8ce6a1-d718f'); // your SECRET_KEY
include 'daemon.ini.php';
include "global/lib.php";
$req = new req();
while(true){
	if(!$mysql){
		$mysql=new Mysql(0);
    }
    $list=$mysql->fetchRows("select * from cnf_paylog where pay_status=1 or pay_status=2",1,5);
	//p($list);exit;
    //echo $mysql->lastSql;exit;
    if(!$list){
        echo time()."没有数据暂停15秒\n";
		$mysql->close();
		unset($mysql);
        sleep(15);
        continue;
    }

    //c=Finance&a=paylog_check
	//自动确认充值到账
    foreach($list as $item){
        $czlist=$req->get_zd();
//]
		$mysql->startTrans();
        foreach ( $czlist as $czitem) {
            $s="created-at";
//            var_dump($item["create_time"]);
//            var_dump(intval($czitem->$s/1000));
            if($czitem->amount==$item["usdt"] and ($item["create_time"]<intval($czitem->$s/1000) and $item["create_time"]+60*10>intval($czitem->$s/1000))){
                $url='kv.com/ht.php?c=Finance&a=paylog_check';
                $p_data=[
                    'item_id'=>$item["id"],
                    'pay_status'=>3
                ];
                $result=curl_post($url,$p_data);

            }
		}
        if(time()-$item["create_time"]>600){
            var_dump(time());
            var_dump($item["create_time"]);
            $url='kv.com/ht.php?c=Finance&a=paylog_check';
            $p_data=[
                'item_id'=>$item["id"],
                'pay_status'=>99
            ];
            $result=curl_post($url,$p_data);
        }

    }
	
	$mysql->close();
    unset($mysql);

    echo time()."处理完一批，暂停15秒\n";
    sleep(15);
}
?>