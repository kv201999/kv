<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 01:56:18
         compiled from "/www/wwwroot/paofen123.com/admin/view/User/apikey.html" */ ?>
<?php /*%%SmartyHeaderCode:1661886645f970dc24c4a44-34121115%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '437a46250768e7b6735f1f86f2228e138ee01b5c' => 
    array (
      0 => '/www/wwwroot/paofen123.com/admin/view/User/apikey.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1661886645f970dc24c4a44-34121115',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'sys_group' => 0,
    'skey' => 0,
    'vo' => 0,
    'mtype_arr' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f970dc2517ea1_42697937',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f970dc2517ea1_42697937')) {function content_5f970dc2517ea1_42697937($_smarty_tpl) {?><div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>商户通道费率</span></div>
<div class="layui-card-body">
	<form class="layui-form" id="searchForm" onsubmit="return false;">
		<div class="layui-form-item" style="margin-bottom:5px;">
			<div class="layui-inline">
				<label class="layui-form-label" style="width:40px;">分组</label>
				<div class="layui-input-inline" style="width:100px;text-align:left;">
					<select id="s_gid">
						<option value="0">全部</option>
						<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['sys_group']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
				<label class="layui-form-label" style="width:50px;">关键词</label>
				<div class="layui-input-inline" style="width:180px;">
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
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="apikeyBtn">更新密钥</a>
		{{#if(d.setrate==1&&d.tdupdate==1){}}
        <a class="layui-btn layui-btn-normal layui-btn-xs" lay-event="tdRateBtn">设置费率</a>
		{{#}}}
		{{#if(d.appoint==1){}}
        <a class="layui-btn layui-btn-default layui-btn-xs" lay-event="appointBtn">指定设置</a>
		{{#}}}
    <?php echo '</script'; ?>
>

</div>
</div>
</div>

<?php echo '<script'; ?>
 type="text/html" id="layerTpl">
	<form class="layui-form LayerForm" onsubmit="return false;">
		<div class="layui-form-item layui-form-text" style="margin-bottom:0;">
			<label class="layui-form-label">上级账号：</label>
			<div class="layui-form-label" style="text-align:left;padding-left:0;">
				{{d.item.up_account||'—'}}
			</div>
		</div>
		<div class="layui-form-item layui-form-text" style="margin-bottom:0;">
			<label class="layui-form-label">下级账号：</label>
			<div class="layui-form-label" style="text-align:left;padding-left:0;">
				{{d.item.account}}
			</div>
		</div>
		{{#  layui.each(d.mtype_arr, function(index,item){}}
		{{#if(item.is_open==1){}}
		<div class="layui-form-item">
			<label class="layui-form-label">{{#if(index>1){}}&nbsp;{{#}else{}}通道费率：{{#}}}</label>
			<div class="layui-inline">
				<input type="text" placeholder="" autocomplete="off" class="layui-input td_rate" data-mtype-id="{{item.id}}" data-up-rate="{{#if(d.item.up_td_rate[item.id]){}}{{(d.item.up_td_rate[item.id]*100).toFixed(2)}}{{#}else{}}0{{#}}}" data-up-account="{{d.item.up_account||''}}" style="width:120px;" value="{{#if(d.item.td_rate[item.id]){}}{{(d.item.td_rate[item.id]*100).toFixed(2)}}{{#}else{}}0{{#}}}" />
				<span style="position:absolute;left:100px;top:10px;">%</span>
			</div>
			<span style="color:#f60;">【{{item.name}}】上级费率：{{#if(d.item.up_td_rate[item.id]){}}{{(d.item.up_td_rate[item.id]*100).toFixed(2)}}%{{#}else{}}未设置{{#}}}</span>
		</div>
		{{#}}}
		{{#});}}
		<div class="layui-form-item">
			<div class="layui-input-block">
				<input type="hidden" id="user_id" value="{{d.item.id}}" />
				<span class="layui-btn" onclick="saveTdrate(this)">提交</span>
				<div style="color:#f00;">设置下级的费率-小数，不得小于上级费率</div>
			</div>
		</div>
	</form>
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
>

var mtype_arr=jsonDecode('<?php echo json_encode($_smarty_tpl->tpl_vars['mtype_arr']->value);?>
');

$('#searchBtn').on('click',function(){
    var obj=$(this);
    var pdata={
		s_keyword:$.trim($('#s_keyword').val()),
		s_gid:$('#s_gid').val()
    };
    dataPage({
        where:pdata,
        url:global.appurl+'c=User&a=apikey_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'gname', title: '分组',width:90},
            {field:'nickname', title: '商户/上级',style:'text-align:left;',width:240,templet:function(d){
				var html=d.account+' / '+d.nickname;
				if(d.up_nickname){
					html+='<br>'+d.up_account+' / '+d.up_nickname+'（上级）';
				}
				return html;
			}},
			/*
            {field:'up_nickname', title: '上级',templet:function(d){
				if(!d.up_nickname){
					return '';
				}
				return d.up_account+'<br>'+d.up_nickname;
			}},*/
			<?php if ($_smarty_tpl->tpl_vars['user']->value['gid']<42) {?>
			{field:'appoint_agent_flag',title: '指定代理',templet:function(d){
				if(!d.appoint_agent_flag){
					return '';
				}
				var tmp_arr=d.appoint_agent_flag.split(',');
				var html='';
				for(var i in tmp_arr){
					html+=tmp_arr[i]+'<br>';
				}
				return html;
			}},
			{field:'appoint_ms_flag',title: '指定码商',templet:function(d){
				if(!d.appoint_ms_flag){
					return '';
				}
				var tmp_arr=d.appoint_ms_flag.split(',');
				var html='';
				for(var i in tmp_arr){
					html+=tmp_arr[i]+'<br>';
				}
				return html;
			}},
			<?php }?>
			{field:'apikey',width:240,title: '签名密钥'},
			{field:'td_rate', title: '通道费率&配置',width:510,style:'text-align:left;',templet:function(d){
				var html='';
				if(d.switch==1){
					html+='<form class="layui-form" action="#">';
					var idx=1;
					for(var i in d.td_rate){
						if(mtype_arr[i].is_open!=1){
							continue;
						}
						var switch_flag='';
						if(d.td_switch[i]==1){
							switch_flag='checked';
						}
						if(d.td_rate[i]){
							td_rate_i=(d.td_rate[i]*100).toFixed(2);
						}else{
							td_rate_i=0;
						}
						html+='<input type="checkbox" '+switch_flag+' value="'+d.id+'_'+i+'" lay-skin="primary" lay-filter="setPass" title="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'+mtype_arr[i].name+'：'+td_rate_i+'%"/>';
						if(idx%3==0){
							html+='<br>';
						}else{
							html+='&nbsp;&nbsp;';
						}
						idx++;
					}
					html+='</form>';
				}else{
					var idx=1;
					for(var i in d.td_rate){
						if(d.td_rate[i]){
							td_rate_i=(d.td_rate[i]*100).toFixed(2);
						}else{
							td_rate_i=0;
						}
						html+=mtype_arr[i].name+'：<b style="color:#f30;">'+td_rate_i+'%</b>';
						if(idx%3==0){
							html+='<br>';
						}else{
							html+='，';
						}
						idx++;
					}
					html=trim(html,'，');
				}
				return html;
			}},
            {field:'', width:240, title: '操作',toolbar:'#barItemAct'}
        ]],
        done:function(res, curr, count){
            //console.log(res);
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

layui.form.on('radio(appoint_type)', function(data){
	var obj=$(data.elem);
	var type=data.value;
	var accounts=obj.attr('data-accounts');
	if(!accounts){
		accounts='';
	}
	$('#appoint_accounts').val(accounts);
});

//当前操作项
var nowActItem=null;

//监听工具条
layui.table.on('tool(dataTable)', function(obj){
    nowActItem=obj;
    var item = obj.data;
    var layEvent = obj.event;
    var tr = obj.tr;
    
    if(layEvent === 'apikeyBtn'){
        layer.confirm('确定要更新密钥么？',{title:'系统提示',icon: 3},function(index){
            ajax({
                url:global.appurl+'c=User&a=apikey_update',
                data:{uid:item.id},
                success:function(json){
                    if(json.code!=1){
                        _alert(json.msg);
                        return;
                    }
					var uitem={apikey:json.data.apikey};
					nowActItem.update(uitem);
                    layer.close(index);
                }
            });
        });
    }else if(layEvent=='tdRateBtn'){
        layer.open({
            title:'设置通道费率',
            type: 1,
            shadeClose: true,
            area: global.screenType < 2 ? ['80%', '300px'] : ['540px', '600'],
            content: layui.laytpl($('#layerTpl').html()).render({item:item,mtype_arr:mtype_arr}),
            success:function(){
				//
				layui.form.render();
            }
        });
	}else if(layEvent=='appointBtn'){
		var con='<form class="layui-form">';
		con+='<div>';
			con+='<span style="position:relative;top:4px;">指定类型：</span>';
			con+='<input type="radio" name="appoint_type" value="1" title="码商代理" data-accounts="'+item.appoint_agent_flag+'" lay-filter="appoint_type" />';
			con+='<input type="radio" name="appoint_type" value="2" title="码商" data-accounts="'+item.appoint_ms_flag+'" lay-filter="appoint_type" />';
		con+='</div>';
		con+='<div>账号列表：<textarea class="layui-textarea" id="appoint_accounts" placeholder="留空则不指定"></textarea></div>';
		con+='<div style="color:#f30;">请务必填写正确否则将被过滤，多个账号使用逗号分隔 “,”，留空则不指定。</div>';
		con+='</form>';
		layer.open({
			title:'商户指定代理/码商匹配',
			content:con,
			btnAlign: 'c',
			btn:['确定','取消'],
			success:function(){
				layui.form.render();
			},
			yes:function(index){
				var appoint_type=$('input[name="appoint_type"]:checked').val();
				if(!appoint_type){
					alert('请选择指定类型');
					return;
				}
				var appoint_accounts=$.trim($('#appoint_accounts').val());
				if(!appoint_accounts){
					appoint_accounts='';
				}
				ajax({
					url:global.appurl+'c=User&a=appoint_update',
					data:{item_id:item.id,appoint_type:appoint_type,appoint_accounts:appoint_accounts},
					success:function(json){
						if(json.code=='1'){
							_alert(json.msg,'',function(){
								layer.close(index);
								var uitem={};
								if(appoint_type==1){
									uitem.appoint_agent_flag=json.data.accounts_str;
								}else if(appoint_type==2){
									uitem.appoint_ms_flag=json.data.accounts_str;
								}else{
									return;
								}
								nowActItem.update(uitem);
							});
						}else{
							_alert(json.msg);
						}
					}
				});
			}
		});
	}
});


///////////////////////////////////////////////////////////////

//保存通道费率
function saveTdrate(ts){
	var obj=$(ts);
	var td_rate={};
	var msg='';
	$('.td_rate').each(function(i,o){
		var iobj=$(o);
		var mtype_id=iobj.attr('data-mtype-id');
		var rate=(($.trim(iobj.val())*1)/100).toFixed(4);
		var up_rate=((iobj.attr('data-up-rate')*1)/100).toFixed(4);
		if(isNaN(up_rate)){
			up_rate=0;
		}
		var up_account=iobj.attr('data-up-account');
		if(!rate||rate.length<1||isNaN(rate)||rate<0||rate>1){
			msg='【'+mtype_arr[mtype_id].name+'】设置的通道费率不正确';
			return false;
		}else{
			if(up_account&&rate<up_rate){
				msg='【'+mtype_arr[mtype_id].name+'】设置的通道费率不能小于上级费率';
				return false;
			}
		}
		td_rate[mtype_id]=rate;
	});
	if(msg){
		_alert(msg);
		return;
	}
	
	var item_id=$('#user_id').val();
	ajax({
		url:global.appurl+'c=User&a=tdrate_update',
		data:{item_id:item_id,td_rate:td_rate},
		success:function(json){
			_alert(json.msg);
			if(json.code!=1){
				return;
			}
			layer.closeAll('page');
			$('#searchBtn').trigger('click');
			/*
			var uitem={
				td_rate:td_rate
			};
			nowActItem.update(uitem);
			*/
		}
	});
}

//设置通道开关
layui.form.on('checkbox(setPass)', function(data){
	//console.log(data.elem);
	var obj=$(data.elem);
	var uid_ptype=data.value;
	var is_open;
	if(data.elem.checked){
		is_open=1;
	}else{
		is_open=0;
	}
	ajax({
		url:global.appurl+'c=User&a=tdswitch_update',
		data:{uid_ptype:uid_ptype,is_open:is_open},
		success:function(json){
			if(json.code!=1){
				_alert(json.msg);
				layui.form.render('checkbox');
				return;
			}
			//
		}
	});
});

<?php echo '</script'; ?>
><?php }} ?>
