<?php /*%%SmartyHeaderCode:815910365f970e7db5b9c3-95409884%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '89b34caef826e196633adb2a6ca37d65253b915e' => 
    array (
      0 => '/www/wwwroot/paofen123.com/admin/view/Finance/banklog.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '815910365f970e7db5b9c3-95409884',
  'variables' => 
  array (
    'bank_arr' => 0,
    'vo' => 0,
    'province_arr' => 0,
    'city_arr' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f970e7dbe0f03_79482424',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f970e7dbe0f03_79482424')) {function content_5f970e7dbe0f03_79482424($_smarty_tpl) {?><style>
.imgItemBtn{cursor:pointer;}
.banner_it{width:80px;height:80px;background-size:cover;border:1px solid #dedede;
line-height:80px;margin-right:5px;display:inline-block;float:left;text-align:center;font-size:4rem;cursor:pointer;
position:relative;}
.bannerItemCancel{position:absolute;right:0px;top:0px;font-size:30px;line-height:30px;background:rgba(11,11,11,0.5);color:#fff;}
</style>

<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>提现银行卡</span><span class="layui-btn layui-btn-sm layui-btn-normal addBtn">+添加卡</span></div>
<div class="layui-card-body">


        <form class="layui-form" id="searchForm" onsubmit="return false;">
            <div class="layui-form-item" style="margin-bottom:5px;">
			<div class="layui-inline">
				<label class="layui-form-label" style="width:60px;">开户行</label>
				<div class="layui-input-inline" style="width:160px;text-align:left;">
					<select id="s_bank_id">
						<option value="0">全部</option>
												<option value="1">中国工商银行</option>
												<option value="2">中国农业银行</option>
												<option value="3">中国银行</option>
												<option value="4">中国建设银行</option>
												<option value="5">交通银行</option>
												<option value="6">中信银行</option>
												<option value="7">中国光大银行</option>
												<option value="8">华夏银行</option>
												<option value="9">中国民生银行</option>
												<option value="10">广发银行</option>
												<option value="11">深圳发展银行</option>
												<option value="12">招商银行</option>
												<option value="13">兴业银行</option>
												<option value="14">上海浦东发展银行</option>
												<option value="15">恒丰银行</option>
												<option value="16">浙商银行</option>
												<option value="17">渤海银行</option>
												<option value="18">中国邮政储蓄银行</option>
												<option value="19">广西北部湾银行</option>
												<option value="20">东亚银行</option>
												<option value="21">平安银行</option>
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
        <script type="text/html" id="barItemAct">
            <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
            <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="edit">编辑</a>
        </script>
	
</div>
</div>
</div>

<!--弹层-->
<script type="text/html" id="layerTpl">
	<form class="layui-form LayerForm" onsubmit="return false;">
		<div class="layui-form-item">
			<label class="layui-form-label">银行省市：</label>
			<div class="layui-inline" style="width:140px;margin-right:20px;">
				<select id="province_id" lay-filter="province_id">
					<option value="0">请选择省份</option>
										<option value="11">北京市</option>
										<option value="12">天津市</option>
										<option value="13">河北省</option>
										<option value="14">山西省</option>
										<option value="15">内蒙古</option>
										<option value="21">辽宁省</option>
										<option value="22">吉林省</option>
										<option value="23">黑龙江省</option>
										<option value="31">上海市</option>
										<option value="32">江苏省</option>
										<option value="33">浙江省</option>
										<option value="34">安徽省</option>
										<option value="35">福建省</option>
										<option value="36">江西省</option>
										<option value="37">山东省</option>
										<option value="41">河南省</option>
										<option value="42">湖北省</option>
										<option value="43">湖南省</option>
										<option value="44">广东省</option>
										<option value="45">广西</option>
										<option value="46">海南省</option>
										<option value="50">重庆市</option>
										<option value="51">四川省</option>
										<option value="52">贵州省</option>
										<option value="53">云南省</option>
										<option value="54">西藏</option>
										<option value="61">陕西省</option>
										<option value="62">甘肃省</option>
										<option value="63">青海省</option>
										<option value="64">宁夏</option>
										<option value="65">新疆</option>
									</select>
			</div>
			<div class="layui-inline" style="width:160px;">
				<select id="city_id" lay-filter="city_id" lay-search>
					<option value="0">请选择城市</option>
									</select>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label" style="font-size:13px;">开户行：</label>
			<div class="layui-input-block">
				<select id="bank_id">
										<option value="1">中国工商银行</option>
										<option value="2">中国农业银行</option>
										<option value="3">中国银行</option>
										<option value="4">中国建设银行</option>
										<option value="5">交通银行</option>
										<option value="6">中信银行</option>
										<option value="7">中国光大银行</option>
										<option value="8">华夏银行</option>
										<option value="9">中国民生银行</option>
										<option value="10">广发银行</option>
										<option value="11">深圳发展银行</option>
										<option value="12">招商银行</option>
										<option value="13">兴业银行</option>
										<option value="14">上海浦东发展银行</option>
										<option value="15">恒丰银行</option>
										<option value="16">浙商银行</option>
										<option value="17">渤海银行</option>
										<option value="18">中国邮政储蓄银行</option>
										<option value="19">广西北部湾银行</option>
										<option value="20">东亚银行</option>
										<option value="21">平安银行</option>
									</select>
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">银行卡号：</label>
			<div class="layui-input-block">
				<input type="text" id="bank_account" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.bank_account||''}}" />
			</div>
		</div>
		<div class="layui-form-item layui-form-text">
			<label class="layui-form-label">持卡姓名：</label>
			<div class="layui-input-block">
				<input type="text" id="bank_realname" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.bank_realname||''}}" />
			</div>
		</div>		
		<div class="layui-form-item">
			<div class="layui-input-block">
				<input type="hidden" id="item_id" value="{{d.item.id||''}}" />
				<span class="layui-btn" onclick="saveBtn(this)">提交保存</span>
			</div>
		</div>
	</form>
</script>


<script>

$('#searchBtn').on('click',function(){
    var obj=$(this);
    var pdata={
        s_keyword:$.trim($('#s_keyword').val()),
        s_bank_id:$.trim($('#s_bank_id').val()),
    };
    dataPage({
        where:pdata,
        url:global.appurl+'c=Finance&a=banklog_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'account', title: '商户',templet:function(d){
				return d.account+' / '+d.nickname;
			}},
            {field:'bank_name', title: '开户行'},
            {field:'bank_account',width:200, title: '银行卡号'},
            {field:'bank_realname', title: '收款姓名'},
			{field:'province_name', title: '省份'},
			{field:'city_name', title: '城市'},
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
                url:global.appurl+'c=Finance&a=banklog_delete',
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
        area: global.screenType < 2 ? ['80%', '300px'] : ['540px', '360px'],
        content: layui.laytpl($('#layerTpl').html()).render({item:item}),
        success:function(){

            if(obj&&obj.data){
                //$('input[name="status"][value="'+item.status+'"]').attr('checked',true);
				provinceChange(item.province_id,item.city_id);
				$('#province_id').val(item.province_id);
				$('#bank_id').val(item.bank_id);
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
	var province_id=$.trim($('#province_id').val());
	var city_id=$.trim($('#city_id').val());
	var bank_id=$.trim($('#bank_id').val());
	var bank_account=$.trim($('#bank_account').val());
	var bank_realname=$.trim($('#bank_realname').val());
	//var max_tmoney=$.trim($('#max_tmoney').val());
	//var sort=$.trim($('#sort').val());
	//var cover=$.trim($('#cover').val());
	//var status=$('input[name="status"]:checked').val();
	var has_click=obj.attr('has-click');
	if(has_click=='1'){
		return false;
	}else{
		obj.attr('has-click','1');
	}
	ajax({
		url:global.appurl+'c=Finance&a=banklog_update',
		data:{item_id:item_id,province_id:province_id,city_id:city_id,bank_id:bank_id,bank_account:bank_account,bank_realname:bank_realname},
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

                nowActItem.update({
                    bank_id:bank_id,
                    bank_name:$('#bank_id').find('option[value="'+bank_id+'"]').text(),
                    bank_account:bank_account,
                    bank_realname:bank_realname,
                    province_id:province_id,
                    province_name:$('#province_id').find('option[value="'+province_id+'"]').text(),
                    city_id:city_id,
                    city_name:$('#city_id').find('option[value="'+city_id+'"]').text()
                    //max_tmoney:max_tmoney,
                    //sort:sort,
                    //cover:cover,
                    //status:status,
                    //status_flag:$('input[name="status"][value="'+status+'"]').attr('title')
                });
                
			}
		}
	});
}



</script><?php }} ?>
