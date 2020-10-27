<?php
!defined('ROOT_PATH') && exit;
class BaseController{
	
	protected $mysql;
	protected $memcache;
	protected $pageSize=12;
	
	public function __construct($io,$socket){
        $this->io=$io;
        $this->socket=$socket;
        $this->params=$socket->params;
    }

    protected function send(){
        $args=func_get_args();
        if(!$args){
            return false;
        }
        if($this->isHttp()){
            $str='';
            if(is_string($args[0])){
                $str=$args[0];
            }else{
                $str=var_export($args[0],true);
            }
            //\Workerman\Protocols\Http::header('Access-Control-Allow-Origin: *');
            \Workerman\Protocols\Http::header('Server: abc',true);
            $this->socket->send($str);
        }else{
            $obj=count($args)==3?$args[2]:$this->socket;
            send($args[0],$args[1],$obj);
        }
    }

    //是否时http请求
    protected function isHttp(){
        if($this->socket->protocol=='\Workerman\Protocols\Http'){
            return true;
        }
        return false;
    }

    public function _index(){
        if($this->isHttp()){
            $this->send('hello world!');
        }else{
            $this->send('Defult_bindex','hello world! your client id is：'.$this->socket->id);
        }
    }
    
}

?>