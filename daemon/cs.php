<?php
//include 'common.func.php';

include 'daemon.ini.php';
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

//$url=getQrContent("uploads/home/202011/7b2e3a1ec22b25bc.jpeg");
//var_dump($url);
$appid = "M7czvDKQB7XiE7Yg" ;
$appsecret = "vr3eZ9E2zYSDLvQWrNqEcw6eL3qnRecW" ;
$sign = strtolower(md5($appid .$appsecret) ) ;

$url="https://qr.alipay.com/_d?_b=peerpay&enableWK=YES&biz_no=2020111804200308081065408525_429ede3dacda5c6f5c6a7cdf572e9fd5&app_name=tb&sc=qr_code&v=20201125&sign=5c9cec&__webview_options__=pd%3dNO";


//$shangpin_id="631075368489";
$purl='http://47.113.82.162:8087/Api_Scrapy/index?appid='.$appid.'&sign='.$sign.'&channel=xianyu_order&url='.urlencode($url);
$ch = curl_init($purl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = json_decode(curl_exec($ch));
curl_close($ch);
$xyinfo=[
    'status'=>$result->data->trade_status,
    'price'=>$result->data->trade_itemRealAmount,
    'title'=>$result->data->trade_goodsTitle
];
var_dump($xyinfo["price"]);


//preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $result, $matches);
//$cookies = array();
//foreach($matches[1] as $item) {
//    parse_str($item, $cookie);
//    $cookies = array_merge($cookies, $cookie);
//}
//$token=substr($cookies["_m_h5_tk"],0,32);
//$t=time()*1000;
//$appKey="12574478";
//$data='{"itemId":"'.$shangpin_id.'"}';
//$sign=md5($token.'&'.$t.'&'.$appKey.'&'.$data);
////    var_dump($token);
////    var_dump($t);
////    var_dump($sign);
//$setcookies="_m_h5_tk=".$cookies["_m_h5_tk"].";"."_m_h5_tk_enc=".$cookies["_m_h5_tk_enc"];
//
//$xyurl='https://h5api.m.taobao.com/h5/mtop.taobao.idle.awesome.detail/1.0/?jsv=2.4.5&appKey=12574478&t='.$t.'&sign='.$sign.'&api=mtop.taobao.idle.awesome.detail&v=1.0&data='.$data;
//$url = curl_init($xyurl);
//
//curl_setopt ($url, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($url, CURLOPT_COOKIE, $setcookies);
//$file_contents = json_decode(curl_exec($url));
//$shangpin_status=$file_contents->data->itemDO->itemStatus;
//$shangpin_price=$file_contents->data->itemDO->soldPrice;
//$xyinfo=[
//    'status'=>$shangpin_status,
//    'price'=>$shangpin_price
//];
//curl_close($url);
////return $xyinfo;
//var_dump($xyurl);

?>
