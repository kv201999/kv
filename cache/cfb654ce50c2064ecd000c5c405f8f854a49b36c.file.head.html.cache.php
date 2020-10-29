<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-29 03:54:37
         compiled from "D:\phpstudy_pro\WWW\kv\home\view\head.html" */ ?>
<?php /*%%SmartyHeaderCode:200535f9a3cfd09f531-55049828%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cfb654ce50c2064ecd000c5c405f8f854a49b36c' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\head.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '200535f9a3cfd09f531-55049828',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9a3cfd0a4524_00550127',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9a3cfd0a4524_00550127')) {function content_5f9a3cfd0a4524_00550127($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
<meta name="apple-touch-fullscreen" content="YES" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="email=no" name="format-detection" />
<meta http-equiv="Expires" content="-1" />
<meta http-equiv="pragram" content="no-cache" />
<link rel="stylesheet" type="text/css" href="public/layer/need/layer.css">
<?php if ($_ENV['mobile']) {?>
<link rel="stylesheet" type="text/css" href="public/home/css/mainStyle.css?v=0.41">
<?php echo '<script'; ?>
 type="text/javascript" src="public/home/js/init.js?v=0.41"><?php echo '</script'; ?>
>
<?php } else { ?>
<link rel="stylesheet" type="text/css" href="public/home/css/mainStylePc.css?v=0.41">
<?php }?>
<style>
.moreBtn,.noData{text-align:center;font-size: 1.2rem;padding: 0.8rem 0;color: #666;}
</style>
<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>
</head>
<body><?php }} ?>
