<?php
include 'daemon.ini.php';


$p_data=[
    'blog_id'=>5,
    'money'=>3500,
    'autotx'=>"shtx",
];
$url=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/ht.php?c=Finance&a=balance_cash';
$result=curl_post($url,$p_data);
var_dump($url);
var_dump($p_data);
var_dump($result);

?>
