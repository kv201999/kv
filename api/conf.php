<?php
error_reporting(0);
@header("content-Type: text/html; charset=utf-8");
$mch_id='shanghu';
$mch_key='4f846b4969887c45bbda6beb38d8b6c021677650';

$mch_rsa_private='-----BEGIN RSA PRIVATE KEY-----
MIICXAIBAAKBgQDXw2fgn0XVrWRLrNHPXkNpswIaJsukY2Fm52GoPA7kxo4WJDvx
OXL3FfErV4V6TqdisUd29ajC3m6InkOww0vsBLaW51BjRLZTZI/ttiUUm1P0/SPn
JbSqFt1g3p3xFzoUpuX5BLfjnZOCyPHHW1ljIMlvGSHbV3i3PjpCAebApQIDAQAB
AoGAYspGqrNib0a30GptmmwHo8LhqIWw4jDarRouPbBaBWfgMMUgaP+r4vQ5+2VU
aT7QJ0ESfqZWQftEUutcBPg2rx/wezWk5eIk46tFpxne4LWS0bpB4fix1DY5+b2B
nV5F4XlKXv8u111wVulRBKqZF4209zAo786sdff/ve5+02ECQQDuG8Nf7WQ5vK2k
BiEXVCSCnNhZyC9WaBPYOAYKBi+pyhX0FSY0zhtR6NIvMEmSpLNYNfboNqMKx60Z
2j5eH9kNAkEA5/nQH6/z+AU+P5whRb2XpfSnhxjmCUNHrdmx44CnXX2CvsLLpk6m
/s93KXm1ch1fm49tMXAsMmmpMk8oKRBv+QJAOumFmntq29oyAC5AC7yW1/YklXox
NCjGGC4sWFiVfGXyrpR5AoGoQsjfECvbWDwF36Jid6vlBSrISmg0HCe3FQJBAKuc
eKZogcDzCAkA1PCGAMEqDCF6fvtNRaLMULhwPeCA8I91BjmDKDGLg6kwO9Yu+sLX
ST1wsZGd7yijvJ8cZOkCQDzpePgVV19AeX/ghinHwWH9F/R6u8LZ97BPpSQCkSf9
5b5HcM/HjIipB6LDkI5rrJzhGVZ0V6AEExZdR8gwtT0=
-----END RSA PRIVATE KEY-----';

$pt_rsa_public='-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCv46J8nFWD7B/U3PtS9XTcqQiX
JHbKxjhMg61LlYirmc0snEv6AkoXgo3NgsdEfORFW2K5lDuo86SUts2RaENywN+2
5+TLdA/SBKapdejjDz31DO8HCBfAUNoaE6i5npJHA7HqxNxgaJFJbDT4UsgJkIK6
eCBgPnKs9xP9zGBBYwIDAQAB
-----END PUBLIC KEY-----';

//rsa加密
function encryptRsa($str,$rsa_public){
	if(!$str){
		return ['code'=>'-1','msg'=>'缺少加密参数'];
	}
	if(!$rsa_public){
		return ['code'=>'-1','msg'=>'缺少RSA公钥'];
	}
	
	$public_key=openssl_pkey_get_public($rsa_public);
	if(!$public_key){
		return ['code'=>'-1','msg'=>'RSA公钥不可用'];
	}
	$rstr='';
	$bits=openssl_pkey_get_details($public_key)['bits'];
	$tmp_arr=str_split($str,($bits/8)-11);
	foreach($tmp_arr as $val){
		openssl_public_encrypt($val,$encrypt_data,$public_key);
		$rstr.=$encrypt_data;
	}
	$base64_cry=base64_encode($rstr);
	return ['code'=>'1','msg'=>'加密成功','data'=>$base64_cry];
}

//rsa解密
function decryptRsa($str,$rsa_private){
	if(!$str){
		return ['code'=>'-1','msg'=>'缺少解密参数'];
	}
	if(!$rsa_private){
		return ['code'=>'-1','msg'=>'缺少RSA私钥'];
	}
	$private_key=openssl_pkey_get_private($rsa_private);
	if(!$private_key){
		return ['code'=>'-1','msg'=>'RSA私钥不可用'];
	}
	$decrypted='';
	$str=base64_decode($str);
	$bits=openssl_pkey_get_details($private_key)['bits'];
	$tmp_arr=str_split($str,$bits/8);
	foreach($tmp_arr as $val){
		openssl_private_decrypt($val,$decrypt_data,$private_key);
		if($decrypt_data){
			$decrypted.=$decrypt_data;
		}
	}
	$decrypted=base64_decode($decrypted);
	$params=json_decode($decrypted,true);
	if(!$params){
		$params=$decrypted;
	}
	return ['code'=>'1','msg'=>'解密成功','data'=>$params,'decrypted'=>$decrypted];
}

?>