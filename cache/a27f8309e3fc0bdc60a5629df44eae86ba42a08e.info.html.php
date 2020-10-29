<?php /*%%SmartyHeaderCode:19435f9a9b09ce9948-06744930%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a27f8309e3fc0bdc60a5629df44eae86ba42a08e' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Pay\\info.html',
      1 => 1603880032,
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
  'nocache_hash' => '19435f9a9b09ce9948-06744930',
  'variables' => 
  array (
    'info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9a9b0a0e78d2_28639592',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9a9b0a0e78d2_28639592')) {function content_5f9a9b0a0e78d2_28639592($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>PU支付</title>
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
.qrcode img{cursor:pointer;}
.uname{color:#000;text-align:left;font-weight:600;}
.copyBtn{border:1px solid #f60;color:#f60;padding:2px 4px;padding-top:1px;font-size:12px;line-height:10px;border-radius:3px;cursor: pointer;}

.PaymentCon .time .timeBox{opacity:0;border: 1px solid #fc744d;background-color: #fc744d;color: #fff;padding: 6px 10px;font-size: 16px;border-radius: 5px;cursor: pointer;}

.HeadTopZfb{background-color:rgba(10,170,240,1);}
.HeadTopWx{background-color:rgba(66,174,60,1);}
.HeadTopYsf{background-color:rgba(255,51,0,1);}
.Payment .HeadTop{height: 50px;}
.Payment .HeadTop .Tit{font-size: 20px;padding: 12px 0;}

.PaymentCon .wxTips{font-size:1rem;background:#f8ecd6;color:#e88900;line-height:1.3rem;padding:0.5rem;font-weight:400;border-radius:8px;margin-bottom:0.5rem;}
</style>
<div class="Payment">
	<div class="HeadTop ">
		<p class="Tit">银行卡</p>
		<!--<a href="javascript:;" class="backBtn"></a>-->
	</div>
	<div class="PaymentCon">	
		<div class="amount cpBtn" data-clipboard-text="2900.00">2900.00<span class="copyBtn">复制</span></div>
		<div style="font-size: 18px;margin-top:5px;color: #333" data-clipboard-text="432.84">≈432.84USDT</div>
				<div class="uname" style="text-align:left;">
											开户银行：中国工商银行<br>
												<div style="clear:both;height:0.5rem;"></div>
				<span class="cpBtn" data-clipboard-text="黄峰">收款姓名：黄峰 <span class="copyBtn">复制</span></span><br>
				<div style="clear:both;height:0.5rem;"></div>
				<span class="cpBtn" data-clipboard-text="897878978933333">收款账号：897878978933333 <span class="copyBtn">复制</span></span><br>
				<div style="clear:both;height:0.8rem;"></div>
									</div>
		<div class="time">
						订单已支付
					</div>
		<div class="warmTips" >
			<b>温馨提示：</b><br>
			1、请在订单有效期内进行付款<br>
			2、不可重复支付，务必支付以上金额，否则会不到账<br>
			3、点击复制金额，扫码支付时，在金额一栏粘贴，完成付款<br>
			4、付款15分钟未到账，请联系在线客服<br>
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
<script src="public/js/clipboard.min.js"></script>
<script>
preventDefault();
$(function(){

	var clipboard = new ClipboardJS('.cpBtn');
    clipboard.on('success', function (e) {
        _alert("复制成功");
    });
	
	var clipboard2 = new ClipboardJS('.linkBtn');
    clipboard2.on('success', function (e) {
		var url='';
        _alert({
			content:'金额复制成功，即将跳转并打开支付宝',
			time:3,
			end:function(){
				location.href=url;
			}
		});
    });
	
	var d_time='0'*1;
	var timer=null;
	if(d_time>0){
		setTimer();
	}else{
		$('.time').html('订单已超时');
	}
	
	function setTimer(){
		if(timer){
			clearInterval(timer);
		}
		var d_time_flag=secTrans(d_time);
		$('.timeBox').html('剩余'+d_time_flag+'，点我已付款').css({opacity:1});
		timer=setInterval(function(){
			d_time--;
			if(d_time<0){
				location.reload();
				clearInterval(timer);
			}
			var d_time_flag=secTrans(d_time);
			$('.timeBox').html('剩余'+d_time_flag+'，点我已付款').css({opacity:1});
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
	
	
	$('body').on('click','.qrcode',function(){
		var obj=$(this);
		var ma_qrcode=obj.find('img').attr('src');
		layer.open({
			content:'<div style="width:100%;text-align:center;"><img src="'+ma_qrcode+'"/></div>',
			style:'width:80%',
			btn:['关闭'],
			yes:function(idx){
				layer.close(idx);
			}
		});
	});
	
	$('.timeBox').on('click',function(){
		var obj=$(this);
		var osn='MS2020102910295141390';
		layer.open({
			//title:'',
			content:'如果您已支付请确定提交',
			style:'width:62%',
			btn:['确定','取消'],
			yes:function(idx){
				layer.close(idx);
				ajax({
					url:global.appurl+'c=Pay&a=infoAct',
					data:{osn:osn},
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
	
});
</script>
<script src="/public/js/socket.io.js"></script>
<script src="/public/home/js/Music.js"></script>
<script>
$(function(){

	nowOrderSn='MS2020102910295141390';
	
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
