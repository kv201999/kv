<?php /*%%SmartyHeaderCode:5291593985f970e80a66130-71779500%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '441d39bcd7322cd2974e3f17b665be75c1c4d26f' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/User/index.html',
      1 => 1578476498,
      2 => 'file',
    ),
    '4b7133a76229f2c1960bdc4a61a1d43d468ee5b8' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/head.html',
      1 => 1578476498,
      2 => 'file',
    ),
    'e42155a4e0aabf6b08d4870cfb0b0b5a84ec8817' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/menu.html',
      1 => 1578476498,
      2 => 'file',
    ),
    '6dfe1b88c9fd492b894f064fc8fa911676e42650' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/js.html',
      1 => 1578476498,
      2 => 'file',
    ),
    'ab59b13474c191ec627b740bc472d81a3bfa27b2' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/foot.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5291593985f970e80a66130-71779500',
  'variables' => 
  array (
    'user' => 0,
    'team_num' => 0,
    'order_num' => 0,
    'order_money' => 0,
    'yong_money' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f970e80b4b585_41225208',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f970e80b4b585_41225208')) {function content_5f970e80b4b585_41225208($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>我的</title>
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
<div class="Home">
	<div class="HomeTop">
		<div class="wrap">			
			<!-- <a href="/?c=User&a=setting" class="setBtn"></a> -->
			<div class="headIco" style="background-image:url(public/images/head.png);"></div>
			<div class="info">
				<p class="userName">kv123</p>
				<!-- 两个状态：on-line/off-line -->
				<p class="userState on-line">在线</p>
			</div>
			<a href="/?c=Finance&a=pay" class="fillCashBtn">充值</a>
		</div>
	</div>
	<div class="HomeCen">
		<ul>
						<li><p>3975.49</p><p>接单余额</p></li>
			<li><p>10035.1</p><p>可提余额</p></li>
			<li><p>0</p><p>冻结余额</p></li>
						
			<li><p>12</p><p>订单数</p></li>
			<li><p>7024.51</p><p>订单总额</p></li>
			<li><p>35.1</p><p>提成</p></li>
		</ul>
	</div>
	<div class="HomeList">
		<ul>
			<li><a href="/?c=User&a=bcard"><i><img src="/public/home/images/ico7.png"></i><p>绑定卡</p></a></li>
			<li><a href="/?c=Finance&a=cash"><i><img src="/public/home/images/ico8.png"></i><p>提现</p></a></li>
						<li><a href="/?c=Tg"><i><img src="/public/home/images/ico9.png"></i><p>推荐二维码</p></a></li>
			<li><a href="/?c=User&a=team"><i><img src="/public/home/images/ico10.png"></i><p>我的团队</p></a></li>
			<li><a href="/?c=Finance&a=yong"><i><img src="/public/home/images/ico11.png"></i><p>分成记录</p></a></li>
			<li><a href="/?c=Finance&a=balancelog"><i><img src="/public/home/images/ico7.png"></i><p>资金明细</p></a></li>
			<li><a href="/?c=User&a=api"><i><img src="/public/home/images/ico21.png"></i><p>回调助手</p></a></li>
			<li><a href="/?c=User&a=setting"><i><img src="/public/home/images/ico15.png"></i><p>设置</p></a></li>
		</ul>
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
		<a href="/?c=Service&a=online" class="Link_4 ">
			<div class="ico"></div>
			<p>客服</p>
		</a>
		<a href="/?c=User" class="Link_5 on">
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
	$('.userState').on('click',function(){
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
				obj.removeClass('on-line off-line');
				if(json.data.is_online=='1'){
					$('.userState').addClass('on-line');
				}else{
					$('.userState').addClass('off-line');
				}
				obj.html(json.data.is_online_flag);
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
		wsUrl:'ws://paofen123.com:9502',
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
