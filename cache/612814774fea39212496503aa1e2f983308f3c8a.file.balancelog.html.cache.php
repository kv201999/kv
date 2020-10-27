<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-08 13:48:48
         compiled from "D:\phpstudy_pro\WWW\home\view\Finance\balancelog.html" */ ?>
<?php /*%%SmartyHeaderCode:317025f7ea840de63b9-62242421%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '612814774fea39212496503aa1e2f983308f3c8a' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Finance\\balancelog.html',
      1 => 1602039578,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '317025f7ea840de63b9-62242421',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'skey' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f7ea8414e6f05_70844763',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f7ea8414e6f05_70844763')) {function content_5f7ea8414e6f05_70844763($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<style>
.CommissionCon .detailBox tr td{line-height:2rem;padding:4px 8px;}
.viewBtn{padding:2px 8px;border:1px solid #fc744d;color:#fc744d;border-radius:3px;}

.time_input{width:22%;line-height:1.9rem;padding:0 0.2rem;border:1px solid #aaa;border-radius:3px;}
.serachBtn2,.downloadBtn {
	cousor:pointer;
    display: inline-block;
    color: #fff;
    background: #1E9FFF;
    line-height: 1.8rem;
    text-align: center;
    font-size: 1rem;
    border-radius: 0.2rem;
	padding:0.1rem 0.5rem;
}
.CommissionCon .detailBox table tr td{width:16.6% !important;}
.getDateBox .choiceDateTitle button{color:#fc744d !important;}
</style>

<div class="Commission">
	<div class="HeadTop" style="z-index:2;">
		<p class="Tit">资金变动明细</p>
		<a href="/?c=User" class="backBtn"></a>
	</div>
	<div class="CommissionCon">
		<form id="searchForm">
			<div style="padding:0.5rem;">
				<input class="time_input" id="s_start_time" placeholder="开始日期"/> -
				<input class="time_input" id="s_end_time" placeholder="结束日期"/>
				<select id="s_type" style="height:2rem;line-height:2rem;width:90px;border-radius:3px;position:relative;top:1px;">
					<option value="0">全部类型</option>
					<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_balance_type'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
					<?php if (!in_array($_smarty_tpl->tpl_vars['skey']->value,array(3,5,7,11))) {?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
					<?php }?>
					<?php } ?>
				</select>
				<span class="serachBtn2">查询</span>
				<span class="downloadBtn" id="downloadBtn" style="background:#fc744d;">导出</span>
				<input type="hidden" name="is_download" id="is_download"/>
			</div>
		</form>
		<div class="detailBox">
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr style="font-weight:bold;">
						<td>时间</td>
						<td>类型</td>
						<td>原余额</td>
						<td>变更金额</td>
						<td>现余额</td>
						<td>备注</td>
					</tr>
				</thead>
				<tbody id="listBox">
					<!--
					<tr>
						<td>DD</td>
						<td>268</td>
						<td>268</td>
						<td>2019-7-18</td>
					</tr>
					-->
				</tbody>
			</table>
			<div class="moreBtn" style="text-align:center;">点击加载更多</div>
		</div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
 src="/public/mdate/iScroll.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/public/mdate/Mdate.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

$(function(){

	new Mdate("s_start_time", {
		beginYear: "2019",
		endYear: "2025",
		beginMonth: "1",
		beginDay: "1",
		format: "-"	//此项为Mdate需要显示的格式，可填写"/"或"-"或".",不填写默认为年月日
	});
	
	new Mdate("s_end_time", {
		beginYear: "2019",
		beginMonth: "1",
		beginDay: "1",
		endYear: "2025",
		format: "-"	//此项为Mdate需要显示的格式，可填写"/"或"-"或".",不填写默认为年月日
	});
	
	//获取充值记录
    $('.moreBtn').on('click',function(){
        dataPage({
            url:global.appurl+'c=Finance&a=balancelog_list',
            data:{
				s_type:$('#s_type').val(),
				s_start_time:$('#s_start_time').val(),
				s_end_time:$('#s_end_time').val(),
			},
            success:function(json){
                var html='';
                for(var i in json.data.list){
                    var item=json.data.list[i];
                    html+='<tr>';
                        html+='<td>'+item.create_time+'</td>';
                        html+='<td>'+item.type_flag+'</td>';
                        html+='<td>'+item.ori_balance+'</td>';
						html+='<td>'+item.money+'</td>';
                        html+='<td>'+item.new_balance+'</td>';
                        html+='<td>'+item.remark+'</td>';
                    html+='</tr>';
                }
                $('#listBox').append(html);
            }
        });
    });

    $('.moreBtn').trigger('click');
	
	$('.serachBtn2').on('click',function(){
		NOW_PAGE=1;
		$('#listBox').html('');
		$('.moreBtn').trigger('click');
	});
	
	//导出操作
	$('#downloadBtn').on('click',function(){
		$('#is_download').val(1);
		var params=$('#searchForm').serialize();
		var url=global.appurl+'c=Finance&a=balancelog_list&'+params;
		window.open(url,'_blank');
		$('#is_download').val(0);
	});
	
});
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
