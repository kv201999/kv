<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-29 17:46:34
         compiled from "D:\phpstudy_pro\WWW\kv\admin\view\Pay\yong.html" */ ?>
<?php /*%%SmartyHeaderCode:46185f9a8f7a42ac00-86065616%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '591d8eed6ffc898f696e2db2201d77d6d65cf0da' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\Pay\\yong.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '46185f9a8f7a42ac00-86065616',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
    'skey' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9a8f7a477f96_60220058',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9a8f7a477f96_60220058')) {function content_5f9a8f7a477f96_60220058($_smarty_tpl) {?><div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>分成记录</span></div>
<div class="layui-card-body">
    
    
        <form class="layui-form" id="searchForm" onsubmit="return false;">
            <div class="layui-form-item" style="margin-bottom:5px;">
				<div class="layui-inline">
					<label class="layui-form-label" style="width:60px;">分成类型</label>
					<div class="layui-input-inline" style="width:120px;text-align:left;">
						<select id="s_type">
							<option value="0">全部</option>
							<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_yong_type'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
							<?php if ($_smarty_tpl->tpl_vars['user']->value['gid']>41) {?>
								<?php if (in_array($_smarty_tpl->tpl_vars['user']->value['gid'],array(85,91))&&$_smarty_tpl->tpl_vars['skey']->value==1) {?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
								<?php }?>
								<?php if (in_array($_smarty_tpl->tpl_vars['user']->value['gid'],array(61,81))&&$_smarty_tpl->tpl_vars['skey']->value==2) {?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
								<?php }?>
							<?php } else { ?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
							<?php }?>
							<?php } ?>
						</select>
					</div>
				</div>
			
                <div class="layui-inline" style="margin-right:0;">
                    <label class="layui-form-label" style="width:30px;">开始</label>
                    <div class="layui-input-inline" style="width:120px;">
                        <input name="s_start_time" id="s_start_time" class="layui-input" placeholder="请选择" />
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:30px;">结束</label>
                    <div class="layui-input-inline" style="width:120px;">
                        <input name="s_end_time" id="s_end_time" class="layui-input" placeholder="请选择">
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
    
</div>
</div>
</div>
    
    
<?php echo '<script'; ?>
>

$('#searchBtn').on('click',function(){
    var obj=$(this);
    var pdata={
        s_keyword:$.trim($('#s_keyword').val()),
        s_type:$.trim($('#s_type').val()),
        s_start_time:$.trim($('#s_start_time').val()),
        s_end_time:$.trim($('#s_end_time').val())
    };
    dataPage({
        where:pdata,
        url:global.appurl+'c=Pay&a=yong_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'type_flag', title: '分成类型'},
            {field:'account',width:220, title: '所属用户',templet:function(d){
                return d.account+'（'+d.nickname+'）';
            }},
            {field:'level', title: '层级'},
            {field:'order_money', title: '订单金额'},
            {field:'rate', title: '分成比例'},
            {field:'money', title: '分成额度'},
            {field:'ori_balance', title: '原余额'},
            {field:'new_balance', title: '现余额'},
            {field:'create_time', title: '时间'}
        ]],
        done:function(res, curr, count){
            //console.log(res);
            if($('.sumLine').length<1){
                var html='<div class="sumLine"><span>分成总额：'+res.odata.sum_money+'</span></div>';
                $('.layui-table-page').before(html);   
            }
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


<?php echo '</script'; ?>
><?php }} ?>
