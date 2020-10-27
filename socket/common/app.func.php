<?php

function send($act, $data='',$obj){
	if(!$obj){
		return false;
	}
	$json=json_encode(['emit'=>'sendFromServer','act'=>$act,'data'=>$data]);
	$obj->emit('sendFromServer',$json);
}

function jsonReturn($code,$msg,$data=[]){
	$rdata=[
		'code'=>$code,
		'msg'=>$msg,
		'data'=>$data
	];
	$json=json_encode($rdata,256);
	return $json;
}

?>