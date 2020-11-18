<?php
!defined('ROOT_PATH') && exit;
class TestController extends BaseController{
	
	public function __construct($io,$socket){
        parent::__construct($io,$socket);
    }
    
	public function _index(){
		global $User;
		p($User);
		/*
		$uid=1044;
		$client_arr=$User[$uid];
		$return_data=[];
		foreach($client_arr as $ck=>$cv){
			$return_data['cindex']=$ck;
			$return_data['client_id']=$cv;
			$obj=$this->io->to($cv);
			send('Game/testOk',$return_data,$obj);
		}
		*/
	}

}

?>