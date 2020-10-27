<?php /*%%SmartyHeaderCode:222635f97d7051fd257-48054023%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5c7f277e7c912f54d34e059a7dae49456984121b' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Finance\\cash.html',
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
  'nocache_hash' => '222635f97d7051fd257-48054023',
  'variables' => 
  array (
    'user' => 0,
    'banklog' => 0,
    'cash_time_str' => 0,
    'fee_str' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f97d705400e45_10860332',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97d705400e45_10860332')) {function content_5f97d705400e45_10860332($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>提现</title>
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

</style>
<div class="cashOut">
	<div class="HeadTop">
		<p class="Tit">提现</p>
		<a href="/?c=User" class="backBtn"></a>
	</div>
	<div class="cashOutCon">
		<p class="txtline">账号：***</p>
				<p class="txtline">可提余额：￥0 <a href="javascript:;" class="editBtn transToBalance" style="width:6rem;" data-type="1">可提⇄接单</a></p>
		<p class="txtline">接单余额：￥12510.59 <a href="javascript:;" class="editBtn transToBalance" style="width:6rem;" data-type="2">接单⇄可提</a></p>
		<p class="txtline">接单冻结：￥0</p>
				<p class="txtline">收款账号：，，<a href="/?c=User&a=bcard" class="editBtn">修改</a></p>
		<div class="OutNum">提现额度：<div class="inbox"><input type="text" id="money"></div></div>
		<a href="javascript:;" class="cashOutBtn" style="margin-top:1.5rem;">提现</a>
		<div style="padding:1rem 2rem 0;">
			<div style="color:#f60;">单笔提现：￥100 ~ ￥50000</div>
			<div style="color:#f60;">可提现时间：周一至周日 00:00 - 23:59</div>
			<div style="color:#f30;">手续费 = 提现金额 × 0.00 + 2</div>
			<div style="color:#f60;">注意：直接提现需要扣除手续费，系统派单收款不收取手续费</div>
		</div>
		<h1>提现明细</h1>
		<div class="detailBox">
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>时间</th>
						<th>金额</th>
						<th>实到</th>
						<th>状态</th>
					</tr>
				</thead>
				<tbody id="listBox">
					<!--
					<tr>
						<td>2019-7-18 16:08</td>
						<td>668</td>
						<td>中国工商银行</td>
						<td class="Audited">已审核</td>
					</tr>
					-->
				</tbody>
			</table>
			<div class="moreBtn" style="text-align:center;">点击加载更多</div>
		</div>
	</div>
</div>

<div class="addIdCodePop">
	<div class="Wrap" style="top:28%;">
		<div class="Con">			
			<div class="ConIn">		
				<p class="Tt">标题</p>
				<div class="Row">
					<p class="lttxt balanceTit">可提余额：</p>
					<div class="inputbox" style="border:1px solid #fff;">
						<span class="balanceFlag" style="line-height:2.4rem;padding:0 0.5rem;color:#f60;margin-right:0.5rem;"></span>
						<span class="transAllBtn" style="border:1px solid #f60;color:#f60;border-radius:0.3rem;padding:0 0.4rem;">全部</span>
					</div>
				</div>
				<div class="Row">
					<p class="lttxt">转出额度：</p>
					<div class="inputbox"><input type="text" id="z_money" placeholder=""></div>
				</div>
				<input type="hidden" id="ptype" value=""/>
				<a href="javascript:;" class="confirmBtn">提交</a>
			</div>
		</div>
		<a href="javascript:;" class="closeBtn"></a>
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

	$('.transAllBtn').on('click',function(){
		var balance=$.trim($('.balanceFlag').text());
		$('#z_money').val(balance);
	});

	//余额互转
	$('.transToBalance').on('click',function(){
		var obj=$(this);
		var ptype=obj.attr('data-type');
		var title='';
		if(ptype==1){
			title='可提现余额->接单余额';
			$('.balanceTit').text('可提余额：');
			$('.balanceFlag').text('0');
		}else if(ptype==2){
			title='接单余额->可提现余额';
			$('.balanceTit').text('接单余额：');
			$('.balanceFlag').text('12510.59');
		}else{
			_alert('未知操作类型');
			return;
		}
		$('.addIdCodePop .Tt').text(title);
		$('#ptype').val(ptype);
		$('.addIdCodePop').fadeIn();
	});
	
	$('.addIdCodePop .closeBtn').on('click',function(){
		$('.addIdCodePop').hide();
	});
	
	$('.confirmBtn').on('click',function(){
		var obj=$(this);
		var ptype=$('#ptype').val();
		var money=$.trim($('#z_money').val());
		if(!money||money<0.01){
			_alert('转出额度不正确');
			return;
		}
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return false;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=Finance&a=balanceTrans',
			data:{ptype:ptype,money:money},
			success:function(json){
				if(json.code!=1){
					obj.attr('has-click','0');
					_alert(json.msg);
					return;
				}
				_alert({
					content:json.msg,
					end:function(){
						$('.addIdCodePop .closeBtn').trigger('click');
						location.reload();
					}
				});
			}
		});
	});
	
	////////////////////////////////////////////////////
	
	$('.cashOutBtn').on('click',function(){
		var obj=$(this);
		var money=$.trim($('#money').val());
		
		layer.open({
			//title:'',
			content:'您确定要提现么？',
			style:'width:60%',
			btn:['确定','取消'],
			yes:function(idx){
				layer.close(idx);
				ajax({
					url:global.appurl+'c=Finance&a=cashAct',
					data:{money:money},
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
	
	
	
	//获取提现记录
    $('.moreBtn').on('click',function(){
        dataPage({
            url:global.appurl+'c=Finance&a=cashlog_list',
            data:{},
            success:function(json){
                var html='';
                for(var i in json.data.list){
                    var item=json.data.list[i];
                    html+='<tr>';
                        html+='<td>'+item.create_time_flag+'</td>';
                        html+='<td>'+item.money+'</td>';
                        html+='<td>'+item.real_money+'</td>';
                        html+='<td>'+item.status_flag+'</td>';
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
