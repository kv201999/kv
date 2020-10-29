<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-29 05:44:03
         compiled from "D:\phpstudy_pro\WWW\kv\home\view\Default\index.html" */ ?>
<?php /*%%SmartyHeaderCode:317065f9a56a31c30c7-30722524%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24a750c339ca510cd299192ae89eb74073291993' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Default\\index.html',
      1 => 1603884046,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '317065f9a56a31c30c7-30722524',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'queue_num' => 0,
    'total_num' => 0,
    'order_num' => 0,
    'forder_num' => 0,
    'forder_rate' => 0,
    'order_money' => 0,
    'forder_money' => 0,
    'yong_money' => 0,
    'd_time' => 0,
    'notify_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9a56a31f85d2_10455603',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9a56a31f85d2_10455603')) {function content_5f9a56a31f85d2_10455603($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<style>
	.robOrderNum li p:nth-child(1){
		font-size: 1.5rem;
		font-weight: bold;
	}
	.robOrderBox .robNowBtn{
		background-image: linear-gradient(to bottom, #019aff, #019aff);
	}
	.robOrderTipstxt,.robOrder .warmTips{
		color: #333;
	}
	.robOrderBox .stopRob .countDown{
		font-size: 1.8rem;
		font-weight: bold;
	}
</style>
<div class="robOrder">
	<div class="robOrderBox">
		<!-- 立即抢单 -->
		<a href="javascript:;" class="robNowBtn" style="<?php if ($_smarty_tpl->tpl_vars['user']->value['is_online']==1) {?>display:none;<?php }?>">开启抢单</a>
		<!-- 停止抢单 -->
		<div class="stopRob" style="<?php if ($_smarty_tpl->tpl_vars['user']->value['is_online']==0) {?>display:none;<?php }?>">
			<p class="countDown">00:00</p>
			<a href="javascript:;" class="robStopBtn">停止抢单</a>
		</div>
	</div>
	<p class="robOrderTipstxt">每隔<?php echo getConfig('cnf_user_offline_time')/60;?>
分钟会自动下线</p>
	<?php if ($_smarty_tpl->tpl_vars['queue_num']->value>0) {?>
	<p class="robOrderTipstxt" style="margin-top:0.2rem;">排队人数：<?php echo $_smarty_tpl->tpl_vars['queue_num']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['total_num']->value;?>
</p>
	<?php } else { ?>
	<p style="height:0.5rem;">&nbsp;</p>
	<?php }?>
	<div class="robOrderNum">
		<p class="userbox"><span>余额：<?php echo $_smarty_tpl->tpl_vars['user']->value['sx_balance'];?>
 USDT</span><span class="edu">冻结：<?php echo $_smarty_tpl->tpl_vars['user']->value['fz_balance'];?>
 USDT</span></p>
		<ul>
			<li><p><?php echo $_smarty_tpl->tpl_vars['order_num']->value;?>
</p><p>总单数</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['forder_num']->value;?>
</p><p>完成单数</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['forder_rate']->value;?>
%</p><p>成功率</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['order_money']->value;?>
</p><p>总金额 </p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['forder_money']->value;?>
</p><p>完成金额</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['yong_money']->value;?>
</p><p>提成</p></li>
		</ul>
	</div>

	<div class="warmTips">
		1.保持在线状态才会派发订单<br>
		2.收到款后请及时点击确认收款，恶意不确认可能会被禁止接单<br>
		3.有新订单会语音提醒，部分手机要保持屏幕常亮才有语音提提醒把这个放在订单列表里面
	</div>


	<!-- 底部导航 -->
	<?php echo $_smarty_tpl->getSubTemplate ("menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
>
preventDefault();
$(function(){
	var timer=null;
	var d_time='<?php echo $_smarty_tpl->tpl_vars['d_time']->value;?>
'*1;
	setTimer();
	
	function setTimer(){
		if(timer){
			clearInterval(timer);
		}
		var d_time_flag=secTrans(d_time);
		$('.countDown').html(d_time_flag);
		timer=setInterval(function(){
			d_time--;
			if(d_time<0){
				$('.robNowBtn,.stopRob').hide();
				$('.robNowBtn').show();
				clearInterval(timer);
			}
			var d_time_flag=secTrans(d_time);
			$('.countDown').html(d_time_flag);
		},1000);
	}
	
	function secTrans(sec){
		var d_min=Math.floor(sec/60);
		var d_sec=sec%60;
		if(d_min<0){
			d_min=0;
		}
		if(d_min<10){
			d_min='0'+d_min;
		}
		if(d_sec<0){
			d_sec=0;
		}
		if(d_sec<10){
			d_sec='0'+d_sec;
		}
		var d_time_flag=d_min+':'+d_sec;
		return d_time_flag;
	}
	
	$('.robNowBtn,.robStopBtn').on('click',function(){
		var obj=$(this);
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=User&a=onlineSet',
			success:function(json){
				obj.attr('has-click','0');
				if(json.code!=1){
					_alert(json.msg);
					return;
				}
				$('.robNowBtn,.stopRob').hide();
				if(json.data.is_online=='1'){
					//开始倒计时
					d_time=json.data.d_time;
					setTimer();
					$('.stopRob').show();
					
					return false;
					/*
					$('.robNowBtn').show();
					layer.open({
						content: '点击抢单后，停止必须点击停止抢单，不能直接关闭或者直接关闭app必须点击停止抢单。否则在这个期间抢单订单不能及时确定，第一次罚款50元，第二次罚款50元，冻结3天，第三次冻结账号。已经了解，保证遵守下线，点击停止抢单。',
						btn: ['确定', '取消'],
						shadeClose:false,
						yes: function(index){
							layer.close(index);
							setTimer();
							$('.robNowBtn').hide();
							$('.stopRob').show();
						},
						no:function(index){
							$('.robStopBtn').trigger('click');
						}
					});
					*/
				}else{
					//停止倒计时
					if(timer){
						clearInterval(timer);
					}
					$('.robNowBtn').show();
				}
			}
		});
	});
	
	<?php if ($_GET['f']=='login') {?>
	if(typeof(androidWeihuagu)!='undefined'){
		androidWeihuagu.JumpMainAndPostUrlAndKey('<?php echo $_smarty_tpl->tpl_vars['notify_url']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['user']->value['apikey'];?>
');
	}else{
		//console.log('<?php echo $_smarty_tpl->tpl_vars['notify_url']->value;?>
');
	}
	<?php }?>
	
});
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
