<?php
include 'daemon.ini.php';

while(true){
	if(!$mysql){
		$mysql=new Mysql(0);
    }
	$sql="select DISTINCT(uid) from (select log.uid from sk_ma log left join sys_user u on log.uid=u.id where log.status=2 and u.is_online=0) b";
    $list=$mysql->fetchRows($sql,1,5);
	//p($list);exit;
    //echo $mysql->lastSql;exit;
    if(!$list){
        echo "没有数据暂停5秒\n";
		$mysql->close();
		unset($mysql);
        sleep(5);
        continue;
    }
	//用户不在线自动下线该用户对应的码
    foreach($list as $item){
		$sk_ma=[
			'status'=>1
		];
		$mysql->update($sk_ma,"uid={$item['uid']} and status=2",'sk_ma');
    }
	
	$mysql->close();
    unset($mysql);
    echo "处理完一批，暂停1秒\n";
    sleep(1);
}
?>