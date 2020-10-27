<?php /*%%SmartyHeaderCode:6297780135f970e902a1497-86404166%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b15f68135d6300b3109bbc76297d570ce12df0a2' => 
    array (
      0 => '/www/wwwroot/paofen123.com/admin/view/User/datatj.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6297780135f970e902a1497-86404166',
  'variables' => 
  array (
    's' => 0,
    'mtype_arr' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f970e902e9872_05218341',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f970e902e9872_05218341')) {function content_5f970e902e9872_05218341($_smarty_tpl) {?><div class="layui-card">
  <div class="layui-card-header">数据统计</div>
  <div class="layui-card-body layui-text">
  
	<form class="layui-form" id="searchForm" action="">
		<div class="layui-form-item" style="margin-bottom:5px;">
			<div class="layui-inline" style="margin-right:0;">
				<label class="layui-form-label" style="width:30px;">开始</label>
				<div class="layui-input-inline" style="width:120px;">
					<input name="s_start_time" id="s_start_time" value="2020-10-20" class="layui-input" placeholder="开始日期" />
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label" style="width:30px;">结束</label>
				<div class="layui-input-inline" style="width:120px;">
					<input name="s_end_time" id="s_end_time" value="2020-10-27" class="layui-input" placeholder="结束日期">
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label" style="width:60px;">支付类型</label>
				<div class="layui-input-inline" style="width:120px;">
					<select id="s_mtype_id" name="s_mtype_id">
						<option value="0">全部</option>
												<option value="1">支付宝(闲鱼)</option>
												<option value="3">银行卡(转账)</option>
											</select>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label">搜索团队</label>
				<div class="layui-input-inline">
				<input type="text" name="s_keyword2" id="s_keyword2" placeholder="请输入关键词" autocomplete="off" class="layui-input">
				</div>
			</div>
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
		<tbody id="tjBox">

		</tbody>
	</table>
	<div style="height:300px;"></div>
	
  </div>
</div>

<script>
$('#searchBtn').on('click',function(){
	var obj=$(this);
	var pdata={
		s_keyword:$.trim($('#s_keyword').val()),
		s_keyword2:$.trim($('#s_keyword2').val()),
		s_mtype_id:$.trim($('#s_mtype_id').val()),
		s_start_time:$.trim($('#s_start_time').val()),
		s_end_time:$.trim($('#s_end_time').val())
	};
	ajax({
		url:global.appurl+'c=User&a=datatj_list',
		data:pdata,
		success:function(json){
			if(json.code!=1){
				_alert(json.msg);
				return;
			}
			var data=json.data;
			var html='';
			html+='<tr style="background:#f1f1f2;">';
			  html+='<th>订单总数</th>';
			  html+='<th>订单总额</th>';
			  html+='<th>总手续费</th>';
			  html+='<th>昨日统计</th>';
			  html+='<th>成功订单数</th>';
			  html+='<th>成功订单总额</th>';
			  html+='<th>成功手续费</th>';
			  html+='<th>订单成功率</th>';
			  html+='<th style="font-weight:bold;">利润</th>';
			html+='</tr>';
			html+='<tr>';
				html+='<td>'+json.data.od_sum_cnt+'</td>';
				html+='<td>'+json.data.od_sum_money+'</td>';
				html+='<td>'+json.data.od_sum_fee+'</td>';
				html+='<td>￥<b>'+data.od_ok_money_ytoday+'</b> / <b>'+data.od_all_money_ytoday+'</b>，<b>'+data.od_ok_cnt_ytoday+'</b> / <b>'+data.od_all_cnt_ytoday+'</b>单，成功率：<b>'+data.od_ytdpercent+'</b></td>';
				html+='<td>'+json.data.od_ok_cnt+'</td>';
				html+='<td>'+json.data.od_ok_money+'</td>';
				html+='<td>'+json.data.od_ok_fee+'</td>';
				html+='<td>'+json.data.od_ok_percent+'%</td>';
				html+='<td>'+json.data.profit+'</td>';
			html+='</tr>';
			
			html+='<tr><td colspan="9">&nbsp;</td></tr>';
			
			html+='<tr style="background:#f1f1f2;">';
			html+='<th>码商充值</th>';
			html+='<th>码商提现</th>';
			html+='<th>商户提现</th>';
			html+='<th>今日统计</th>';
			html+='<th>码商余额</th>';
			html+='<th>码商冻结</th>';
			html+='<th>商户余额</th>';
			html+='<th>商户冻结</th>';
			html+='<th>卡余额</th>';
			html+='</tr>';
			
			html+='<tr>';
				html+='<td>'+json.data.ms_pay_money+'</td>';
				html+='<td>'+json.data.ms_cash_money+'</td>';
				html+='<td>'+json.data.sh_cash_money+'</td>';
				html+='<td>￥<b>'+data.od_ok_money_today+'</b> / <b>'+data.od_all_money_today+'</b>，<b>'+data.od_ok_cnt_today+'</b> / <b>'+data.od_all_cnt_today+'</b>单，成功率：<b>'+data.od_tdpercent+'</b></td>';
				html+='<td>'+json.data.ms_balance+'</td>';
				html+='<td>'+json.data.ms_fz_balance+'</td>';
				html+='<td>'+json.data.sh_balance+'</td>';
				html+='<td>'+json.data.sh_fz_balance+'</td>';
				html+='<td>'+json.data.card_money+'</td>';
			html+='</tr>';
			
			html+='<tr><td colspan="9">&nbsp;</td></tr>';
			html+='<tr style="background:#f1f1f2;">';
			html+='<th colspan="3">15分钟统计</th>';
			html+='<th colspan="1">30分钟统计</th>';
			html+='<th colspan="5">60分钟统计</th>';
			html+='</tr>';
			
			html+='<tr>';
				html+='<td colspan="3">￥<b>'+data.m15_ok.money+'</b> / <b>'+data.m15_all.money+'</b>，<b>'+data.m15_ok.cnt+'</b> / <b>'+data.m15_all.cnt+'</b>单，成功率：<b>'+data.m15_percent+'</b></td>';
				html+='<td colspan="1">￥<b>'+data.m30_ok.money+'</b> / <b>'+data.m30_all.money+'</b>，<b>'+data.m30_ok.cnt+'</b> / <b>'+data.m30_all.cnt+'</b>单，成功率：<b>'+data.m30_percent+'</b></td>';
				html+='<td colspan="5">￥<b>'+data.m60_ok.money+'</b> / <b>'+data.m60_all.money+'</b>，<b>'+data.m60_ok.cnt+'</b> / <b>'+data.m60_all.cnt+'</b>单，成功率：<b>'+data.m60_percent+'</b></td>';
			html+='</tr>';
			
			$('#tjBox').html(html);
		}
	});
});

$('#searchBtn').trigger('click');

$('#s_keyword').on('keyup',function(e){
	if(e.keyCode==13){
		$('#searchBtn').trigger('click');
	}
});
</script><?php }} ?>
