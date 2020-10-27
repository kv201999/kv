<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 16:01:17
         compiled from "D:\phpstudy_pro\WWW\kv\admin\view\Finance\balancelog.html" */ ?>
<?php /*%%SmartyHeaderCode:71275f97d3cd3fba63-02796114%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9e08f3722282f5f3e79371ba70bbd1e69c808db9' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\Finance\\balancelog.html',
      1 => 1602039328,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '71275f97d3cd3fba63-02796114',
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
  'unifunc' => 'content_5f97d3cd41b6b8_63549704',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97d3cd41b6b8_63549704')) {function content_5f97d3cd41b6b8_63549704($_smarty_tpl) {?><div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>资金变动明细</span></div>
<div class="layui-card-body">

    <form class="layui-form" id="searchForm" action="">
        <div class="layui-form-item" style="margin-bottom:5px;">
            <div class="layui-inline" style="margin-right:0;">
                <label class="layui-form-label" style="width:30px;">开始</label>
                <div class="layui-input-inline" style="width:120px;">
                    <input name="s_start_time" id="s_start_time" class="layui-input" placeholder="开始日期" />
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width:30px;">结束</label>
                <div class="layui-input-inline" style="width:120px;">
                    <input name="s_end_time" id="s_end_time" class="layui-input" placeholder="结束日期">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width:60px;">发生类型</label>
                <div class="layui-input-inline" style="width:140px;text-align:left;">

                    <select id="s_type" name="s_type">
                        <option value="all">全部</option>
                        <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_balance_type'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                <!--
                <span class="layui-btn layui-btn-danger" id="downloadBtn">导出</span>
                -->
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
		s_end_time:$.trim($('#s_end_time').val()),
	};
	dataPage({
		where:pdata,
        url:global.appurl+'c=Finance&a=balancelog_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'gname', title: '分组'},
            {field:'account', title: '用户',templet:function(d){
				return d.account+' / '+d.nickname;
			}},
            {field:'type_flag', title: '类型'},
            {field:'money', title: '发生额度'},
            {field:'ori_balance', title: '原余额'},
            {field:'new_balance', title: '现余额'},
            {field:'remark', title: '备注',width:300},
            {field:'create_time',width:120, title: '发生时间'}
        ]],
        done:function(res, curr, count){
            //console.log(res);
            if($('.sumLine').length<1){
                var html='<div class="sumLine"><span>总额：'+res.odata.sum_money+'</span></div>';
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
