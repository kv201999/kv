<?php /*%%SmartyHeaderCode:18833954345f9785247b5394-43662781%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '40aa177c16c203d92e5e319a9296175fcd034ab6' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/Login/login.html',
      1 => 1578476498,
      2 => 'file',
    ),
    '4b7133a76229f2c1960bdc4a61a1d43d468ee5b8' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/head.html',
      1 => 1578476498,
      2 => 'file',
    ),
    '6dfe1b88c9fd492b894f064fc8fa911676e42650' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/js.html',
      1 => 1578476498,
      2 => 'file',
    ),
    'ab59b13474c191ec627b740bc472d81a3bfa27b2' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/foot.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18833954345f9785247b5394-43662781',
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f978524807322_38823357',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f978524807322_38823357')) {function content_5f978524807322_38823357($_smarty_tpl) {?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>登录</title>
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
<div class="Login">
	<div class="LoginCon" style="padding-top:14rem;">
		<div class="inputbox phone"><input type="text" id="phone" placeholder="请填写手机账号"></div>
		<div class="inputbox password"><input type="password" id="password" placeholder="请填写密码"></div>
		<div class="inputbox password"><input type="text" id="gcode" placeholder="谷歌验证码-未开启请忽略"></div>
		<div class="inputbox txCode">
			<input type="text" id="imgcode" placeholder="图形验证码">
			<a href="javascript:;" class="txImage"><img id="imgcodeBtn" src="/?c=Login&a=varify_code"></a>
		</div>
		<p><a href="/?c=Login&a=register" class="registerLink">立即注册</a><a href="/?c=Login&a=forget" class="lossPassLink">忘记密码？</a></p>
		<a href="javascript:;" class="LoginBtn">登录</a>
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

<script>
$(function(){

	$('#imgcodeBtn').on('click',function(){
		var obj=$(this);
		var src='/?c=Login&a=varify_code&rt='+Math.random();
		obj.attr('src',src);
	});

	$('.LoginBtn').on('click',function(){
		var obj=$(this);
		var phone=$.trim($('#phone').val());
		var password=$.trim($('#password').val());
		var imgcode=$.trim($('#imgcode').val());
		var gcode=$.trim($('#gcode').val());
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return ;
		}else{
			obj.attr('has-click','1');
		}
		password=md5(password);
		ajax({
			url:global.appurl+'c=Login&a=loginAct',
			data:{phone:phone,password:password,imgcode:imgcode,gcode:gcode},
			success:function(json){
				if(json.code!=1){
					obj.attr('has-click','0');
					$('#imgcodeBtn').trigger('click');
					_alert(json.msg);
					return;
				}
				
				var localData={account:json.data.account};
				localData[global.tokenName]=json.data.token;
				updateLocalTable(global.tableName,localData);

				_alert({
					content:json.msg,
					end:function(){
						location.href=json.data.url
					}
				});
			}
		});
	});


});
</script>
</body>
</html><?php }} ?>