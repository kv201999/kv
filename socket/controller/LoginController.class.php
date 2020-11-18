<?php
!defined('ROOT_PATH') && exit;
class LoginController extends BaseController{
	
	public function __construct($io,$socket){
        parent::__construct($io,$socket);
    }
    
    public function _loginAct(){
		if(!isset($this->params['token'])||!$this->params['token']){
			return;
		}
        $tuser=getUserByToken($this->params['token']);
		if(!$tuser){
            $this->send('Error/msg','need oauth');
            return;
        }
        if($tuser['id']!=$this->params['uid']){
            $this->send('Error/msg','need oauth');
            return;   
        }
		$mysql=new Mysql(0);
        $user=getUserinfo($tuser['id'],$mysql);
        unset($mysql);
        if(!$user){
            $this->send('Error/msg','no user');
            return;
        }
		global $User,$Ucidx;
		$User[$user['id']][]=$this->socket->id;
		$Ucidx[$this->socket->id]=$user['id'];
        $this->socket->session['user']=$user;
        $this->send('Login/loginOk',['account'=>$user['account'],'time'=>NOW_TIME]);
    }

    public function _logout(){
        $user=$this->socket->session['user'];
        unset($this->socket->session);
        $this->send('Login/logout',['account'=>$user['account']]);
        $this->socket->disconnect();
    }

}

?>