<?php
// 定义参数
define('ACCOUNT_ID', '14917665'); // your account ID
define('ACCESS_KEY','ghjrgrft5g-ca180f30-647ec19a-c1012'); // your ACCESS_KEYs
define('SECRET_KEY', '64a5934a-bbc8e273-33702cf1-a7306'); // your SECRET_KEY



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
print_r($req->get_zd()[0]->state);

print ("------\n");
print ("------\n");
//print ("最新入账时间：".date('Y-m-d H:i:s', $req->get_zd()['updated_at']));

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
