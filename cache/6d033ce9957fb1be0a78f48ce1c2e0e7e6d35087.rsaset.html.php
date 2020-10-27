<?php /*%%SmartyHeaderCode:214278665f970df0058457-09136720%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d033ce9957fb1be0a78f48ce1c2e0e7e6d35087' => 
    array (
      0 => '/www/wwwroot/paofen123.com/admin/view/User/rsaset.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '214278665f970df0058457-09136720',
  'variables' => 
  array (
    'user' => 0,
    'skey' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f970df00fb939_86675279',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f970df00fb939_86675279')) {function content_5f970df00fb939_86675279($_smarty_tpl) {?><style>
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
				admin
			</div>
		</div>
		<div class="layui-form-item" style="margin-bottom:2px;">
			<label class="layui-form-label">签名密钥：</label>
			<div class="layui-input-block" style="line-height:38px;">
								未生成
							</div>
		</div>
		<div class="layui-form-item" style="margin-bottom:2px;">
			<label class="layui-form-label">下单网关地址：</label>
			<div class="layui-input-block" style="line-height:38px;">
				http://paofen123.com/?c=Pay
			</div>
		</div>
		
		<div class="layui-form-item">
			<label class="layui-form-label">接口RSA加密：</label>
			<div class="layui-input-block">
								<input type="radio" name="is_rsa" lay-filter="is_rsa" value="1" title="开启" >
								<input type="radio" name="is_rsa" lay-filter="is_rsa" value="0" title="关闭" checked>
							</div>
		</div>
		
		<div class="layui-form-item rsaItem" style="display:none;">
			<label class="layui-form-label">平台RSA公钥：</label>
			<div class="layui-input-block">
				<textarea class="layui-textarea" style="height:160px;resize:none;" readonly>-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIC69RsIl4yeUhBdeHYxTMCEQQ
csy2P4bT7LpciebpoHT1U9wv4rtpD4FAVecpp57S8CQ9IcOo/MyLNzIikw6FGi3D
J5sLQ82kRf21B4CUOL8NHSPsheJ3k1by+IfkmWMwjpglwbZvseT9NJEBN1R6V24N
zD+1z+RPM2YKVq0dNQIDAQAB
-----END PUBLIC KEY-----</textarea>
			</div>
		</div>
		<div class="layui-form-item rsaItem" style="display:none;">
			<label class="layui-form-label">商户RSA公钥：</label>
			<div class="layui-input-block">
				<textarea class="layui-textarea" id="rsa_public" style="height:160px;resize:none;" placeholder="复制生成的RSA公钥"></textarea>
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

<script>

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


</script><?php }} ?>
