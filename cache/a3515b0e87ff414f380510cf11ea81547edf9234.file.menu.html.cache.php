<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-28 11:09:22
         compiled from "D:\phpstudy_pro\WWW\kv\home\view\menu.html" */ ?>
<?php /*%%SmartyHeaderCode:252405f995162cb31f2-00320840%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a3515b0e87ff414f380510cf11ea81547edf9234' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\menu.html',
      1 => 1603794667,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '252405f995162cb31f2-00320840',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f995162cbdd79_72200199',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f995162cbdd79_72200199')) {function content_5f995162cbdd79_72200199($_smarty_tpl) {?><!-- 底部导航栏 -->
<div class="BotMenu">
	<div class="wrap">
		<a href="/?c=Order" class="Link_1 <?php if (@constant('CONTROLLER_NAME')=='Order') {?>on<?php }?>">
			<div class="ico"></div>
			<p>订单</p>
		</a>
		<a href="/?c=Skma" class="Link_2 <?php if (@constant('CONTROLLER_NAME')=='Skma') {?>on<?php }?>">
			<div class="ico"></div>
			<p>收款码</p>
		</a>
		<a href="/" class="Link_3 <?php if (@constant('CONTROLLER_NAME')=='Default') {?>on<?php }?>">
			<div class="ico"></div>
			<p>首页</p>
		</a>
		<a href="/?c=Service&a=online" class="Link_4 <?php if (@constant('CONTROLLER_NAME')=='Service') {?>on<?php }?>">
			<div class="ico"></div>
			<p>新手指引</p>
		</a>
		<a href="/?c=User" class="Link_5 <?php if (@constant('CONTROLLER_NAME')=='User') {?>on<?php }?>">
			<div class="ico"></div>
			<p>我的</p>
		</a>
	</div>
</div><?php }} ?>
