<?php
// 定义参数
define('ACCOUNT_ID', '14917665'); // your account ID
define('ACCESS_KEY','75450f5c-3ed1a1a8-bewr5drtmh-82c1e'); // your ACCESS_KEY
define('SECRET_KEY', '99003dd5-ed5f058d-6948a56f-44010'); // your SECRET_KEY



include "lib.php";

//实例化类库
$req = new req();
// 获取account-id, 用来替换ACCOUNT_ID
//var_dump($req->get_account_accounts());
// 获取账户余额示例

print ("用户当前余额：".$req->get_balance()."USDT");
print ("------\n");
print ("用户TRC地址：".$req->get_address());
print ("------\n");
print ("买入价格：".$req->get_otcbuy());
print ("------\n");
print ("卖出价格：".$req->get_otcsell());


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
