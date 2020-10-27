<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-26 11:39:29
         compiled from "D:\phpstudy_pro\WWW\home\view\Finance\pay.html" */ ?>
<?php /*%%SmartyHeaderCode:305205f96b571e218a2-87086153%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '48359043a0f52f930effbcc1d67b6f6eecd8f49b' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Finance\\pay.html',
      1 => 1603712365,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '305205f96b571e218a2-87086153',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'paylog' => 0,
    'bank_arr' => 0,
    'vo' => 0,
    'skey' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f96b571e4adf1_31458904',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f96b571e4adf1_31458904')) {function content_5f96b571e4adf1_31458904($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>


<div class="fillCash">
	<!-- 顶部 -->
	<div class="HeadTop">
		<p class="Tit">充值</p>
		<a href="/?c=User" class="backBtn"></a>
		<a href="/?c=Finance&a=paylog" class="rightBtn">充值记录</a>
	</div>
	<div class="fillCashCon">
		<p class="userId">账号：<?php echo $_smarty_tpl->tpl_vars['user']->value['account'];?>
</p>
		<div class="fillCashNum">充值USDT：
			<div class="inputbox"><input type="text" id="money" placeholder="请填写充值USDT数量" ></div>
		</div>
		<div style="padding:20px 20px;color:#999;">
			<div>当前火币价格为：<?php echo $_smarty_tpl->tpl_vars['paylog']->value['order_sn'];?>
请注册火币网，购买USDT后进行充值，仅支持TRC20</div>
		</div>
		<h1 style="display: none">请选择收款账户</h1>
		<div class="paywayList" style="display: none">
			<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bank_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
			<a style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['vo']->value['cover'];?>
);" href="javascript:;" class="alipay <?php if ($_smarty_tpl->tpl_vars['skey']->value==0) {?>on<?php }?>" data-id="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><p><?php echo $_smarty_tpl->tpl_vars['vo']->value['bank_name'];
if ($_smarty_tpl->tpl_vars['vo']->value['uid']) {?>【代理-<?php echo $_smarty_tpl->tpl_vars['vo']->value['nickname'];?>
】<?php }?></p></a>
			<?php } ?>
		</div>
		<a href="javascript:;" class="fillCashBtn" style="margin-top:2rem;">充值</a>

	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
>
preventDefault();
$(function(){
	
	$('.alipay').on('click',function(){
		var obj=$(this);
		$('.alipay').removeClass('on');
		obj.addClass('on');
	});
	
	$('.fillCashBtn').on('click',function(){
		var obj=$(this);
		var money=$.trim($('#money').val());
		var skbank_id=$('.paywayList .on').attr('data-id');
		if(!money){
			_alert('请填写充值额度');
			return;
		}
		if(!skbank_id){
			_alert('请选择收款账户');
			return;
		}
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=Finance&a=payAct',
			data:{skbank_id:skbank_id,money:money},
			success:function(json){
				if(json.code!=1){
					obj.attr('has-click','0');
					_alert(json.msg);
					return;
				}
				_alert({
					content:json.msg,
					end:function(){
						var url=global.appurl+'c=Finance&a=payInfo&osn='+json.data.order_sn;
						location.href=url;
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
