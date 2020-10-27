<?php /*%%SmartyHeaderCode:124445f97d6998648d7-84777256%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c55691a36db064083ec160f932689e2785ba908' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\User\\bcard.html',
      1 => 1578476498,
      2 => 'file',
    ),
    'cfb654ce50c2064ecd000c5c405f8f854a49b36c' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\head.html',
      1 => 1578476498,
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
  'nocache_hash' => '124445f97d6998648d7-84777256',
  'variables' => 
  array (
    'user' => 0,
    'bank_arr' => 0,
    'vo' => 0,
    'banklog' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f97d6999c0dd8_00057173',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97d6999c0dd8_00057173')) {function content_5f97d6999c0dd8_00057173($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>绑定银行卡</title>
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
<style>
.layui-upload-file{display: none;}
</style>

<div class="bindCard">
	<!-- 顶部 -->
	<div class="HeadTop">
		<p class="Tit">绑定银行卡</p>
		<a href="/?c=User" class="backBtn"></a>
	</div>
	<div class="bindCardCon">
		<div class="Wrap">
			<div class="Row userid">
				<div class="ltbox">账号：</div>
				<div class="rtbox">***</div>
			</div>
			<div class="Row">
				<div class="ltbox">验证码：</div>
				<div class="rtbox">
					<div class="Insert code"><input type="text" id="smscode"></div>
					<a href="javascript:;" class="clickget" style="top:2px;width:6rem;">点击获取</a>
				</div>
			</div>
			<div class="Row">
				<div class="ltbox">开户行：</div>
				<div class="rtbox" style="background: #fff url('/public/home/images/sanjiao.png') no-repeat 96% center/1rem auto;border: 1px solid #d5d5d5;">
					<select id="bank_id" style="width:20rem;appearance: none;-moz-appearance: none;-webkit-appearance: none;background: transparent;border: 0;height: 3rem;padding: 0 1rem;">
												<option value="1">中国工商银行</option>
												<option value="2">中国农业银行</option>
												<option value="3">中国银行</option>
												<option value="4">中国建设银行</option>
												<option value="5">交通银行</option>
												<option value="6">中信银行</option>
												<option value="7">中国光大银行</option>
												<option value="8">华夏银行</option>
												<option value="9">中国民生银行</option>
												<option value="10">广发银行</option>
												<option value="11">深圳发展银行</option>
												<option value="12">招商银行</option>
												<option value="13">兴业银行</option>
												<option value="14">上海浦东发展银行</option>
												<option value="15">恒丰银行</option>
												<option value="16">浙商银行</option>
												<option value="17">渤海银行</option>
												<option value="18">中国邮政储蓄银行</option>
												<option value="19">广西北部湾银行</option>
												<option value="20">东亚银行</option>
												<option value="21">平安银行</option>
											</select>
				</div>
			</div>
			<div class="Row">
				<div class="ltbox">姓名：</div>
				<div class="rtbox">
					<div class="Insert"><input type="text" id="bank_realname" value="" ></div>
				</div>
			</div>
			<div class="Row">
				<div class="ltbox">卡号：</div>
				<div class="rtbox">
					<div class="Insert"><input type="text" id="bank_account" value="" ></div>
				</div>
			</div>
			<a href="javascript:;" class="bindBtn">绑定</a>
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
	
	var ini_bank_id='';
	if(ini_bank_id){
		$('#bank_id').val(ini_bank_id);
	}

	$('.clickget').on('click',function(){
		var obj=$(this);
		var phone='';
		if(obj.attr('is-timer')){
			return true;
		}
		ajax({
			url:global.appurl+'a=getPhoneCode',
			data:{phone:phone,stype:5},
			success:function(json){
				if(json.code!=1){
					_alert(json.msg);
					return;
				}
				smsTimer(obj);
			}
		});
	});
	
	$('.bindBtn').on('click',function(){
		var obj=$(this);
		var bank_id=$.trim($('#bank_id').val());
		var bank_realname=$.trim($('#bank_realname').val());
		var bank_account=$.trim($('#bank_account').val());
		var idcard=$.trim($('#idcard').val());
		var smscode=$.trim($('#smscode').val());
		var zfb_account=$.trim($('#zfb_account').val());
		var zfb_qrcode=$.trim($('#zfb_qrcode').val());
		var wx_account=$.trim($('#wx_account').val());
		var wx_qrcode=$.trim($('#wx_qrcode').val());
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=User&a=bcardAct',
			data:{bank_id:bank_id,bank_realname:bank_realname,bank_account:bank_account,idcard:idcard,zfb_account:zfb_account,zfb_qrcode:zfb_qrcode,wx_account:wx_account,wx_qrcode:wx_qrcode,smscode:smscode},
			success:function(json){
				if(json.code!=1){
					obj.attr('has-click','0');
					_alert(json.msg);
					return;
				}
				_alert({
					content:json.msg,
					end:function(){
						location.href='/?c=User';
					}
				});
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
