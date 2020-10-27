<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-21 18:22:29
         compiled from "D:\phpstudy_pro\WWW\home\view\User\api.html" */ ?>
<?php /*%%SmartyHeaderCode:64035f900be513d003-54354984%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09526958cb0a12d1f8063b0bafdfac79992bf0c4' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\home\\view\\User\\api.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '64035f900be513d003-54354984',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'notify_url' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f900be5166981_54805591',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f900be5166981_54805591')) {function content_5f900be5166981_54805591($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<style type="text/css">
.cashOutCon .huidiaoBox{position: relative;width: 11.5rem;height: 11.5rem;margin: 3rem auto 0;border-radius: 12rem;}
.cashOutCon .huidiaoBox .txt1{font-size: 1.5rem;margin-top: 3.5rem;}
.cashOutCon .huidiaoBox .txt2{text-align: center;color: #019aff;font-size: 1.5rem;padding: 2.2rem 0 1.5rem;}
.cashOutCon .huidiaoBox .con1{position: absolute;width: 100%;height: 100%;color: #fff;text-align: center;background-image: linear-gradient(to bottom, #019aff, #dedede);border-radius: 12rem;}
.cashOutCon .huidiaoBox .con2{position: absolute;width: 100%;height: 100%;top: 0;left: 0;border: 2px solid #019aff;border-radius: 12rem;box-sizing: border-box;}
.cashOutCon .huidiaoBox .huidiao_OpenBtn{display: block;width: 7rem;text-align: center;border-radius: 2rem;line-height: normal;padding: 0.4rem 0;background: #fff;color: #019aff;margin: 0 auto;font-size: 1.2rem;box-shadow: 0px 0px 3px 2px #019aff;}
</style>
<div class="cashOut">
	<div class="HeadTop">
		<p class="Tit">回调助手</p>
		<a href="/?c=User" class="backBtn"></a>
	</div>
	<div class="cashOutCon">
		<p class="txtline"><b>我的账号：</b><?php echo $_smarty_tpl->tpl_vars['user']->value['account'];?>
</p>
		<p class="txtline" style="line-height:1.5rem;word-break:break-all;margin-bottom:1rem;"><b>回调地址：</b><?php echo $_smarty_tpl->tpl_vars['notify_url']->value;?>
 <span class="editBtn" id="notifyUrl" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['notify_url']->value;?>
" >复制</span></p>
		<p class="txtline" style="line-height:1.5rem;word-break:break-all;margin-bottom:1rem;"><b>签名密钥：</b><?php if ($_smarty_tpl->tpl_vars['user']->value['apikey']) {
echo $_smarty_tpl->tpl_vars['user']->value['apikey'];?>
 <span class="editBtn" id="apikey" data-clipboard-text="<?php echo $_smarty_tpl->tpl_vars['user']->value['apikey'];?>
" >复制</span><?php } else { ?>/<?php }?></p>
		<div class="OutNum"><b>二级密码：</b><div class="inbox"><input type="password" id="password2"></div></div>
		<a href="javascript:;" class="cashOutBtn" style="margin-top:1.5rem;">更新密钥</a>
		<div style="padding:1rem 2rem 0;">
			<div style="color:#f60;">注意：请妥善保管您的密钥，切勿转发或泄漏给其他人，若别人已知道密钥，请及时更新！</div>
		</div>

		<div class="huidiaoBox">
			<div class="con1" style="<?php if ($_smarty_tpl->tpl_vars['user']->value['apiauto']) {?>display:none;<?php }?>">
				<p class="txt1">自动回调<br>点击开启</p>
			</div>
			<div class="con2" style="<?php if (!$_smarty_tpl->tpl_vars['user']->value['apiauto']) {?>display:none;<?php }?>">	
				<p class="txt2">自动回调</p>
				<a href="javascript:;" class="huidiao_OpenBtn">点击关闭</a>
			</div>
		</div>
		<div class="apiautoFlag" style="text-align:center;padding-top:0.5rem;font-weight:bold;">自动回调已<?php echo $_smarty_tpl->tpl_vars['user']->value['apiauto_flag'];?>
</div>
		
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
 src="/public/js/clipboard.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

$(function(){

	var clipboard = new ClipboardJS('#notifyUrl');

	clipboard.on('success', function(e) {
		_alert('复制回调地址成功');
	});
	
	var clipboard2 = new ClipboardJS('#apikey');

	clipboard2.on('success', function(e) {
		_alert('复制签名密钥成功');
	});
	
	$('.cashOutBtn').on('click',function(){
		var obj=$(this);
		var password2=$.trim($('#password2').val());
		if(!password2){
			_alert('请填写二级密码');
			return;
		}
		password2=md5(password2);
		layer.open({
			//title:'',
			content:'您确定要更新签名密钥么？',
			style:'width:65%',
			btn:['确定','取消'],
			yes:function(idx){
				layer.close(idx);
				ajax({
					url:global.appurl+'c=User&a=apikeyUpdate',
					data:{password2:password2},
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

	//自动回调
	$('.con1,.huidiao_OpenBtn').on('click',function(){
		var obj=$(this);
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=User&a=autoSet',
			data:{},
			success:function(json){
				obj.attr('has-click','0');
				if(json.code!=1){
					_alert(json.msg);
					return;
				}
				$('.con1,.con2').hide();
				if(json.data.apiauto==1){
					$('.con2').show();
				}else{
					$('.con1').show();
				}
				$('.apiautoFlag').text('自动回调已'+json.data.apiauto_flag);
				if(json.data.apiauto==1&&typeof(androidWeihuagu)!='undefined'){
					androidWeihuagu.JumpMainAndPostUrlAndKey('<?php echo $_smarty_tpl->tpl_vars['notify_url']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['user']->value['apikey'];?>
');
				}
			}
		});
	});
	
});
<?php echo '</script'; ?>
>
<?php echo $_smarty_tpl->getSubTemplate ("foot.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>
<?php }} ?>
