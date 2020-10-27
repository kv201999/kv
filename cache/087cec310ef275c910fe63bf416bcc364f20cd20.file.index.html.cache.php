<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 16:56:57
         compiled from "D:\phpstudy_pro\WWW\kv\home\view\Order\index.html" */ ?>
<?php /*%%SmartyHeaderCode:138875f97e0d9416706-97247737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '087cec310ef275c910fe63bf416bcc364f20cd20' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Order\\index.html',
      1 => 1603788225,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '138875f97e0d9416706-97247737',
  'function' => 
  array (
  ),
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
  'unifunc' => 'content_5f97e0d94545f9_03476946',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97e0d94545f9_03476946')) {function content_5f97e0d94545f9_03476946($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

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
			<select id="pstatus" style="<?php if ($_smarty_tpl->tpl_vars['is_msdbhk']->value) {?>width:6rem;<?php }?>padding-right:0.1rem;">
				<option value="0">支付状态</option>
				<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_pay_status'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
				<?php } ?>
			</select>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['is_msdbhk']->value) {?>
		<div class="searchbox" style="width:50%;">
			<input type="text" id="keyword" placeholder="请输入关键词">
			<a href="javascript:;" class="serachBtn">搜索</a>
			<a href="javascript:;" class="serachBtn2">回款</a>
			<input type="hidden" id="s_hk_type" value="0"/>
		</div>
		<?php } else { ?>
		<div class="searchbox">
			<input type="text" id="keyword" placeholder="请输入关键词">
			<a href="javascript:;" class="serachBtn">搜索</a>
		</div>
		<?php }?>
		<div class="datebox">
			<div class="inp">
				<input type="text" id="s_start_time" placeholder="开始日期" onfocus="this.blur();">
			</div>
			<span>-</span>
			<div class="inp">
				<input type="text" id="s_end_time" placeholder="结束日期" onfocus="this.blur();">
			</div>
		</div>
		<div class="userState <?php if ($_smarty_tpl->tpl_vars['user']->value['is_online']==1) {?>on-line<?php } else { ?>off-line<?php }?>"><?php echo $_smarty_tpl->tpl_vars['user']->value['is_online_flag'];?>
</div>
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
	<?php echo $_smarty_tpl->getSubTemplate ("menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

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
						<div>银行：<?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_name'];?>
</div>
						<?php if ($_smarty_tpl->tpl_vars['bank']->value['branch_name']) {?>
						<div>支行：<?php echo $_smarty_tpl->tpl_vars['bank']->value['branch_name'];?>
</div>
						<?php }?>
						<div style="margin-bottom:5px;">姓名：<?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_realname'];?>
 <span class="cpBtn" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_realname'];?>
">复制</span></div>
						<div>卡号：<?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_account'];?>
 <span class="cpBtn" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_account'];?>
">复制</span></div>
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
				<div class="Row codeImgBox" style="<?php if ($_smarty_tpl->tpl_vars['s']->value['mtype']==3) {?>display:none;<?php }?>">
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

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
 src="/public/mdate/iScroll.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/public/mdate/Mdate.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="public/js/clipboard.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/public/js/lrz.all.bundle.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
isOrderPage=true;
var is_msdbhk='<?php echo $_smarty_tpl->tpl_vars['is_msdbhk']->value;?>
';

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
			html+='<p class="amount">'+item.money+'</p>';
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
	var cnf_mscheck_needpwd='<?php echo getConfig("cnf_mscheck_needpwd");?>
';
	
	$('body').on('click','.payConfirmBtn',function(){
		var obj=$(this);
		var liObj=obj.parents('li');
		var osn=liObj.attr('data-osn');
		var item=nowlist[osn];
		var con='确定已收到<b style="color:#fc744d;font-size:20px;">'+item.money+'</b>';
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
		var bank_account='<?php echo $_smarty_tpl->tpl_vars['bank']->value['bank_account'];?>
';
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
		$('#hk_money').text(item.hk_money).attr('data-money',item.hk_money);
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
		var bk_id='<?php echo $_smarty_tpl->tpl_vars['bank']->value['id'];?>
';
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
