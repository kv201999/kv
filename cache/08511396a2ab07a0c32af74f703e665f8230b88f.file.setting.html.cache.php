<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-21 18:22:22
         compiled from "D:\phpstudy_pro\WWW\home\view\User\setting.html" */ ?>
<?php /*%%SmartyHeaderCode:292065f900bde802aa7-73951512%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '08511396a2ab07a0c32af74f703e665f8230b88f' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\User\\setting.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '292065f900bde802aa7-73951512',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f900bde837128_69438967',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f900bde837128_69438967')) {function content_5f900bde837128_69438967($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>


<div class="Set">
	<div class="HeadTop">
		<p class="Tit">设置</p>
		<a href="/?c=User" class="backBtn"></a>
	</div>
	<div class="SetCon">		
		<div class="linkRow">
			<a href="/?c=User&a=password"><p>修改登录密码</p></a>
		</div>
		<div class="linkRow">
			<a href="/?c=User&a=password2"><p>修改二级密码</p></a>
		</div>
		<div class="linkRow">
			<a href="/?c=User&a=google"><p>谷歌验证</p></a>
		</div>
		<a href="/?c=Login&a=logoutAct" class="exitLoginBtn">退出登录</a>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
>
preventDefault();
$(function(){

});
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
