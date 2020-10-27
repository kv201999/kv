<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-22 18:22:48
         compiled from "D:\phpstudy_pro\WWW\admin\view\Sys\oauth.html" */ ?>
<?php /*%%SmartyHeaderCode:306735f915d7808ff90-94474510%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd348d67266fb7a1128e0d4aae8dad842930ea173' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\admin\\view\\Sys\\oauth.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '306735f915d7808ff90-94474510',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'skey' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f915d780b0133_61290819',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f915d780b0133_61290819')) {function content_5f915d780b0133_61290819($_smarty_tpl) {?><div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>权限管理</span></div>
<div class="layui-card-body">

    <form class="layui-form" id="searchForm" action="">
        <div class="layui-form-item" style="margin-bottom:5px;text-align: left;">
            
            <div class="layui-inline">
                <label class="layui-form-label">系统分组</label>
                <div class="layui-input-inline" style="width:120px;">
                    <select id="s_gid">
                        <option value="0">请选择</option>
                        <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('sys_group'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                <label class="layui-form-label" style="width:30px;">账号</label>
                <div class="layui-input-inline" style="width:180px;">
                    <input type="text" name="s_account" id="s_account" autocomplete="off" class="layui-input" placeholder="请输入账号">
                </div>
            </div>
            <div class="layui-inline" style="margin-right:0;">
                <span class="layui-btn layui-btn-normal" id="searchBtn">设置</span>&nbsp;&nbsp;&nbsp;&nbsp;
                <span style="color:#f60;">授权优先级账号高于分组</span>
            </div>
        </div>
    </form>


    <div class="appContentBox">
        <?php echo '<script'; ?>
 id="listTpl" type="text/html">
            <form class="layui-form" action="#">
                {{# layui.each(d.list, function(index, item){ }}
                <fieldset class="layui-elem-field" style="margin-top: 20px;">
                    <legend style="color:#000;font-weight:bold;">
                        <input type="checkbox" name="oauth" lay-skin="primary" title="{{item.name}}{{item.type_flag}}{{item.public_flag}}" value="{{item.id}}" {{# if(item.oauth==1){ }}checked{{# } }} />
                    </legend>
                    <div class="layui-field-box">
                        <div class="layui-form-item">
                        {{# layui.each(item.sub_node, function(sindex, sitem){ }}
                            <input type="checkbox" name="oauth" lay-skin="primary" title="{{sitem.name}}{{sitem.type_flag}}{{sitem.public_flag}}" value="{{sitem.id}}" {{# if(sitem.oauth==1){ }}checked{{# } }} />&nbsp;&nbsp;
                        {{# }); }}
                        </div>
                        {{# if(item.sub_node===0){ }}
                        <div>没有子节点</div>
                        {{# } }}
                    </div>
                </fieldset>
                {{# }); }}
                {{# if(d.list.length === 0){ }}
                <div class="layui-field-box">暂时没有数据</div>
                {{#	} }}
            </form>
            <div style="padding:10px 0;">
                <span class="layui-btn layui-btn-small layui-btn-danger oauthSaveBtn">确定授权</span>
            </div>
        <?php echo '</script'; ?>
>
        <div id="appContentHtml"></div>
    </div>
        
</div>
</div>
</div>


<?php echo '<script'; ?>
>


$('#searchBtn').on('click',function(){
	var obj=$(this);
	var s_account=$.trim($('#s_account').val());
	if(s_account){
		$('#s_gid').val(0);
	}

	var pdata={
		s_account:$.trim($('#s_account').val()),
		s_gid:$('#s_gid').val()
    };
    var has_click=obj.attr('has-click');
    if(has_click=='1'){
        return;
    }else{
        obj.attr('has-click','1');
    }
    ajax({
        url:global.appurl+'c=Sys&a=oauth_list',
        data:pdata,
        success:function(json){
            obj.attr('has-click','0');
            if(json.code!=1){
                _alert(json.msg);
                return;
            }
            var tpl=layui.laytpl($('#listTpl').html()).render(json.data);
            $('#appContentHtml').html(tpl);
            layui.form.render();
        }
    });
});

$('#searchBtn').trigger('click');

$('#s_account').on('keyup',function(e){
	if(e.keyCode==13){
		$('#searchBtn').trigger('click');
	}
});


//保存
$('body').on('click','.oauthSaveBtn',function(){
	var obj=$(this);
	var account=$.trim($('#s_account').val());
	var gid=$('#s_gid').val();
	if(gid<1&&!account){
		_alert('请设置需要授权的对象');
		return false;
	}
	var oauth=[];
	$('input[name="oauth"]:checked').each(function(i,o){
		oauth.push($(o).val());
	});
	layer.open({
		title:'系统提示',
		content:'您确定要进行授权码？',
		btnAlign: 'c',
		btn:['确定','取消'],
		yes:function(index){
			ajax({
				url:global.appurl+'c=Sys&a=oauth_update',
				data:{gid:gid,account:account,oauth:oauth},
				success:function(json){
					if(json.code=='1'){
						_alert(json.msg,'',function(){
							layer.close(index);
						});
					}else{
						_alert(json.msg);
					}
				}
			});
			return false;
		},
		btn2:function(index){
			layer.close(index);
		}
	});
});

<?php echo '</script'; ?>
><?php }} ?>
