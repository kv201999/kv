<?php
// 定义参数
define('ACCOUNT_ID', '15139866'); // your account ID
define('ACCESS_KEY','527507fc-bg2hyw2dfg-707db7a0-2372d'); // your ACCESS_KEYs
define('SECRET_KEY', '0297281b-62cf32e9-3f8ce6a1-d718f'); // your SECRET_KEY

include "lib.php";
//实例化类库
$req = new req();
// 获取account-id, 用来替换ACCOUNT_ID
//var_dump($req->get_account_accounts());
// 获取账户余额示例
//
//print ("用户当前余额：".$req->get_balance()."USDT");
//
//print ("------\n");
//print ("用户TRC地址：".$req->get_address());
//print ("------\n");
//print ("买入价格：".$req->get_otcbuy());
//print ("------\n");
//print ("卖出价格：".$req->get_otcsell());

print ("------\n");
print ("------\n");
print ("------\n");
//print ("最新入账金额：".$req->get_zd()['amount']);
//var_dump($req->get_zd());
var_dump(time());
print ("------\n");
print ("------\n");
//print ("最新入账时间：".date('Y-m-d H:i:s', $req->get_zd()["data"][0]["created-at"]/1000));

//var_dump($req->get_otc());
//print($balancelist[0]->currency);

//foreach($balancelist as $v){
//    foreach($v as $item){
//        $values = array_values($item["currency"]);
//        if(in_array("usdt",$values)) {
//            $usdtbalance=$item["balance"];
//            break;
//        }
//    }
//}
//去用户当前余额
//For($i=0;$i<count($balancelist);$i++)
//    {
//        if($balancelist[$i]->currency=="usdt" and $balancelist[$i]->type=="trade") {
//            print ("用户当前余额：".$balancelist[$i]->balance."USDT");
//        }
//    }
//



?>
