<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 06:23:05
         compiled from "D:\phpstudy_pro\WWW\kv\admin\view\User\rsaset.html" */ ?>
<?php /*%%SmartyHeaderCode:211355f97bcc91fe360-85805352%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1bef0e7df5f371177c2d42637af76af94ad17a7d' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\User\\rsaset.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211355f97bcc91fe360-85805352',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'skey' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f97bcc922f153_91613326',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97bcc922f153_91613326')) {function content_5f97bcc922f153_91613326($_smarty_tpl) {?><style>
.layui-form-label{width:100px;}
.layui-input-block{margin-left:130px;}
</style>
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">
	<span>API对接</span>
</div>
<div class="layui-card-body">
	<form class="layui-form layui-col-lg6">
		<div class="layui-form-item" style="margin-bottom:2px;">
			<label class="layui-form-label">商户账号：</label>
			<div class="layui-input-block" style="line-height:38px;">
				<?php echo $_smarty_tpl->tpl_vars['user']->value['account'];?>

			</div>
		</div>
		<div class="layui-form-item" style="margin-bottom:2px;">
			<label class="layui-form-label">签名密钥：</label>
			<div class="layui-input-block" style="line-height:38px;">
				<?php if ($_smarty_tpl->tpl_vars['user']->value['apikey']) {?>
				<?php echo $_smarty_tpl->tpl_vars['user']->value['apikey'];?>

				<?php } else { ?>
				未生成
				<?php }?>
			</div>
		</div>
		<div class="layui-form-item" style="margin-bottom:2px;">
			<label class="layui-form-label">下单网关地址：</label>
			<div class="layui-input-block" style="line-height:38px;">
				<?php echo $_SERVER['REQUEST_SCHEME'];?>
://<?php echo $_SERVER['HTTP_HOST'];?>
/?c=Pay
			</div>
		</div>
		
		<div class="layui-form-item">
			<label class="layui-form-label">接口RSA加密：</label>
			<div class="layui-input-block">
				<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('sys_switch'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
				<input type="radio" name="is_rsa" lay-filter="is_rsa" value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['skey']->value==$_smarty_tpl->tpl_vars['user']->value['is_rsa']) {?>checked<?php }?>>
				<?php } ?>
			</div>
		</div>
		
		<div class="layui-form-item rsaItem" style="<?php if (!$_smarty_tpl->tpl_vars['user']->value['is_rsa']) {?>display:none;<?php }?>">
			<label class="layui-form-label">平台RSA公钥：</label>
			<div class="layui-input-block">
				<textarea class="layui-textarea" style="height:160px;resize:none;" readonly><?php echo getConfig('rsa_pt_public');?>
</textarea>
			</div>
		</div>
		<div class="layui-form-item rsaItem" style="<?php if (!$_smarty_tpl->tpl_vars['user']->value['is_rsa']) {?>display:none;<?php }?>">
			<label class="layui-form-label">商户RSA公钥：</label>
			<div class="layui-input-block">
				<textarea class="layui-textarea" id="rsa_public" style="height:160px;resize:none;" placeholder="复制生成的RSA公钥"><?php echo $_smarty_tpl->tpl_vars['user']->value['rsa_public'];?>
</textarea>
				<a href="/doc/tool.zip" style="color:#1E9FFF;" target="_blank">点击下载RSA生成工具</a>
			</div>
		</div>
		
		<div class="layui-form-item">
			<label class="layui-form-label">二级密码：</label>
			<div class="layui-input-block" style="width:40%;">
				<input type="password" id="password2" autocomplete="off" placeholder="" class="layui-input">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">&nbsp;</label>
			<div class="layui-input-block">
				<span class="layui-btn layui-btn-normal saveBtn">提交保存</span>
			</div>
		</div>
		
		<div class="layui-form-item">
			<label class="layui-form-label">&nbsp;</label>
			<div class="layui-input-block">
				<a href="/doc/api.zip?v=0.1" style="color:#f30;" target="_blank">点击下载对接文档</a>
			</div>
		</div>
	</form>
	
	<div style="height:50px;clear:both;"></div>
</div>
</div>
</div>

<?php echo '<script'; ?>
>

layui.form.on('radio(is_rsa)', function(data){
	if(data.value==1){
		$('.rsaItem').show();
	}else{
		$('.rsaItem').hide();
	}
});

$('.saveBtn').on('click',function(){
	var obj=$(this);
	var rsa_public=$.trim($('#rsa_public').val());
	var password2=$.trim($('#password2').val());
	var is_rsa=$('input[name="is_rsa"]:checked').val();
	if(!rsa_public){
		_alert('请填写您的RSA公钥');
		return false;
	}
	if(!password2){
		_alert('请填写二级密码');
		return false;
	}
	password2=md5(password2);
	var has_click=obj.attr('has-click');
	if(has_click=='1'){
		return false;
	}else{
		obj.attr('has-click','1');
	}
	ajax({
		url:global.appurl+'c=User&a=rsaset_update',
		data:{rsa_public:rsa_public,password2:password2,is_rsa:is_rsa},
		success:function(json){
			if(json.code!='1'){
				obj.attr('has-click','0');
				_alert(json.msg);
				return false;
			}
			_alert(json.msg,{},function(){
				location.reload();
			});
		}
	});
});


<?php echo '</script'; ?>
><?php }} ?>
