<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 01:58:06
         compiled from "/www/wwwroot/paofen123.com/admin/view/User/sjuser.html" */ ?>
<?php /*%%SmartyHeaderCode:2579022765f970e2e6030a6-28053995%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f0d0c01e954f0ec2708174d85750c0b12e08af1b' => 
    array (
      0 => '/www/wwwroot/paofen123.com/admin/view/User/sjuser.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2579022765f970e2e6030a6-28053995',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f970e2e6313d5_86300264',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f970e2e6313d5_86300264')) {function content_5f970e2e6313d5_86300264($_smarty_tpl) {?><div class="layui-card">
  <div class="layui-card-header">上级查询</div>
  <div class="layui-card-body layui-text">
  
	<form class="layui-form" id="searchForm" action="">
		<div class="layui-form-item" style="margin-bottom:5px;">
			<div class="layui-inline">
				<label class="layui-form-label">关键词</label>
				<div class="layui-input-inline">
				<input type="text" name="s_keyword" id="s_keyword" placeholder="请输入关键词" autocomplete="off" class="layui-input">
				</div>
			</div>
			<div class="layui-inline">
				<div class="layui-input-inline">
				<span class="layui-btn" id="searchBtn">查询</span>
				<!--<span class="layui-btn layui-btn-danger">导出</span>-->
				</div>
			</div>
		</div>
	</form>
	

	<table class="layui-table">
	  <tbody>
		<thead>
			<tr>
			  <th>ID</th>
			  <th>层级</th>
			  <th>账号</th>
			  <th>手机号</th>
			  <th>分组</th>
			  <th>昵称</th>
			  <th>姓名</th>
			  <th>邀请码</th>
			</tr>
		</thead>
		<tbody id="tjBox">
			<tr>
				<td colspan="8">暂无数据</td>
			</tr>
		</tbody>
	  </tbody>
	</table>
	<div style="height:300px;"></div>
	
  </div>
</div>

<?php echo '<script'; ?>
>
$('#searchBtn').on('click',function(){
	var obj=$(this);
	var pdata={
		s_keyword:$.trim($('#s_keyword').val()),
	};
	ajax({
		url:global.appurl+'c=User&a=sjuser_list',
		data:pdata,
		success:function(json){
			if(json.code!=1){
				_alert(json.msg);
				return;
			}
			var html='';
			for(var i in json.data.list){
				var item=json.data.list[i];
				html+='<tr>';
					html+='<td>'+item.id+'</td>';
					html+='<td>'+item.agent_level+'</td>';
					html+='<td>'+item.account+'</td>';
					html+='<td>'+item.phone+'</td>';
					html+='<td>'+item.gname+'</td>';
					html+='<td>'+item.nickname+'</td>';
					html+='<td>'+item.realname+'</td>';
					html+='<td>'+item.icode+'</td>';
				html+='</tr>';
			}
			if(!html){
				html='<tr><td colspan="8"></td></tr>';
			}
			$('#tjBox').html(html);
		}
	});
});

//$('#searchBtn').trigger('click');

$('#s_keyword').on('keyup',function(e){
	if(e.keyCode==13){
		$('#searchBtn').trigger('click');
	}
});
<?php echo '</script'; ?>
><?php }} ?>
