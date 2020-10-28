<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-28 17:34:54
         compiled from "D:\phpstudy_pro\WWW\kv\home\view\Skma\index.html" */ ?>
<?php /*%%SmartyHeaderCode:205875f993b3e61fcd4-55772668%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eca752588a5352cbf6229a868ea95844c505ffa4' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\home\\view\\Skma\\index.html',
      1 => 1603871139,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '205875f993b3e61fcd4-55772668',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    's' => 0,
    'mtype_arr' => 0,
    'vo' => 0,
    'province_arr' => 0,
    'bank_arr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f993b3e6651f2_87040957',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f993b3e6651f2_87040957')) {function content_5f993b3e6651f2_87040957($_smarty_tpl) {?><?php echo $_smarty_tpl->getSubTemplate ("head.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
>
function showImg(ts){
	var obj=$(ts);
	var src=obj.attr('src');
	layer.open({
		content:'<div style="width:100%;text-align:center;"><img src="'+src+'"/></div>',
		style:'width:80%',
		btn:['关闭'],
		yes:function(idx){
			layer.close(idx);
		}
	});
}
<?php echo '</script'; ?>
>
<style>
.bannerItem{margin-right:5px;position:relative;}
.bannerItem span{position:absolute;top:0px;right:0px;line-height:20px;font-size:28px;}
select{width:14rem;position: relative;height: 2.2rem;padding: 0 0.5rem;}
.editItem,.delItem,.statusItem,.maQrcodeBox{cursor:pointer;}

.wb_bash{height:40px;line-height:20px;border:1px solid #dedede;padding:5px;width:93%;}
.wb_del_btn{position:absolute;right:-2px;top:0px;background:#f40;color:#fff;padding:1px 4px;font-size:12px;cursor:pointer;}
.wb_add_btn{background:#f60;font-size:12px;padding:2px 4px;color:#fff;display:inline-block;cursor:pointer;float:right;}

.addIdCodePop .Wrap{bottom:10%;}

.testItem{color:#F30;
    border: 1px solid #F30;
    border-radius: 2rem;
    padding: 0 0.8rem;
    font-size: 1rem;
}
</style>
<div class="payCode">
	<div class="payCodeTop">	
		<div class="searchbox">
			<!--
			<input type="text" id="keyword" value="<?php echo $_smarty_tpl->tpl_vars['s']->value['keyword'];?>
" placeholder="请输入关键词">
			<a href="javascript:;" class="serachBtn">搜索</a>
			-->
			<select id="s_mtype" style="height:3rem;border:0;width:100%;border-radius:5px;">
				<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mtype_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
				<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['vo']->value['type'];?>
" <?php if ($_smarty_tpl->tpl_vars['s']->value['mtype']==$_smarty_tpl->tpl_vars['vo']->value['id']) {?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['vo']->value['name'];?>
</option>
				<?php } ?>
			</select>
		</div>
		<a href="javascript:;" class="addIdNum" style="margin-left:0.7rem;">添加账号</a>
	</div>
	<div class="payCOdeList" style="top:11rem;">
		<ul>
			<!--
			<li>
				<div class="ltbox">
					<p>支付类型：卡转支付宝</p>
					<p>收款姓名：一小</p>
					<p>收款码：<i class="paywayIco"></i></p>
					<p>收益率：100%</p>
				</div>
				<div class="rtbox">
					!-- 两种状态on-line/off-line --
					<p>状态：<span class="state on-line">在线</span></p>
					<p>收款账号：13536920159</p>
					<p>省市：广东省广州市</p>
					<p>提成：688</p>
				</div>
			</li>
			-->
		</ul>
		<div class="moreBtn" style="text-align:center;">点击加载更多</div>
	</div>
	<!-- 底部导航 -->
	<?php echo $_smarty_tpl->getSubTemplate ("menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

</div>

<!-- 添加收款码 -->
<div class="addIdCodePop">
	<!-- <div class="bot_line"><img src="/public/home/images/bot_line.png"></div> -->
	<div class="Wrap">
		<div class="Con">			
			<div class="ConIn">		
				<p class="Tt">添加收款码</p>
				<div class="Row">
					<p class="lttxt">支付类型：</p>
					<div class="selectbox">
						<select id="mtype_id">
							<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['mtype_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['name'];?>
</option>
							<?php } ?>
						</select>
					</div>
				</div>
<!--				<div class="Row">-->
<!--					<p class="lttxt">所属省份：</p>-->
<!--					<div class="selectbox">-->
<!--						<select id="province_id">-->
<!--							<option value="0">请选择</option>-->
<!--							<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['province_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>-->
<!--							<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['cname'];?>
</option>-->
<!--							<?php } ?>-->
<!--						</select>-->
<!--					</div>-->
<!--				</div>-->
<!--				<div class="Row" style="margin-bottom:0.1rem;">-->
<!--					<p class="lttxt">所属城市：</p>-->
<!--					<div class="selectbox">-->
<!--						<select id="city_id">-->
<!--							<option value="0">请选择</option>-->
<!--						</select>-->
<!--					</div>-->
<!--				</div>-->
<!--				<div style="padding:0 1.8rem 0.5rem;padding-right:2.8rem;color:#f60;font-size:0.5rem;text-align:right;">系统会派发同城订单，避免封号</div>-->
				<div class="Row bankBox">
					<p class="lttxt">开户行：</p>
					<div class="selectbox">
						<select id="bank_id">
							<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['bank_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['bank_name'];?>
</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="Row">
					<p class="lttxt">收款姓名：</p>
					<div class="inputbox"><input type="text" id="ma_realname" placeholder=""></div>
				</div>
				<div class="Row bankBox">
					<p class="lttxt">银行卡号：</p>
					<div class="inputbox"><input type="text" id="ma_account" placeholder="银行卡号"></div>
				</div>
				<div class="Row bankBox">
					<p class="lttxt">开户支行：</p>
					<div class="inputbox"><input type="text" id="branch_name" placeholder="选填"></div>
				</div>
				<!--
				<div class="Row">
					<p class="lttxt">最小收款：</p>
					<div class="inputbox"><input type="text" id="min_money" placeholder="" value=""></div>
				</div>
				<div class="Row" style="display:none;">
					<p class="lttxt">匹配次数：</p>
					<div class="inputbox"><input type="text" id="match_num" placeholder="0或空则不限制" value=""></div>
				</div>
				-->
<!--				<div class="Row maxBox">-->
<!--					<p class="lttxt">最大收款：</p>-->
<!--					<div class="inputbox"><input type="text" id="max_money" placeholder="" value=""></div>-->
<!--				</div>-->
				<div class="Row moneyBox2" style="display:none;">
					<p class="lttxt">选择金额：</p>
					<div class="selectbox">
						<select id="ma_zkmoney">
							<option value="0" selected>0</option>
							<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_zkling_mitem'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="Row moneyBox" style="display:none;">
					<p class="lttxt">口令内容：</p>
					<div class="inputbox" style="border:0;">
						<textarea id="ma_zkling" style="border:1px solid #dedede;height:60px;width:94%;padding:0.4rem 0.4rem;"></textarea>
					</div>
				</div>
				<div class="Row uidBox" style="display:none;">
					<p class="lttxt">UID：</p>
					<div class="inputbox"><input type="text" id="ma_zfbuid" placeholder="直接复制粘贴即可" value=""></div>
				</div>
				<div class="Row uidBox" style="display:none;">
					<p class="lttxt">获取UID：</p>
					<div class="inputbox" style="border:1px solid #fff;">
						<img src="public/home/images/zfbuid.png" style="width:50%;cursor:pointer;" onclick="showImg(this)" />
					</div>
				</div>
				<div class="Row codeImgBox">
					<p class="lttxt">固定金额：</p>
					<div class="inputbox"><input type="text" id="guding_money" placeholder="" value=""></div>
				</div>
				<div class="Row codeImgBox">
					<p class="lttxt">闲鱼收款码：</p>
					<div class="codeImgs">
						<ul>
							<li class="bannerItem"><a href="javascript:;"><img src="/public/home/images/add.png"></a></li>
						</ul>
						<input type="file" id="maQrcode" accept="image/*" style="display:none;"/>
					</div>
				</div>
				<div class="Row state">
					<p class="lttxt">状态：</p>
					<div class="stateNav"><span class="on" data-status="2">在线</span><span data-status="1">离线</span></div>
				</div>
				<input type="hidden" id="item_id" value="0"/>
				<a href="javascript:;" class="confirmBtn">提交</a>
			</div>
		</div>
		<a href="javascript:;" class="closeBtn"></a>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("js.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 9999, null, array(), 0);?>

<?php echo '<script'; ?>
 src="/public/js/lrz.all.bundle.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="public/js/base64.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
$(function(){
	
	///////////////////////////////////////////////////////

	$('.addIdCodePop').on('touchmove',function(event){
		//event.preventDefault();
	});

	document.getElementById('maQrcode').addEventListener('change', function () {
		var that = this;
		lrz(that.files[0], {
			width:800,
			height:800
		}).then(function(rst){
			that.value=null;
			ajax({
				url:global.appurl+'a=imgUpload',
				data:{imgdata:rst.base64},
				success:function(json){
					if(json.code!=1){
						_alert(json.msg);
						return;
					}
					$('.bannerItem').find('img').attr('src',json.data.src);
					/*
					var html='<li class="bannerItem"><img src="'+json.data.src+'"><span>×</span></li>';
					$('#fileUploadH5Btn').before(html);
					if($('.bannerItem').length>=3){
						$('#fileUploadH5Btn').hide();
					}*/
				}
			});
			return rst;
		});
	});

	//监听选择图片
	$('.bannerItem').on('click',function(){
		$('#maQrcode').trigger('click');
	});

	//顶部切换类型	
	$('#s_mtype').on('change',function(){
		var obj=$(this);
		var mtype=obj.val();
		var keyword=$.trim($('#keyword').val());
		var url='/?c=Skma&mtype='+mtype;
		if(keyword){
			url+='&keyword='+keyword;
		}
		location.href=url;
	});
	
	//搜索关键词
	$('.serachBtn').on('click',function(){
		var mtype=$('.payCodeNav ul').find('.on').attr('data-mtype');
		var keyword=$.trim($('#keyword').val());
		var url='/?c=Skma&mtype='+mtype;
		if(keyword){
			url+='&keyword='+keyword;
		}
		location.href=url;
	});
	
	/////////////////////////////////////////////
	//全部隐藏
	function showNone(){
		$('.bankBox,.codeImgBox,.maxBox,.moneyBox,.uidBox').hide();
	}
	
	//只显示账号
	function showAccount(){
		showNone();
	}
	
	//显示银行信息
	function showBank(){
		showNone();
		$('.bankBox').show();
	}
	
	//显示二维码
	function showCode(){
		showNone();
		$('.codeImgBox').show();
	}
	
	function iniSetInput(mtype_id){
		var mtype_type=$('#s_mtype').find('option[value="'+mtype_id+'"]').attr('data-type');
		if(!mtype_type){
			return;
		}
		showNone();
		if(mtype_type==1){
			showAccount();
		}else if(mtype_type==2){
			showCode();
		}else if(mtype_type==3){
			showBank();
		}else if(mtype_type==4){
			//...
		}else if(mtype_type==5){
			$('.uidBox').show();
		}
		$('.maxBox').show();
		if(mtype_type==4){
			$('.moneyBox').show();
		}else{
			//$('.maxBox').show();
		}
		
	}
	
	/////////////////////////////////////////////
	
	//添加切换支付类型
	$('#mtype_id').on('change',function(){
		var obj=$(this);
		var mtype_id=obj.val();
		iniSetInput(mtype_id);
	});
	
	//切换状态
	$('.stateNav span').on('click',function(){
		var obj=$(this);
		$('.stateNav span').removeClass('on');
		obj.addClass('on');
	});
	
	//切换省份
	$('#province_id').on('change',function(){
		var obj=$(this);
		var province_id=obj.val();
		iniCity(province_id,0);
	});
	
	function iniCity(province_id,city_id,callback){
		ajax({
			url:global.appurl+'c=Skma&a=getCity',
			data:{pid:province_id},
			success:function(json){
				var html='<option value="0">请选择</option>';
				for(var i in json.data){
					var item=json.data[i];
					html+='<option value="'+item.id+'">'+item.cname+'</option>';
				}
				$('#city_id').html(html).val(city_id);
				if(callback){
					callback();
				}
			}
		});
	}
	
	//添加码
	$('.addIdNum').on('click',function(){
		var mtype_id=1;
		$('#mtype_id').val(mtype_id).prop('disabled',false);
		iniSetInput(mtype_id);
		$('#province_id').val(0);
		$('#city_id').html('<option value="0">请选择</option>');
		$('#bank_id').val($('#bank_id').find('option').eq(0).attr('value'));
		$('#branch_name').val('');
		$('#ma_realname').val('');
		$('#ma_account').val('');
		$('#ma_zkling').val('');
		$('#min_money').val("<?php echo getConfig('cnf_skm_min_money');?>
");
		$('#max_money').val("<?php echo getConfig('cnf_skm_max_money');?>
");

		$('#item_id').val(0);
		$('.bannerItem').find('img').attr('src','/public/home/images/add.png');
		$('.stateNav span[data-status="2"]').trigger('click');
		$('.addIdCodePop .ConIn .Tt').text('添加收款码');
		$('.addIdCodePop').fadeIn();
	});
	
	$('.addIdCodePop .closeBtn').on('click',function(){
		$('.addIdCodePop').hide();
	});
	
	//编辑
	$('body').on('click','.editItem',function(){
		var obj=$(this);
		var id=obj.parents('li').attr('data-id');
		layer.open({
			type: 2,
			content: '加载中'
		});
		ajax({
			url:global.appurl+'c=Skma&a=skma_one',
			data:{item_id:id},
			success:function(json){
				layer.closeAll();
				if(json.code!='1'){
					_alert(json.msg);
					return;
				}
				var item=json.data;
				$('#mtype_id').val(item.mtype_id).prop('disabled',true);
				iniSetInput(item.mtype_id);
				if(item.mtype_type==2){
					$('.bannerItem').find('img').attr('src',item.ma_qrcode);
				}else if(item.mtype_type==3){
					$('#bank_id').val(item.bank_id);
				}else if(item.mtype_type==4){
					$('#ma_zkmoney').val(item.ma_zkmoney);
					$('#ma_zkling').val(item.ma_zkling);
				}else if(item.mtype_type==5){
					$('#ma_zfbuid').val(item.ma_zfbuid);
				}
				
				$('#province_id').val(item.province_id);
				iniCity(item.province_id,item.city_id);
				$('#branch_name').val(item.branch_name);
				$('#ma_realname').val(item.ma_realname);
				$('#ma_account').val(item.ma_account);
				$('#min_money').val(item.min_money);
				$('#max_money').val(item.max_money);
				$('#guding_money').val(item.max_money);
				$('#match_num').val(item.match_num);
				$('.stateNav span[data-status="'+item.status+'"]').trigger('click');
				
				$('#item_id').val(item.id);
				$('.addIdCodePop .ConIn .Tt').text('编辑收款码');
				$('.addIdCodePop').fadeIn();
				
			}
		});
	});
	
	$('.confirmBtn').on('click',function(){
		var obj=$(this);
		var item_id=$('#item_id').val();;
		var mtype_id=$('#mtype_id').val();
		var province_id=$('#province_id').val();
		var city_id=$('#city_id').val();
		var bank_id=$('#bank_id').val();
		var branch_name=$('#branch_name').val();
		var ma_realname=$('#ma_realname').val();
		var ma_account=$('#ma_account').val();
		var min_money=$('#min_money').val();
		var max_money=$('#max_money').val();
		var match_num=$('#match_num').val();
		var ma_qrcode=$('.bannerItem').find('img').attr('src');
		var status=$('.stateNav').find('.on').attr('data-status');
		var ma_zkmoney=$.trim($('#ma_zkmoney').val());
		var guding_money=$('#guding_money').val();
		var ma_zkling=$.trim($('#ma_zkling').val());
		if(ma_zkling){
			ma_zkling=Base64.encode(ma_zkling);
		}
		
		var ma_zfbuid=$.trim($('#ma_zfbuid').val());
		
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=Skma&a=skma_update',
			data:{
				item_id:item_id,mtype_id:mtype_id,province_id:province_id,city_id:city_id,bank_id:bank_id,branch_name:branch_name,
				ma_realname:ma_realname,ma_account:ma_account,ma_qrcode:ma_qrcode,status:status,
				min_money:min_money,max_money:max_money,match_num:match_num,guding_money:guding_money,
				ma_zkmoney:ma_zkmoney,ma_zkling:ma_zkling,ma_zfbuid:ma_zfbuid
			},
			success:function(json){
				obj.attr('has-click','0');
				if(json.code!=1){
					_alert(json.msg);
					return;
				}
				$('.addIdCodePop .closeBtn').trigger('click');
				_alert({
					content:json.msg,
					end:function(){
						//location.reload();
					}
				});
				var itid=item_id;
				ajax({
					url:global.appurl+'c=Skma&a=skma_one',
					data:{item_id:json.data.id},
					success:function(json2){
						if(json2.code==1){
							var html=parseSkma(json2.data);
							if(!itid||itid<1){
								if($('.skmaItem').eq(0)){
									$('.skmaItem').eq(0).before(html);
								}else{
									$('.payCOdeList ul').append(html);
								}
							}else{
								var skmaItemObj=$('.skmaItem[data-id="'+json.data.id+'"]');
								skmaItemObj.before(html);
								skmaItemObj.remove();
							}
						}
					}
				});
			}
		});
	});
	
	
	//删除
	$('body').on('click','.delItem',function(){
		var obj=$(this);
		var liObj=obj.parents('li');
		var item_id=liObj.attr('data-id');
		layer.open({
			content:'您确定要删除么？',
			style:'width:66%',
			btn:['确定','取消'],
			yes:function(idx){
				layer.close(idx);
				ajax({
					url:global.appurl+'c=Skma&a=skma_delete',
					data:{item_id:item_id},
					success:function(json){
						if(json.code!=1){
							_alert(json.msg);
							return;
						}
						_alert({
							content:json.msg,
							end:function(){
								//location.reload();
								liObj.fadeOut();
							}
						});
					}
				});
			}
		});
	});
	
	///////////////////////////////////////////////////////
	//查看收款码
	$('body').on('click','.maQrcodeBox',function(){
		var obj=$(this);
		var qrObj=obj.find('.paywayIco');
		var ma_qrcode=qrObj.attr('data-ma-qrcode');
		layer.open({
			content:'<div style="width:100%;text-align:center;"><img src="'+ma_qrcode+'"/></div>',
			style:'width:80%',
			btn:['关闭'],
			yes:function(idx){
				layer.close(idx);
			}
		});
	});
	
	//####格式化二维码####
	function parseSkma(item){
		if(!item){
			return '';
		}
		var html='';
		html+='<li class="skmaItem" data-id="'+item.id+'">';
			html+='<div class="ltbox">';
				html+='<p>类型：'+item.mtpye_name+'</p>';
				html+='<p>收款人：'+item.ma_realname+"("+item.ma_account+')</p>';
				if(item.mtype_type==3){
					html+='<p>开户行：'+item.bank_name+'</p>';
				}else if(item.mtype_type==2){
					html+='<p class="maQrcodeBox">收款码：<i class="paywayIco" data-ma-qrcode="'+item.ma_qrcode+'" style="background-image:url('+item.ma_qrcode+');position:relative;top:3px;"></i></p>';
				}
				//html+='<p>收益率：'+item.fy_rate+'%</p>';
				html+='<p>今日笔数：'+item.day_tcnt+'/'+item.day_tcnt2+'</p>';
				//html+='<p><a href="/?c=Skma&a=info&id='+item.id+'" style="color:#f30;">自动回调助手</a></p>';
			html+='</div>';
			html+='<div class="rtbox">';
				//!-- 两种状态on-line/off-line --
				var class_flag='on-line';
				if(item.status!=2){
					class_flag='off-line';
				}
				html+='<p class="statusItem">状态：<span class="state '+class_flag+'">'+item.status_flag+'</span></p>';
				//html+='<p class="maaccountItem">收款号：'+item.ma_account+'</p>';
				html+='<p>接单范围：'+item.min_money+"-"+item.max_money+'</p>';
				html+='<p>收益：'+item.yong_money+"("+item.fy_rate+"%)"+'</p>';
				html+='<p>成功率：'+item.day_percent+'</p>';
				html+='<p style="color:#fc744d;">';
					html+='<a class="delItem" style="margin-right:10px;">删除</a>';
					html+='<a class="editItem">修改</a>';
					if(item.mtype_type<=3){
						html+='<a class="testItem" style="margin-left:10px;">测试</a>';
					}
				html+='</p>';
			html+='</div>';
		html+='</li>';
		return html;
	}
	
	//获取记录
    $('.moreBtn').on('click',function(){
        dataPage({
            url:global.appurl+'c=Skma&a=skma_list',
            data:{mtype:'<?php echo $_smarty_tpl->tpl_vars['s']->value['mtype'];?>
',keyword:'<?php echo $_smarty_tpl->tpl_vars['s']->value['keyword'];?>
'},
            success:function(json){
                var html='';
                for(var i in json.data.list){
                    var item=json.data.list[i];
					html+=parseSkma(item);
                }
                $('.payCOdeList ul').append(html);
            }
        });
    });

    $('.moreBtn').trigger('click');
	
	$('body').on('click','.statusItem',function(){
		var obj=$(this);
		var skma_id=obj.parents('li').attr('data-id');
		var has_click=obj.attr('has-click');
		if(has_click=='1'){
			return;
		}else{
			obj.attr('has-click','1');
		}
		ajax({
			url:global.appurl+'c=Skma&a=skma_set',
			data:{skma_id:skma_id},
			success:function(json){
				obj.attr('has-click','0');
				if(json.code!=1){
					if(json.code!='-1'){
						_alert({content:json.msg,time:5});
					}else{
						_alert(json.msg);
					}
					return;
				}
				var liObj=$('.skmaItem[data-id="'+skma_id+'"]');
				var statusObj=liObj.find('.statusItem .state');
				statusObj.removeClass('on-line off-line').text(json.data.status_flag);
				if(json.data.status==2){
					statusObj.addClass('on-line');
				}else{
					statusObj.addClass('off-line');
				}
			}
		});
	});
	
	/////////////////////////////////////////////////
	$('body').on('click','.testItem',function(){
		var obj=$(this);
		var liObj=obj.parents('li');
		var skma_id=liObj.attr('data-id');
		layer.open({
			content: '<div style="padding-bottom:10px;">金额：<input type="text" id="test_money" value="1" style="line-height:30px;padding:0 5px;width:60%;border-radius:3px;border:1px solid #dedede;" /></div><span style="color:#f60;">您确定要发起测试么？</span>',
			style:'width:65%',
			btn: ['确定', '不了'],
			yes: function(index){
				var money=$.trim($('#test_money').val());
				layer.close(index);
				ajax({
					url:global.appurl+'c=Skma&a=skma_test',
					data:{skma_id:skma_id,money:money},
					success:function(json){
						if(json.code!=1){
							if(json.code=='-2'){
								_alert({content:json.msg,time:5});
								return;
							}
							_alert(json.msg);
							return;
						}
						var item=json.data;
						var con='<div>';
							con+='<div>金额：<span style="font-size:22px;color:#f30;font-weight:bold;">'+item.money+'</span></div>';
							if(item.qrcode){
								con+='<div><img src="'+item.qrcode+'" style="width:100%;"/></div>';
							}else{
								if(item.mtype_type==3){
									con+='<div>开户行：'+item.bank+'</div>';
								}
							}
							con+='<div>姓名：'+item.realname+'</div>';
							con+='<div>账号：'+item.account+'</div>';
						con+='</div>';
						layer.open({
							content:con,
							style:'width:80%',
							shadeClose:false,
							btn: '我已付款'
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
