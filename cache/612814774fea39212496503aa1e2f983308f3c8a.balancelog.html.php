<?php /*%%SmartyHeaderCode:317025f7ea840de63b9-62242421%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '612814774fea39212496503aa1e2f983308f3c8a' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Finance\\balancelog.html',
      1 => 1602039578,
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
  'nocache_hash' => '317025f7ea840de63b9-62242421',
  'variables' => 
  array (
    'skey' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f7ea8419c31d7_21091959',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f7ea8419c31d7_21091959')) {function content_5f7ea8419c31d7_21091959($_smarty_tpl) {?><!doctype html>
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
<style>
.CommissionCon .detailBox tr td{line-height:2rem;padding:4px 8px;}
.viewBtn{padding:2px 8px;border:1px solid #fc744d;color:#fc744d;border-radius:3px;}

.time_input{width:22%;line-height:1.9rem;padding:0 0.2rem;border:1px solid #aaa;border-radius:3px;}
.serachBtn2,.downloadBtn {
	cousor:pointer;
    display: inline-block;
    color: #fff;
    background: #1E9FFF;
    line-height: 1.8rem;
    text-align: center;
    font-size: 1rem;
    border-radius: 0.2rem;
	padding:0.1rem 0.5rem;
}
.CommissionCon .detailBox table tr td{width:16.6% !important;}
.getDateBox .choiceDateTitle button{color:#fc744d !important;}
</style>

<div class="Commission">
	<div class="HeadTop" style="z-index:2;">
		<p class="Tit">资金变动明细</p>
		<a href="/?c=User" class="backBtn"></a>
	</div>
	<div class="CommissionCon">
		<form id="searchForm">
			<div style="padding:0.5rem;">
				<input class="time_input" id="s_start_time" placeholder="开始日期"/> -
				<input class="time_input" id="s_end_time" placeholder="结束日期"/>
				<select id="s_type" style="height:2rem;line-height:2rem;width:90px;border-radius:3px;position:relative;top:1px;">
					<option value="0">全部类型</option>
															<option value="50">后台充值余额</option>
																				<option value="51">前台充值余额</option>
																				<option value="52">充值冻结</option>
																				<option value="53">充值接单余额</option>
																				<option value="54">充值应回款</option>
																				<option value="55">接单可提余额互转</option>
																														<option value="4">码商订单分成</option>
																														<option value="6">夜间接单奖励</option>
																				<option value="8">注册赠送余额</option>
																														<option value="12">提现退还</option>
																				<option value="13">接单冻结</option>
																				<option value="14">扣除冻结</option>
																				<option value="15">冻结退还</option>
																				<option value="16">补单扣除</option>
																				<option value="20">订单回款</option>
																				<option value="21">订单累计应回款</option>
																				<option value="22">码商应回款扣除</option>
																				<option value="23">码商应回款退还</option>
																				<option value="24">审核增加应回款</option>
																				<option value="31">用户提现应回款拨付</option>
																				<option value="32">审核提现应回款退还</option>
														</select>
				<span class="serachBtn2">查询</span>
				<span class="downloadBtn" id="downloadBtn" style="background:#fc744d;">导出</span>
				<input type="hidden" name="is_download" id="is_download"/>
			</div>
		</form>
		<div class="detailBox">
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr style="font-weight:bold;">
						<td>时间</td>
						<td>类型</td>
						<td>原余额</td>
						<td>变更金额</td>
						<td>现余额</td>
						<td>备注</td>
					</tr>
				</thead>
				<tbody id="listBox">
					<!--
					<tr>
						<td>DD</td>
						<td>268</td>
						<td>268</td>
						<td>2019-7-18</td>
					</tr>
					-->
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
<script src="/public/mdate/iScroll.js"></script>
<script src="/public/mdate/Mdate.js"></script>
<script>

$(function(){

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
	
	//获取充值记录
    $('.moreBtn').on('click',function(){
        dataPage({
            url:global.appurl+'c=Finance&a=balancelog_list',
            data:{
				s_type:$('#s_type').val(),
				s_start_time:$('#s_start_time').val(),
				s_end_time:$('#s_end_time').val(),
			},
            success:function(json){
                var html='';
                for(var i in json.data.list){
                    var item=json.data.list[i];
                    html+='<tr>';
                        html+='<td>'+item.create_time+'</td>';
                        html+='<td>'+item.type_flag+'</td>';
                        html+='<td>'+item.ori_balance+'</td>';
						html+='<td>'+item.money+'</td>';
                        html+='<td>'+item.new_balance+'</td>';
                        html+='<td>'+item.remark+'</td>';
                    html+='</tr>';
                }
                $('#listBox').append(html);
            }
        });
    });

    $('.moreBtn').trigger('click');
	
	$('.serachBtn2').on('click',function(){
		NOW_PAGE=1;
		$('#listBox').html('');
		$('.moreBtn').trigger('click');
	});
	
	//导出操作
	$('#downloadBtn').on('click',function(){
		$('#is_download').val(1);
		var params=$('#searchForm').serialize();
		var url=global.appurl+'c=Finance&a=balancelog_list&'+params;
		window.open(url,'_blank');
		$('#is_download').val(0);
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
