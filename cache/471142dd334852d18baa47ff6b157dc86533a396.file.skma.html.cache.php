<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-29 17:46:28
         compiled from "D:\phpstudy_pro\WWW\kv\admin\view\Pay\skma.html" */ ?>
<?php /*%%SmartyHeaderCode:64335f9a8f745e9595-12290655%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '471142dd334852d18baa47ff6b157dc86533a396' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\Pay\\skma.html',
      1 => 1581840097,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '64335f9a8f745e9595-12290655',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'updateall' => 0,
    'mtype_arr' => 0,
    'vo' => 0,
    'skey' => 0,
    'province_arr' => 0,
    'bank_arr' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9a8f746815e4_39738775',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9a8f746815e4_39738775')) {function content_5f9a8f746815e4_39738775($_smarty_tpl) {?><style>
.imgItemBtn{cursor:pointer;}
.banner_it{width:80px;height:80px;background-size:cover;border:1px solid #dedede;
line-height:80px;margin-right:5px;display:inline-block;float:left;text-align:center;font-size:4rem;cursor:pointer;
position:relative;}
.bannerItemCancel{position:absolute;right:0px;top:0px;font-size:30px;line-height:30px;background:rgba(11,11,11,0.5);color:#fff;}
</style>

<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header">
	<span>收款码列表</span>
	<span class="layui-btn layui-btn-sm layui-btn-normal addBtn">+添加</span>
	<?php if ($_smarty_tpl->tpl_vars['updateall']->value) {?>
	<span class="layui-btn layui-btn-sm layui-btn-danger msSet" style="margin-top:8px;margin-right:20px;float:right;">批量设置</span>
	<?php }?>
</div>
<div class="layui-card-body">


    <form class="layui-form" id="searchForm" onsubmit="return false;">
        <div class="layui-form-item" style="margin-bottom:5px;">
            <div class="layui-inline">
                <label class="layui-form-label" style="width:40px;">类型</label>
                <div class="layui-input-inline" style="width:140px;">
                    <select id="s_mtype_id" name="s_mtype_id">
                        <option value="0">全部</option>
                        <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['mtype_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['name'];?>
</option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width:60px;">用户在线</label>
                <div class="layui-input-inline" style="width:100px;">
                    <select id="s_is_online" name="s_is_online">
                        <option value="all">全部</option>
                        <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('yes_or_no'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
                <label class="layui-form-label" style="width:50px;">码状态</label>
                <div class="layui-input-inline" style="width:100px;">
                    <select id="s_status" name="s_status">
                        <option value="0">全部</option>
                        <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_skma_status'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
		{{#if(d.delete==1){}}
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
		{{#}}}
		{{#if(d.edit==1){}}
        <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="edit">编辑</a>
		{{#}}}
    <?php echo '</script'; ?>
>
    
</div>
</div>
</div>

<!--弹层-->
<?php echo '<script'; ?>
 type="text/html" id="layerTpl">
    <form class="layui-form LayerForm" onsubmit="return false;">
        <div class="layui-form-item" style="width:45%;">
            <label class="layui-form-label">类型：</label>
            <div class="layui-input-block" style="width:160px;">
                <select id="mtype_id" lay-filter="mtype_id">
					<option value="0">请选择类型</option>
                    <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['mtype_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
" data-type="<?php echo $_smarty_tpl->tpl_vars['vo']->value['type'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['name'];?>
</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <div class="layui-inline" style="margin-right:0;width:45%;">
                <label class="layui-form-label">所在省份：</label>
                <div class="layui-input-inline" style="width:160px;">
					<select id="province_id" lay-filter="province_id">
						<option value="0">请选择省份</option>
						<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['province_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['cname'];?>
</option>
						<?php } ?>
					</select>
                </div>
            </div>
            <div class="layui-inline" style="width:150px;width:45%;">
                <label class="layui-form-label" style="width:60px;padding-left:0;">城市：</label>
                <div class="layui-input-inline" style="width:160px;">
					<select id="city_id">

					</select>
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text suserBox" style="{{#if(d.item.stype==2){}}display:none;{{#}}}">
            <label class="layui-form-label">所属用户：</label>
            <div class="layui-input-block">
                <input type="text" id="account" placeholder="系统用户的账号" style="width:50%;" autocomplete="off" class="layui-input" value="{{d.item.account||''}}" />
            </div>
        </div>
        <div class="layui-form-item bankBox" style="width:45%;display:none;">
            <label class="layui-form-label">开户行：</label>
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
        <div class="layui-form-item layui-form-text bankBox">
            <label class="layui-form-label"><span>开户支行</span>：</label>
            <div class="layui-input-block">
                <input type="text" id="branch_name" placeholder="选填" style="width:50%;" autocomplete="off" class="layui-input" value="{{d.item.branch_name||''}}" />
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label"><span>收款姓名</span>：</label>
            <div class="layui-input-block">
                <input type="text" id="ma_realname" placeholder="账号对应的真实姓名" style="width:50%;" autocomplete="off" class="layui-input" value="{{d.item.ma_realname||''}}" />
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label"><span>收款账号</span>：</label>
            <div class="layui-input-block">
                <input type="text" id="ma_account" placeholder="支付宝/微信/手机号/卡号等等" style="width:50%;" autocomplete="off" class="layui-input" value="{{d.item.ma_account||''}}" />
            </div>
        </div>
        <div class="layui-form-item layui-form-text maxBox" style="display:none;">
            <label class="layui-form-label"><span>单笔最小</span>：</label>
            <div class="layui-input-block">
                <input type="text" id="min_money" placeholder="" style="width:50%;" autocomplete="off" class="layui-input" value="{{d.item.min_money||<?php echo getConfig('cnf_skm_min_money');?>
}}" />
            </div>
        </div>
        <div class="layui-form-item layui-form-text maxBox" style="display:none;">
            <label class="layui-form-label"><span>单笔最大</span>：</label>
            <div class="layui-input-block">
                <input type="text" id="max_money" placeholder="" style="width:50%;" autocomplete="off" class="layui-input" value="{{d.item.max_money||<?php echo getConfig('cnf_skm_max_money');?>
}}" <?php if ($_smarty_tpl->tpl_vars['user']->value['gid']>41) {?>disabled<?php }?> />
            </div>
        </div>
		
        <div class="layui-form-item moneyBox2" style="width:45%;display:none;">
            <label class="layui-form-label">选择金额：</label>
            <div class="layui-input-block">
                <select id="ma_zkmoney">
					<option value="0">0</option>
                    <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_zkling_mitem'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
                    <option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
</option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="layui-form-item layui-form-text moneyBox" style="display:none;">
            <label class="layui-form-label"><span>口令内容</span>：</label>
            <div class="layui-input-block">
				<textarea class="layui-textarea" id="ma_zkling" style="margin-bottom:10px;height:40px;">{{d.item.ma_zkling||''}}</textarea>
            </div>
        </div>
		
        <div class="layui-form-item layui-form-text uidBox" style="display:none;">
            <label class="layui-form-label"><span>UID</span>：</label>
            <div class="layui-input-block">
                <input type="text" id="ma_zfbuid" placeholder="空格会自动去除" style="width:50%;" autocomplete="off" class="layui-input" value="{{d.item.ma_zfbuid||''}}" />
            </div>
        </div>
        <div class="layui-form-item layui-form-text uidBox" style="display:none;">
            <label class="layui-form-label"><span>获取UID</span>：</label>
            <div class="layui-input-block">
                <img src="public/home/images/zfbuid.png" style="width:50%;"/>
            </div>
        </div>
		
        <div class="layui-form-item codeImgBox" style="margin-bottom:0;">
            <label class="layui-form-label">收款码：</label>
            <div class="layui-input-block">
                <div class="layui-upload">
                    <div class="layui-upload-list" id="coverImgBtn" title="点击修改" style="background-image:url(/{{d.item.ma_qrcode}});display:inline-block;cursor:pointer;width:80px;height:80px;line-height:80px;text-align:center;border:1px solid #dedede;background-size:cover;background-color:#eee;">
                        <i class="layui-icon" style="font-size:30px;">&#xe654;</i>
                        <input type="hidden" id="cover" value="{{d.item.ma_qrcode||''}}"/>
                    </div>
                    <div style="color:#f60;display:inline-block;">建议尺寸320×320</div>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <label class="layui-form-label">状态：</label>
            <div class="layui-input-block">
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_skma_status'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>
                <input type="radio" name="status" value="<?php echo $_smarty_tpl->tpl_vars['skey']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['vo']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['skey']->value==1) {?>checked="checked"<?php }?> />
				<?php } ?>
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
 type="text/html" id="layerTpl2">
    <form class="layui-form LayerForm" onsubmit="return false;">
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">码商账号：</label>
            <div class="layui-input-block">
                <input type="text" id="ms_account" placeholder="" style="width:50%;" autocomplete="off" class="layui-input" value="" />
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label"><span>单笔最小</span>：</label>
            <div class="layui-input-block">
                <input type="text" id="ms_min_money" placeholder="" style="width:50%;" autocomplete="off" class="layui-input" value="<?php echo getConfig('cnf_skm_min_money');?>
" />
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label"><span>单笔最大</span>：</label>
            <div class="layui-input-block">
                <input type="text" id="ms_max_money" placeholder="" style="width:50%;" autocomplete="off" class="layui-input" value="<?php echo getConfig('cnf_skm_max_money');?>
" />
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <span class="layui-btn" onclick="saveMsBtn(this)">提交保存</span>
            </div>
        </div>
    </form>
<?php echo '</script'; ?>
>

<?php echo '<script'; ?>
 src="public/js/base64.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>

$('#searchBtn').on('click',function(){
    var obj=$(this);
    var pdata={
        s_keyword:$.trim($('#s_keyword').val()),
        s_status:$.trim($('#s_status').val()),
        s_is_online:$.trim($('#s_is_online').val()),
        s_mtype_id:$.trim($('#s_mtype_id').val()),
    };
    dataPage({
        where:pdata,
        url:global.appurl+'c=Pay&a=skma_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'uid', title: '用户',templet:function(d){
				return d.account+'<br>'+d.nickname;
			}},
            {field:'mtype_name', title: '类型'},
            {field:'ma_realname',width:240,title: '收款信息',templet:function(d){
				var html='';
				html+='<div style="text-align:left;">';
					if(d.mtype_type==3){
						html+='<div>银行：'+d.bank_name+'</div>';
						if(d.branch_name){
							html+='<div>支行：'+d.branch_name+'</div>';
						}
					}
					html+='<div>姓名：'+d.ma_realname+'</div>';
					html+='<div>账号：'+d.ma_account+'</div>';
				html+='</div>';
				return html;
			}},
            //{field:'ma_account', title: '收款账号'},
			/*
            {field:'bank_id', title: '开户行',templet:function(d){
				var html='';
				if(d.mtype_type==3){
					html+='<div>'+d.bank_name+'</div>';
					if(d.branch_name){
						html+='<div>'+d.branch_name+'</div>';
					}
				}else{
					html+='/';
				}
				return html;
			}},*/
            {field:'ma_qrcode', title: '收款码',width:90,templet:function(d){
				if(d.mtype_type!=2){
					return '/';
				}
				var qrcode='<img style="height:40px;" src="'+d.ma_qrcode+'"/ onclick="showImg(this);" >';
				return qrcode;
			}},
			{field:'province_name', title: '省份'},
			{field:'city_name', title: '城市'},
			{field:'min_money', title: '单笔最小'},
			{field:'max_money', title: '单笔最大'},
			{field:'create_time', title: '创建时间',width:130},
            {field:'status_flag', title: '状态',width:80,templet:function(d){
				var style='';
				var span='<span style="'+style+'">'+d.status_flag+'</span>';
				return span;
			}},
			{field:'tj', style:'text-align:left;',width:240,title: '订单统计',templet:function(d){
				var html='<div style="line-height:18px;">';
				html+='<div>今日：'+d.jt_money+'元 ， '+d.jt_cnt+'/'+d.jt_cnt2+'笔&nbsp;&nbsp;'+d.jt_percent+'</div>';
				html+='<div>昨日：'+d.zt_money+'元 ， '+d.zt_cnt+'/'+d.zt_cnt2+'笔&nbsp;&nbsp;'+d.zt_percent+'</div>';
				html+='<div>一周：'+d.wt_money+'元 ， '+d.wt_cnt+'/'+d.wt_cnt2+'笔&nbsp;&nbsp;'+d.wt_percent+'</div>';
				html+='</div>';
				return html;
			}},
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
                url:global.appurl+'c=Pay&a=skma_delete',
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

////////////////////////////////////////////////////////
//全部隐藏
function showNone(){
	$('.bankBox,.codeImgBox,.maxBox,.moneyBox,.uidBox').hide();
}

//只显示账号
function showAccount(){
	showNone();
}

//显示银行信息
function showBank(){
	showNone();
	$('.bankBox').show();
}

//显示二维码
function showCode(){
	showNone();
	$('.codeImgBox').show();
}

function iniSetInput(mtype_id){
	var mtype_type=$('#mtype_id').find('option[value="'+mtype_id+'"]').attr('data-type');
	if(!mtype_type||mtype_id<1){
		showNone();
		return;
	}
	showNone();
	if(mtype_type==1){
		showAccount();
	}else if(mtype_type==2){
		showCode();
	}else if(mtype_type==3){
		showBank();
	}else if(mtype_type==4){
		$('.moneyBox').show();
	}else if(mtype_type==5){
		$('.uidBox').show();
	}
	$('.maxBox').show();
}
////////////////////////////////////////////////////////

function updateView(obj){
    var item={};
    if(obj&&obj.data){
        item=obj.data;
        var title='编辑收款码';
    }else{
        var title='添加收款码';
    }
    layer.open({
        title:title,
        type: 1,
        shadeClose: true,
        area: global.screenType < 2 ? ['80%', '300px'] : ['700px', '655px'],
        content: layui.laytpl($('#layerTpl').html()).render({item:item}),
        success:function(){

            fileUpload({
                elem: '#coverImgBtn',
                auto:true,
                done:function(json){
                    if(json.code!='1'){
                        _alert(json.msg);
                        return false;
                    }
                    $('#cover').val(json.data.src);
                    $('#coverImgBtn').css({backgroundImage:'url(/'+json.data.src+')'});
                }
            });

            if(obj&&obj.data){
				$('#province_id').val(item.province_id);
				initPc(item.province_id,item.city_id);
                $('input[name="status"][value="'+item.status+'"]').attr('checked',true);
                $('#mtype_id').val(item.mtype_id).prop('disabled',true);
				iniSetInput(item.mtype_id);
                $('#bank_id').val(item.bank_id);
                $('#ma_zkmoney').val(item.ma_zkmoney);
            }else{
				iniSetInput(1);
			}
            layui.form.render();
        }
    });
}

////////////////////////////////////////////////////////

$('.addBtn').on('click',function(){
    updateView(null);
});



//切换支付类型
layui.form.on('select(mtype_id)', function(data){
	var mtype_id=data.value;
	iniSetInput(mtype_id);
});

//切换省份
layui.form.on('select(province_id)', function(data){
	var province_id=data.value;
	initPc(province_id,0);
});

function initPc(province_id,city_id){
	ajax({
		url:global.appurl+'c=Pay&a=getCity',
		data:{pid:province_id},
		success:function(json){
			var html='';
			for(var i in json.data){
				var item=json.data[i];
				html+='<option value="'+item.id+'">'+item.cname+'</option>';
			}
			$('#city_id').html(html).val(city_id>0?city_id:0);
			layui.form.render('select');
		}
	});
}

///////////////////////////////////////


//保存更新
function saveBtn(ts){
    var obj=$(ts);
    var item_id=$('#item_id').val();
    var mtype_id=$.trim($('#mtype_id').val());
    var province_id=$.trim($('#province_id').val());
    var city_id=$.trim($('#city_id').val());
    var account=$.trim($('#account').val());
    var bank_id=$.trim($('#bank_id').val());
    var branch_name=$.trim($('#branch_name').val());
    var ma_realname=$.trim($('#ma_realname').val());
    var ma_account=$.trim($('#ma_account').val());
    var min_money=$.trim($('#min_money').val());
    var max_money=$.trim($('#max_money').val());
    var cover=$.trim($('#cover').val());
    var status=$('input[name="status"]:checked').val();
	
	var ma_zkmoney=$.trim($('#ma_zkmoney').val());
	var ma_zkling_flag=$.trim($('#ma_zkling').val());
	var ma_zkling='';
	if(ma_zkling_flag){
		ma_zkling=Base64.encode(ma_zkling_flag);
	}
	
	var ma_zfbuid=$.trim($('#ma_zfbuid').val());
	
	if(mtype_id<1){
		_alert('请选择支付类型');
		return;
	}
	
    var has_click=obj.attr('has-click');
    if(has_click=='1'){
        return false;
    }else{
        obj.attr('has-click','1');
    }
    ajax({
        url:global.appurl+'c=Pay&a=skma_update',
        data:{
			item_id:item_id,mtype_id:mtype_id,province_id:province_id,city_id:city_id,
			account:account,min_money:min_money,max_money:max_money,
			bank_id:bank_id,ma_realname:ma_realname,ma_account:ma_account,
			status:status,ma_qrcode:cover,branch_name:branch_name,
			ma_zkmoney:ma_zkmoney,ma_zkling:ma_zkling,ma_zfbuid:ma_zfbuid
		},
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

                var uitem={
					account:account,
					nickname:json.data.nickname,
                    //bank_id:bank_id,
                    //bank_name:$('#bank').find('option[value="'+bank_id+'"]').text(),
                    min_money:min_money,
                    max_money:max_money,
                    ma_realname:ma_realname,
                    ma_account:ma_account,
					status:status,
                    status_flag:$('input[name="status"][value="'+status+'"]').attr('title'),
                    mtype_id:mtype_id,
                    mtype_name:$('#mtype_id').find('option[value="'+mtype_id+'"]').text(),
					province_id:province_id,
					city_id:city_id,
					province_name:$('#province_id').find('option[value="'+province_id+'"]').text(),
					city_name:$('#city_id').find('option[value="'+city_id+'"]').text()
                };
				var mtype_type=$('#mtype_id').find('option[value="'+mtype_id+'"]').attr('data-type');
				if(mtype_type==2){
					uitem.ma_qrcode=cover;
				}else if(mtype_type==3){
					uitem.bank_id=bank_id;
					uitem.bank_name=$('#bank').find('option[value="'+bank_id+'"]').text();
					uitem.branch_name=branch_name;
				}else if(mtype_type==4){
					uitem.ma_zkmoney=ma_zkmoney;
					uitem.ma_zkling=ma_zkling_flag;
				}else if(mtype_type==5){
					uitem.ma_zfbuid=ma_zfbuid;
				}
                nowActItem.update(uitem);
                
            }
        }
    });
}

///////////////////////////////////////////////////////

//批量设置收款码区间
$('.msSet').on('click',function(){
	var item={};
    layer.open({
        title:'批量设置码商收款码金额区间',
        type: 1,
        shadeClose: true,
        area: global.screenType < 2 ? ['80%', '300px'] : ['500px', '305px'],
        content: layui.laytpl($('#layerTpl2').html()).render({item:item}),
        success:function(){
            layui.form.render();
        }
    });
});

function saveMsBtn(ts){
    var obj=$(ts);
    var ms_account=$.trim($('#ms_account').val());
    var ms_min_money=$.trim($('#ms_min_money').val());
    var ms_max_money=$.trim($('#ms_max_money').val());
    var has_click=obj.attr('has-click');
    if(has_click=='1'){
        return false;
    }else{
        obj.attr('has-click','1');
    }
    ajax({
        url:global.appurl+'c=Pay&a=skma_allupdate',
        data:{ms_account:ms_account,ms_min_money:ms_min_money,ms_max_money:ms_max_money},
        success:function(json){
            _alert(json.msg);
            obj.attr('has-click','0');
            if(json.code!='1'){
                return false;
            }
            layer.closeAll('page');
            $('#searchBtn').trigger('click');//重新加载
        }
    });
}

<?php echo '</script'; ?>
><?php }} ?>
