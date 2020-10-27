<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-22 16:34:36
         compiled from "D:\phpstudy_pro\WWW\admin\view\Sys\log.html" */ ?>
<?php /*%%SmartyHeaderCode:303045f91441cb003e3-89012958%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4975c63d5841a13944b7e873bc0bc6e06ccb8238' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\admin\\view\\Sys\\log.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '303045f91441cb003e3-89012958',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f91441cb61d79_67223574',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f91441cb61d79_67223574')) {function content_5f91441cb61d79_67223574($_smarty_tpl) {?><div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>日志查询</span></div>
<div class="layui-card-body">


        <form class="layui-form" id="searchForm" action="">
            <div class="layui-form-item" style="margin-bottom:5px;">
                <div class="layui-inline" style="margin-right:0;">
                    <label class="layui-form-label" style="width:30px;">开始</label>
                    <div class="layui-input-inline" style="width:120px;">
                        <input name="s_start_time" id="s_start_time" class="layui-input" placeholder="操作开始日期" />
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label" style="width:30px;">结束</label>
                    <div class="layui-input-inline" style="width:120px;">
                        <input name="s_end_time" id="s_end_time" class="layui-input" placeholder="操作结束日期">
                    </div>
                </div>
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

<?php echo '<script'; ?>
>

$('#searchBtn').on('click',function(){
	var obj=$(this);
	var pdata={
		s_keyword:$.trim($('#s_keyword').val()),
		s_start_time:$.trim($('#s_start_time').val()),
		s_end_time:$.trim($('#s_end_time').val())
	};
	dataPage({
		where:pdata,
        url:global.appurl+'c=Sys&a=log_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'nickname',width:180, title: '用户'},
            {field:'opt_name', width:180,title: '操作名'},
            {field:'sql_str', title: '操作详情'},
            {field:'create_time',width:120, title: '时间'},
            {field:'create_ip',width:140, title: 'IP'}
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

<?php echo '</script'; ?>
><?php }} ?>
