<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-26 17:53:29
         compiled from "D:\phpstudy_pro\WWW\admin\view\Sys\bset.html" */ ?>
<?php /*%%SmartyHeaderCode:225505f969c99ba7c29-30076044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0522d2c131bb6e2f10f21d969ac7b298d060f8ca' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\admin\\view\\Sys\\bset.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '225505f969c99ba7c29-30076044',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f969c99bbfd08_88701167',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f969c99bbfd08_88701167')) {function content_5f969c99bbfd08_88701167($_smarty_tpl) {?><div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>基础配置</span><span class="layui-btn layui-btn-sm layui-btn-normal addBtn">+添加配置</span></div>
<div class="layui-card-body">

    <form class="layui-form" id="searchForm" action="">
        <div class="layui-form-item" style="margin-bottom:5px;">
            <div class="layui-inline">
                <label class="layui-form-label">关键词</label>
                <div class="layui-input-inline">
                <input type="text" name="s_keyword" id="s_keyword" placeholder="请输入关键词" autocomplete="off" class="layui-input">
                </div>
            </div>
            <div class="layui-inline">
                <div class="layui-input-inline">
                <span class="layui-btn" id="searchBtn">查询</span>
                <!--<span class="layui-btn layui-btn-danger">导出</span>-->
                </div>
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
			<label class="layui-form-label">单KEY：</label>
			<div class="layui-input-block">
				<input type="radio" name="single" value="0" title="否" checked="checked">
				<input type="radio" name="single" value="1" title="是">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">SKEY：</label>
			<div class="layui-input-block">
				<input type="text" id="skey" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.skey||''}}" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">名称：</label>
			<div class="layui-input-block">
				<input type="text" id="name" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.name||''}}" />
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">配置内容：</label>
			<div class="layui-input-block">
				<textarea id="config" placeholder="" class="layui-textarea">{{d.item.config||''}}</textarea>
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<input type="hidden" id="item_id" value="{{d.item.id||''}}" />
				<span class="layui-btn" onclick="saveAct(this);">提交保存</span>
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
		s_keyword:$.trim($('#s_keyword').val())
	};
	dataPage({
		where:pdata,
        url:global.appurl+'c=Sys&a=bset_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'skey', title: 'SKEY'},
            {field:'name', title: '配置名称'},
            {field:'config_flag',width:500, title: '配置内容'},
            {field:'single_flag',width:80, title: '单KEY'},
            {field:'', width:120, title: '操作',toolbar:'#barItemAct'}
        ]],
        done:function(res, curr, count){
            //console.log(res);
        }
	});
});

$('#searchBtn').trigger('click');

$('#s_keyword').on('keyup',function(e){
	if(e.keyCode==13){
		$('#searchBtn').trigger('click');
	}
});

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
                url:global.appurl+'c=Sys&a=bset_delete',
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
        var title='编辑配置';
    }else{
        var title='添加配置';
    }
    layer.open({
        title:title,
        type: 1,
        shadeClose: true,
        area: global.screenType < 2 ? ['80%', '300px'] : ['540px', '410px'],
        content: layui.laytpl($('#layerTpl').html()).render({item:item}),
        success:function(){
            if(obj&&obj.data){
                $('input[name="single"][value="'+item.single+'"]').attr('checked',true);
				$('input[name="single"]').prop('disabled',true);
            }
            layui.form.render();
        }
    });
}
////////////////////////////////////////////////////////

$('.addBtn').on('click',function(){
    updateView(null);
});

//保存更新
function saveAct(dom){
	var obj=$(dom);
	var item_id=$('#item_id').val();
	var skey=$.trim($('#skey').val());
	var name=$.trim($('#name').val());
	var config=$.trim($('#config').val());
	var single=$('input[name="single"]:checked').val();
	if(!skey){
		_alert('请填写SKEY');
		return false;
	}
	if(!name){
		_alert('请填写配置名称');
		return false;
	}
	if(!config){
		_alert('请填写配置内容');
		return false;
	}
	var has_click=obj.attr('has-click');
	if(has_click=='1'){
		return false;
	}else{
		obj.attr('has-click','1');
	}
	ajax({
		url:global.appurl+'c=Sys&a=bset_update',
		data:{item_id:item_id,skey:skey,name:name,single:single,config:config},
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
                //同步更新
                nowActItem.update({
                    name: name,
                    skey: skey,
                    single: single,
                    config: config,
                    config_flag: config,
                    single_flag: $('input[name="single"][value="'+single+'"]').attr('title')
                });
			}
		}
	});
}

////////////////////////////////////////////////////////

<?php echo '</script'; ?>
><?php }} ?>