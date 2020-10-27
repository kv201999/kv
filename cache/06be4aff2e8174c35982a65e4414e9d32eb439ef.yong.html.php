<?php /*%%SmartyHeaderCode:12245661555f9707cb3acce5-66495727%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '06be4aff2e8174c35982a65e4414e9d32eb439ef' => 
    array (
      0 => '/www/wwwroot/paofen123.com/admin/view/Pay/yong.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12245661555f9707cb3acce5-66495727',
  'variables' => 
  array (
    'user' => 0,
    'skey' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9707cb43b0e3_37878063',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9707cb43b0e3_37878063')) {function content_5f9707cb43b0e3_37878063($_smarty_tpl) {?><div class="layui-col-md12">
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
																					<option value="1">码商分成</option>
																												<option value="2">商户分成</option>
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
    
    
<script>

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


</script><?php }} ?>
