<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-28 18:16:39
         compiled from "D:\phpstudy_pro\WWW\kv\admin\view\Finance\bank.html" */ ?>
<?php /*%%SmartyHeaderCode:88155f994507be2704-70340376%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9957648e33493acb580e25be3709f4e69f2eafea' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\Finance\\bank.html',
      1 => 1603711001,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '88155f994507be2704-70340376',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'bank_arr' => 0,
    'vo' => 0,
    'user' => 0,
    'province_arr' => 0,
    'city_arr' => 0,
    'skey' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f994507c1ed11_42286600',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f994507c1ed11_42286600')) {function content_5f994507c1ed11_42286600($_smarty_tpl) {?><style>
.imgItemBtn{cursor:pointer;}
.banner_it{width:80px;height:80px;background-size:cover;border:1px solid #dedede;
line-height:80px;margin-right:5px;display:inline-block;float:left;text-align:center;font-size:4rem;cursor:pointer;
position:relative;}
.bannerItemCancel{position:absolute;right:0px;top:0px;font-size:30px;line-height:30px;background:rgba(11,11,11,0.5);color:#fff;}
</style>

<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>收款银行卡</span><span class="layui-btn layui-btn-sm layui-btn-normal addBtn">+添加卡</span></div>
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
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">所属代理：</label>
			<div class="layui-input-block">
				<input type="text" id="account" placeholder="留空归属平台" autocomplete="off" class="layui-input" <?php if ($_smarty_tpl->tpl_vars['user']->value['gid']!=1) {?>disabled<?php }?> value="<?php if ($_smarty_tpl->tpl_vars['user']->value['gid']==1) {?>{{d.item.account||''}}<?php } else {
echo $_smarty_tpl->tpl_vars['user']->value['account'];
}?>" />
			</div>
		</div>
<!--		<div class="layui-form-item">-->
<!--			<label class="layui-form-label">银行省市：</label>-->
<!--			<div class="layui-inline" style="width:140px;margin-right:20px;">-->
<!--				<select id="province_id" lay-filter="province_id">-->
<!--					<option value="0">请选择省份</option>-->
<!--					<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['province_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>-->
<!--					<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['cname'];?>
</option>-->
<!--					<?php } ?>-->
<!--				</select>-->
<!--			</div>-->
<!--			<div class="layui-inline" style="width:160px;">-->
<!--				<select id="city_id" lay-filter="city_id" lay-search>-->
<!--					<option value="0">请选择城市</option>-->
<!--					<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['city_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
?>-->
<!--					<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['cname'];?>
</option>-->
<!--					<?php } ?>-->
<!--				</select>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="layui-form-item">-->
<!--			<label class="layui-form-label" style="font-size:13px;">开户行：</label>-->
<!--			<div class="layui-input-block">-->
<!--				<select id="bank_id">-->
<!--					<?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bank_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vo']->key => $_smarty_tpl->tpl_vars['vo']->value) {
$_smarty_tpl->tpl_vars['vo']->_loop = true;
 $_smarty_tpl->tpl_vars['skey']->value = $_smarty_tpl->tpl_vars['vo']->key;
?>-->
<!--					<option value="<?php echo $_smarty_tpl->tpl_vars['vo']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vo']->value['bank_name'];?>
</option>-->
<!--					<?php } ?>-->
<!--				</select>-->
<!--			</div>-->
<!--		</div>-->
<!--		<div class="layui-form-item layui-form-text">-->
<!--			<label class="layui-form-label">开户支行：</label>-->
<!--			<div class="layui-input-block">-->
<!--				<input type="text" id="branch_name" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.branch_name||''}}" />-->
<!--			</div>-->
<!--		</div>-->
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">USDT地址（TRC）：</label>
			<div class="layui-input-block">
				<input type="text" id="bank_account" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.bank_account||''}}" />
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">地址备注：</label>
			<div class="layui-input-block">
				<input type="text" id="bank_realname" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.bank_realname||''}}" />
			</div>
		</div>
<!--		<div class="layui-form-item layui-form-text">-->
<!--			<label class="layui-form-label">最大收款：</label>-->
<!--			<div class="layui-input-block">-->
<!--				<input type="text" id="max_tmoney" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.max_tmoney||''}}" />-->
<!--			</div>-->
<!--		</div>-->
		<div class="layui-form-item layui-form-text" style="margin-bottom:0;">
			<label class="layui-form-label">排序值：</label>
			<div class="layui-input-block">
				<input type="text" id="sort" placeholder="数字" autocomplete="off" class="layui-input" value="{{d.item.sort||'100'}}" />
				<span style="color:#f60;">从大到小</span>
			</div>
		</div>
<!--		<div class="layui-form-item" style="margin-bottom:0;">-->
<!--			<label class="layui-form-label">显示图标：</label>-->
<!--			<div class="layui-input-block">-->
<!--				<div class="layui-upload">-->
<!--					<div class="layui-upload-list" id="coverImgBtn" title="点击修改" style="background-image:url(/{{d.item.cover}});display:inline-block;cursor:pointer;width:60px;height:60px;line-height:60px;text-align:center;border:1px solid #dedede;background-size:cover;background-color:#eee;">-->
<!--						<i class="layui-icon" style="font-size:30px;">&#xe654;</i>-->
<!--						<input type="hidden" id="cover" value="{{d.item.cover||''}}"/>-->
<!--					</div>-->
<!--					<div style="color:#f60;display:inline-block;">建议尺寸120×120</div>-->
<!--				</div>-->
<!--			</div>-->
<!--		</div>-->
		
		<div class="layui-form-item">
			<label class="layui-form-label">状态：</label>
			<div class="layui-input-block">
                <?php  $_smarty_tpl->tpl_vars['vo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vo']->_loop = false;
 $_smarty_tpl->tpl_vars['skey'] = new Smarty_Variable;
 $_from = getConfig('cnf_skbank_status'); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
>

$('#searchBtn').on('click',function(){
    var obj=$(this);
    var pdata={
        s_keyword:$.trim($('#s_keyword').val()),
        s_bank_id:$.trim($('#s_bank_id').val()),
    };
    dataPage({
        where:pdata,
        url:global.appurl+'c=Finance&a=bank_list',
        cols:[[
            // {field:'id', width:70, title: 'ID'},
            // {field:'bank_name', title: '开户行'},
            // {field:'branch_name', title: '支行'},
			{field:'bank_realname', title: '地址名称'},
            {field:'bank_account',width:200, title: 'USDT地址（TRC20）'},

            // {field:'province_name', title: '省市',templet:function(d){
			// 	return d.province_name+'/'+d.city_name;
			// }},
            //{field:'city_name', title: '城市'},
            // {field:'account', title: '所属代理',templet:function(d){
			// 	if(!d.account){
			// 		return '平台';
			// 	}
			// 	return d.account+'<br>'+d.nickname;
			// }},
			// {field:'max_tmoney', title: '最大收款'},
			{field:'now_tmoney', title: '累计收款'},
			{field:'today_money', title: '今日收款'},
            // {field:'cover', title: '图标',templet:function(d){
            //     return '<img class="imgItemBtn" onclick="showImg(this)" style="height:60px;" src="/'+d.cover+'"/>';
            // }},
            {field:'sort', title: '排序值(从大到小)'},
            {field:'status_flag', title: '状态'},
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
                url:global.appurl+'c=Finance&a=bank_delete',
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
        area: global.screenType < 2 ? ['80%', '300px'] : ['540px', '655px'],
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
                $('input[name="status"][value="'+item.status+'"]').attr('checked',true);
				$('#bank_id').val(item.bank_id);
				provinceChange(item.province_id,item.city_id);
				$('#province_id').val(item.province_id);
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
	var province_id=11;
	var city_id=1000;
	var bank_id=1;
	var bank_account=$.trim($('#bank_account').val());
	var branch_name=$.trim($('#branch_name').val());
	var bank_realname=$.trim($('#bank_realname').val());
	var max_tmoney=1000000;
	var sort=$.trim($('#sort').val());
	var cover=$.trim($('#cover').val());
	var account=$.trim($('#account').val());
	var status=$('input[name="status"]:checked').val();
	var has_click=obj.attr('has-click');
	if(has_click=='1'){
		return false;
	}else{
		obj.attr('has-click','1');
	}
	ajax({
		url:global.appurl+'c=Finance&a=bank_update',
		data:{
			item_id:item_id,province_id:province_id,city_id:city_id,
			bank_id:bank_id,branch_name:branch_name,bank_account:bank_account,bank_realname:bank_realname,
			sort:sort,max_tmoney:max_tmoney,cover:cover,status:status,account:account
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
                    province_id:province_id,
                    province_name:$('#province_id').find('option[value="'+province_id+'"]').text(),
                    city_id:city_id,
                    city_name:$('#city_id').find('option[value="'+city_id+'"]').text(),
                    branch_name:branch_name,
                    bank_id:bank_id,
                    bank_name:$('#bank_id').find('option[value="'+bank_id+'"]').text(),
                    bank_account:bank_account,
                    bank_realname:bank_realname,
                    max_tmoney:max_tmoney,
                    sort:sort,
                    cover:cover,
                    status:status,
                    status_flag:$('input[name="status"][value="'+status+'"]').attr('title')
                };
				if(json.data&&json.data.account){
					uitem.account=json.data.account;
					uitem.nickname=json.data.nickname;
				}
                nowActItem.update(uitem);
                
			}
		}
	});
}



<?php echo '</script'; ?>
><?php }} ?>
