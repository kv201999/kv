<?php
include 'daemon.ini.php';

while(true){
	if(!$mysql){
		$mysql=new Mysql(0);
    }

    $list=$mysql->fetchRows("select * from sk_order where pay_status=1 or pay_status=2 ");
    //p($list);exit;
    //echo $mysql->lastSql;exit;
    if(!$list){
        echo "没有数据暂停5秒\n";
        $mysql->close();
        unset($mysql);
        sleep(15);
        continue;
    }
    foreach($list as $item){
        $mysql->startTrans();
        $ma_url=$mysql->fetchRow("select ma_qrcodeurl from sk_ma where id={$item['ma_id']} for update");
        $skorder_queren=getxy($ma_url["ma_qrcodeurl"]);
        if($skorder_queren["status"]=="BNI"){
            $url='127.0.0.1/ht.php?c=Pay&a=order_check';
            $p_data=[
                'item_id'=>$item["id"]
            ];
            $result=curl_post($url,$p_data);

        }
    }

//	$sql="select DISTINCT(uid) from (select log.uid from sk_ma log left join sys_user u on log.uid=u.id where log.status=2 and u.is_online=0) b";
//    $list=$mysql->fetchRows($sql,1,5);
//	//p($list);exit;
//    //echo $mysql->lastSql;exit;
//    if(!$list){
//        echo "没有数据暂停5秒\n";
//		$mysql->close();
//		unset($mysql);
//        sleep(5);
//        continue;
//    }
//	//用户不在线自动下线该用户对应的码
//    foreach($list as $item){
//		$sk_ma=[
//			'status'=>1
//		];
//		$mysql->update($sk_ma,"uid={$item['uid']} and status=2",'sk_ma');
//    }
	
	$mysql->close();
    unset($mysql);
    echo "处理完一批，暂停1秒\n";
    sleep(15);
}
?>