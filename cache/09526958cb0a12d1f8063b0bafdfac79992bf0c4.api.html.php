<?php /*%%SmartyHeaderCode:64035f900be513d003-54354984%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09526958cb0a12d1f8063b0bafdfac79992bf0c4' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\User\\api.html',
      1 => 1578476498,
      2 => 'file',
    ),
    '434e113806f32d87abf56db39a5c5905a98df8c3' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\head.html',
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
  'nocache_hash' => '64035f900be513d003-54354984',
  'variables' => 
  array (
    'user' => 0,
    'notify_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f900be52b1633_17328626',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f900be52b1633_17328626')) {function content_5f900be52b1633_17328626($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>KV支付</title>
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
<style type="text/css">
.cashOutCon .huidiaoBox{position: relative;width: 11.5rem;height: 11.5rem;margin: 3rem auto 0;border-radius: 12rem;}
.cashOutCon .huidiaoBox .txt1{font-size: 1.5rem;margin-top: 3.5rem;}
.cashOutCon .huidiaoBox .txt2{text-align: center;color: #019aff;font-size: 1.5rem;padding: 2.2rem 0 1.5rem;}
.cashOutCon .huidiaoBox .con1{position: absolute;width: 100%;height: 100%;color: #fff;text-align: center;background-image: linear-gradient(to bottom, #019aff, #dedede);border-radius: 12rem;}
.cashOutCon .huidiaoBox .con2{position: absolute;width: 100%;height: 100%;top: 0;left: 0;border: 2px solid #019aff;border-radius: 12rem;box-sizing: border-box;}
.cashOutCon .huidiaoBox .huidiao_OpenBtn{display: block;width: 7rem;text-align: center;border-radius: 2rem;line-height: normal;padding: 0.4rem 0;background: #fff;color: #019aff;margin: 0 auto;font-size: 1.2rem;box-shadow: 0px 0px 3px 2px #019aff;}
</style>
<div class="cashOut">
	<div class="HeadTop">
		<p class="Tit">回调助手</p>
		<a href="/?c=User" class="backBtn"></a>
	</div>
	<div class="cashOutCon">
		<p class="txtline"><b>我的账号：</b>kv123</p>
		<p class="txtline" style="line-height:1.5rem;word-break:break-all;margin-bottom:1rem;"><b>回调地址：</b>http://127.0.0.1/?c=Notify&mid=1649 <span class="editBtn" id="notifyUrl" data-clipboard-text="http://127.0.0.1/?c=Notify&mid=1649" >复制</span></p>
		<p class="txtline" style="line-height:1.5rem;word-break:break-all;margin-bottom:1rem;"><b>签名密钥：</b>b534c98ca47d74c5cf44145e3733ec099a6683c9 <span class="editBtn" id="apikey" data-clipboard-text="b534c98ca47d74c5cf44145e3733ec099a6683c9" >复制</span></p>
		<div class="OutNum"><b>二级密码：</b><div class="inbox"><input type="password" id="password2"></div></div>
		<a href="javascript:;" class="cashOutBtn" style="margin-top:1.5rem;">更新密钥</a>
		<div style="padding:1rem 2rem 0;">
			<div style="color:#f60;">注意：请妥善保管您的密钥，切勿转发或泄漏给其他人，若别人已知道密钥，请及时更新！</div>
		</div>

		<div class="huidiaoBox">
			<div class="con1" style="display:none;">
				<p class="txt1">自动回调<br>点击开启</p>
			</div>
			<div class="con2" style="">	
				<p class="txt2">自动回调</p>
				<a href="javascript:;" class="huidiao_OpenBtn">点击关闭</a>
			</div>
		</div>
		<div class="apiautoFlag" style="text-align:center;padding-top:0.5rem;font-weight:bold;">自动回调已开启</div>
		
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
<script src="/public/js/clipboard.min.js"></script>
<script>

$(function(){

	var clipboard = new ClipboardJS('#notifyUrl');

	clipboard.on('success', function(e) {
		_alert('复制回调地址成功');
	});
	
	var clipboard2 = new ClipboardJS('#apikey');

	clipboard2.on('success', function(e) {
		_alert('复制签名密钥成功');
	});
	
	$('.cashOutBtn').on('click',function(){
		var obj=$(this);
		var password2=$.trim($('#password2').val());
		if(!password2){
			_alert('请填写二级密码');
			return;
		}
		password2=md5(password2);
		layer.open({
			//title:'',
			content:'您确定要更新签名密钥么？',
			style:'width:65%',
			btn:['确定','取消'],
			yes:function(idx){
				layer.close(idx);
				ajax({
					url:global.appurl+'c=User&a=apikeyUpdate',
					data:{password2:password2},
					success:function(json){
						if(json.code!=1){
							_alert(json.msg);
							return;
						}
						_alert({
							content:json.msg,
							end:function(){
								location.reload();
							}
						});
					}
				});
			}
		});
	});

	//自动回调
	$('.con1,.huidiao_OpenBtn').on('click',function(){
		var obj=$(this);
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=User&a=autoSet',
			data:{},
			success:function(json){
				obj.attr('has-click','0');
				if(json.code!=1){
					_alert(json.msg);
					return;
				}
				$('.con1,.con2').hide();
				if(json.data.apiauto==1){
					$('.con2').show();
				}else{
					$('.con1').show();
				}
				$('.apiautoFlag').text('自动回调已'+json.data.apiauto_flag);
				if(json.data.apiauto==1&&typeof(androidWeihuagu)!='undefined'){
					androidWeihuagu.JumpMainAndPostUrlAndKey('http://127.0.0.1/?c=Notify&mid=1649','b534c98ca47d74c5cf44145e3733ec099a6683c9');
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
