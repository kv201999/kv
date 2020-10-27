<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-21 17:13:58
         compiled from "D:\phpstudy_pro\WWW\home\view\Pay\test.html" */ ?>
<?php /*%%SmartyHeaderCode:99045f8ffbd6be1be7-14745703%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5dcd9396c563b234ac421a8a2cbf8d32059a932b' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Pay\\test.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '99045f8ffbd6be1be7-14745703',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'mtype_arr' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f8ffbd6c51135_32646629',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f8ffbd6c51135_32646629')) {function content_5f8ffbd6c51135_32646629($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<div class="yingyong">
	<div class="HeadTop">
		<p class="Tit">测试通道</p>
		<!--<a href="javacript:;" class="backBtn"></a>-->
	</div>
	<div class="yingyongCon">
		<div class="fillCashNum">金额：<div class="inputbox"><input type="text" id="money" value="10"></div></div>
		<h1>请选择支付方式</h1>
		<div class="paywayList">
			<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mtype_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
			<a href="javascript:;" data-id="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
" class="<?php if (in_array($_smarty_tpl->tpl_vars['vo']->value['id'],array(1,11,12))) {?>alipay<?php } elseif (in_array($_smarty_tpl->tpl_vars['vo']->value['id'],array(2,4,5))) {?>wxpay<?php } elseif ($_smarty_tpl->tpl_vars['vo']->value['id']==3) {?>bankCardpay<?php } else { ?>bankCardpay<?php }?> <?php if ($_smarty_tpl->tpl_vars['vo']->value['id']==1) {?>on<?php }?>"><p><?php echo $_smarty_tpl->tpl_vars['vo']->value['name'];?>
</p></a>
			<?php } ?>
		</div>
		<a href="javascript:;" class="fillCashBtn">充值</a>
		<div class="warmTips" style="color:#fc744d;">
			<p class="title" style="color:#fc744d;">温馨提示：</p>
			1、本页面为应用测试页面<br>
			2、请使用小额进行测试<br>
		</div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
>
preventDefault();
needSocket=false;
$(function(){

	$('.paywayList a').on('click',function(){
		var obj=$(this);
		$('.paywayList a').removeClass('on');
		obj.addClass('on');
	});
	
	$('.fillCashBtn').on('click',function(){
		var obj=$(this);
		var money=$.trim($('#money').val());
		if(!money||money<0.01){
			_alert('充值金额不正确');
			return;
		}
		var ptype=$('.paywayList .on').attr('data-id');
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=Pay&a=testAct',
			data:{ptype:ptype,money:money},
			beforeSend:function(){
				layer.open({type:2});
			},
			success:function(json){
				setTimeout(function(){
					layer.closeAll();
					if(json.code!=1){
						obj.attr('has-click','0');
						if(json.code=='-2'){
							_alert({content:json.msg,time:6});
						}else{
							_alert(json.msg);
						}
						return;
					}
					location.href=json.data.url;
				},1200);
			}
		});
	});
});
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
