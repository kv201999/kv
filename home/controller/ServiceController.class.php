<?php
!defined('ROOT_PATH') && exit;
class ServiceController extends BaseController{

    public function __construct(){
        parent::__construct();
    }

    public function _index(){
        checkLogin();
        $data=[
            'title'=>getConfig('sys_name'),
            //'service_qq'=>getConfig('service_qq')
        ];
        $this->display($data);
    }
	
	public function _online(){
        checkLogin();
		$item=$this->mysql->fetchRow("select * from sys_news where id=1");
		if(!file_exists($item['cover'])){
			$item['cover']='public/home/images/kf.png';
		}
        $data=[
            'title'=>'在线客服',
			'info'=>$item
        ];
        $this->display($data);
	}

	///////////////////////////////////////////////////

    //我的工单
    public function _myWork(){
        checkLogin();
        $data=[
            'title'=>'我的工单',
			's'=>$this->params
        ];
        $this->display($data);
    }

    public function _myWork_list(){
        $pageuser=checkLogin();
        
		$pageSize=10;
        $params=$this->_param();
        $params['time']=intval($params['time']);
		$params['page']=intval($params['page']);
        $where="where log.uid={$pageuser['id']} and log.status<99";
        if($params['time']){
            if($params['time']==1){
                $start=strtotime(date('Y-m-d 00:00:01'));
                $end=strtotime(date('Y-m-d 23:59:59'));
            }elseif($params['time']==2){
                $start=strtotime(date("Y-m-d 00:00:01",strtotime("-1 day")));
                $end=strtotime(date("Y-m-d 23:59:59",strtotime("-1 day")));
            }elseif($params['time']==3){
                $sdefaultDate = date("Y-m-d");
                $first =1;
                $w=date('w',strtotime($sdefaultDate));
                $week_start=date('Y-m-d',strtotime("$sdefaultDate -".($w ? $w - $first : 6).' days'));
                $start =strtotime(date('Y-m-d 00:00:01',strtotime("$sdefaultDate -".($w ? $w - $first : 6).' days')));
                $end = $start+86400*7;
            }
            $where.=" and log.create_time between {$start} and {$end}";
        }
        if($params['keyword']){
            $s_id=intval($params['keyword']);
            $where.=" and (log.id={$s_id} or log.title like '%{$params['keyword']}%')";
        }
		$count_item=$this->mysql->fetchRow("select count(1) as cnt from cnf_work log {$where}");
        $sql="select log.id,log.title,log.create_time,log.is_new from cnf_work log {$where} order by log.id desc";
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		foreach($list as &$item){
            $item['create_time']=date('m-d H:i',$item['create_time']);
		}
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'limit'=>$pageSize,
			'page'=>$params['page']+1,
			'pages'=>ceil($count_item['cnt']/$pageSize)
		);
		jReturn('1','ok',$data);
    }

	//工单详情
    public function _workInfo(){
		$pageuser=checkLogin();
        $id=intval(getParam('id'));
        $work=$this->mysql->fetchRow("select * from cnf_work where id={$id} and status<99");
        if(!$work||$work['uid']!=$pageuser['id']){
			header("Location:/?c=Service&a=myWork");exit;
        }
        if($work['qa_images']){
            $work['qa_images']=json_decode($work['qa_images'],true);
        }
        $cnf_work_list=getConfig('cnf_work_list');
        $work['type_flag']=$cnf_work_list[$work['type']];
        
        //重置状态
        if($work['is_new']==1){
            $cnf_work=['is_new'=>0];
            $this->mysql->update($cnf_work,"id={$work['id']}",'cnf_work');
        }
        $data=[
            'title'=>'工单详情',
			'work'=>$work,
			's'=>$this->params
        ];
        $this->display($data);
    }

	//追问
    public function _workInfoAdd(){
        $pageuser=checkLogin();
        $id=intval(getParam('id'));
        $recon=getParam('recon');
        $work=$this->mysql->fetchRow("select * from cnf_work where id={$id} and status<99");
        if(!$work||$work['uid']!=$pageuser['id']){
            jReturn('-1','没有权限操作该工单');
        }
        $cnf_work_log=[
            'fuid'=>$pageuser['id'],
            'create_time'=>NOW_TIME,
            'wid'=>$work['id'],
            'recon'=>$recon,
        ];
        $res=$this->mysql->insert($cnf_work_log,'cnf_work_log');
        if(!$res){
            jReturn('-1','系统繁忙请稍后再试');
        }
        $this->mysql->update(['is_new'=>1],"id={$id}",'cnf_work');
        jReturn('1','提交成功');
    }

	//答复列表
    public function _workAnswerList(){
        $pageuser=checkLogin();
        $id=intval(getParam('id'));
		$pageSize=10;
        $params=$this->_param();
		$params['page']=intval($params['page']);
        $where="where log.wid={$id} and wk.uid={$pageuser['id']}";
		$count_item=$this->mysql->fetchRow("select count(1) as cnt from cnf_work_log log {$where}");
        $sql="select log.id,log.fuid,log.recon,log.create_time from cnf_work_log log left join cnf_work wk on log.wid=wk.id {$where} order by log.id desc";
        $list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		foreach($list as &$item){
            $item['create_time']=date('m-d H:i',$item['create_time']);
            if($item['fuid']==$pageuser['id']){
                $item['u_flag']='我说';
            }else{
                $item['u_flag']='客服';
            }
		}
		$data=array(
			'list'=>$list,
			'count'=>$count_item['cnt'],
			'limit'=>$pageSize,
			'page'=>$params['page']+1,
			'pages'=>ceil($count_item['cnt']/$pageSize)
		);
		jReturn('1','ok',$data);
    }

    ///////////////////////////////////////////////////

    //提交工单
    public function _postWork(){
        $pageuser=checkLogin();
        $cnf_work_list=getConfig('cnf_work_list');
        $data=[
            'title'=>'提交工单',
            'cnf_work_list'=>$cnf_work_list,
            'user'=>$pageuser
        ];
        $this->display($data);
    }

    public function _postWorkAct(){
        $pageuser=checkLogin();
        $phone=getParam('phone');
        $title=getParam('title');
        $qacon=$_POST['qacon'];
        if(!$phone){
           $phone=$pageuser['phone'];
        }
        if(!$title){
            jReturn('-1','请填写工单标题');
        }
        $qa_images=[];
        foreach($_POST['imgs'] as $img){
            if($img){
                $qa_images[]=$img;
            }
        }
        $cnf_work=[
            'type'=>intval(getParam('type')),
            'uid'=>$pageuser['id'],
            'wphone'=>$phone,
            'title'=>$title,
            'qacon'=>$qacon,
            'qa_images'=>json_encode($qa_images),
            'create_time'=>NOW_TIME
        ];
        $res=$this->mysql->insert($cnf_work,'cnf_work');
        if(!$res){
            jReturn('-1','系统繁忙请稍后再试');
        }
        jReturn('1','提交成功');
    }

}

?>