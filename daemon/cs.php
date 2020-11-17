<?php
//include 'daemon.ini.php';
//
//
//$p_data=[
//    'blog_id'=>5,
//    'money'=>3500,
//    'autotx'=>"shtx",
//];
//$url=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/ht.php?c=Finance&a=balance_cash';
//$result=curl_post($url,$p_data);
//var_dump($url);
//var_dump($p_data);
//var_dump($result);
$shangpin_id="631075368489";
$ch = curl_init('https://h5api.m.taobao.com/h5/mtop.taobao.idle.awesome.detail/1.0/?jsv=2.4.5&appKey=12574478');
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
//return $xyinfo;
var_dump($xyurl);

?>
