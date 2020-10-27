<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 15:43:18
         compiled from "D:\phpstudy_pro\WWW\kv\home\view\Finance\payInfo.html" */ ?>
<?php /*%%SmartyHeaderCode:320945f97cf967ff7c6-17173306%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f3f4a138cab0934f201fee75cf5750664be84467' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Finance\\payInfo.html',
      1 => 1603784367,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '320945f97cf967ff7c6-17173306',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'paylog' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f97cf9682af95_11961765',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97cf9682af95_11961765')) {function content_5f97cf9682af95_11961765($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

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
		<p style="font-weight:bold;color: red">订单金额：<?php echo $_smarty_tpl->tpl_vars['paylog']->value['money'];?>
</p>
		<p style="font-weight:bold;">充值钱包地址：<?php echo $_smarty_tpl->tpl_vars['paylog']->value['skbank']['bank_account'];?>
</p>
		<p>----------</p>
		<h3>充值教程：</h3>
		<p>1.火币网注册实名 2.OTC购买USDT 3.选择提币到上面地址</p>
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
