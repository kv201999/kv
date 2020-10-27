<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 16:00:59
         compiled from "D:\phpstudy_pro\WWW\kv\admin\view\Finance\banklog.html" */ ?>
<?php /*%%SmartyHeaderCode:148755f97d3bb5ea126-68794481%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5a0003820e54a17be7f25e8872d25c8bafdf28ea' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\Finance\\banklog.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '148755f97d3bb5ea126-68794481',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'bank_arr' => 0,
    'vo' => 0,
    'province_arr' => 0,
    'city_arr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f97d3bb618017_14791131',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97d3bb618017_14791131')) {function content_5f97d3bb618017_14791131($_smarty_tpl) {?><style>
.imgItemBtn{cursor:pointer;}
.banner_it{width:80px;height:80px;background-size:cover;border:1px solid #dedede;
line-height:80px;margin-right:5px;display:inline-block;float:left;text-align:center;font-size:4rem;cursor:pointer;
position:relative;}
.bannerItemCancel{position:absolute;right:0px;top:0px;font-size:30px;line-height:30px;background:rgba(11,11,11,0.5);color:#fff;}
</style>

<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>提现银行卡</span><span class="layui-btn layui-btn-sm layui-btn-normal addBtn">+添加卡</span></div>
<div class="layui-card-body">


        <form class="layui-form" id="searchForm" onsubmit="return false;">
            <div class="layui-form-item" style="margin-bottom:5px;">
			<div class="layui-inline">
				<label class="layui-form-label" style="width:60px;">开户行</label>
				<div class="layui-input-inline" style="width:160px;text-align:left;">
					<select id="s_bank_id">
						<option value="0">全部</option>
						<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bank_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['bank_name'];?>
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
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="edit">编辑</a>
        <?php echo '</script'; ?>
>
	
</div>
</div>
</div>

<!--弹层-->
<?php echo '<script'; ?>
 type="text/html" id="layerTpl">
	<form class="layui-form LayerForm" onsubmit="return false;">
		<div class="layui-form-item">
			<label class="layui-form-label">银行省市：</label>
			<div class="layui-inline" style="width:140px;margin-right:20px;">
				<select id="province_id" lay-filter="province_id">
					<option value="0">请选择省份</option>
					<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['province_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['cname'];?>
</option>
					<?php } ?>
				</select>
			</div>
			<div class="layui-inline" style="width:160px;">
				<select id="city_id" lay-filter="city_id" lay-search>
					<option value="0">请选择城市</option>
					<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['cname'];?>
</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label" style="font-size:13px;">开户行：</label>
			<div class="layui-input-block">
				<select id="bank_id">
					<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bank_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
					<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['bank_name'];?>
</option>
					<?php } ?>
				</select>
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">银行卡号：</label>
			<div class="layui-input-block">
				<input type="text" id="bank_account" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.bank_account||''}}" />
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">持卡姓名：</label>
			<div class="layui-input-block">
				<input type="text" id="bank_realname" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.bank_realname||''}}" />
			</div>
		</div>		
		<div class="layui-form-item">
			<div class="layui-input-block">
				<input type="hidden" id="item_id" value="{{d.item.id||''}}" />
				<span class="layui-btn" onclick="saveBtn(this)">提交保存</span>
			</div>
		</div>
	</form>
<?php echo '</script'; ?>
>


<?php echo '<script'; ?>
>

$('#searchBtn').on('click',function(){
    var obj=$(this);
    var pdata={
        s_keyword:$.trim($('#s_keyword').val()),
        s_bank_id:$.trim($('#s_bank_id').val()),
    };
    dataPage({
        where:pdata,
        url:global.appurl+'c=Finance&a=banklog_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'account', title: '商户',templet:function(d){
				return d.account+' / '+d.nickname;
			}},
            {field:'bank_name', title: '开户行'},
            {field:'bank_account',width:200, title: '银行卡号'},
            {field:'bank_realname', title: '收款姓名'},
			{field:'province_name', title: '省份'},
			{field:'city_name', title: '城市'},
            {field:'create_time', title: '创建时间'},
            {field:'', width:120, title: '操作',toolbar:'#barItemAct'}
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

//当前操作项
var nowActItem=null;

//监听工具条
layui.table.on('tool(dataTable)', function(obj){
    nowActItem=obj;
    var item = obj.data;
    var layEvent = obj.event;
    var tr = obj.tr;
 
    if(layEvent === 'del'){ //删除
        layer.confirm('确定要删除么？',{title:'系统提示',icon: 3},function(index){
            ajax({
                url:global.appurl+'c=Finance&a=banklog_delete',
                data:{item_id:item.id},
                success:function(json){
                    if(json.code!=1){
                        _alert(json.msg);
                        return;
                    }
                    obj.del();
                    layer.close(index);
                }
            });
        });
    } else if(layEvent === 'edit'){ //编辑
        updateView(obj);
    }
});

function updateView(obj){
    var item={};
    if(obj&&obj.data){
        item=obj.data;
        var title='编辑银行卡';
    }else{
        var title='添加银行卡';
    }
    layer.open({
        title:title,
        type: 1,
        shadeClose: true,
        area: global.screenType < 2 ? ['80%', '300px'] : ['540px', '360px'],
        content: layui.laytpl($('#layerTpl').html()).render({item:item}),
        success:function(){

            if(obj&&obj.data){
                //$('input[name="status"][value="'+item.status+'"]').attr('checked',true);
				provinceChange(item.province_id,item.city_id);
				$('#province_id').val(item.province_id);
				$('#bank_id').val(item.bank_id);
            }
            layui.form.render();
        }
    });
}
////////////////////////////////////////////////////////

$('.addBtn').on('click',function(){
    updateView(null);
});

//切换城市
provinceChange(0,0);
layui.form.on('select(province_id)', function(data){
	var pid=data.value;
	provinceChange(pid,0);
});

function provinceChange(pid,cid){
	var pObj=$('#province_id');
	//var province_id=pObj.val();
	var html='<option value="0">请选择城市</option>';
	if(pid<1){
		$('#city_id').html(html);
		layui.form.render('select');
	}else{
		ajax({
			url:global.appurl+'c=Pay&a=getCity',
			data:{pid:pid},
			beforeSend:function(){
				$('#city_id').html(html);
				layui.form.render('select');
			},
			success:function(json){
				if(!json.data){
					return;
				}
				for(var i in json.data){
					var item=json.data[i];
					var selected='';
					if(cid==item.id){
						selected='selected';
					}
					html+='<option value="'+item.id+'" '+selected+'>'+item.cname+'</option>';
				}
				$('#city_id').html(html);
				layui.form.render('select');
			}
		});
	}
}

///////////////////////////////////////


//保存更新
function saveBtn(ts){
	var obj=$(ts);
	var item_id=$('#item_id').val();
	var i_index=$('#item_id').attr('i-index');
	var province_id=$.trim($('#province_id').val());
	var city_id=$.trim($('#city_id').val());
	var bank_id=$.trim($('#bank_id').val());
	var bank_account=$.trim($('#bank_account').val());
	var bank_realname=$.trim($('#bank_realname').val());
	//var max_tmoney=$.trim($('#max_tmoney').val());
	//var sort=$.trim($('#sort').val());
	//var cover=$.trim($('#cover').val());
	//var status=$('input[name="status"]:checked').val();
	var has_click=obj.attr('has-click');
	if(has_click=='1'){
		return false;
	}else{
		obj.attr('has-click','1');
	}
	ajax({
		url:global.appurl+'c=Finance&a=banklog_update',
		data:{item_id:item_id,province_id:province_id,city_id:city_id,bank_id:bank_id,bank_account:bank_account,bank_realname:bank_realname},
		success:function(json){
			_alert(json.msg);
			obj.attr('has-click','0');
			if(json.code!='1'){
				return false;
			}
			layer.closeAll('page');

			if(!item_id){
				$('#searchBtn').trigger('click');//重新加载
			}else{

                nowActItem.update({
                    bank_id:bank_id,
                    bank_name:$('#bank_id').find('option[value="'+bank_id+'"]').text(),
                    bank_account:bank_account,
                    bank_realname:bank_realname,
                    province_id:province_id,
                    province_name:$('#province_id').find('option[value="'+province_id+'"]').text(),
                    city_id:city_id,
                    city_name:$('#city_id').find('option[value="'+city_id+'"]').text()
                    //max_tmoney:max_tmoney,
                    //sort:sort,
                    //cover:cover,
                    //status:status,
                    //status_flag:$('input[name="status"][value="'+status+'"]').attr('title')
                });
                
			}
		}
	});
}



<?php echo '</script'; ?>
><?php }} ?>
