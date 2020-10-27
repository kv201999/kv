<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-26 12:01:37
         compiled from "D:\phpstudy_pro\WWW\home\view\Finance\cash.html" */ ?>
<?php /*%%SmartyHeaderCode:266205f964a212e56e5-22779260%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3853b177f9a34267cd55bda5d04147d0fd52b80b' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\Finance\\cash.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '266205f964a212e56e5-22779260',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'banklog' => 0,
    'cash_time_str' => 0,
    'fee_str' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f964a2136a2c4_62547207',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f964a2136a2c4_62547207')) {function content_5f964a2136a2c4_62547207($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<style>

</style>
<div class="cashOut">
	<div class="HeadTop">
		<p class="Tit">提现</p>
		<a href="/?c=User" class="backBtn"></a>
	</div>
	<div class="cashOutCon">
		<p class="txtline">账号：<?php echo $_smarty_tpl->tpl_vars['user']->value['phone'];?>
</p>
		<?php if (getConfig('cnf_xyhk_model')=='是') {?>
		<p class="txtline">可提余额：￥<?php echo $_smarty_tpl->tpl_vars['user']->value['balance'];?>
</p>
		<?php } else { ?>
		<p class="txtline">可提余额：￥<?php echo $_smarty_tpl->tpl_vars['user']->value['balance'];?>
 <a href="javascript:;" class="editBtn transToBalance" style="width:6rem;" data-type="1">可提⇄接单</a></p>
		<p class="txtline">接单余额：￥<?php echo $_smarty_tpl->tpl_vars['user']->value['sx_balance'];?>
 <a href="javascript:;" class="editBtn transToBalance" style="width:6rem;" data-type="2">接单⇄可提</a></p>
		<p class="txtline">接单冻结：￥<?php echo $_smarty_tpl->tpl_vars['user']->value['fz_balance'];?>
</p>
		<?php }?>
		<p class="txtline">收款账号：<?php echo $_smarty_tpl->tpl_vars['banklog']->value['bank_name'];?>
，<?php echo $_smarty_tpl->tpl_vars['banklog']->value['bank_realname'];?>
，<?php echo $_smarty_tpl->tpl_vars['banklog']->value['bank_account'];?>
<a href="/?c=User&a=bcard" class="editBtn">修改</a></p>
		<div class="OutNum">提现额度：<div class="inbox"><input type="text" id="money"></div></div>
		<a href="javascript:;" class="cashOutBtn" style="margin-top:1.5rem;">提现</a>
		<div style="padding:1rem 2rem 0;">
			<div style="color:#f60;">单笔提现：￥<?php echo getConfig('min_cash_money');?>
 ~ ￥<?php echo getConfig('max_cash_money');?>
</div>
			<div style="color:#f60;"><?php echo $_smarty_tpl->tpl_vars['cash_time_str']->value;?>
</div>
			<div style="color:#f30;">手续费 = <?php echo $_smarty_tpl->tpl_vars['fee_str']->value;?>
</div>
			<div style="color:#f60;">注意：直接提现需要扣除手续费，系统派单收款不收取手续费</div>
		</div>
		<h1>提现明细</h1>
		<div class="detailBox">
			<table cellpadding="0" cellspacing="0">
				<thead>
					<tr>
						<th>时间</th>
						<th>金额</th>
						<th>实到</th>
						<th>状态</th>
					</tr>
				</thead>
				<tbody id="listBox">
					<!--
					<tr>
						<td>2019-7-18 16:08</td>
						<td>668</td>
						<td>中国工商银行</td>
						<td class="Audited">已审核</td>
					</tr>
					-->
				</tbody>
			</table>
			<div class="moreBtn" style="text-align:center;">点击加载更多</div>
		</div>
	</div>
</div>

<div class="addIdCodePop">
	<div class="Wrap" style="top:28%;">
		<div class="Con">			
			<div class="ConIn">		
				<p class="Tt">标题</p>
				<div class="Row">
					<p class="lttxt balanceTit">可提余额：</p>
					<div class="inputbox" style="border:1px solid #fff;">
						<span class="balanceFlag" style="line-height:2.4rem;padding:0 0.5rem;color:#f60;margin-right:0.5rem;"></span>
						<span class="transAllBtn" style="border:1px solid #f60;color:#f60;border-radius:0.3rem;padding:0 0.4rem;">全部</span>
					</div>
				</div>
				<div class="Row">
					<p class="lttxt">转出额度：</p>
					<div class="inputbox"><input type="text" id="z_money" placeholder=""></div>
				</div>
				<input type="hidden" id="ptype" value=""/>
				<a href="javascript:;" class="confirmBtn">提交</a>
			</div>
		</div>
		<a href="javascript:;" class="closeBtn"></a>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
>

$(function(){

	$('.transAllBtn').on('click',function(){
		var balance=$.trim($('.balanceFlag').text());
		$('#z_money').val(balance);
	});

	//余额互转
	$('.transToBalance').on('click',function(){
		var obj=$(this);
		var ptype=obj.attr('data-type');
		var title='';
		if(ptype==1){
			title='可提现余额->接单余额';
			$('.balanceTit').text('可提余额：');
			$('.balanceFlag').text('<?php echo $_smarty_tpl->tpl_vars['user']->value['balance'];?>
');
		}else if(ptype==2){
			title='接单余额->可提现余额';
			$('.balanceTit').text('接单余额：');
			$('.balanceFlag').text('<?php echo $_smarty_tpl->tpl_vars['user']->value['sx_balance'];?>
');
		}else{
			_alert('未知操作类型');
			return;
		}
		$('.addIdCodePop .Tt').text(title);
		$('#ptype').val(ptype);
		$('.addIdCodePop').fadeIn();
	});
	
	$('.addIdCodePop .closeBtn').on('click',function(){
		$('.addIdCodePop').hide();
	});
	
	$('.confirmBtn').on('click',function(){
		var obj=$(this);
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
				_alert({
					content:json.msg,
					end:function(){
						$('.addIdCodePop .closeBtn').trigger('click');
						location.reload();
					}
				});
			}
		});
	});
	
	////////////////////////////////////////////////////
	
	$('.cashOutBtn').on('click',function(){
		var obj=$(this);
		var money=$.trim($('#money').val());
		
		layer.open({
			//title:'',
			content:'您确定要提现么？',
			style:'width:60%',
			btn:['确定','取消'],
			yes:function(idx){
				layer.close(idx);
				ajax({
					url:global.appurl+'c=Finance&a=cashAct',
					data:{money:money},
					success:function(json){
						if(json.code!=1){
							_alert(json.msg);
							return;
						}
						_alert({
							content:json.msg,
							end:function(){
								location.reload();
							}
						});
					}
				});
			}
		});
	});
	
	
	
	//获取提现记录
    $('.moreBtn').on('click',function(){
        dataPage({
            url:global.appurl+'c=Finance&a=cashlog_list',
            data:{},
            success:function(json){
                var html='';
                for(var i in json.data.list){
                    var item=json.data.list[i];
                    html+='<tr>';
                        html+='<td>'+item.create_time_flag+'</td>';
                        html+='<td>'+item.money+'</td>';
                        html+='<td>'+item.real_money+'</td>';
                        html+='<td>'+item.status_flag+'</td>';
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
