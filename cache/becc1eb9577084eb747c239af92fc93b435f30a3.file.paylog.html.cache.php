<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-26 19:19:42
         compiled from "D:\phpstudy_pro\WWW\home\view\Finance\paylog.html" */ ?>
<?php /*%%SmartyHeaderCode:216605f96b0ce0a2500-09686620%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'becc1eb9577084eb747c239af92fc93b435f30a3' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Finance\\paylog.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '216605f96b0ce0a2500-09686620',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f96b0ce0bd6f6_62133889',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f96b0ce0bd6f6_62133889')) {function content_5f96b0ce0bd6f6_62133889($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<style>
.CommissionCon .detailBox tr td{line-height:2rem;padding:4px 8px;}
.viewBtn{padding:2px 8px;border:1px solid #fc744d;color:#fc744d;border-radius:3px;}
</style>
<div class="Commission">
	<div class="HeadTop">
		<p class="Tit">充值记录</p>
		<a href="/?c=Finance&a=pay" class="backBtn"></a>
	</div>
	<div class="CommissionCon">
		<div class="detailBox">
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>时间/单号</th>
						<th>金额</th>
						<th>状态</th>
						<th>详情</th>
					</tr>
				</thead>
				<tbody id="listBox">

				</tbody>
			</table>
			<div class="moreBtn" style="text-align:center;">点击加载更多</div>
		</div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
>

$(function(){
	
	//获取充值记录
    $('.moreBtn').on('click',function(){
        dataPage({
            url:global.appurl+'c=Finance&a=paylog_list',
            data:{},
            success:function(json){
                var html='';
                for(var i in json.data.list){
                    var item=json.data.list[i];
                    html+='<tr>';
                        html+='<td>'+item.create_time_flag+'<br>'+item.order_sn+'</td>';
                        html+='<td>'+item.money+'</td>';
                        html+='<td>'+item.pay_status_flag+'</td>';
                        html+='<td><a href="/?c=Finance&a=payInfo&osn='+item.order_sn+'" class="viewBtn">查看</a></td>';
                    html+='</tr>';
                }
                $('#listBox').append(html);
            }
        });
    });

    $('.moreBtn').trigger('click');
	
});
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
