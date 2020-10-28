<?php /*%%SmartyHeaderCode:137475f99450db11c16-58446301%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '137475f99450db11c16-58446301',
  'variables' => 
  array (
    'skey' => 0,
    'vo' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f99450db79685_50185244',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f99450db79685_50185244')) {function content_5f99450db79685_50185244($_smarty_tpl) {?><div class="layui-col-md12">
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
                                                <option value="50">后台充值余额</option>
                                                <option value="51">前台充值余额</option>
                                                <option value="52">充值冻结</option>
                                                <option value="53">充值接单余额</option>
                                                <option value="54">充值应回款</option>
                                                <option value="55">接单可提余额互转</option>
                                                <option value="3">商户订单结算</option>
                                                <option value="4">码商订单分成</option>
                                                <option value="5">商户订单分成</option>
                                                <option value="6">夜间接单奖励</option>
                                                <option value="8">注册赠送余额</option>
                                                <option value="11">提现支出</option>
                                                <option value="12">提现退还</option>
                                                <option value="13">接单冻结</option>
                                                <option value="14">扣除冻结</option>
                                                <option value="15">冻结退还</option>
                                                <option value="16">补单扣除</option>
                                                <option value="20">订单回款</option>
                                                <option value="21">订单累计应回款</option>
                                                <option value="22">码商应回款扣除</option>
                                                <option value="23">码商应回款退还</option>
                                                <option value="24">审核增加应回款</option>
                                                <option value="31">用户提现应回款拨付</option>
                                                <option value="32">审核提现应回款退还</option>
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


<script>

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

</script><?php }} ?>
