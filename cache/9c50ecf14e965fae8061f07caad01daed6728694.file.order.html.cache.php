<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-29 18:30:28
         compiled from "D:\phpstudy_pro\WWW\kv\admin\view\Pay\order.html" */ ?>
<?php /*%%SmartyHeaderCode:22025f9a99c48304b0-65208563%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c50ecf14e965fae8061f07caad01daed6728694' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\Pay\\order.html',
      1 => 1603937460,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '22025f9a99c48304b0-65208563',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'create' => 0,
    'mtype_arr' => 0,
    'vo' => 0,
    'skey' => 0,
    'isOrderHk' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9a99c4876b46_29494694',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9a99c4876b46_29494694')) {function content_5f9a99c4876b46_29494694($_smarty_tpl) {?><style>
	.layui-table td, .layui-table th{
		font-size: 12px;
	}
	.layui-table-cell{
		padding: 0 5px;
	}
	#searchForm{
		text-align:left;
		font-size: 12px;
	}
	.layui-form-label{
		padding: 9px 10px;
		text-align: left;
	}
</style>
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">
	<span>订单明细</span>
	<?php if ($_smarty_tpl->tpl_vars['create']->value) {?><span class="layui-btn layui-btn-sm layui-btn-normal addBtn">+创建订单</span><?php }?>
</div>
<div class="layui-card-body">
    
	<form class="layui-form" id="searchForm" onsubmit="return false;">
		<div class="layui-form-item" style="margin-bottom:5px;">
		
			<div class="layui-inline">
				<label class="layui-form-label" style="width:60px;">订单创建</label>
				<div class="layui-input-inline" style="width:120px;">
					<select id="s_is_create" name="s_is_create">
						<option value="0">全部</option>
						<option value="1">后台创建</option>
						<option value="2">前台创建</option>
					</select>
				</div>
			</div>
		
			<div class="layui-inline">
				<label class="layui-form-label" style="width:60px;">支付类型</label>
				<div class="layui-input-inline" style="width:120px;">
					<select id="s_mtype_id" name="s_mtype_id">
						<option value="0">全部</option>
						<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['mtype_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['name'];?>
</option>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="layui-inline">
				<label class="layui-form-label" style="width:60px;">支付状态</label>
				<div class="layui-input-inline" style="width:120px;">
					<select id="s_pay_status" name="s_pay_status">
						<option value="0">全部</option>
						<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_pay_status'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<div class="layui-inline">
				<label class="layui-form-label" style="width:60px;">回调状态</label>
				<div class="layui-input-inline" style="width:120px;">
					<select id="s_notice_status" name="s_notice_status">
						<option value="0">全部</option>
						<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_notice_status'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
						<?php } ?>
					</select>
				</div>
			</div>
			
			<?php if ($_smarty_tpl->tpl_vars['isOrderHk']->value) {?>
			<div class="layui-inline">
				<label class="layui-form-label" style="width:60px;">回款状态</label>
				<div class="layui-input-inline" style="width:120px;">
					<select id="s_hk_status" name="s_hk_status">
						<option value="all">全部</option>
						<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_order_hkstatus'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
						<?php } ?>
					</select>
				</div>
			</div>
			<?php }?>

			<div class="layui-inline" style="margin-right:-4px;"></div>
		</div>
		<div class="layui-form-item" style="margin-bottom:5px;">
			<div class="layui-inline" style="margin-right:0;">
				<label class="layui-form-label" style="width:30px;">开始</label>
				<div class="layui-input-inline" style="width:100px;">
					<input name="s_start_time" id="s_start_time" class="layui-input" placeholder="请选择" />
				</div>
			</div>
			<div class="layui-inline" style="margin-right:0;">
				<label class="layui-form-label" style="width:30px;">结束</label>
				<div class="layui-input-inline" style="width:100px;">
					<input name="s_end_time" id="s_end_time" class="layui-input" placeholder="请选择">
				</div>
			</div>
			<?php if ($_smarty_tpl->tpl_vars['user']->value['gid']<42) {?>
            <div class="layui-inline">
                <label class="layui-form-label" style="width:80px;">收款码账号</label>
                <div class="layui-input-inline" style="width:130px;">
                    <input type="text" name="s_ma_account" id="s_ma_account" autocomplete="off" class="layui-input" placeholder="请输入">
                </div>
            </div>
			<?php }?>
            <div class="layui-inline">
                <label class="layui-form-label" style="width:60px;">搜索团队</label>
                <div class="layui-input-inline" style="width:130px;">
                    <input type="text" name="s_keyword2" id="s_keyword2" autocomplete="off" class="layui-input" placeholder="请输入">
                </div>
            </div>
			<div class="layui-inline">
				<label class="layui-form-label" style="width:50px;">关键词</label>
				<div class="layui-input-inline" style="width:130px;">
					<input type="text" name="s_keyword" id="s_keyword" autocomplete="off" class="layui-input" placeholder="请输入关键词">
				</div>
			</div>
			<div class="layui-inline" style="margin-right:0;">
				<input type="hidden" name="is_download" id="is_download"/>
				<span class="layui-btn" id="searchBtn">查询</span>
				<!--<span class="layui-btn layui-btn-danger" id="downloadBtn">导出</span>-->
			</div>
		</div>
	</form>

	<table class="layui-hide" id="dataTable" lay-filter="dataTable"></table>
    <!--记录操作工具条-->
    <?php echo '<script'; ?>
 type="text/html" id="barItemAct">
		{{#if(d.delete==1&&d.pay_status>2){}}
		<a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="delete">删除</a>
		{{#}}}
		
		{{#if(d.pay_status==9){}}
			{{#if(d.notice==1){}}
			<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="notice">回调</a>
			{{#}}}
		{{#}}}
		
		{{#if(d.pay_status!=9){}}
			{{#if(d.pay_status==2){}}
				{{#if(d.check==1){}}
				<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="check">确认</a>
				{{#}}}
				
				{{#if(d.cancel==1){}}
				<a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="cancel">取消</a>
				{{#}}}
			{{#}}}
			
			{{#if(d.check==1&&d.pay_status==1){}}
			<a class="layui-btn layui-btn-primary layui-btn-xs" lay-event="check">确认</a>
			{{#}}}
			
			{{#if(d.budan==1&&d.pay_status==3){}}
			<a class="layui-btn layui-btn-warm layui-btn-xs" lay-event="budan">补单</a>
			{{#}}}
		{{#}}}
		
		{{#if(d.match==1&&(d.pay_status==1||d.pay_status==2)){}}
		<a class="layui-btn layui-btn-xs" lay-event="match">匹配</a>
		{{#}}}
		
    <?php echo '</script'; ?>
>
    
</div>
</div>
</div>
    
    
<?php echo '<script'; ?>
>

$('#searchBtn').on('click',function(){
    var obj=$(this);
    var pdata={
        s_keyword:$.trim($('#s_keyword').val()),
        s_keyword2:$.trim($('#s_keyword2').val()),
        s_ma_account:$.trim($('#s_ma_account').val()),
        s_mtype_id:$.trim($('#s_mtype_id').val()),
        s_pay_status:$.trim($('#s_pay_status').val()),
        s_notice_status:$.trim($('#s_notice_status').val()),
		s_hk_status:$.trim($('#s_hk_status').val()),
		s_is_create:$.trim($('#s_is_create').val()),
        s_start_time:$.trim($('#s_start_time').val()),
        s_end_time:$.trim($('#s_end_time').val())
    };
	if(!pdata.s_hk_status){
		pdata.s_hk_status='all';
	}
	
    dataPage({
        where:pdata,
        url:global.appurl+'c=Pay&a=order_list',
        cols:[[
           // {field:'id', width:80, title: 'ID'},
			{field:'order_sn',width:150,style:'text-align:left;',title: '类型/系统/商户单号',templet:function(d){
				var html=d.mtype_name;
				html+='<br>'+d.order_sn+'<br>'+d.out_order_sn;
				if(d.pay_status==9){
					html+='<span class="isFinishFlag"></span>';
				}
				return html;
			}},
			//{field:'out_order_sn', title: '商户单号'},
			{field:'rmb', width:75,title: '订单金额'},
			{field:'otcbuy',width:55, title: '兑换价格'},
			{field:'money', width:65,title: 'USDT'},
			//{field:'goods_desc', title: '商品描述'},
			<?php if ($_smarty_tpl->tpl_vars['user']->value['gid']<42||in_array($_smarty_tpl->tpl_vars['user']->value['gid'],array(61,81))) {?>
			{field:'fee', width:55,title: '手续费'},
			{field:'real_money', width:65,title: '应结算'},
            {field:'su_account',width:70, title: '所属商户',templet:function(d){
                return d.su_account+'<br>'+d.su_nickname;
            }},
			<?php }?>
			//{field:'mtype_name', title: '支付类型'},
			<?php if ($_smarty_tpl->tpl_vars['user']->value['gid']<42||$_smarty_tpl->tpl_vars['user']->value['gid']==85) {?>
            {field:'mu_account',width:160,title: '码商/收款码',templet:function(d){
				var html='';
				if(d.ma_id<1){
					return '/';
				}
				html+='<div style="text-align:left;">';
					html+='<div style="border-bottom:1px solid #dedede;">'+d.mu_account+' / '+d.mu_nickname+'</div>';
					if(d.bank_name){
						html+='<div>银行：'+d.bank_name+'</div>';
					}
					html+='<div>账号：'+d.ma_account+'</div>';
					html+='<div>姓名：'+d.ma_realname+' / '+d.ma_id+'</div>';
					if(d.ma_qrcode){
						html+='<img onclick="showImg(this);" src="'+d.ma_qrcode+'" style="cursor:pointer;height:50px;position:absolute;right:0;top:30px;"/>';
					}
				html+='</div>';
				return html;
            }},
            /*
			{field:'ma_account',width:160,style:'text-align:left;',title: '收款码',templet:function(d){
                var html='';
				if(d.ma_id>0){
					if(d.bank_name){
						html+='<div>银行：'+d.bank_name+'</div>';
					}
					html+='<div>账号：'+d.ma_account+'</div>';
					html+='<div>姓名：'+d.ma_realname+'</div>';
				}else{
				}
				return html;
            }},*/
			// {field:'up_user',width:130,title: '上级代理',templet:function(d){
			// 	var html='';
			// 	if(!d.up_arr||d.up_arr.length<1){
			// 		return html;
			// 	}
			// 	for(var i in d.up_arr){
			// 		var it=d.up_arr[i];
			// 		html+='<div style="text-align:left;">'+it.account+'</div>';
			// 	}
			// 	return html;
			// }},
			<?php }?>
            {field:'check_id', title: '确认者',templet:function(d){
				if(!d.check_id||d.check_id==0){
					return '';
				}
				var html='';
				if(d.check_id=='-1'){
					html='自动回调';
				}else if(d.check_id==1){
					html='管理员';
				}else{
					html='码商';
				}
				html+='<br>'+d.check_id;
				return html;
			}},
            {field:'create_time',width:100,title: '下单时间'},
            {field:'pay_status_flag',width:60, title: '支付状态'},
            {field:'pay_time',width:100,title: '支付时间'},
            {field:'notice_status_flag', title: '通知状态'},
            // {field:'notice_msg', title: '回复内容'},
			<?php if ($_smarty_tpl->tpl_vars['isOrderHk']->value) {?>
            {field:'hk_status_flag',width:80,title: '回款状态',templet:function(d){
				if(d.pay_status!=9){
					return '/';
				}
				return d.hk_status_flag;
			}},
			<?php }?>
			{field:'', width:100, title: '操作',toolbar:'#barItemAct'}
        ]],
        done:function(res, curr, count){
            //console.log(res);
            if($('.sumLine').length<1){
				var html='<div class="sumLine">';
					html+='<span>订单数：'+res.odata.count+'</span>';
					html+='<span>订单总额：'+res.odata.sum_money+'</span>';
					<?php if ($_smarty_tpl->tpl_vars['user']->value['gid']<42||in_array($_smarty_tpl->tpl_vars['user']->value['gid'],array(61,81))) {?>
					html+='<span>应结算：'+res.odata.sum_real_money+'</span>';
					html+='<span>手续费：'+res.odata.sum_fee+'</span>';
					<?php }?>
				html+='</div>';
                $('.layui-table-page').before(html); 
            }
			$('.isFinishFlag').each(function(i,o){
				var obj=$(o);
				var tr=obj.parents('tr');
				tr.css({color:'#00c250'});
			});
        }
    });
});

$('#s_keyword').on('keyup',function(e){
    if(e.keyCode==13){
        $('#searchBtn').trigger('click');
    }
});

$('#searchBtn').trigger('click');

////////////////////////////////////////////////////////

//当前操作项
var nowActItem=null;

//监听工具条
layui.table.on('tool(dataTable)', function(obj){
    nowActItem=obj;
    var item = obj.data;
    var layEvent = obj.event;
    var tr = obj.tr;
    if(layEvent === 'notice'){
        layer.confirm('确定要进行回调么？',{title:'系统提示',icon: 3},function(index){
            ajax({
                url:global.appurl+'c=Pay&a=order_notice',
                data:{item_id:item.id},
                success:function(json){
                    if(json.code!=1){
                        _alert(json.msg);
                        return;
                    }
                    layer.close(index);
					_alert(json.msg);
					var uitem={
						notice_status:json.data.notice_status,
						notice_status_flag:json.data.notice_status_flag,
						notice_msg:json.data.notice_msg
					};
					nowActItem.update(uitem);
                }
            });
        });
    }else if(layEvent=='delete'){
        layer.confirm('确定要删除么，删除后不可找回？',{title:'系统提示',icon: 3},function(index){
            ajax({
                url:global.appurl+'c=Pay&a=order_delete',
                data:{item_id:item.id},
                success:function(json){
                    if(json.code!=1){
                        _alert(json.msg);
                        return;
                    }
                    layer.close(index);
					obj.del();
                }
            });
        });
	}else if(layEvent=='check'){
        layer.confirm('确定已收到款了么？',{title:'系统提示',icon: 3},function(index){
            ajax({
                url:global.appurl+'c=Pay&a=order_check',
                data:{item_id:item.id},
                success:function(json){
                    if(json.code!=1){
                        _alert(json.msg);
                        return;
                    }
                    layer.close(index);
					_alert(json.msg);
					var uitem={
						pay_status:json.data.pay_status,
						pay_status_flag:json.data.pay_status_flag,
						pay_time:json.data.pay_time,
						notice_status:json.data.notice_status,
						notice_status_flag:json.data.notice_status_flag,
						notice_msg:json.data.notice_msg
					};
					nowActItem.update(uitem);
					$(nowActItem.tr.selector).find('td').last().html('<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="notice">回调</a>');
                }
            });
        });
	}else if(layEvent=='cancel'){
        layer.confirm('您确定要取消该订单么？',{title:'系统提示',icon: 3},function(index){
            ajax({
                url:global.appurl+'c=Pay&a=order_cancel',
                data:{item_id:item.id},
                success:function(json){
                    if(json.code!=1){
                        _alert(json.msg);
                        return;
                    }
                    layer.close(index);
					var uitem={
						pay_status:json.data.pay_status,
						pay_status_flag:json.data.pay_status_flag,
						cancel_time:json.data.cancel_time,
					};
					nowActItem.update(uitem);
					$(nowActItem.tr.selector).find('td').last().html('/');
                }
            });
        });
	}else if(layEvent=='match'){
		var con='<div>';
			con+='<div>订单号：'+item.order_sn+'</div>';
			con+='<div>订单金额：'+item.rmb+'</div>';
			con+='<div>兑换价格：'+item.otcbuy+'</div>';
			con+='<div>USDT金额：'+item.money+'</div>';
			con+='<div>支付状态：'+item.pay_status_flag+'</div>';
			con+='<div>当前码商：'+item.mu_account+' / '+item.mu_nickname+'</div>';
			con+='<div>支付方式：'+item.mtype_name+'</div>';
			con+='<div>匹配目标码商账号：<input type="text" class="layui-input" placeholder="请填写新码商账号" id="newMsAccount" value=""/></div>';
		con+='</div>';
		layer.open({
			title:'变更匹配码商',
			content:con,
			area:['400px','315px'],
			btn:['确定更改','关闭'],
			yes:function(idx){
				var account=$.trim($('#newMsAccount').val());
				var item_id=item.id;
				if(!account){
					alert('请填写新码商账号');
					return;
				}
				ajax({
					url:global.appurl+'c=Pay&a=order_match',
					data:{item_id:item.id,account:account},
					success:function(json){
						if(json.code!=1){
							alert(json.msg);
							return;
						}
						_alert(json.msg);
						var uitem={
							mu_account:json.data.mu_account,
							mu_nickname:json.data.mu_nickname
						};
						nowActItem.update(uitem);
						//$(nowActItem.tr.selector).find('td').last().html('/');
					}
				});
			}
		});
	}else if(layEvent=='budan'){
        layer.confirm('您确定要进行补单么？',{title:'系统提示',icon: 3},function(index){
            ajax({
                url:global.appurl+'c=Pay&a=order_budan',
                data:{item_id:item.id},
                success:function(json){
                    if(json.code!=1){
                        _alert(json.msg);
                        return;
                    }
                    layer.close(index);
					var uitem={
						pay_status:json.data.pay_status,
						pay_status_flag:json.data.pay_status_flag,
						pay_time:json.data.pay_time,
						notice_status:json.data.notice_status,
						notice_status_flag:json.data.notice_status_flag,
						notice_msg:json.data.notice_msg
					};
					nowActItem.update(uitem);
					$(nowActItem.tr.selector).find('td').last().html('<a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="notice">回调</a>');
                }
            });
        });
	}
});

//创建订单
$('.addBtn').on('click',function(){
	var obj=$(this);
	var con='<div>';
		con+='<div>异常单号：<input type="text" class="layui-input" placeholder="金额有差异的系统单号" id="yc_order_sn" value=""/></div>';
		con+='<div>实付金额：<input type="text" class="layui-input" placeholder="请填写实际支付的金额" id="yc_money" value=""/></div>';
	con+='</div>';
	layer.open({
		title:'创建订单',
		content:con,
		area:['400px','265px'],
		btn:['提交','关闭'],
		yes:function(idx){
			var order_sn=$.trim($('#yc_order_sn').val());
			var money=$.trim($('#yc_money').val());
			if(!order_sn){
				alert('请填写异常单号');
				return;
			}
			if(!money){
				alert('请填写实付金额');
				return;
			}
			if(money<=0.01){
				alert('实付金额不正确');
				return;
			}
			ajax({
				url:global.appurl+'c=Pay&a=order_create',
				data:{order_sn:order_sn,money:money},
				success:function(json){
					if(json.code!=1){
						alert(json.msg);
						return;
					}
					_alert(json.msg);
					$('#searchBtn').trigger('click');
				}
			});
		}
	});
});


<?php echo '</script'; ?>
><?php }} ?>
