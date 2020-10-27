<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 01:59:28
         compiled from "/www/wwwroot/paofen123.com/home/view/User/index.html" */ ?>
<?php /*%%SmartyHeaderCode:5291593985f970e80a66130-71779500%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '441d39bcd7322cd2974e3f17b665be75c1c4d26f' => 
    array (
      0 => '/www/wwwroot/paofen123.com/home/view/User/index.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5291593985f970e80a66130-71779500',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'team_num' => 0,
    'order_num' => 0,
    'order_money' => 0,
    'yong_money' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f970e80aea718_34848300',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f970e80aea718_34848300')) {function content_5f970e80aea718_34848300($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<div class="Home">
	<div class="HomeTop">
		<div class="wrap">			
			<!-- <a href="/?c=User&a=setting" class="setBtn"></a> -->
			<div class="headIco" style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['user']->value['headimgurl'];?>
);"></div>
			<div class="info">
				<p class="userName"><?php echo $_smarty_tpl->tpl_vars['user']->value['account'];?>
</p>
				<!-- 两个状态：on-line/off-line -->
				<p class="userState <?php if ($_smarty_tpl->tpl_vars['user']->value['is_online']) {?>on-line<?php } else { ?>off-line<?php }?>"><?php echo $_smarty_tpl->tpl_vars['user']->value['is_online_flag'];?>
</p>
			</div>
			<a href="/?c=Finance&a=pay" class="fillCashBtn">充值</a>
		</div>
	</div>
	<div class="HomeCen">
		<ul>
			<?php if (getConfig('cnf_xyhk_model')=='是') {?>
			<li><p><?php echo $_smarty_tpl->tpl_vars['team_num']->value;?>
</p><p>团队人数</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['user']->value['balance'];?>
</p><p>可提余额</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['user']->value['kb_balance'];?>
</p><p>应回款</p></li>
			<?php } else { ?>
			<li><p><?php echo $_smarty_tpl->tpl_vars['user']->value['sx_balance'];?>
</p><p>接单余额</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['user']->value['balance'];?>
</p><p>可提余额</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['user']->value['fz_balance'];?>
</p><p>冻结余额</p></li>
			<?php }?>			
			<li><p><?php echo $_smarty_tpl->tpl_vars['order_num']->value;?>
</p><p>订单数</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['order_money']->value;?>
</p><p>订单总额</p></li>
			<li><p><?php echo $_smarty_tpl->tpl_vars['yong_money']->value;?>
</p><p>提成</p></li>
		</ul>
	</div>
	<div class="HomeList">
		<ul>
			<li><a href="/?c=User&a=bcard"><i><img src="/public/home/images/ico7.png"></i><p>绑定卡</p></a></li>
			<li><a href="/?c=Finance&a=cash"><i><img src="/public/home/images/ico8.png"></i><p>提现</p></a></li>
			<?php if (getConfig('cnf_xyhk_model')=='是') {?>
			<li><a href="/?c=Finance&a=hkuan"><i><img src="/public/home/images/ico8.png"></i><p>回款</p></a></li>
			<?php }?>
			<li><a href="/?c=Tg"><i><img src="/public/home/images/ico9.png"></i><p>推荐二维码</p></a></li>
			<li><a href="/?c=User&a=team"><i><img src="/public/home/images/ico10.png"></i><p>我的团队</p></a></li>
			<li><a href="/?c=Finance&a=yong"><i><img src="/public/home/images/ico11.png"></i><p>分成记录</p></a></li>
			<li><a href="/?c=Finance&a=balancelog"><i><img src="/public/home/images/ico7.png"></i><p>资金明细</p></a></li>
			<li><a href="/?c=User&a=api"><i><img src="/public/home/images/ico21.png"></i><p>回调助手</p></a></li>
			<li><a href="/?c=User&a=setting"><i><img src="/public/home/images/ico15.png"></i><p>设置</p></a></li>
		</ul>
	</div>

	<!-- 底部导航 -->
	<?php echo $_smarty_tpl->getSubTemplate ("menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
>
preventDefault();
$(function(){
	$('.userState').on('click',function(){
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
				obj.removeClass('on-line off-line');
				if(json.data.is_online=='1'){
					$('.userState').addClass('on-line');
				}else{
					$('.userState').addClass('off-line');
				}
				obj.html(json.data.is_online_flag);
			}
		});
	});
});
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
