<?php /*%%SmartyHeaderCode:211645f96a77e8d6569-77851277%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c0693483f85854a87705642934d226bcb452067d' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\admin\\view\\Finance\\balance.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '211645f96a77e8d6569-77851277',
  'variables' => 
  array (
    'user' => 0,
    'djs_balance' => 0,
    'banklog_arr' => 0,
    'vo' => 0,
    'cash_time_str' => 0,
    'fee_str' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f96a77eac8de1_73583971',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f96a77eac8de1_73583971')) {function content_5f96a77eac8de1_73583971($_smarty_tpl) {?><div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>账户余额</span></div>
<div class="layui-card-body">
	<form class="layui-form layui-col-lg5">
		<div class="layui-form-item" style="margin-bottom:2px;">
			<label class="layui-form-label">账号：</label>
			<div class="layui-input-block" style="line-height:38px;">
				admin
			</div>
		</div>
		<!--码商-->
				<!--商户-->
		<div class="layui-form-item" style="margin-bottom:2px;">
			<label class="layui-form-label">可提余额：</label>
			<div class="layui-input-block" style="line-height:38px;">
				￥0
			</div>
		</div>
		<div class="layui-form-item" style="margin-bottom:2px;">
			<label class="layui-form-label">冻结金额：</label>
			<div class="layui-input-block" style="line-height:38px;">
				￥0
			</div>
		</div>
		<div class="layui-form-item" style="margin-bottom:2px;">
			<label class="layui-form-label">待结算：</label>
			<div class="layui-input-block" style="line-height:38px;">
				￥0
			</div>
		</div>
		
		<div class="layui-form-item">
			<label class="layui-form-label">银行卡：</label>
			<div class="layui-input-block" style="width:60%;">
				<select id="blog_id">
					<option value="0">请选择银行卡</option>
									</select>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">提现金额：</label>
			<div class="layui-input-block" style="width:60%;">
				<input type="text" id="money" autocomplete="off" placeholder="" class="layui-input">
				<div style="color:#f60;">单笔最小：￥100 ，单笔最大：￥50000 ，单日累计：￥10000000</div>
				<div style="color:#f60;">提现时间：周一至周日 00:00 - 23:59</div>
				<div style="color:#f30;">提现手续费 = 提现金额 × 0 + 3</div>
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
				<span class="layui-btn layui-btn-normal saveBtn">提现申请</span>
			</div>
		</div>
	</form>
	
	<div style="height:100px;clear:both;"></div>
</div>
</div>
</div>

<!--弹层-->
<script type="text/html" id="layerTpl">
	<form class="layui-form LayerForm" onsubmit="return false;">
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label balanceTit">{{d.item.title}}</label>
			<div class="layui-input-block" style="line-height:38px;padding-left:0;text-align:left;">
				<span class="balanceFlag">{{d.item.balance}}</span>
				<span class="layui-btn layui-btn-xs layui-btn-normal transAllBtn" style="margin-left:10px;">全部</span>
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">转出额度：</label>
			<div class="layui-input-block">
				<input type="text" id="z_money" placeholder="" autocomplete="off" class="layui-input" value="" />
			</div>
		</div>		
		<div class="layui-form-item">
			<div class="layui-input-block">
				<input type="hidden" id="ptype" value="0" />
				<span class="layui-btn" onclick="saveTrans(this)">提交保存</span>
			</div>
		</div>
	</form>
</script>

<script>

$('body').on('click','.transAllBtn',function(){
	var balance=$.trim($('.balanceFlag').text());
	$('#z_money').val(balance);
});

$('.transToBalance').on('click',function(){
	var obj=$(this);
	var ptype=obj.attr('data-type');
	var item={};
	if(ptype==1){
		title='可提现余额->接单余额';
		item.title='可提余额：';
		item.balance='0';
	}else if(ptype==2){
		title='接单余额->可提现余额';
		item.title='接单余额：';
		item.balance='0';
	}else{
		_alert('未知操作类型');
		return;
	}
	layer.open({
		title:title,
		type: 1,
		shadeClose: true,
		area: global.screenType < 2 ? ['80%', '300px'] : ['400px', '260px'],
		content: layui.laytpl($('#layerTpl').html()).render({item:item}),
		success:function(){
			$('#ptype').val(ptype);
			layui.form.render();
		}
	});
});

function saveTrans(ts){
	var obj=$(ts);
	var ptype=$('#ptype').val();
	var money=$.trim($('#z_money').val());
	if(!money||money<0.01){
		_alert('转出额度不正确');
		return;
	}
	var has_click=obj.attr('has-click');
	if(has_click=='1'){
		return false;
	}else{
		obj.attr('has-click','1');
	}
	ajax({
		url:global.appurl+'c=Finance&a=balanceTrans',
		data:{ptype:ptype,money:money},
		success:function(json){
			if(json.code!=1){
				obj.attr('has-click','0');
				_alert(json.msg);
				return;
			}
			layer.closeAll();
			_alert(
				json.msg,{},
				function(){
					location.reload();
				}
			);
		}
	});	
}

/////////////////////////////////////////////////////

$('.saveBtn').on('click',function(){
	var obj=$(this);
	var has_money='0'*1;
	var blog_id=$.trim($('#blog_id').val());
	var money=$.trim($('#money').val())*1;
	var password2=$.trim($('#password2').val());
	if(blog_id<1){
		_alert('请选择提现银行卡');
		return false;
	}
	if(!money||money<0.01){
		_alert('提现金额不正确');
		return false;
	}else{
		if(money>has_money){
			_alert('可提现金额不足');
			return false;
		}
	}
	if(!password2){
		_alert('请输入二级密码');
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
		url:global.appurl+'c=Finance&a=balance_cash',
		data:{blog_id:blog_id,money:money,password2:password2},
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
