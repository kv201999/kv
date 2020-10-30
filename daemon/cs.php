<?php
include 'daemon.ini.php';

$cnf_xyhk_model=getConfig('cnf_xyhk_model');
$cnf_mshk_signle=getConfig('cnf_mshk_signle');
if(!$mysql){
    $mysql=new Mysql(0);
}
$mysql->startTrans();
$url="https://api.telegram.org/bot1296230416:AAHAuPEccOk-KIPp7S3K7oFD6__m1zPEcgQ/sendMessage?chat_id=-386042225&text=商户【".$user['openid']."】额度已满，请尽快下发";
curl_get($url);
$blog_id=$mysql->fetchRow("select * from cnf_banklog where id={$item['suid']} for update");
$p_data=[
    'blog_id'=>2,
    'money'=>2000,
    'autotx'=>"shtx",
];
$url=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/ht.php?c=Finance&a=balance_cash';
$result=curl_post($url,$p_data);
var_dump($url);
var_dump($p_data);
var_dump($result);

?>
