<?php /*%%SmartyHeaderCode:256105f97926fa33d12-60176088%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c60500b12e25c65fdcbace0ef22d9513912a31d1' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Order\\index.html',
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
  'nocache_hash' => '256105f97926fa33d12-60176088',
  'variables' => 
  array (
    'is_msdbhk' => 0,
    'skey' => 0,
    'vo' => 0,
    'user' => 0,
    'bank' => 0,
    's' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f97926fdeae82_50864879',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97926fdeae82_50864879')) {function content_5f97926fdeae82_50864879($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>订单管理</title>
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
.userState{cursor:pointer;}
.orderList .selectbox{display:inline-block;margin-left:4%;background: #fff url('/public/home/images/sanjiao.png') no-repeat 96% center/1rem auto;border: 1px solid #d5d5d5;}
select{padding:0.75rem 0.5rem;width:8rem;border:1px solid #d2d2d2;appearance:none;-moz-appearance:none;-webkit-appearance:none;background: transparent;border: 0;}
.noData,.moreBtn{padding-top:0.2rem;}
.getDateBox .choiceDateTitle button{color:#fc744d !important;}

.payHkBtn {
    display: inline-block;
    width: 26%;
    color: #f60;
    border: 1px solid #f60;
    text-align: center;
    line-height: normal;
    padding: 0.2rem 0;
    border-radius: 2rem;
    vertical-align: middle;
	float:right;
}

.payHkFlag{
    display: inline-block;
    width: 26%;
    color: #f60;
    border: 0;
    text-align: right;
    line-height: normal;
    padding: 0.2rem 0;
    border-radius: 2rem;
    vertical-align: middle;
	float:right;
}
.cpBtn,.cpBtnFlag{padding:0px 6px;border:1px solid #f60;border-radius:3px;color:#f60;cursor:pointer;}
.searchbox .serachBtn2 {
    position: absolute;
    display: block;
    color: #fff;
    background: #f60;
    top: -0.1rem;
    right: -5.5rem;
    width: 5rem;
    height: 3.2rem;
    line-height: 3.2rem;
    text-align: center;
    font-size: 1.2rem;
    border-radius: 0.5rem;
}
</style>
<div class="orderList">
	<div class="orderListTop">
		<div class="selectbox">
			<select id="pstatus" style="padding-right:0.1rem;">
				<option value="0">支付状态</option>
								<option value="1">待支付</option>
								<option value="2">已提交</option>
								<option value="3">已超时</option>
								<option value="4">已取消</option>
								<option value="9">已支付</option>
							</select>
		</div>
				<div class="searchbox">
			<input type="text" id="keyword" placeholder="请输入关键词">
			<a href="javascript:;" class="serachBtn">搜索</a>
		</div>
				<div class="datebox">
			<div class="inp">
				<input type="text" id="s_start_time" placeholder="开始日期" onfocus="this.blur();">
			</div>
			<span>-</span>
			<div class="inp">
				<input type="text" id="s_end_time" placeholder="结束日期" onfocus="this.blur();">
			</div>
		</div>
		<div class="userState on-line">在线</div>
	</div>
	<div class="orderListCon">
		<ul>
			<!--
			<li>
				<div class="nunbox">
					<p class="orderId">单号：34895258865</p>
					<p class="amount">￥188.80</p>
				</div>
				<p>支付方式：支付宝</p>
				<p>下单时间：2019-1-17 15:30</p>
				<p>支付时间：2019-1-17 16:05</p>
				<div class="paystatebox">
					<p class="paystate">待支付</p>
					<a href="javascript:;"  class="payConfirmBtn">确认收款</a>
				</div>
			</li>
			-->
		</ul>
		<div class="moreBtn" style="text-align:center;">点击加载更多</div>
	</div>
	<!-- 底部导航 -->
	<!-- 底部导航栏 -->
<div class="BotMenu">
	<div class="wrap">
		<a href="/?c=Order" class="Link_1 on">
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
		<a href="/?c=User" class="Link_5 ">
			<div class="ico"></div>
			<p>我的</p>
		</a>
	</div>
</div>
</div>

<div class="addIdCodePop">
	<div class="Wrap" style="top:10%;">
		<div class="Con">			
			<div class="ConIn">		
				<p class="Tt">提交回款</p>
				<div class="Row" style="margin-bottom:0;">
					<p class="lttxt" style="width:38%;font-weight:bold;">目标收款信息：</p>
				</div>
				<div class="Row">
					<div class="inputbox" style="width:94%;margin-left:3%;padding:5px;padding-bottom:10px;">
						<div>银行：</div>
												<div style="margin-bottom:5px;">姓名： <span class="cpBtn" data-clipboard-text="">复制</span></div>
						<div>卡号： <span class="cpBtn" data-clipboard-text="">复制</span></div>
					</div>
				</div>
				<div class="Row">
					<p class="lttxt">回款金额：</p>
					<div class="inputbox">
						<span id="hk_money" data-money="" style="color:#f30;font-weight:bold;font-size:18px;line-height:2.4rem;"></span>
						<span class="cpBtn" data-clipboard-text="" style="position:relative;top:-2px;">复制</span>
					</div>
				</div>
				<div class="Row">
					<p class="lttxt">单号：</p>
					<div class="inputbox">
						<span id="hk_id" hk-id="" style="padding:0 0.2rem;font-weight:bold;font-size:18px;line-height:2.4rem;"></span>
						<span class="cpBtn" data-clipboard-text="" style="position:relative;top:-2px;">复制</span>
					</div>
				</div>
				<div class="Row">
					<p class="lttxt">付款姓名：</p>
					<div class="inputbox"><input type="text" id="hk_realname" placeholder="真实姓名"></div>
				</div>
				<div class="Row">
					<p class="lttxt">付款账号：</p>
					<div class="inputbox"><input type="text" id="hk_account" placeholder="支付宝/微信/其他账号"></div>
				</div>
				<div class="Row">
					<p class="lttxt">付款备注：</p>
					<div class="inputbox">
						<textarea id="hk_remark" placeholder="" style="border:0;padding:0.2rem 0.4rem;width:96%;height:40px;"></textarea>
					</div>
				</div>
				<div class="Row codeImgBox" style="">
					<p class="lttxt">回款凭证：</p>
					<div class="codeImgs">
						<ul>
							<li class="bannerItem"><a href="javascript:;"><img src="/public/home/images/add.png"></a></li>
						</ul>
						<input type="file" id="hkCover" accept="image/*" style="display:none;"/>
					</div>
				</div>
				<input type="hidden" id="order_sn" value=""/>
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
<script src="/public/mdate/iScroll.js"></script>
<script src="/public/mdate/Mdate.js"></script>
<script src="public/js/clipboard.min.js"></script>
<script src="/public/js/lrz.all.bundle.js"></script>
<script>
isOrderPage=true;
var is_msdbhk='0';

//渲染订单
var nowlist={};
function iniOrder(item){
	nowlist[item.order_sn]=item;
	var color='';
	if(item.pay_status==2){
		color='color:#f70315;';
	}
	var html='';
	html+='<li data-osn="'+item.order_sn+'">';
		html+='<div class="nunbox">';
			html+='<p class="orderId" style="'+color+'">'+item.order_sn+'</p>';
			
			html+='<p class="paystate" style="background-image:url(/public/home/images/pstatus'+item.pay_status+'.png);">'+item.pay_status_flag+'</p>';
		html+='</div>';
		html+='<p>商户单号：'+item.out_order_sn+'</p>';
		html+='<p>支付方式：'+item.mtype_name+'</p>';
		html+='<p>收款姓名：'+item.ma_realname+'</p>';
		html+='<p>收款账号：'+item.ma_account+'</p>';
		html+='<p>下单时间：'+item.create_time+'</p>';
		html+='<p>支付时间：<span class="payTime">'+item.pay_time+'</span></p>';
		html+='<div class="paystatebox">';
			html+='<p class="amount">￥'+item.money+'</p>';
			if(item.pay_status==1||item.pay_status==2){
				html+='<a href="javascript:;"  class="payConfirmBtn">确认收款</a>';
			}else if(item.pay_status==3){
				html+='<a href="javascript:;"  class="payConfirmBtn">超时补单</a>';
			}else if(item.pay_status==9){

				if(item.js_status==2){
					//已经结算才有回款
					if(is_msdbhk==1){
						if(item.hk_status==0){
							html+='<a href="javascript:;"  class="payHkBtn">提交回款</a>';
						}else if(item.hk_status==4){
							html+='<a href="javascript:;"  class="payHkBtn">重新回款</a>';
						}else if(item.hk_status==3){
							html+='<a href="javascript:;"  class="payHkFlag" style="width:50%;">已回款：'+item.hk_money+'</a>';
						}else{
							html+='<a href="javascript:;"  class="payHkFlag" style="width:50%;">回款待审核：'+item.hk_money+'</a>';
						}
					}else{
						html+='<a href="javascript:;"  class="payHkFlag">已结算</a>';
					}
				}else{
					html+='<a href="javascript:;"  class="payHkFlag">待结算</a>';
				}
			}
			
		html+='</div>';
	html+='</li>';
	return html;
}
	
$(function(){

	var clipboard = new ClipboardJS('.cpBtn');
    clipboard.on('success', function (e) {
        _alert("复制成功");
    });

	new Mdate("s_start_time", {
		beginYear: "2019",
		endYear: "2025",
		beginMonth: "1",
		beginDay: "1",
		format: "-"	//此项为Mdate需要显示的格式，可填写"/"或"-"或".",不填写默认为年月日
	});
	
	new Mdate("s_end_time", {
		beginYear: "2019",
		beginMonth: "1",
		beginDay: "1",
		endYear: "2025",
		format: "-"	//此项为Mdate需要显示的格式，可填写"/"或"-"或".",不填写默认为年月日
	});
	
    $('.moreBtn').on('click',function(){
		var pdata={
			s_keyword:$.trim($('#keyword').val()),
			s_pay_status:$('#pstatus').val(),
			s_hk_type:$('#s_hk_type').val(),
			s_start_time:$('#s_start_time').val(),
			s_end_time:$('#s_end_time').val()
		};
        dataPage({
            url:global.appurl+'c=Order&a=order_list',
            data:pdata,
            success:function(json){
                var html='';
                for(var i in json.data.list){
					var item=json.data.list[i];
					html+=iniOrder(item);
                }
                $('.orderListCon ul').append(html);
            }
        });
    });

    $('.moreBtn').trigger('click');
	
	//搜索
	$('.serachBtn,.serachBtn2').on('click',function(){
		NOW_PAGE=1;
		var obj=$(this);
		if(obj.hasClass('serachBtn2')){
			$('#s_hk_type').val(1);
		}else{
			$('#s_hk_type').val(0);
		}
		$('.orderListCon ul').html('');
		$('.moreBtn').trigger('click');
	});
	
	/////////////////////////////////////////////
	var cnf_mscheck_needpwd='否';
	
	$('body').on('click','.payConfirmBtn',function(){
		var obj=$(this);
		var liObj=obj.parents('li');
		var osn=liObj.attr('data-osn');
		var item=nowlist[osn];
		var con='确定已收到<b style="color:#fc744d;font-size:20px;">￥'+item.money+'</b>';
		if(cnf_mscheck_needpwd=='是'){
			con+='<div style="font-weight:bold;">请输入二级密码：<br><input type="password" id="password2" style="display:inline-block;line-height:26px;padding:2px 5px;border:1px solid #dedede;;border-radius:3px;" /></div>';
		}
		layer.open({
			content:con,
			style:'width:65%',
			btn:['确定','取消'],
			yes:function(idx){
				var password2='';
				if(cnf_mscheck_needpwd=='是'){
					password2=$.trim($('#password2').val());
					if(!password2){
						_alert('请输入二级密码');
						return false;
					}
					password2=md5(password2);
				}
				layer.close(idx);
				ajax({
					url:global.appurl+'c=Order&a=order_check',
					data:{osn:osn,password2:password2},
					beforeSend:function(){
						layer.open({type:2});
					},
					success:function(json){
						layer.close(idx);
						setTimeout(function(){
							layer.closeAll();
							if(json.code!=1){
								_alert(json.msg);
								return;
							}
							_alert({
								content:json.msg,
								end:function(){
									liObj.find('.orderId').css({color:'#333333'});
									liObj.find('.paystate').css({backgroundImage:'url(/public/home/images/pstatus'+json.data.pay_status+'.png)'}).text(json.data.pay_status_flag);
									liObj.find('.payTime').text(json.data.pay_time);
									liObj.find('.payConfirmBtn').fadeOut(function(){
										liObj.find('.payConfirmBtn').after('<a href="javascript:;"  class="payHkFlag">待结算</a>');
									});
								}
							});
						},1200);
					}
				});
			}
		});
	});
	
	///////////////////////////////////////////////////
	
	document.getElementById('hkCover').addEventListener('change', function () {
		var that = this;
		lrz(that.files[0], {
			width:800,
			height:800
		}).then(function(rst){
			that.value=null;
			ajax({
				url:global.appurl+'a=imgUpload',
				data:{imgdata:rst.base64},
				success:function(json){
					if(json.code!=1){
						_alert(json.msg);
						return;
					}
					$('.bannerItem').find('img').attr('src',json.data.src);
					/*
					var html='<li class="bannerItem"><img src="'+json.data.src+'"><span>×</span></li>';
					$('#fileUploadH5Btn').before(html);
					if($('.bannerItem').length>=3){
						$('#fileUploadH5Btn').hide();
					}*/
				}
			});
			return rst;
		});
	});

	//监听选择图片
	$('.bannerItem').on('click',function(){
		$('#hkCover').trigger('click');
	});
	
	//提交回款
	$('body').on('click','.payHkBtn',function(){
		var bank_account='';
		if(!bank_account){
			_alert('缺少回款对象收款信息，请联系添加');
			return;
		}
		var obj=$(this);
		var order_sn=obj.parents('li').attr('data-osn');
		var item=nowlist[order_sn];
		$('#hk_realname').val(item.hk_realname);
		$('#hk_account').val(item.hk_account);
		if(item.hk_cover){
			$('.bannerItem').find('img').attr('src',item.hk_cover);
		}
		$('#hk_money').text('￥'+item.hk_money).attr('data-money',item.hk_money);
		$('#hk_money').next('.cpBtn').attr('data-clipboard-text',item.hk_money);
		
		$('#hk_id').text(item.id).attr('hk-id',item.id);
		$('#hk_id').next('.cpBtn').attr('data-clipboard-text',item.id);
		
		$('#order_sn').val(item.order_sn);
		//console.log(item);
		$('.addIdCodePop').fadeIn();
	});
	
	$('.confirmBtn').on('click',function(){
		var obj=$(this);
		var order_sn=$('#order_sn').val();
		var hk_money=$('#hk_money').attr('data-money');
		var hk_realname=$('#hk_realname').val();
		var hk_account=$('#hk_account').val();
		var hk_remark=$('#hk_remark').val();
		var hk_cover=$('.bannerItem').find('img').attr('src');
		var bk_id='';
		if(!hk_remark){
			_alert('请填写回款备注');
			return;
		}
		if(hk_cover=='/public/home/images/add.png'){
			_alert('请上传回款凭证');
			return;
		}
		ajax({
			url:global.appurl+'c=Order&a=orderhk',
			data:{
				osn:order_sn,bk_id:bk_id,hk_realname:hk_realname,hk_account:hk_account,
				hk_remark:hk_remark,hk_cover:hk_cover
			},
			success:function(json){
				if(json.code!=1){
					_alert(json.msg);
					return;
				}
				_alert(json.msg);
				var liObj=$('li[data-osn="'+order_sn+'"]');
				var payHkBtn=liObj.find('.payHkBtn');
				payHkBtn.after('<a href="javascript:;"  class="payHkFlag" style="width:50%;">回款待审核：'+hk_money+'</a>');
				payHkBtn.remove();
				$('.addIdCodePop .closeBtn').trigger('click');
			}
		});
	});
	
	$('.addIdCodePop .closeBtn').on('click',function(){
		$('.addIdCodePop').hide();
	});
	
	///////////////////////////////////////////////////
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
