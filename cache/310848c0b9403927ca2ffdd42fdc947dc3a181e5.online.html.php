<?php /*%%SmartyHeaderCode:14955f964dde08ab18-53398498%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '310848c0b9403927ca2ffdd42fdc947dc3a181e5' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Service\\online.html',
      1 => 1578476498,
      2 => 'file',
    ),
    '434e113806f32d87abf56db39a5c5905a98df8c3' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\head.html',
      1 => 1578476498,
      2 => 'file',
    ),
    '7dda7d1218e5327370632c916982a04796b0360a' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\menu.html',
      1 => 1578476498,
      2 => 'file',
    ),
    'fe4220c58636d3a4224094f4ff295c78efc6ea60' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\js.html',
      1 => 1578476498,
      2 => 'file',
    ),
    '2357248d0a402ec88c31c7d14b10e97ae11eab67' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\foot.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14955f964dde08ab18-53398498',
  'variables' => 
  array (
    'info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f964dde2a2e17_37971788',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f964dde2a2e17_37971788')) {function content_5f964dde2a2e17_37971788($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>在线客服</title>
<meta name="apple-touch-fullscreen" content="YES" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="email=no" name="format-detection" />
<meta http-equiv="Expires" content="-1" />
<meta http-equiv="pragram" content="no-cache" />
<link rel="stylesheet" type="text/css" href="public/layer/need/layer.css">
<link rel="stylesheet" type="text/css" href="public/home/css/mainStylePc.css?v=0.41">
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
<script id="__init-script-inline-widget__">
//(function(d,t,u,s,e){e=d.getElementsByTagName(t)[0];s=d.createElement(t);s.src=u;s.async=1;e.parentNode.insertBefore(s,e);})(document,'script','//103.80.27.20/php/app.php?widget-init-inline.js');
</script>
<style>
.kefuOnline{position: relative;width: 100%;color: #333333;background: #fff;}
.kefuOnlineCon{position: relative;width: 100%;padding-top:4rem;}
.kefuOnlineCon .txtbox{padding: 0 3%;font-size: 1.1rem;line-height: 1.8rem;}
.kefuOnlineCon .txtbox h3{color: #019aff;padding: 1.5rem 0 0.5rem;font-size: 1.3rem;}
.kefuOnlineCon .txtbox p{margin-bottom: 0.4rem;}
.kefuOnlineCon .qrcode{width: 45%;margin: 2rem auto;}
.kefuOnlineCon .welcomeTxt{text-align: center;}
.kefuOnlineCon .welcomeTxt p{background: #eef2f5;display: inline-block;padding: 0.3rem 0.8rem;border-radius: 0.2rem;}
</style>
<div style="height:4rem;"></div>
<div class="kefuOnline">
	<!--
	<div class="HeadTop">
		<p class="Tit">在线客服</p>
		<a href="/?c=Service" class="backBtn"></a>
	</div>
	-->
	<div class="kefuOnlineCon">
		<div class="txtbox">
			<h3>温馨提示：</h3>
			<p style="list-style-type: none; -webkit-tap-highlight-color: rgba(255, 0, 0, 0); margin-top: 0px; margin-bottom: 0.4rem; padding: 0px; color: rgb(51, 51, 51); font-family: 微软雅黑, 宋体, Arial; font-size: 17.6px; white-space: normal; background-color: rgb(255, 255, 255);">1、提现到账时间：1-2个工作日内到账</p><p style="list-style-type: none; -webkit-tap-highlight-color: rgba(255, 0, 0, 0); margin-top: 0px; margin-bottom: 0.4rem; padding: 0px; color: rgb(51, 51, 51); font-family: 微软雅黑, 宋体, Arial; font-size: 17.6px; white-space: normal; background-color: rgb(255, 255, 255);">2、微信客服上班时间：周一至周六，早上9:00-12:00，下午13:00-18:00</p><p style="list-style-type: none; -webkit-tap-highlight-color: rgba(255, 0, 0, 0); margin-top: 0px; margin-bottom: 0.4rem; padding: 0px; color: rgb(51, 51, 51); font-family: 微软雅黑, 宋体, Arial; font-size: 17.6px; white-space: normal; background-color: rgb(255, 255, 255);">3、源码由改源码WWW.GAIYM.COM分享</p>
		</div>

		<div class="qrcode" style="width:66%;margin-bottom:0;">
			<img src="public/home/images/kf.png">
		</div>
		<div style="color:#019aff;font-size:18px;text-align:center;padding:10px;padding-top:0;">截图保存图片，打开微信扫一扫添加客服</div>
		
		<div class="welcomeTxt">
			<p>欢迎您的咨询，期待为您服务！</p>
		</div>
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
			<p>上码</p>
		</a>
		<a href="/" class="Link_3 ">
			<div class="ico"></div>
			<p>统计</p>
		</a>
		<a href="/?c=Service&a=online" class="Link_4 on">
			<div class="ico"></div>
			<p>客服</p>
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
$(function(){
	preventDefault();
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
