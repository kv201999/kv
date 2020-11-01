<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-11-01 15:20:04
         compiled from "D:\phpstudy_pro\WWW\kv\home\view\Pay\info.html" */ ?>
<?php /*%%SmartyHeaderCode:128165f9e61a4c88634-93975966%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a27f8309e3fc0bdc60a5629df44eae86ba42a08e' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Pay\\info.html',
      1 => 1604214822,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '128165f9e61a4c88634-93975966',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'info' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9e61a4cd5ea6_04358932',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9e61a4cd5ea6_04358932')) {function content_5f9e61a4cd5ea6_04358932($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<style>
.qrcode img{cursor:pointer;}
.uname{color:#000;text-align:left;font-weight:600;}
.copyBtn{border:1px solid #f60;color:#f60;padding:2px 4px;padding-top:1px;font-size:12px;line-height:10px;border-radius:3px;cursor: pointer;}

.PaymentCon .time .timeBox{opacity:0;border: 1px solid #fc744d;background-color: #fc744d;color: #fff;padding: 6px 10px;font-size: 16px;border-radius: 5px;cursor: pointer;}

.HeadTopZfb{background-color:rgba(10,170,240,1);}
.HeadTopWx{background-color:rgba(66,174,60,1);}
.HeadTopYsf{background-color:rgba(255,51,0,1);}
.Payment .HeadTop{height: 50px;}
.Payment .HeadTop .Tit{font-size: 20px;padding: 12px 0;}

.PaymentCon .wxTips{font-size:1rem;background:#f8ecd6;color:#e88900;line-height:1.3rem;padding:0.5rem;font-weight:400;border-radius:8px;margin-bottom:0.5rem;}
</style>
<div class="Payment">
	<div class="HeadTop <?php if ($_smarty_tpl->tpl_vars['info']->value['mtype_id']==1) {?>HeadTopZfb<?php } elseif (in_array($_smarty_tpl->tpl_vars['info']->value['mtype_id'],array(2,4,5))) {?>HeadTopWx<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['mtype_id']==6) {?>HeadTopYsf<?php } else {
}?>">
		<p class="Tit"><?php echo $_smarty_tpl->tpl_vars['info']->value['mtype_name'];?>
</p>
		<!--<a href="javascript:;" class="backBtn"></a>-->
	</div>
	<div class="PaymentCon">	
		<div class="amount cpBtn" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['info']->value['money'];?>
"><?php echo $_smarty_tpl->tpl_vars['info']->value['money'];?>
<span class="copyBtn">复制</span></div>
		<?php if ($_smarty_tpl->tpl_vars['info']->value['mtype_type']==2||$_smarty_tpl->tpl_vars['info']->value['ptype']==12) {?>
		<div class="qrcode" style="width:80%;"><img src="<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_qrcode'];?>
" style="width:210px;"></div>
		<?php }?>
		<div class="uname" style="text-align:left;">
			<?php if (in_array($_smarty_tpl->tpl_vars['info']->value['mtype_id'],array(3,5))) {?>
				<?php if ($_smarty_tpl->tpl_vars['info']->value['mtype_id']==3) {?>
				开户银行：<?php echo $_smarty_tpl->tpl_vars['info']->value['bank_name'];?>
<br>
				<?php if ($_smarty_tpl->tpl_vars['info']->value['branch_name']) {?>开户支行：<?php echo $_smarty_tpl->tpl_vars['info']->value['branch_name'];?>
<br><?php }?>
				<?php }?>
				<div style="clear:both;height:0.5rem;"></div>
				<span class="cpBtn" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_realname'];?>
">收款姓名：<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_realname2'];?>
 <span class="copyBtn">复制</span></span><br>
				<div style="clear:both;height:0.5rem;"></div>
				<span class="cpBtn" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_account'];?>
">收款账号：<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_account2'];?>
 <span class="copyBtn">复制</span></span><br>
				<div style="clear:both;height:0.8rem;"></div>
				<?php if ($_smarty_tpl->tpl_vars['info']->value['mtype_id']==5) {?>
				<div class="wxTips">
					微信“我”→“支付”→“收付款”→“向银行卡转帐”→填写银行卡相关信息点击下一步→输入金额完成转账。<br>转账金额和银行信息必须与订单完全一致，否则无法完成。
				</div>
				<div class="zfbBox" style="padding-top:25px;padding-bottom:10px;">
					<a class="" style="background-color: rgba(66,174,60,1);color:#fff;font-size:14px;padding:10px 22px;border-radius:5px;" href="weixin://" target="_blank">打开微信立即付款</a>
				</div>
				<?php }?>
			<?php } else { ?>
				<?php if ($_smarty_tpl->tpl_vars['info']->value['mtype_id']==4) {?>
				<p style="text-align:left;margin-bottom:0.5rem;" class="cpBtn" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_account'];?>
">手机号：<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_account2'];?>
 <span class="copyBtn">复制</span></p>
				<p style="text-align:left;margin-bottom:0.5rem;" class="cpBtn" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_realname'];?>
"><b style="opacity:0;">姓</b>姓名：<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_realname2'];?>
 <span class="copyBtn">复制</span></p>
				<div style="clear:both;height:0.5rem;"></div>
				<div class="wxTips">
					微信“我”→“支付”→“收付款”→“向手机号转帐”→填写手机号→输入转帐金额点确定完成转账。<br>转账金额和手机号必须与订单完全一致，否则将无法完成。
				</div>
				<?php } else { ?>
				<p style="text-align:center;">姓名：<?php echo $_smarty_tpl->tpl_vars['info']->value['ma_realname2'];?>
</p>
				<?php }?>
			<?php }?>
		</div>
		<div class="time">
			<?php if ($_smarty_tpl->tpl_vars['info']->value['pay_status']==9) {?>
			订单已支付
			<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['pay_status']==2) {?>
			订单已提交
			<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['pay_status']==3) {?>
			订单已超时
			<?php } elseif ($_smarty_tpl->tpl_vars['info']->value['pay_status']==4) {?>
			订单已取消
			<?php } else { ?>
			<!--倒计时-->
			<span class="timeBox"></span>
			<?php if ($_smarty_tpl->tpl_vars['info']->value['mtype_id']==1&&$_smarty_tpl->tpl_vars['info']->value['zfbh5_url']) {?>
			
			<div class="zfbBox" style="padding-top:25px;">
				<a class="linkBtn" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['info']->value['money'];?>
" style="background:#0aaaf0;color:#fff;font-size:14px;padding:10px 22px;border-radius:5px;" href="javascript:;">复制金额并打开支付宝</a>
				<div style="font-size:0.9rem;color:#f30;text-align:center;padding-top:0.5rem;">请在非QQ浏览器中打开</div>
			</div>
			
			<?php }?>
			<?php if ($_smarty_tpl->tpl_vars['info']->value['mtype_id']==12) {?>
			<div class="zfbBox" style="padding-top:25px;">
				<a class="" style="background:#0aaaf0;color:#fff;font-size:14px;padding:10px 22px;border-radius:5px;" href="<?php echo $_smarty_tpl->tpl_vars['info']->value['zz_url'];?>
" target="_blank">点击打开支付宝</a>
			</div>
			<?php }?>
			<?php }?>
		</div>
		<div class="warmTips" >
			<b>温馨提示：</b><br>
			1、请在订单有效期内进行付款<br>
			2、不可重复支付，务必支付以上金额，否则会不到账<br>
			3、点击复制金额，扫码支付时，在金额一栏粘贴，完成付款<br>
			4、付款15分钟未到账，请联系在线客服<br>
		</div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
 src="public/js/clipboard.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
preventDefault();
$(function(){

	var clipboard = new ClipboardJS('.cpBtn');
    clipboard.on('success', function (e) {
        _alert("复制成功");
    });
	
	var clipboard2 = new ClipboardJS('.linkBtn');
    clipboard2.on('success', function (e) {
		var url='<?php echo $_smarty_tpl->tpl_vars['info']->value['zfbh5_url'];?>
';
        _alert({
			content:'金额复制成功，即将跳转并打开支付宝',
			time:3,
			end:function(){
				location.href=url;
			}
		});
    });
	
	var d_time='<?php echo $_smarty_tpl->tpl_vars['info']->value['d_time'];?>
'*1;
	var timer=null;
	if(d_time>0){
		setTimer();
	}else{
		$('.time').html('订单已超时');
	}
	
	function setTimer(){
		if(timer){
			clearInterval(timer);
		}
		var d_time_flag=secTrans(d_time);
		$('.timeBox').html('剩余'+d_time_flag+'，点我已付款').css({opacity:1});
		timer=setInterval(function(){
			d_time--;
			if(d_time<0){
				location.reload();
				clearInterval(timer);
			}
			var d_time_flag=secTrans(d_time);
			$('.timeBox').html('剩余'+d_time_flag+'，点我已付款').css({opacity:1});
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
	
	
	$('body').on('click','.qrcode',function(){
		var obj=$(this);
		var ma_qrcode=obj.find('img').attr('src');
		layer.open({
			content:'<div style="width:100%;text-align:center;"><img src="'+ma_qrcode+'"/></div>',
			style:'width:80%',
			btn:['关闭'],
			yes:function(idx){
				layer.close(idx);
			}
		});
	});
	
	$('.timeBox').on('click',function(){
		var obj=$(this);
		var osn='<?php echo $_smarty_tpl->tpl_vars['info']->value['order_sn'];?>
';
		layer.open({
			//title:'',
			content:'如果您已支付请确定提交',
			style:'width:62%',
			btn:['确定','取消'],
			yes:function(idx){
				layer.close(idx);
				ajax({
					url:global.appurl+'c=Pay&a=infoAct',
					data:{osn:osn},
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
	
});
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
