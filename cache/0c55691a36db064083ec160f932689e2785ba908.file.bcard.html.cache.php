<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 16:13:13
         compiled from "D:\phpstudy_pro\WWW\kv\home\view\User\bcard.html" */ ?>
<?php /*%%SmartyHeaderCode:124445f97d6998648d7-84777256%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c55691a36db064083ec160f932689e2785ba908' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\User\\bcard.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '124445f97d6998648d7-84777256',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'bank_arr' => 0,
    'vo' => 0,
    'banklog' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f97d69988ade0_04723817',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97d69988ade0_04723817')) {function content_5f97d69988ade0_04723817($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<style>
.layui-upload-file{display: none;}
</style>

<div class="bindCard">
	<!-- 顶部 -->
	<div class="HeadTop">
		<p class="Tit">绑定银行卡</p>
		<a href="/?c=User" class="backBtn"></a>
	</div>
	<div class="bindCardCon">
		<div class="Wrap">
			<div class="Row userid">
				<div class="ltbox">账号：</div>
				<div class="rtbox"><?php echo $_smarty_tpl->tpl_vars['user']->value['phone'];?>
</div>
			</div>
			<div class="Row">
				<div class="ltbox">验证码：</div>
				<div class="rtbox">
					<div class="Insert code"><input type="text" id="smscode"></div>
					<a href="javascript:;" class="clickget" style="top:2px;width:6rem;">点击获取</a>
				</div>
			</div>
			<div class="Row">
				<div class="ltbox">开户行：</div>
				<div class="rtbox" style="background: #fff url('/public/home/images/sanjiao.png') no-repeat 96% center/1rem auto;border: 1px solid #d5d5d5;">
					<select id="bank_id" style="width:20rem;appearance: none;-moz-appearance: none;-webkit-appearance: none;background: transparent;border: 0;height: 3rem;padding: 0 1rem;">
						<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['bank_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['bank_name'];?>
</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="Row">
				<div class="ltbox">姓名：</div>
				<div class="rtbox">
					<div class="Insert"><input type="text" id="bank_realname" value="<?php echo $_smarty_tpl->tpl_vars['banklog']->value['bank_realname'];?>
" ></div>
				</div>
			</div>
			<div class="Row">
				<div class="ltbox">卡号：</div>
				<div class="rtbox">
					<div class="Insert"><input type="text" id="bank_account" value="<?php echo $_smarty_tpl->tpl_vars['banklog']->value['bank_account'];?>
" ></div>
				</div>
			</div>
			<a href="javascript:;" class="bindBtn">绑定</a>
		</div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
>
preventDefault();
$(function(){
	
	var ini_bank_id='<?php echo $_smarty_tpl->tpl_vars['banklog']->value['bank_id'];?>
';
	if(ini_bank_id){
		$('#bank_id').val(ini_bank_id);
	}

	$('.clickget').on('click',function(){
		var obj=$(this);
		var phone='';
		if(obj.attr('is-timer')){
			return true;
		}
		ajax({
			url:global.appurl+'a=getPhoneCode',
			data:{phone:phone,stype:5},
			success:function(json){
				if(json.code!=1){
					_alert(json.msg);
					return;
				}
				smsTimer(obj);
			}
		});
	});
	
	$('.bindBtn').on('click',function(){
		var obj=$(this);
		var bank_id=$.trim($('#bank_id').val());
		var bank_realname=$.trim($('#bank_realname').val());
		var bank_account=$.trim($('#bank_account').val());
		var idcard=$.trim($('#idcard').val());
		var smscode=$.trim($('#smscode').val());
		var zfb_account=$.trim($('#zfb_account').val());
		var zfb_qrcode=$.trim($('#zfb_qrcode').val());
		var wx_account=$.trim($('#wx_account').val());
		var wx_qrcode=$.trim($('#wx_qrcode').val());
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=User&a=bcardAct',
			data:{bank_id:bank_id,bank_realname:bank_realname,bank_account:bank_account,idcard:idcard,zfb_account:zfb_account,zfb_qrcode:zfb_qrcode,wx_account:wx_account,wx_qrcode:wx_qrcode,smscode:smscode},
			success:function(json){
				if(json.code!=1){
					obj.attr('has-click','0');
					_alert(json.msg);
					return;
				}
				_alert({
					content:json.msg,
					end:function(){
						location.href='/?c=User';
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
