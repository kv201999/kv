<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-29 17:46:50
         compiled from "D:\phpstudy_pro\WWW\kv\admin\view\Finance\paylog.html" */ ?>
<?php /*%%SmartyHeaderCode:80995f9a8f8adae743-53153285%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bfe668b140db5d83befb87e9b2dd47a57f584077' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\Finance\\paylog.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '80995f9a8f8adae743-53153285',
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
  'unifunc' => 'content_5f9a8f8ae05ed2_46661368',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9a8f8ae05ed2_46661368')) {function content_5f9a8f8ae05ed2_46661368($_smarty_tpl) {?><style>
.imgItemBtn{cursor:pointer;}
.userItem{display:inline-block;margin-right:5px;border:1px solid #dedede;position:relative;width:80px;cursor:pointer;}
.userItem img{height:80px;}
.userItem .nickname{position:absolute;left:0;bottom:0;display:block;width:100%;overflow:hidden;background:rgba(11,11,11,0.4);color:#fefefe;text-align:center;}
.userItemNva{border:1px solid #f60;}
</style>
<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>充值记录</span></div>
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
                <label class="layui-form-label" style="width:60px;">支付状态</label>
                <div class="layui-input-inline" style="width:120px;text-align:left;">

                    <select id="s_pay_status" name="s_pay_status">
                        <option value="all">全部</option>
                        <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_paylog_status'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
    <!--记录操作工具条-->
    <?php echo '<script'; ?>
 type="text/html" id="barItemAct">
        {{#if(d.check==1&&d.pay_status<=2){}}
        <a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="check">审核</a>
		{{#}else{}}
		/
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
		s_pay_status:$.trim($('#s_pay_status').val()),
		s_start_time:$.trim($('#s_start_time').val()),
		s_end_time:$.trim($('#s_end_time').val()),
	};
	dataPage({
		where:pdata,
        url:global.appurl+'c=Finance&a=paylog_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'account', title: '订单号/充值用户',width:210,templet:function(d){
				return d.order_sn+'<br>'+d.account+' / '+d.nickname;
			}},
            //{field:'order_sn', title: '订单号'},
            {field:'a_account', title: '审核用户',templet:function(d){
				if(!d.a_account){
					return '平台';
				}
				return d.a_account+'<br>'+d.a_nickname;
			}},
            {field:'skbank_id', title: '支付方式',width:220,style:'text-align:left;',templet:function(d){
				var html='';
				if(!d.bank_name){
					return html;
				}
				html+='<div>'+d.bank_name+'</div>';
				html+='<div>'+d.bank_realname+'</div>';
				html+='<div>'+d.bank_account+'</div>';
				return html;
			}},
            {field:'money', title: '订单金额'},
            {field:'ori_balance', title: '原余额'},
            {field:'new_balance', title: '现余额'},
            {field:'create_time',width:130, title: '创建时间'},
            {field:'banners', title: '支付凭证',templet:function(d){
				var html='';
				for(var i in d.banners){
					html+='<img src="'+d.banners[i]+'" class="imgItemBtn" onclick="showImg(this)" style="height:50px;margin:0 3px;"/>';
				}
				return html;
			}},
            {field:'pay_realname', title: '付款姓名'},
            {field:'pay_account', title: '付款账号'},
            {field:'remark', title: '付款备注'},
            {field:'pay_status_flag', title: '支付状态'},
            {field:'pay_time',width:120, title: '支付时间'},
			{field:'', width:70, title: '操作',toolbar:'#barItemAct'}
        ]],
        done:function(res, curr, count){
            //console.log(res);
            if($('.sumLine').length<1){
                var html='<div class="sumLine"><span>订单总数：'+res.odata.count+'</span><span>订单总额：'+res.odata.sum_money+'</span></div>';
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

//当前操作项
var nowActItem=null;

//监听工具条
layui.table.on('tool(dataTable)', function(obj){
    nowActItem=obj;
    var item = obj.data;
    var layEvent = obj.event;
    var tr = obj.tr;
 
    if(layEvent === 'check'){
		var con='<form class="layui-form">';
			con+='<input type="radio" name="ck_pay_status" value="1" title="待支付" />';
			con+='<input type="radio" name="ck_pay_status" value="3" title="已支付"/>';
			con+='<input type="radio" name="ck_pay_status" value="99" title="删除"/>';
		con+='</form>';
		
		layer.open({
			title:'充值到账审核？',
			content:con,
			btnAlign: 'c',
			btn:['确定','取消'],
			success:function(){
				layui.form.render();
			},
			yes:function(index){
				var pay_status=$('input[name="ck_pay_status"]:checked').val();
				if(!pay_status){
					alert('请选择支付状态');
					return;
				}
				
				ajax({
					url:global.appurl+'c=Finance&a=paylog_check',
					data:{item_id:item.id,pay_status:pay_status},
					success:function(json){
						if(json.code!=1){
							alert(json.msg);
							return;
						}
						layer.close(index);
						_alert(json.msg);
						if(pay_status==99){
							obj.del();
							return;
						}
						var uitem={
							pay_status:json.data.pay_status,
							pay_status_flag:json.data.pay_status_flag
						};
						if(pay_status==3){
							uitem.pay_time=json.data.pay_time;
							uitem.ori_balance=json.data.ori_balance;
							uitem.new_balance=json.data.new_balance;
						}
						nowActItem.update(uitem);
						$(nowActItem.tr.selector).find('td').last().html('/');
					}
				});
				
			}
		});

    }
});


//导出操作
$('#downloadBtn').on('click',function(){
	$('#is_download').val(1);
	var params=$('#searchForm').serialize();
	var url='<?php echo @constant('APP_URL');?>
?c=User&a=paylog_list&'+params;
	window.open(url,'_blank');
	$('#is_download').val(0);
});

<?php echo '</script'; ?>
><?php }} ?>