<?php
!defined('ROOT_PATH') && exit;

class NewsController extends BaseController{
	
	public function __construct(){
		parent::__construct();
	}
	
	//充值通道管理
	public function _ptype(){
		checkPower();
		$data=array();
		display('News/ptype.html',$data);
	}
	
	public function _ptype_list(){
		checkLogin();
		$params=$this->_param();
		$params['s_is_pass']=intval($params['s_is_pass']);
		$params['s_is_open']=intval($params['s_is_open']);
		$where="where 1";
		if($params['s_is_pass']!='all'){
			$where.=" and log.is_pass={$params['s_is_pass']}";
		}
		if($params['s_is_open']!='all'){
			$where.=" and log.is_open={$params['s_is_open']}";
		}
		$where.=empty($params['s_keyword'])?'':" and (log.id='{$params['s_keyword']}' or log.name like '%{$params['s_keyword']}%')";
		$count=$this->mysql->fetchResult("select count(1) from cnf_paytype log {$where}");
		$list=$this->mysql->fetchRows("select log.* from cnf_paytype log {$where} order by log.sort desc,log.id desc",$params['page'],$this->pageSize);
		$yes_or_no=getConfig('yes_or_no');
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i',$item['create_time']);
			$item['is_qrcode_flag']=$yes_or_no[$item['is_qrcode']];
			$item['is_open_flag']=$yes_or_no[$item['is_open']];
			$item['is_pass_flag']=$yes_or_no[$item['is_pass']];
			$item['is_form_flag']=$yes_or_no[$item['is_form']];
			$item['is_default_flag']=$yes_or_no[$item['is_default']];
		}
		$data=array(
			'list'=>$list,
			'count'=>$count,
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _ptype_update(){
		checkLogin();
		$params=$this->_param();
		$params['sort']=intval($params['sort']);
		$params['is_qrcode']=intval($params['is_qrcode']);
		$params['is_pass']=intval($params['is_pass']);
		$params['is_open']=intval($params['is_open']);
		$params['is_form']=intval($params['is_form']);
		$item_id=intval($params['item_id']);
		if(!$params['ptype']){
			jReturn('-1','请填写通道代码');
		}
		if(!$params['name']){
			jReturn('-1','请填写通道名称');
		}
		if(!$params['aname']){
			$params['aname']=$params['name'];
		}
		if(!$params['cover']){
			jReturn('-1','请上传图标');
		}
		$cnf_paytype=array(
			'ptype'=>$params['ptype'],
			'name'=>$params['name'],
			'aname'=>$params['aname'],
			'sort'=>$params['sort'],
			'is_qrcode'=>$params['is_qrcode'],
			'is_pass'=>$params['is_pass'],
			'is_open'=>$params['is_open'],
			'is_default'=>$params['is_default'],
			'is_form'=>$params['is_form'],
			'cover'=>$params['cover'],
			'banner'=>$params['banner']
		);
		if($params['is_default']){
			$this->mysql->update(array('is_default'=>0),"1","cnf_paytype");
		}
		if($item_id){
			/*
			$ck_item=$this->mysql->fetchRow("select * from cnf_paytype where ptype='{$params['ptype']}'");
			if($ck_item&&$ck_item['id']!=$item_id){
				jReturn('-1',"已存在支付通道代码：{$params['ptype']}");
			}*/
			$res=$this->mysql->update($cnf_paytype,"id={$item_id}",'cnf_paytype');
		}else{
			$cnf_paytype['create_time']=NOW_TIME;
			$res=$this->mysql->insert($cnf_paytype,'cnf_paytype');
		}
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','操作成功');
	}
	
	//删除
	public function _ptype_delete(){
		checkLogin();
		$item_id=intval($this->_param('item_id'));
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$res=$this->mysql->delete("id={$item_id}",'cnf_paytype');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','操作成功');
	}
	
	/////////////////////////////////////////////////////////
	
	//新闻列表
	public function _arclist(){
		checkPower();
		$arccat_arr=$this->mysql->fetchRows("select * from sys_news_cat where is_show=1",1,100);
		$data=[
			'arccat_arr'=>$arccat_arr
		];
		display('News/arclist.html',$data);
	}
	
	public function _arclist_list(){
		checkPower();
		$params=$this->_param();
		$params['s_cid']=intval($params['s_cid']);
		$where="where log.status<99";
		$where.=empty($params['s_cid'])?'':" and log.cid={$params['s_cid']}";
		$where.=empty($params['s_keyword'])?'':" and (log.id='{$params['s_keyword']}' or log.title like '%{$params['s_keyword']}%')";
		$count=$this->mysql->fetchResult("select count(1) from sys_news log left join sys_news_cat cat on log.cid=cat.id {$where}");
		$list=$this->mysql->fetchRows("select log.*,cat.cat_name from sys_news log left join sys_news_cat cat on log.cid=cat.id {$where} order by log.id desc",$params['page'],$this->pageSize);
		$sys_arc_status=getConfig('sys_arc_status');
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i',$item['create_time']);
			$item['publish_time_flag']=date('Y-m-d H:i:s',$item['publish_time']);
			$item['status_flag']=$sys_arc_status[$item['status']];
		}
		$data=array(
			'list'=>$list,
			'count'=>$count,
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
	public function _getArc(){
		checkPower();
		$item_id=intval(getParam('item_id'));
		$arc=$this->mysql->fetchRow("select * from sys_news where id={$item_id}");
		if(!$arc||$arc['status']==4){
			jReturn('-1','不存在该文章');
		}
		jReturn('1','ok',$arc);
	}
	
	public function _arclist_update(){
		$pageuser=checkPower();
		$params=$this->_param();
		$item_id=intval($params['item_id']);
		$cid=intval($params['cid']);
		$status=intval($params['status']);
		if(!$cid){
			jReturn('-1','请选择分类');
		}
		if(!$params['title']){
			jReturn('-1','请填写文章标题');
		}
		if(!$params['cover']){
			jReturn('-1','请上传封面图');
		}
		if(!$status){
			jReturn('-1','未知文章状态');
		}
		if($params['publish_time_flag']){
			$publish_time=strtotime($params['publish_time_flag']);
		}else{
			$publish_time=NOW_TIME;
		}
		$data=array(
			'title'=>$params['title'],
			'ndesc'=>$params['ndesc'],
			'author'=>$params['author'],
			'status'=>$status,
			'cid'=>$cid,
			'publish_time'=>$publish_time,
			'cover'=>$params['cover'],
			'content'=>$_POST['content']
		);
		if($item_id){
			$res=$this->mysql->update($data,"id={$item_id}",'sys_news');
			$data['id']=$item_id;
		}else{
			$data['create_id']=$pageuser['id'];
			$data['create_time']=NOW_TIME;
			$res=$this->mysql->insert($data,'sys_news');
			$data['id']=$res;
		}
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		//unset($data['content']);
		//actionLog(array('opt_name'=>'更新','sql_str'=>json_encode($data)),$this->mysql);
		$return_data=array(
			'publish_time'=>$publish_time
		);
		jReturn('1','操作成功',$return_data);
	}
	
	//删除
	public function _arclist_delete(){
		checkPower();
		$item_id=intval($this->_param('item_id'));
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		/*
		if($item_id<3){
			jReturn('-1','系统特殊文章不可删除');
		}*/
		$data=array('status'=>99);
		$res=$this->mysql->update($data,"id={$item_id}",'sys_news');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		//actionLog(array('opt_name'=>'删除','sql_str'=>$this->mysql->lastSql),$this->mysql);
		jReturn('1','操作成功');
	}
	
	
	//推送
	public function _arclist_push(){
		checkPower();
		$item_id=intval($this->_param('item_id'));
		if(!$item_id){
			jReturn('-1','缺少参数');
		}
		$item=$this->mysql->fetchRow("select * from sys_news where id={$item_id}");
		if(!$item||$item['status']==9){
			jReturn('-1','不存在要推送的文章');
		}
		$sys_news_push=array(
			'news_id'=>$item_id,
			'create_time'=>NOW_TIME
		);
		$res=$this->mysql->insert($sys_news_push,'sys_news_push');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','推送成功');
	}
	
	////////////////////////////////////////////
	
	public function _arccat(){
		checkPower();
		$data=[];
		display('News/arccat.html',$data);
	}
	
	public function _arccat_list(){
		checkPower();
		$params=$this->_param();
		
		$where="where log.is_show=1";
		$where.=empty($params['s_keyword'])?'':" and (log.cat_name like '%{$params['s_keyword']}%')";
		$count=$this->mysql->fetchResult("select count(1) from sys_news_cat {$where}");
		$list=$this->mysql->fetchRows("select log.* from sys_news_cat log {$where} order by log.id desc",$params['page'],$this->pageSize);
		foreach($list as &$item){
			$item['create_time']=date('m-d H:i',$item['create_time']);
		}
		$data=array(
			'list'=>$list,
			'count'=>$count,
			'limit'=>$this->pageSize
		);
		jReturn('1','ok',$data);
	}
	
}
?>