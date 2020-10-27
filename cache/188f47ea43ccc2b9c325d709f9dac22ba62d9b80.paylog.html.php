<?php /*%%SmartyHeaderCode:98065f97ca98ccb048-00236011%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '188f47ea43ccc2b9c325d709f9dac22ba62d9b80' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Finance\\paylog.html',
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
  'nocache_hash' => '98065f97ca98ccb048-00236011',
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f97ca98de44e1_68896122',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97ca98de44e1_68896122')) {function content_5f97ca98de44e1_68896122($_smarty_tpl) {?><!doctype html>
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
.CommissionCon .detailBox tr td{line-height:2rem;padding:4px 8px;}
.viewBtn{padding:2px 8px;border:1px solid #fc744d;color:#fc744d;border-radius:3px;}
</style>
<div class="Commission">
	<div class="HeadTop">
		<p class="Tit">充值记录</p>
		<a href="/?c=Finance&a=pay" class="backBtn"></a>
	</div>
	<div class="CommissionCon">
		<div class="detailBox">
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>时间/单号</th>
						<th>金额</th>
						<th>状态</th>
						<th>详情</th>
					</tr>
				</thead>
				<tbody id="listBox">

				</tbody>
			</table>
			<div class="moreBtn" style="text-align:center;">点击加载更多</div>
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
	
	//获取充值记录
    $('.moreBtn').on('click',function(){
        dataPage({
            url:global.appurl+'c=Finance&a=paylog_list',
            data:{},
            success:function(json){
                var html='';
                for(var i in json.data.list){
                    var item=json.data.list[i];
                    html+='<tr>';
                        html+='<td>'+item.create_time_flag+'<br>'+item.order_sn+'</td>';
                        html+='<td>'+item.money+'</td>';
                        html+='<td>'+item.pay_status_flag+'</td>';
                        html+='<td><a href="/?c=Finance&a=payInfo&osn='+item.order_sn+'" class="viewBtn">查看</a></td>';
                    html+='</tr>';
                }
                $('#listBox').append(html);
            }
        });
    });

    $('.moreBtn').trigger('click');
	
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
