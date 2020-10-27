<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-26 19:19:07
         compiled from "D:\phpstudy_pro\WWW\home\view\Finance\payInfo.html" */ ?>
<?php /*%%SmartyHeaderCode:324175f96b0ab534ff2-09338644%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '445c513ce3914926b6f5c1cabb7a2ee2ec8b92f6' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Finance\\payInfo.html',
      1 => 1603711143,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '324175f96b0ab534ff2-09338644',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'paylog' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f96b0ab55fa18_39085687',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f96b0ab55fa18_39085687')) {function content_5f96b0ab55fa18_39085687($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<style>
.bannerItem{margin-right:5px;position:relative;}
.bannerItem span{position:absolute;top:0px;right:0px;line-height:20px;font-size:28px;}

.orderDetailCon{line-height:2.2rem;}
</style>
<div class="orderDetail">
	<!-- 顶部 -->
	<div class="HeadTop">
		<p class="Tit">订单详情</p>
		<a href="/?c=Finance&a=pay" class="backBtn"></a>
	</div>
	<div class="orderDetailCon">
		<p>订单号：<?php echo $_smarty_tpl->tpl_vars['paylog']->value['order_sn'];?>
</p>

		<p >所属代理：<?php if ($_smarty_tpl->tpl_vars['paylog']->value['a_account']) {
echo $_smarty_tpl->tpl_vars['paylog']->value['a_account'];?>
-<?php echo $_smarty_tpl->tpl_vars['paylog']->value['a_nickname'];
} else { ?>平台<?php }?></p>
		<p>充值账号：<?php echo $_smarty_tpl->tpl_vars['paylog']->value['account'];?>
</p>
		<p>下单时间：<?php echo $_smarty_tpl->tpl_vars['paylog']->value['create_time'];?>
</p>
		<p>订单状态：<b><?php echo $_smarty_tpl->tpl_vars['paylog']->value['pay_status_flag'];?>
</b></p>
		<p>收款姓名：<?php echo $_smarty_tpl->tpl_vars['paylog']->value['skbank']['bank_realname'];?>
</p>
		<p style="font-weight:bold;color: red">订单金额：￥<?php echo $_smarty_tpl->tpl_vars['paylog']->value['money'];?>
</p>
		<p style="font-weight:bold;">收款卡号：<?php echo $_smarty_tpl->tpl_vars['paylog']->value['skbank']['bank_account'];?>
</p>

		<?php if ($_smarty_tpl->tpl_vars['paylog']->value['pay_status']==1) {?>
		<a href="javascript:;" class="fillCashBtn" style="margin-top:1rem;">我已付款</a>
		<?php }?>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
 src="/public/js/lrz.all.bundle.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
preventDefault();
$(function(){


	$('#fileUploadH5Btn').on('click',function(){
		$('#fileUploadH5').trigger('click');
	});
	

	$('body').on('click','.bannerItem span',function(){
		var obj=$(this);
		obj.parent('.bannerItem').remove();
		if($('.bannerItem').length>=3){
			$('#fileUploadH5Btn').hide();
		}else{
			$('#fileUploadH5Btn').show();
		}
	});
	
	$('body').on('click','.bannerItem img',function(){
		var obj=$(this);
		var src=obj.attr('src');
		layer.open({
			content:'<div style="width:100%;text-align:center;"><img src="'+src+'"/></div>',
			style:'width:80%',
			btn:['关闭'],
			yes:function(idx){
				layer.close(idx);
			}
		});
	});


	
	$('.fillCashBtn').on('click',function(){
		var obj=$(this);
		var osn='<?php echo $_smarty_tpl->tpl_vars['paylog']->value['order_sn'];?>
';
		layer.open({
			//title:'',
			content:'您确定提交已付款状态么？',
			style:'width:65%',
			btn:['确定','取消'],
			yes:function(idx){
				layer.close(idx);
				ajax({
					url:global.appurl+'c=Finance&a=payUpdate',
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
