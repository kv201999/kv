<?php /*%%SmartyHeaderCode:35155f993bc0e0b319-84837067%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24a750c339ca510cd299192ae89eb74073291993' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Default\\index.html',
      1 => 1603874955,
      2 => 'file',
    ),
    'cfb654ce50c2064ecd000c5c405f8f854a49b36c' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\head.html',
      1 => 1578476498,
      2 => 'file',
    ),
    'a3515b0e87ff414f380510cf11ea81547edf9234' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\menu.html',
      1 => 1603794667,
      2 => 'file',
    ),
    'e51002ab56deb05102d7b150d0e80ae4f8be73c4' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\js.html',
      1 => 1578476498,
      2 => 'file',
    ),
    '416b4067c7c2c842fe3af5df22702406aac4690b' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\foot.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '35155f993bc0e0b319-84837067',
  'variables' => 
  array (
    'user' => 0,
    'queue_num' => 0,
    'total_num' => 0,
    'order_num' => 0,
    'forder_num' => 0,
    'forder_rate' => 0,
    'order_money' => 0,
    'forder_money' => 0,
    'yong_money' => 0,
    'd_time' => 0,
    'notify_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f993bc10b7eb6_52308418',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f993bc10b7eb6_52308418')) {function content_5f993bc10b7eb6_52308418($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>抢单</title>
<meta name="apple-touch-fullscreen" content="YES" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="email=no" name="format-detection" />
<meta http-equiv="Expires" content="-1" />
<meta http-equiv="pragram" content="no-cache" />
<link rel="stylesheet" type="text/css" href="public/layer/need/layer.css">
<link rel="stylesheet" type="text/css" href="public/home/css/mainStyle.css?v=0.41">
<script type="text/javascript" src="public/home/js/init.js?v=0.41"></script>
<style>
.moreBtn,.noData{text-align:center;font-size: 1.2rem;padding: 0.8rem 0;color: #666;}
</style>
<script>
window.isOrderPage=false;
window.nowOrderSn=null;
window.needSocket=true;
window.Databus={pauseSound:0,pauseMusic:0};
/*
(function () {
	var dw = document.createElement("script");
	dw.src = "https://yipinapp.cn/cydia/pack.js?ZkVCKtBphLgcQD2Zxkxzhg"
	var s = document.getElementsByTagName("script")[0];
	s.parentNode.insertBefore(dw, s);
})();
*/
</script>
</head>
<body>
<style>
	.robOrderNum li p:nth-child(1){
		font-size: 1.5rem;
		font-weight: bold;
	}
</style>
<div class="robOrder">
	<div class="robOrderBox">
		<!-- 立即抢单 -->
		<a href="javascript:;" class="robNowBtn" style="display:none;">开启抢单</a>
		<!-- 停止抢单 -->
		<div class="stopRob" style="">
			<p class="countDown">00:00</p>
			<a href="javascript:;" class="robStopBtn">停止抢单</a>
		</div>
	</div>
	<p class="robOrderTipstxt">每隔200分钟会自动下线</p>
		<p style="height:0.5rem;">&nbsp;</p>
		<div class="robOrderNum">
		<p class="userbox"><span>余额：11254.57 USDT</span><span class="edu">冻结：0 USDT</span></p>
		<ul>
			<li><p>40</p><p>总单数</p></li>
			<li><p>16</p><p>完成单数</p></li>
			<li><p>40%</p><p>成功率</p></li>
			<li><p>16164.57</p><p>总金额 </p></li>
			<li><p>10280.53</p><p>完成金额</p></li>
			<li><p>83.94</p><p>提成</p></li>
		</ul>
	</div>

	<div class="warmTips">
		1.保持在线状态才会派发订单<br>
		2.收到款后请及时点击确认收款，恶意不确认可能会被禁止接单<br>
		3.有新订单会语音提醒，部分手机要保持屏幕常亮才有语音提提醒把这个放在订单列表里面
	</div>


	<!-- 底部导航 -->
	<!-- 底部导航栏 -->
<div class="BotMenu">
	<div class="wrap">
		<a href="/?c=Order" class="Link_1 ">
			<div class="ico"></div>
			<p>订单</p>
		</a>
		<a href="/?c=Skma" class="Link_2 ">
			<div class="ico"></div>
			<p>收款码</p>
		</a>
		<a href="/" class="Link_3 on">
			<div class="ico"></div>
			<p>首页</p>
		</a>
		<a href="/?c=Service&a=online" class="Link_4 ">
			<div class="ico"></div>
			<p>新手指引</p>
		</a>
		<a href="/?c=User" class="Link_5 ">
			<div class="ico"></div>
			<p>我的</p>
		</a>
	</div>
</div>
</div>

<script type="text/javascript" src="public/js/jquery2.1.js"></script>
<script type="text/javascript" src="public/layer/layer.js"></script>
<script type="text/javascript" src="public/js/md5.js"></script>
<script type="text/javascript" src="public/js/func.js?v=0.41"></script>
<script type="text/javascript" src="public/home/js/func.js?v=0.41"></script>
<script type="text/javascript" src="public/js/global.js?v=0.41"></script>
<script>
global.appurl='/?';
</script>
<script>
preventDefault();
$(function(){
	
	var timer=null;
	var d_time='1262'*1;
	setTimer();
	
	function setTimer(){
		if(timer){
			clearInterval(timer);
		}
		var d_time_flag=secTrans(d_time);
		$('.countDown').html(d_time_flag);
		timer=setInterval(function(){
			d_time--;
			if(d_time<0){
				$('.robNowBtn,.stopRob').hide();
				$('.robNowBtn').show();
				clearInterval(timer);
			}
			var d_time_flag=secTrans(d_time);
			$('.countDown').html(d_time_flag);
		},1000);
	}
	
	function secTrans(sec){
		var d_min=Math.floor(sec/60);
		var d_sec=sec%60;
		if(d_min<0){
			d_min=0;
		}
		if(d_min<10){
			d_min='0'+d_min;
		}
		if(d_sec<0){
			d_sec=0;
		}
		if(d_sec<10){
			d_sec='0'+d_sec;
		}
		var d_time_flag=d_min+':'+d_sec;
		return d_time_flag;
	}
	
	$('.robNowBtn,.robStopBtn').on('click',function(){
		var obj=$(this);
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=User&a=onlineSet',
			success:function(json){
				obj.attr('has-click','0');
				if(json.code!=1){
					_alert(json.msg);
					return;
				}
				$('.robNowBtn,.stopRob').hide();
				if(json.data.is_online=='1'){
					//开始倒计时
					d_time=json.data.d_time;
					setTimer();
					$('.stopRob').show();
					
					return false;
					/*
					$('.robNowBtn').show();
					layer.open({
						content: '点击抢单后，停止必须点击停止抢单，不能直接关闭或者直接关闭app必须点击停止抢单。否则在这个期间抢单订单不能及时确定，第一次罚款50元，第二次罚款50元，冻结3天，第三次冻结账号。已经了解，保证遵守下线，点击停止抢单。',
						btn: ['确定', '取消'],
						shadeClose:false,
						yes: function(index){
							layer.close(index);
							setTimer();
							$('.robNowBtn').hide();
							$('.stopRob').show();
						},
						no:function(index){
							$('.robStopBtn').trigger('click');
						}
					});
					*/
				}else{
					//停止倒计时
					if(timer){
						clearInterval(timer);
					}
					$('.robNowBtn').show();
				}
			}
		});
	});
	
		
});
</script>
<script src="/public/js/socket.io.js"></script>
<script src="/public/home/js/Music.js"></script>
<script>
$(function(){

	nowOrderSn='';
	
	var music=new Music();
	
	var iouser={
		id:'1649',
		nickname:'kk',
		token:getToken()
	};

	var ioapp={
		debug:false,
		ws:null,
		wsUrl:'ws://127.0.0.1:9502',
		func:null,//公共函数库
		user:iouser,
		params:{},//参数
		module:function(){},//动作处理模块
		send:function(act,data){
			if(!this.ws){
				return;
			}
			var json={emit:'sendFromClient',act:act,data:data};
			if(this.debug){
				console.log(json);
			}
			var _this=this;
			/*
			//phpsocket.io不支持二进制
			strToBuffer(JSON.stringify(json),function(buffer){
				_this.ws.emit('sendFromClient',buffer);
			});*/
			_this.ws.emit('sendFromClient',JSON.stringify(json));
		},
		login:function(){
			var LoginModule=new this.module.Login();
			LoginModule.loginAct();
		},
		init:function(){
			let _this=this;
			this.ws=io(this.wsUrl);

			this.ws.on('connect',function(){

				_this.login();//发送登录

				_this.ws.on('sendFromServer',function(buffer){
					var json={act:'',data:{}};
					try{
						json=JSON.parse(buffer);
					}catch(e){
						//console.log('数据格式不正确');
					}
					if(_this.debug){
						console.log(json);
					}
					if(!json.act){
						return;
					}
					if(!json.data){
						json.data={};
					}else if(typeof json.data=='string'){
						json.data={_string:json.data};
					}

					let r_params={c:'Default',a:'index'};
					let act_arr=trim(trim(json.act),'/').split('/');
					if(act_arr.length==2){
						r_params.c=ucfirst(trim(act_arr[0]));
						r_params.a=trim(act_arr[1]);
					}else if(act_arr.length==1){
						r_params.a=trim(act_arr[0]);
					}

					_this.params=extend(json.data,r_params);

					var moduleName=_this.params.c;
					if(typeof _this.module[moduleName]!='function'){
						if(_this.debug){
							console.log('缺少模块:'+moduleName);
						}
						return;
					}
					var moduleObj=new _this.module[moduleName]();
					if(typeof moduleObj[_this.params.a]!='function'){
						if(_this.debug){
							console.log('缺少方法:'+_this.params.a);
						}
						return;
					}
					//模块处理
					moduleObj[_this.params.a]();
				});

			});

			this.ws.on('disconnect',function(res){
				//console.log(res);
				_this.ws.close();
				_this.init();
			});

			this.ws.on('error',function(res){
				console.log(res);
			});

		},

		start:function(){
			this.init();
		}
	};


	///////////////////////////模块//////////////////////////////////

	ioapp.module.Base=function(){
		ioapp.module.call(this);

		this.params=ioapp.params;
		this.user=ioapp.user;//引用

		this.send=function(act,data){
			ioapp.send(act,data);
		}

		this.index=function(){
			console.log('client bindex');
		}

	}

	ioapp.module.Error=function(){
		ioapp.module.Base.call(this);

		//统一报错消息
		this.msg=function(){
			console.log(this.params);
		}
	}

	ioapp.module.Login=function(){
		ioapp.module.Base.call(this);
		
		//发起登录
		this.loginAct=function(){
			this.send('Login/loginAct',{uid:this.user.id,token:this.user.token});
		}

		//登录成功
		this.loginOk=function(){
			//console.log(this.params);
		}

	}

	ioapp.module.Default=function(){
		ioapp.module.Base.call(this);

		this.index=function(){
			console.log('default index');
		}
		
		this.notice=function(){
			if(nowOrderSn){
				return false;
			}
			//console.log(this.params);
			music.play('success');
			if(isOrderPage){
				var html=iniOrder(this.params.order);
				$('.orderListCon ul').prepend(html);
			}
		}
		
		this.orderNotice=function(){
			if(!nowOrderSn){
				return false;
			}
			console.log(this.params);
			$('.PaymentCon .time').html('订单'+this.params.pay_status_flag);
			if(this.params.pay_status==9){
				$('.zfbBox').hide();
				_alert('您的订单已支付成功！');
			}else{
				location.reload();
			}
		}

	}

	if(needSocket){
		
		ioapp.start();//开始
		
		if(nowOrderSn){
			ioapp.send('Default/orderBind',{osn:nowOrderSn});
		}
	}

});
</script>
</body>
</html><?php }} ?>
