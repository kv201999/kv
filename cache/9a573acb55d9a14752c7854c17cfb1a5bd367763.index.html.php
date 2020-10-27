<?php /*%%SmartyHeaderCode:245005f979273de47b8-30701111%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a573acb55d9a14752c7854c17cfb1a5bd367763' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Skma\\index.html',
      1 => 1603703139,
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
  'nocache_hash' => '245005f979273de47b8-30701111',
  'variables' => 
  array (
    's' => 0,
    'mtype_arr' => 0,
    'vo' => 0,
    'province_arr' => 0,
    'bank_arr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f979274223341_56123460',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f979274223341_56123460')) {function content_5f979274223341_56123460($_smarty_tpl) {?><!doctype html>
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
<script>
function showImg(ts){
	var obj=$(ts);
	var src=obj.attr('src');
	layer.open({
		content:'<div style="width:100%;text-align:center;"><img src="'+src+'"/></div>',
		style:'width:80%',
		btn:['关闭'],
		yes:function(idx){
			layer.close(idx);
		}
	});
}
</script>
<style>
.bannerItem{margin-right:5px;position:relative;}
.bannerItem span{position:absolute;top:0px;right:0px;line-height:20px;font-size:28px;}
select{width:14rem;position: relative;height: 2.2rem;padding: 0 0.5rem;}
.editItem,.delItem,.statusItem,.maQrcodeBox{cursor:pointer;}

.wb_bash{height:40px;line-height:20px;border:1px solid #dedede;padding:5px;width:93%;}
.wb_del_btn{position:absolute;right:-2px;top:0px;background:#f40;color:#fff;padding:1px 4px;font-size:12px;cursor:pointer;}
.wb_add_btn{background:#f60;font-size:12px;padding:2px 4px;color:#fff;display:inline-block;cursor:pointer;float:right;}

.addIdCodePop .Wrap{bottom:10%;}

.testItem{color:#F30;
    border: 1px solid #F30;
    border-radius: 2rem;
    padding: 0 0.8rem;
    font-size: 1rem;
}
</style>
<div class="payCode">
	<div class="payCodeTop">	
		<div class="searchbox">
			<!--
			<input type="text" id="keyword" value="" placeholder="请输入关键词">
			<a href="javascript:;" class="serachBtn">搜索</a>
			-->
			<select id="s_mtype" style="height:3rem;border:0;width:100%;border-radius:5px;">
								<option value="0" data-type="" selected>全部支付类型</option>
								<option value="1" data-type="2" >支付宝(闲鱼)</option>
								<option value="3" data-type="3" >银行卡(转账)</option>
							</select>
		</div>
		<a href="javascript:;" class="addIdNum" style="margin-left:0.7rem;">添加账号</a>
	</div>
	<div class="payCOdeList" style="top:11rem;">
		<ul>
			<!--
			<li>
				<div class="ltbox">
					<p>支付类型：卡转支付宝</p>
					<p>收款姓名：一小</p>
					<p>收款码：<i class="paywayIco"></i></p>
					<p>收益率：100%</p>
				</div>
				<div class="rtbox">
					!-- 两种状态on-line/off-line --
					<p>状态：<span class="state on-line">在线</span></p>
					<p>收款账号：13536920159</p>
					<p>省市：广东省广州市</p>
					<p>提成：688</p>
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
		<a href="/?c=Order" class="Link_1 ">
			<div class="ico"></div>
			<p>订单</p>
		</a>
		<a href="/?c=Skma" class="Link_2 on">
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

<!-- 添加收款码 -->
<div class="addIdCodePop">
	<!-- <div class="bot_line"><img src="/public/home/images/bot_line.png"></div> -->
	<div class="Wrap">
		<div class="Con">			
			<div class="ConIn">		
				<p class="Tt">添加收款码</p>
				<div class="Row">
					<p class="lttxt">支付类型：</p>
					<div class="selectbox">
						<select id="mtype_id">
														<option value="0">全部支付类型</option>
														<option value="1">支付宝(闲鱼)</option>
														<option value="3">银行卡(转账)</option>
													</select>
					</div>
				</div>
<!--				<div class="Row">-->
<!--					<p class="lttxt">所属省份：</p>-->
<!--					<div class="selectbox">-->
<!--						<select id="province_id">-->
<!--							<option value="0">请选择</option>-->
<!--							-->
<!--							<option value="11">北京市</option>-->
<!--							-->
<!--							<option value="12">天津市</option>-->
<!--							-->
<!--							<option value="13">河北省</option>-->
<!--							-->
<!--							<option value="14">山西省</option>-->
<!--							-->
<!--							<option value="15">内蒙古</option>-->
<!--							-->
<!--							<option value="21">辽宁省</option>-->
<!--							-->
<!--							<option value="22">吉林省</option>-->
<!--							-->
<!--							<option value="23">黑龙江省</option>-->
<!--							-->
<!--							<option value="31">上海市</option>-->
<!--							-->
<!--							<option value="32">江苏省</option>-->
<!--							-->
<!--							<option value="33">浙江省</option>-->
<!--							-->
<!--							<option value="34">安徽省</option>-->
<!--							-->
<!--							<option value="35">福建省</option>-->
<!--							-->
<!--							<option value="36">江西省</option>-->
<!--							-->
<!--							<option value="37">山东省</option>-->
<!--							-->
<!--							<option value="41">河南省</option>-->
<!--							-->
<!--							<option value="42">湖北省</option>-->
<!--							-->
<!--							<option value="43">湖南省</option>-->
<!--							-->
<!--							<option value="44">广东省</option>-->
<!--							-->
<!--							<option value="45">广西</option>-->
<!--							-->
<!--							<option value="46">海南省</option>-->
<!--							-->
<!--							<option value="50">重庆市</option>-->
<!--							-->
<!--							<option value="51">四川省</option>-->
<!--							-->
<!--							<option value="52">贵州省</option>-->
<!--							-->
<!--							<option value="53">云南省</option>-->
<!--							-->
<!--							<option value="54">西藏</option>-->
<!--							-->
<!--							<option value="61">陕西省</option>-->
<!--							-->
<!--							<option value="62">甘肃省</option>-->
<!--							-->
<!--							<option value="63">青海省</option>-->
<!--							-->
<!--							<option value="64">宁夏</option>-->
<!--							-->
<!--							<option value="65">新疆</option>-->
<!--							-->
<!--						</select>-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="Row" style="margin-bottom:0.1rem;">-->
<!--					<p class="lttxt">所属城市：</p>-->
<!--					<div class="selectbox">-->
<!--						<select id="city_id">-->
<!--							<option value="0">请选择</option>-->
<!--						</select>-->
<!--					</div>-->
<!--				</div>-->
<!--				<div style="padding:0 1.8rem 0.5rem;padding-right:2.8rem;color:#f60;font-size:0.5rem;text-align:right;">系统会派发同城订单，避免封号</div>-->
				<div class="Row bankBox">
					<p class="lttxt">开户行：</p>
					<div class="selectbox">
						<select id="bank_id">
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
				<div class="Row bankBox">
					<p class="lttxt">收款姓名：</p>
					<div class="inputbox"><input type="text" id="ma_realname" placeholder="真实姓名"></div>
				</div>
				<div class="Row bankBox">
					<p class="lttxt">银行卡号：</p>
					<div class="inputbox"><input type="text" id="ma_account" placeholder="银行卡号"></div>
				</div>
				<div class="Row bankBox">
					<p class="lttxt">开户支行：</p>
					<div class="inputbox"><input type="text" id="branch_name" placeholder="选填"></div>
				</div>
				<!--
				<div class="Row">
					<p class="lttxt">最小收款：</p>
					<div class="inputbox"><input type="text" id="min_money" placeholder="" value=""></div>
				</div>
				<div class="Row" style="display:none;">
					<p class="lttxt">匹配次数：</p>
					<div class="inputbox"><input type="text" id="match_num" placeholder="0或空则不限制" value=""></div>
				</div>
				-->
<!--				<div class="Row maxBox">-->
<!--					<p class="lttxt">最大收款：</p>-->
<!--					<div class="inputbox"><input type="text" id="max_money" placeholder="" value=""></div>-->
<!--				</div>-->
				<div class="Row moneyBox2" style="display:none;">
					<p class="lttxt">选择金额：</p>
					<div class="selectbox">
						<select id="ma_zkmoney">
							<option value="0" selected>0</option>
														<option value="100">100</option>
														<option value="200">200</option>
														<option value="300">300</option>
														<option value="500">500</option>
														<option value="1000">1000</option>
														<option value="2000">2000</option>
														<option value="5000">5000</option>
														<option value="10000">10000</option>
													</select>
					</div>
				</div>
				<div class="Row moneyBox" style="display:none;">
					<p class="lttxt">口令内容：</p>
					<div class="inputbox" style="border:0;">
						<textarea id="ma_zkling" style="border:1px solid #dedede;height:60px;width:94%;padding:0.4rem 0.4rem;"></textarea>
					</div>
				</div>
				<div class="Row uidBox" style="display:none;">
					<p class="lttxt">UID：</p>
					<div class="inputbox"><input type="text" id="ma_zfbuid" placeholder="直接复制粘贴即可" value=""></div>
				</div>
				<div class="Row uidBox" style="display:none;">
					<p class="lttxt">获取UID：</p>
					<div class="inputbox" style="border:1px solid #fff;">
						<img src="public/home/images/zfbuid.png" style="width:50%;cursor:pointer;" onclick="showImg(this)" />
					</div>
				</div>
				<div class="Row codeImgBox">
					<p class="lttxt">固定金额：</p>
					<div class="inputbox"><input type="text" id="guding_money" placeholder="请输入闲鱼商品金额" value=""></div>
				</div>
				<div class="Row codeImgBox">
					<p class="lttxt">闲鱼收款码：</p>
					<div class="codeImgs">
						<ul>
							<li class="bannerItem"><a href="javascript:;"><img src="/public/home/images/add.png"></a></li>
						</ul>
						<input type="file" id="maQrcode" accept="image/*" style="display:none;"/>
					</div>
				</div>
				<div class="Row state">
					<p class="lttxt">状态：</p>
					<div class="stateNav"><span class="on" data-status="2">在线</span><span data-status="1">离线</span></div>
				</div>
				<input type="hidden" id="item_id" value="0"/>
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
<script src="/public/js/lrz.all.bundle.js"></script>
<script src="public/js/base64.min.js"></script>
<script>
$(function(){
	
	///////////////////////////////////////////////////////

	$('.addIdCodePop').on('touchmove',function(event){
		//event.preventDefault();
	});

	document.getElementById('maQrcode').addEventListener('change', function () {
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
		$('#maQrcode').trigger('click');
	});

	//顶部切换类型	
	$('#s_mtype').on('change',function(){
		var obj=$(this);
		var mtype=obj.val();
		var keyword=$.trim($('#keyword').val());
		var url='/?c=Skma&mtype='+mtype;
		if(keyword){
			url+='&keyword='+keyword;
		}
		location.href=url;
	});
	
	//搜索关键词
	$('.serachBtn').on('click',function(){
		var mtype=$('.payCodeNav ul').find('.on').attr('data-mtype');
		var keyword=$.trim($('#keyword').val());
		var url='/?c=Skma&mtype='+mtype;
		if(keyword){
			url+='&keyword='+keyword;
		}
		location.href=url;
	});
	
	/////////////////////////////////////////////
	//全部隐藏
	function showNone(){
		$('.bankBox,.codeImgBox,.maxBox,.moneyBox,.uidBox').hide();
	}
	
	//只显示账号
	function showAccount(){
		showNone();
	}
	
	//显示银行信息
	function showBank(){
		showNone();
		$('.bankBox').show();
	}
	
	//显示二维码
	function showCode(){
		showNone();
		$('.codeImgBox').show();
	}
	
	function iniSetInput(mtype_id){
		var mtype_type=$('#s_mtype').find('option[value="'+mtype_id+'"]').attr('data-type');
		if(!mtype_type){
			return;
		}
		showNone();
		if(mtype_type==1){
			showAccount();
		}else if(mtype_type==2){
			showCode();
		}else if(mtype_type==3){
			showBank();
		}else if(mtype_type==4){
			//...
		}else if(mtype_type==5){
			$('.uidBox').show();
		}
		$('.maxBox').show();
		if(mtype_type==4){
			$('.moneyBox').show();
		}else{
			//$('.maxBox').show();
		}
		
	}
	
	/////////////////////////////////////////////
	
	//添加切换支付类型
	$('#mtype_id').on('change',function(){
		var obj=$(this);
		var mtype_id=obj.val();
		iniSetInput(mtype_id);
	});
	
	//切换状态
	$('.stateNav span').on('click',function(){
		var obj=$(this);
		$('.stateNav span').removeClass('on');
		obj.addClass('on');
	});
	
	//切换省份
	$('#province_id').on('change',function(){
		var obj=$(this);
		var province_id=obj.val();
		iniCity(province_id,0);
	});
	
	function iniCity(province_id,city_id,callback){
		ajax({
			url:global.appurl+'c=Skma&a=getCity',
			data:{pid:province_id},
			success:function(json){
				var html='<option value="0">请选择</option>';
				for(var i in json.data){
					var item=json.data[i];
					html+='<option value="'+item.id+'">'+item.cname+'</option>';
				}
				$('#city_id').html(html).val(city_id);
				if(callback){
					callback();
				}
			}
		});
	}
	
	//添加码
	$('.addIdNum').on('click',function(){
		var mtype_id=1;
		$('#mtype_id').val(mtype_id).prop('disabled',false);
		iniSetInput(mtype_id);
		$('#province_id').val(0);
		$('#city_id').html('<option value="0">请选择</option>');
		$('#bank_id').val($('#bank_id').find('option').eq(0).attr('value'));
		$('#branch_name').val('');
		$('#ma_realname').val('');
		$('#ma_account').val('');
		$('#ma_zkling').val('');
		$('#min_money').val("0");
		$('#max_money').val("20000");

		$('#item_id').val(0);
		$('.bannerItem').find('img').attr('src','/public/home/images/add.png');
		$('.stateNav span[data-status="2"]').trigger('click');
		$('.addIdCodePop .ConIn .Tt').text('添加收款码');
		$('.addIdCodePop').fadeIn();
	});
	
	$('.addIdCodePop .closeBtn').on('click',function(){
		$('.addIdCodePop').hide();
	});
	
	//编辑
	$('body').on('click','.editItem',function(){
		var obj=$(this);
		var id=obj.parents('li').attr('data-id');
		layer.open({
			type: 2,
			content: '加载中'
		});
		ajax({
			url:global.appurl+'c=Skma&a=skma_one',
			data:{item_id:id},
			success:function(json){
				layer.closeAll();
				if(json.code!='1'){
					_alert(json.msg);
					return;
				}
				var item=json.data;
				$('#mtype_id').val(item.mtype_id).prop('disabled',true);
				iniSetInput(item.mtype_id);
				if(item.mtype_type==2){
					$('.bannerItem').find('img').attr('src',item.ma_qrcode);
				}else if(item.mtype_type==3){
					$('#bank_id').val(item.bank_id);
				}else if(item.mtype_type==4){
					$('#ma_zkmoney').val(item.ma_zkmoney);
					$('#ma_zkling').val(item.ma_zkling);
				}else if(item.mtype_type==5){
					$('#ma_zfbuid').val(item.ma_zfbuid);
				}
				
				$('#province_id').val(item.province_id);
				iniCity(item.province_id,item.city_id);
				$('#branch_name').val(item.branch_name);
				$('#ma_realname').val(item.ma_realname);
				$('#ma_account').val(item.ma_account);
				$('#min_money').val(item.min_money);
				$('#max_money').val(item.max_money);
				$('#guding_money').val(item.max_money);
				$('#match_num').val(item.match_num);
				$('.stateNav span[data-status="'+item.status+'"]').trigger('click');
				
				$('#item_id').val(item.id);
				$('.addIdCodePop .ConIn .Tt').text('编辑收款码');
				$('.addIdCodePop').fadeIn();
				
			}
		});
	});
	
	$('.confirmBtn').on('click',function(){
		var obj=$(this);
		var item_id=$('#item_id').val();;
		var mtype_id=$('#mtype_id').val();
		var province_id=$('#province_id').val();
		var city_id=$('#city_id').val();
		var bank_id=$('#bank_id').val();
		var branch_name=$('#branch_name').val();
		var ma_realname=$('#ma_realname').val();
		var ma_account=$('#ma_account').val();
		var min_money=$('#min_money').val();
		var max_money=$('#max_money').val();
		var match_num=$('#match_num').val();
		var ma_qrcode=$('.bannerItem').find('img').attr('src');
		var status=$('.stateNav').find('.on').attr('data-status');
		var ma_zkmoney=$.trim($('#ma_zkmoney').val());
		var guding_money=$('#guding_money').val();
		var ma_zkling=$.trim($('#ma_zkling').val());
		if(ma_zkling){
			ma_zkling=Base64.encode(ma_zkling);
		}
		
		var ma_zfbuid=$.trim($('#ma_zfbuid').val());
		
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=Skma&a=skma_update',
			data:{
				item_id:item_id,mtype_id:mtype_id,province_id:province_id,city_id:city_id,bank_id:bank_id,branch_name:branch_name,
				ma_realname:ma_realname,ma_account:ma_account,ma_qrcode:ma_qrcode,status:status,
				min_money:min_money,max_money:max_money,match_num:match_num,guding_money:guding_money,
				ma_zkmoney:ma_zkmoney,ma_zkling:ma_zkling,ma_zfbuid:ma_zfbuid
			},
			success:function(json){
				obj.attr('has-click','0');
				if(json.code!=1){
					_alert(json.msg);
					return;
				}
				$('.addIdCodePop .closeBtn').trigger('click');
				_alert({
					content:json.msg,
					end:function(){
						//location.reload();
					}
				});
				var itid=item_id;
				ajax({
					url:global.appurl+'c=Skma&a=skma_one',
					data:{item_id:json.data.id},
					success:function(json2){
						if(json2.code==1){
							var html=parseSkma(json2.data);
							if(!itid||itid<1){
								if($('.skmaItem').eq(0)){
									$('.skmaItem').eq(0).before(html);
								}else{
									$('.payCOdeList ul').append(html);
								}
							}else{
								var skmaItemObj=$('.skmaItem[data-id="'+json.data.id+'"]');
								skmaItemObj.before(html);
								skmaItemObj.remove();
							}
						}
					}
				});
			}
		});
	});
	
	
	//删除
	$('body').on('click','.delItem',function(){
		var obj=$(this);
		var liObj=obj.parents('li');
		var item_id=liObj.attr('data-id');
		layer.open({
			content:'您确定要删除么？',
			style:'width:66%',
			btn:['确定','取消'],
			yes:function(idx){
				layer.close(idx);
				ajax({
					url:global.appurl+'c=Skma&a=skma_delete',
					data:{item_id:item_id},
					success:function(json){
						if(json.code!=1){
							_alert(json.msg);
							return;
						}
						_alert({
							content:json.msg,
							end:function(){
								//location.reload();
								liObj.fadeOut();
							}
						});
					}
				});
			}
		});
	});
	
	///////////////////////////////////////////////////////
	//查看收款码
	$('body').on('click','.maQrcodeBox',function(){
		var obj=$(this);
		var qrObj=obj.find('.paywayIco');
		var ma_qrcode=qrObj.attr('data-ma-qrcode');
		layer.open({
			content:'<div style="width:100%;text-align:center;"><img src="'+ma_qrcode+'"/></div>',
			style:'width:80%',
			btn:['关闭'],
			yes:function(idx){
				layer.close(idx);
			}
		});
	});
	
	//####格式化二维码####
	function parseSkma(item){
		if(!item){
			return '';
		}
		var html='';
		html+='<li class="skmaItem" data-id="'+item.id+'">';
			html+='<div class="ltbox">';
				html+='<p>类型：'+item.mtpye_name+'</p>';
				html+='<p>收款人：'+item.ma_realname+"("+item.ma_account+')</p>';
				if(item.mtype_type==3){
					html+='<p>开户行：'+item.bank_name+'</p>';
				}else if(item.mtype_type==2){
					html+='<p class="maQrcodeBox">收款码：<i class="paywayIco" data-ma-qrcode="'+item.ma_qrcode+'" style="background-image:url('+item.ma_qrcode+');position:relative;top:3px;"></i></p>';
				}
				//html+='<p>收益率：'+item.fy_rate+'%</p>';
				html+='<p>今日笔数：'+item.day_tcnt+'/'+item.day_tcnt2+'</p>';
				//html+='<p><a href="/?c=Skma&a=info&id='+item.id+'" style="color:#f30;">自动回调助手</a></p>';
			html+='</div>';
			html+='<div class="rtbox">';
				//!-- 两种状态on-line/off-line --
				var class_flag='on-line';
				if(item.status!=2){
					class_flag='off-line';
				}
				html+='<p class="statusItem">状态：<span class="state '+class_flag+'">'+item.status_flag+'</span></p>';
				//html+='<p class="maaccountItem">收款号：'+item.ma_account+'</p>';
				html+='<p>接单范围：'+item.min_money+"-"+item.max_money+'</p>';
				html+='<p>收益：'+item.yong_money+"("+item.fy_rate+"%)"+'</p>';
				html+='<p>成功率：'+item.day_percent+'</p>';
				html+='<p style="color:#fc744d;">';
					html+='<a class="delItem" style="margin-right:10px;">删除</a>';
					html+='<a class="editItem">修改</a>';
					if(item.mtype_type<=3){
						html+='<a class="testItem" style="margin-left:10px;">测试</a>';
					}
				html+='</p>';
			html+='</div>';
		html+='</li>';
		return html;
	}
	
	//获取记录
    $('.moreBtn').on('click',function(){
        dataPage({
            url:global.appurl+'c=Skma&a=skma_list',
            data:{mtype:'0',keyword:''},
            success:function(json){
                var html='';
                for(var i in json.data.list){
                    var item=json.data.list[i];
					html+=parseSkma(item);
                }
                $('.payCOdeList ul').append(html);
            }
        });
    });

    $('.moreBtn').trigger('click');
	
	$('body').on('click','.statusItem',function(){
		var obj=$(this);
		var skma_id=obj.parents('li').attr('data-id');
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=Skma&a=skma_set',
			data:{skma_id:skma_id},
			success:function(json){
				obj.attr('has-click','0');
				if(json.code!=1){
					if(json.code!='-1'){
						_alert({content:json.msg,time:5});
					}else{
						_alert(json.msg);
					}
					return;
				}
				var liObj=$('.skmaItem[data-id="'+skma_id+'"]');
				var statusObj=liObj.find('.statusItem .state');
				statusObj.removeClass('on-line off-line').text(json.data.status_flag);
				if(json.data.status==2){
					statusObj.addClass('on-line');
				}else{
					statusObj.addClass('off-line');
				}
			}
		});
	});
	
	/////////////////////////////////////////////////
	$('body').on('click','.testItem',function(){
		var obj=$(this);
		var liObj=obj.parents('li');
		var skma_id=liObj.attr('data-id');
		layer.open({
			content: '<div style="padding-bottom:10px;">金额：<input type="text" id="test_money" value="1" style="line-height:30px;padding:0 5px;width:60%;border-radius:3px;border:1px solid #dedede;" /></div><span style="color:#f60;">您确定要发起测试么？</span>',
			style:'width:65%',
			btn: ['确定', '不了'],
			yes: function(index){
				var money=$.trim($('#test_money').val());
				layer.close(index);
				ajax({
					url:global.appurl+'c=Skma&a=skma_test',
					data:{skma_id:skma_id,money:money},
					success:function(json){
						if(json.code!=1){
							if(json.code=='-2'){
								_alert({content:json.msg,time:5});
								return;
							}
							_alert(json.msg);
							return;
						}
						var item=json.data;
						var con='<div>';
							con+='<div>金额：<span style="font-size:22px;color:#f30;font-weight:bold;">￥'+item.money+'</span></div>';
							if(item.qrcode){
								con+='<div><img src="'+item.qrcode+'" style="width:100%;"/></div>';
							}else{
								if(item.mtype_type==3){
									con+='<div>开户行：'+item.bank+'</div>';
								}
							}
							con+='<div>姓名：'+item.realname+'</div>';
							con+='<div>账号：'+item.account+'</div>';
						con+='</div>';
						layer.open({
							content:con,
							style:'width:80%',
							shadeClose:false,
							btn: '我已付款'
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
