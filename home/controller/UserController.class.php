<?php
!defined('ROOT_PATH') && exit;
class UserController extends BaseController{

    public function __construct(){
        parent::__construct();
    }

    //个人中心首页
    public function _index(){
		$pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
        $user['balance']=floatval($user['balance']);
        $user['sx_balance']=floatval($user['sx_balance']);
        $user['fz_balance']=floatval($user['fz_balance']);
        $user['kb_balance']=floatval($user['kb_balance']);
		$cnf_user_online=getConfig('cnf_user_online');
		$user['is_online_flag']=$cnf_user_online[$user['is_online']];
		
		$team_arr=getDownUser($user['id']);
		$o_sql="select count(1) as cnt,sum(log.money) as sum_money from sk_order log where log.muid={$user['id']} and log.pay_status=9";
		$oitem=$this->mysql->fetchRow($o_sql);
		
		$y_sql="select count(1) as cnt,sum(money) as sum_money from sk_yong where uid={$user['id']} and type=1";
		$yitem=$this->mysql->fetchRow($y_sql);
		$data=[
            'title'=>'我的',
			'user'=>$user,
			'team_num'=>count($team_arr),
			'order_num'=>intval($oitem['cnt']),
			'order_money'=>floatval($oitem['sum_money']),
			'yong_money'=>floatval($yitem['sum_money'])
        ];
		$this->display($data);
    }

	//开启抢单
	public function _onlineSet(){
		$pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		if($user['is_online']){
			$is_online=0;
		}else{
			$is_online=1;
			
			if($user['forbid_day']){
				jReturn('-1','当前被暂停接单，请稍后再试');
			}
			
			$min_match_money=getConfig('min_match_money');
			if($user['sx_balance']<=$min_match_money){
				jReturn('-1','接单余额不足请先充值');
			}
			
			$cnf_xyhk_model=getConfig('cnf_xyhk_model');
			$cnf_mshk_signle=getConfig('cnf_mshk_signle');
			//信用单笔回款
			if($cnf_xyhk_model=='是'&&$cnf_mshk_signle=='是'){
				$cnf_whkbjjd_num=intval(getConfig('cnf_whkbjjd_num'));
				$cnf_whkbjjd_money=floatval(getConfig('cnf_whkbjjd_money'));
				$check_item=$this->mysql->fetchRow("select count(1) as cnt,sum(hk_money) as money from sk_order where muid={$user['id']} and pay_status=9 and hk_status!=3");
				if($check_item['cnt']>=$cnf_whkbjjd_num||$check_item['money']>=$cnf_whkbjjd_money){
					jReturn('-1','您当前未回款订单或累计金额已达到上限，请先回款后才能继续接单');
				}
			}
			
			//信用累计回款达到上限，自动下线码商
			if($cnf_xyhk_model=='是'&&$cnf_mshk_signle!='是'){
				$cnf_whkljjd_money=floatval(getConfig('cnf_whkljjd_money'));
				if($user['kb_balance']>=$cnf_whkljjd_money){
					jReturn('-1','您当前累计未回款金额已达到上限，请先回款后才能继续接单');
				}
			}
			
		}
		$sys_user=[
			'is_online'=>$is_online,
			'online_time'=>NOW_TIME
		];
		if($is_online){
			$sys_user['queue_time']=NOW_TIME;
		}
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$cnf_user_online=getConfig('cnf_user_online');
		$cnf_user_offline_time=intval(getConfig('cnf_user_offline_time'));
		$return_data=[
			'is_online'=>$is_online,
			'is_online_flag'=>$cnf_user_online[$is_online],
			'd_time'=>$cnf_user_offline_time
		];
		jReturn('1','切换成功',$return_data);
	}
	
	//自动回调开关
	public function _autoSet(){
		$pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		if($user['apiauto']){
			$apiauto=0;
		}else{
			$apiauto=1;
			if(!$user['apikey']){
				jReturn('-1','开启自动回调之前请先更新密钥');
			}
		}
		$sys_user=[
			'apiauto'=>$apiauto
		];
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		$sys_switch=getConfig('sys_switch');
		$return_data=[
			'apiauto'=>$apiauto,
			'apiauto_flag'=>$sys_switch[$apiauto]
		];
		jReturn('1','切换成功',$return_data);
	}

    /////////////////////////////////////////

    //银行卡
    public function _bcard(){
        $pageuser=checkLogin();
		$pageuser['phone']=substr($pageuser['phone'],0,3).'***'.substr($pageuser['phone'],-4);
        $bank_arr=$this->mysql->fetchRows("select * from cnf_bank where status=1");
		$banklog=$this->mysql->fetchRow("select * from cnf_banklog where uid={$pageuser['id']}");
        $data=[
            'title'=>'绑定银行卡',
			'user'=>$pageuser,
            'bank_arr'=>$bank_arr,
			'banklog'=>$banklog
        ];
        $this->display($data);
    }

    public function _bcardAct(){
        $pageuser=checkLogin();
		$params=$this->params;
		$params['bank_id']=intval($params['bank_id']);
		$params['province_id']=intval($params['province_id']);
		$params['city_id']=intval($params['city_id']);
		if(!$params['bank_id']){
			jReturn('-1','请选择开户行');
		}else{
			$bank=$this->mysql->fetchRow("select * from cnf_bank where id={$params['bank_id']}");
			if(!$bank){
				jReturn('-1','未知开户行');
			}
		}
		if(!$params['bank_realname']){
			jReturn('-1','请填写持卡人姓名');
		}
		if(!$params['bank_account']){
			jReturn('-1','请填写银行卡号');
		}
        if(!$params['smscode']){
            jReturn('-1','请填写短信验证码');
        }
        $checkSms=checkPhoneCode(['stype'=>5,'phone'=>$pageuser['phone'],'code'=>$params['smscode']]);
        if($checkSms['code']!=1){
            exit(json_encode($checkSms));
        }
		
		$cnf_banklog=[
			'bank_id'=>$params['bank_id'],
			'bank_account'=>$params['bank_account'],
			'bank_realname'=>$params['bank_realname'],
			'province_id'=>$params['province_id'],
			'city_id'=>$params['city_id']
		];
		
		$banklog=$this->mysql->fetchRow("select * from cnf_banklog where uid={$pageuser['id']}");
        if(!$banklog){
            $cnf_banklog['uid']=$pageuser['id'];
            $cnf_banklog['create_time']=NOW_TIME;
            $res=$this->mysql->insert($cnf_banklog,'cnf_banklog');
        }else{
			$res=$this->mysql->update($cnf_banklog,"id={$banklog['id']}",'cnf_banklog');
		}
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
        jReturn('1','绑定成功');
    }

    /////////////////////////////////////////
	
    public function _team(){
        checkLogin();
		$this->params['level']=intval($this->params['level']);
		$level_arr=[];
		for($i=1;$i<=10;$i++){
			$level_arr[]=$i;
		}
        $data=[
            'title'=>'我的团队',
			'level_arr'=>$level_arr,
			's'=>$this->params
        ];
        $this->display($data);
    }

    public function _team_list(){
        $pageuser=checkLogin();
		$params=$this->params;
		$params['level']=intval($params['level']);
        unset($GLOBALS['g_down_user']);
        $duser_arr=getDownUser($pageuser['id'],true,1,10);
        $duser_ids_arr=[];
        $duser_index=[];
        foreach($duser_arr as $dv){
			if($params['level']&&$params['level']!=$dv['agent_level']){
				continue;
			}
            $duser_ids_arr[]=$dv['id'];
            $duser_index[$dv['id']]=$dv['agent_level'];
        }
        $duser_ids=implode(',',$duser_ids_arr);
        
		$pageSize=10;
		$params=$this->_param();
		$params['page']=intval($params['page']);
		$where="where log.id in ({$duser_ids})";
		$where.=empty($params['keyword'])?'':" and (log.account='{$params['keyword']}' or log.nickname like '%{$params['keyword']}%')";
		$count_item=$this->mysql->fetchRow("select count(1) as cnt from sys_user log {$where}");
		$sql="select log.id,log.nickname,log.account,log.is_online,log.reg_time from sys_user log {$where} order by log.id desc";
		//echo $sql;exit;
		$list=$this->mysql->fetchRows($sql,$params['page'],$pageSize);
		$cnf_user_online=getConfig('cnf_user_online');
		foreach($list as &$item){
            $item['reg_time']=date('m-d H:i',$item['reg_time']);
            $item['agent_level']=$duser_index[$item['id']];
            $item['account']=substr($item['account'],0,3).'***'.substr($item['account'],7);
			$item['is_online_flag']=$cnf_user_online[$item['is_online']];
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
	
	public function _teamInfo(){
		$pageuser=checkLogin();
		$uid=intval($this->params['uid']);
		$this->params['level']=intval($this->params['level']);
		$user=$this->mysql->fetchRow("select * from sys_user where id={$uid}");
		if(!$user||$user['pid']!=$pageuser['id']){
			header("Location:/?c=User&a=team");
			exit;
		}
		$user['fy_rate']=json_decode($user['fy_rate'],true);
		if(!$user['fy_rate']){
			$user['fy_rate']=[];
		}
		$cnf_user_online=getConfig('cnf_user_online');
		$user['reg_time']=date('m-d H:i',$user['reg_time']);
		$user['is_online_flag']=$cnf_user_online[$user['is_online']];
		//查询上级费率
		$up_user=[];
		if($user['pid']){
			$up_user=$this->mysql->fetchRow("select * from sys_user where id={$user['pid']}");
			if($up_user){
				$up_user['fy_rate']=json_decode($up_user['fy_rate'],true);
				if(!$up_user['fy_rate']){
					$up_user['fy_rate']=[];
				}
			}
			
		}
		
		$set_user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$up_td_switch=json_decode($set_user['td_switch'],true);
		if(!$up_td_switch){
			$up_td_switch=[];
		}
		
		$mtype_arr=rows2arr($this->mysql->fetchRows("select * from sk_mtype where is_open=1"));
		$data=[
			'user'=>$user,
			'up_user'=>$up_user,
			'up_td_switch'=>$up_td_switch,
			'mtype_arr'=>$mtype_arr,
			's'=>$this->params
		];
		$this->display($data);
	}
	
	//设置下级的分成比例
	public function _teamSet(){
		$pageuser=checkLogin();
		$uid=intval($this->params['uid']);
		$fy_rate=$this->params['fy_rate'];
		
		$user=$this->mysql->fetchRow("select * from sys_user where id={$uid}");
		if(!$user){
			jReturn('-1','不存在需要设置的账号');
		}
		if($user['pid']!=$pageuser['id']){
			jReturn('-1','非直推下级无法设置');
		}
		/*
		$down_uids=getDownUser($pageuser['id'],false,1,1);
		if(!in_array($uid,$down_uids)){
			jReturn('-1','该用户不是您的直推下级无法设置并激活');
		}*/
		$up_user=$this->mysql->fetchRow("select * from sys_user where id={$user['pid']}");
		$up_user['fy_rate']=json_decode($up_user['fy_rate'],true);
		$up_user['td_switch']=json_decode($up_user['td_switch'],true);
		if(!$up_user['fy_rate']){
			jReturn('-1','上级账号未激活无法设置下级的分成比例');
		}
		
		$cnf_msmin_fyrate=getConfig('cnf_msmin_fyrate');
		$mtype_arr=rows2arr($this->mysql->fetchRows("select * from sk_mtype"));
		$fy_rate_arr=[];
		$td_switch_arr=[];
		foreach($mtype_arr as $mv){
			$mval=floatval($fy_rate[$mv['id']]);
			if($mv['is_open']&&$up_user['td_switch'][$mv['id']]>0){
				if(!$mval||!isset($mval)||$mval<0){
					jReturn('-1',"【{$mv['name']}】分成比例设置不正确");
				}
				//检测最小设置
				$min_val=$cnf_msmin_fyrate[$mv['id']];
				if($mval<$min_val){
					$min_val_flag=$min_val*100;
					jReturn('-1',"【{$mv['name']}】分成比例不可小于{$min_val_flag}%");
				}
				if($up_user['fy_rate'][$mv['id']]<$mval){
					jReturn('-1',"【{$mv['name']}】分成比例不能超过上级的分成比例");
				}
				$td_switch_arr[$mv['id']]=1;
			}
			$fy_rate_arr[$mv['id']]=$mval;
		}
		$sys_user=[
			'fy_rate'=>json_encode($fy_rate_arr),
			'td_switch'=>json_encode($td_switch_arr)
		];
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		if($user['fy_rate']){
			jReturn('1','设置成功');
		}else{
			jReturn('1','设置并激活成功');
		}
	}

    /////////////////////////////////////////

    public function _setting(){
        $pageuser=checkLogin();
        $data=[
            'title'=>'设置',
            'user'=>$pageuser
        ];
        $this->display($data);
    }

	//修改登录密码
    public function _password(){
        $pageuser=checkLogin();
		if(!$pageuser['phone']){
			$pageuser['phone']=$pageuser['account'];
		}
		$pageuser['phone']=substr($pageuser['phone'],0,3).'***'.substr($pageuser['phone'],-4);
        $data=[
            'title'=>'修改登录密码',
			'user'=>$pageuser
        ];
        $this->display($data);
    }

    public function _password2(){
        $pageuser=checkLogin();
		if(!$pageuser['phone']){
			$pageuser['phone']=$pageuser['account'];
		}
		$pageuser['phone']=substr($pageuser['phone'],0,3).'***'.substr($pageuser['phone'],-4);
        $data=[
            'title'=>'修改二级密码',
			'user'=>$pageuser
        ];
        $this->display($data);
    }
	
	//处理修改密码
	public function _passwordAct(){
		$pageuser=checkLogin();
		$params=$this->params;
		$params['type']=intval($params['type']);
		if($params['type']!=1&&$params['type']!=2){
			jReturn('-1','未知修改类型');
		}
        if(!$params['smscode']){
            jReturn('-1','请输入短信验证码');
        }
		if(!$params['newpwd']){
			jReturn('-1','请填写新密码');
		}
		$checkSms=checkPhoneCode(['stype'=>4,'phone'=>$pageuser['phone'],'code'=>$params['smscode']]);
		if($checkSms['code']!=1){
			exit(json_encode($checkSms));
		}
		
		$params['newpwd']=getPassword($params['newpwd']);
		$sys_user=[];
		if($params['type']==1){
			$sys_user['password']=$params['newpwd'];
		}elseif($params['type']==2){
			$sys_user['password2']=$params['newpwd'];
		}
		$res=$this->mysql->update($sys_user,"id={$pageuser['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','密码修改成功');
		
		/*
		$params['oldpwd']=getPassword($params['oldpwd']);
		$params['newpwd']=getPassword($params['newpwd']);
		$user=$this->mysql->fetchRow("select id,password,password2 from sys_user where id={$pageuser['id']}");
		$sys_user=[];
		if($params['type']==1){
			if($params['oldpwd']!=$user['password']){
				jReturn('-1','旧登录密码不正确');
			}
			$sys_user['password']=$params['newpwd'];
		}elseif($params['type']==2){
			if($params['oldpwd']!=$user['password2']){
				jReturn('-1','旧二级密码不正确');
			}
			$sys_user['password2']=$params['newpwd'];
		}
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','密码修改成功');
		*/
	}
	
    public function _google(){
        $pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		include GLOBAL_PATH.'library/GoogleAuthenticator.php';
		$ga=new PHPGangsta_GoogleAuthenticator();
		if(!$user['google_secret']){
			$secret=$ga->createSecret();
			$sys_user=['google_secret'=>$secret];
			$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
			$user['google_secret']=$secret;
		}
		$google_qrcode=$ga->getQRCodeGoogleUrl($user['account'],$user['google_secret']);
		$sys_switch=getConfig('sys_switch');
		$user['is_google_flag']=$sys_switch[$user['is_google']];
        $data=[
            'title'=>'谷歌验证',
			'user'=>$user,
			'google_qrcode'=>$google_qrcode
        ];
        $this->display($data);
    }
	
	public function _googleAct(){
		$pageuser=checkLogin();
		$is_google=intval($this->params['is_google']);
		$sys_user=['is_google'=>$is_google];
		$res=$this->mysql->update($sys_user,"id={$pageuser['id']}",'sys_user');
		if($res===false){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','保存成功');
	}
	
	/////////////////////////////////////////
	//自动回调助手
	public function _api(){
		$pageuser=checkLogin();
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		$sys_switch=getConfig('sys_switch');
		$user['apiauto_flag']=$sys_switch[$user['apiauto']];
		$data=[
			'user'=>$user,
			'notify_url'=>$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/?c=Notify&mid='.$user['id']
		];
		$this->display($data);
	}
	
	public function _apikeyUpdate(){
		$pageuser=checkLogin();
		$password2=getPassword($this->params['password2']);
		$user=$this->mysql->fetchRow("select * from sys_user where id={$pageuser['id']}");
		if($password2!=$user['password2']){
			jReturn('-1','二级密码不正确');
		}
		$sys_user=[
			'apikey'=>sha1(md5($user['id'].'_'.$user['account'].'_'.time().'_'.SYS_KEY)),
			'apiauto'=>0
		];
		$res=$this->mysql->update($sys_user,"id={$user['id']}",'sys_user');
		if(!$res){
			jReturn('-1','系统繁忙请稍后再试');
		}
		jReturn('1','更新成功');
	}
	

}

?>