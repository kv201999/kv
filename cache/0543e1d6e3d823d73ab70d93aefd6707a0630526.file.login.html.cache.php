<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-11-01 15:08:41
         compiled from "D:\phpstudy_pro\WWW\kv\home\view\Login\login.html" */ ?>
<?php /*%%SmartyHeaderCode:151265f9e5ef9640183-01145728%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0543e1d6e3d823d73ab70d93aefd6707a0630526' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Login\\login.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '151265f9e5ef9640183-01145728',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9e5ef965a546_09066629',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9e5ef965a546_09066629')) {function content_5f9e5ef965a546_09066629($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

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

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>


<?php echo '<script'; ?>
>
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
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
