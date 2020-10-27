<?php
include 'daemon.ini.php';

while(true){
	if(!$mysql){
		$mysql=new Mysql(0);
    }
	$cnf_user_offline_time=intval(getConfig('cnf_user_offline_time'));
	if($cnf_user_offline_time<=0){
		$cnf_user_offline_time=60*15;
	}
	$diff_time=time()-$cnf_user_offline_time;
    $list=$mysql->fetchRows("select id,is_online from sys_user where is_online=1 and online_time<{$diff_time}",1,5);
	//p($list);exit;
    //echo $mysql->lastSql;exit;
    if(!$list){
        echo "没有数据暂停5秒\n";
		$mysql->close();
		unset($mysql);
        sleep(5);
        continue;
    }
	//在线超时，自动下线
    foreach($list as $item){
		$sys_user=[
			'is_online'=>0,
			'online_time'=>time()
		];
		$mysql->update($sys_user,"id={$item['id']}",'sys_user');
    }
	
	$mysql->close();
    unset($mysql);
    echo "处理完一批，暂停1秒\n";
    sleep(1);
}
?>