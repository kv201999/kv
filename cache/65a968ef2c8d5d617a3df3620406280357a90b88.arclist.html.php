<?php /*%%SmartyHeaderCode:45315f97f690cbf493-17118498%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '65a968ef2c8d5d617a3df3620406280357a90b88' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\News\\arclist.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '45315f97f690cbf493-17118498',
  'variables' => 
  array (
    'arccat_arr' => 0,
    'vo' => 0,
    'skey' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f97f690dd43e5_47602151',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f97f690dd43e5_47602151')) {function content_5f97f690dd43e5_47602151($_smarty_tpl) {?><style>
td img{cursor:pointer;}
</style>

<div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>文章列表</span><span class="layui-btn layui-btn-sm layui-btn-normal addBtn">+添加文章</span></div>
<div class="layui-card-body">


	<form class="layui-form" id="searchForm" onsubmit="return false;">
		<div class="layui-form-item" style="margin-bottom:5px;">
			<div class="layui-inline">
				<label class="layui-form-label" style="width:40px;">分类</label>
				<div class="layui-input-inline" style="width:100px;text-align:left;">
					<select id="s_cid">
						<option value="0">全部</option>
												<option value="2">系统消息</option>
												<option value="3">通知公告</option>
												<option value="5">其他杂项</option>
											</select>
				</div>
			</div>
			<div class="layui-inline">
				<label class="layui-form-label" style="width:50px;">关键词</label>
				<div class="layui-input-inline" style="width:120px;">
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
		<a class="layui-btn layui-btn-xs layui-btn-danger" lay-event="del">删除</a>
		<a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="edit">编辑</a>
	</script>
	
</div>
</div>
</div>

<!--弹层-->
<script type="text/html" id="layerTpl">
	<form class="layui-form" onsubmit="return false;" style="padding:20px 40px 20px 20px;">
		<div class="layui-form-item">
			<label class="layui-form-label" style="font-size:13px;">所属分类：</label>
			<div class="layui-input-block" style="width:40%;">
				<select id="cid">
										<option value="2">系统消息</option>
										<option value="3">通知公告</option>
										<option value="5">其他杂项</option>
									</select>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label" style="font-size:13px;">文章标题：</label>
			<div class="layui-input-block" style="width:40%;">
				<input type="text" id="title" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.title||''}}" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label" style="font-size:13px;">作者：</label>
			<div class="layui-input-block" style="width:40%;">
				<input type="text" id="author" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.author||''}}" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">发布时间：</label>
			<div class="layui-input-block" style="width:40%;">
				<input type="text" id="publish_time_flag" placeholder="请选择日期" autocomplete="off" class="layui-input" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">封面图：</label>
			<div class="layui-input-block">
				<div class="layui-upload">
					<div class="layui-upload-list" id="coverImgBtn" title="点击修改" style="background-image:url(/{{d.item.cover}});display:inline-block;cursor:pointer;width:100px;height:100px;line-height:100px;text-align:center;border:1px solid #dedede;background-size:cover;background-color:#eee;">
						<i class="layui-icon" style="font-size:30px;">&#xe654;</i>
						<input type="hidden" id="cover" value="{{d.item.cover||''}}"/>
					</div>
					<div style="color:#f60;display:inline-block;">建议尺寸100×100</div>
				</div>
			</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">状态：</label>
			<div class="layui-input-block">
								<input type="radio" name="status" value="1" title="待发布" checked="checked" />
								<input type="radio" name="status" value="2" title="已发布"  />
							</div>
		</div>

		<div class="layui-form-item">
			<label class="layui-form-label">文章内容：</label>
			<div class="layui-input-block">
				<textarea id="content" style="width:100%;height:400px;"></textarea>
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

<script type="text/javascript" src="./public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="./public/ueditor/ueditor.all.js"></script>
<script>
var ue=null;

$('#searchBtn').on('click',function(){
	var obj=$(this);
	var pdata={
		s_keyword:$.trim($('#s_keyword').val()),
		s_cid:$.trim($('#s_cid').val()),
	};
	dataPage({
		where:pdata,
        url:global.appurl+'c=News&a=arclist_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'title', title: '标题'},
            {field:'cat_name', title: '文章分类'},
            {field:'ndesc', title: '摘要'},
            {field:'author', title: '作者'},
            {field:'create_time', title: '创建时间'},
            {field:'publish_time_flag', title: '发布时间'},
            {field:'status_flag', title: '状态'},
            {field:'cover',width:100, title: '封面图',templet:function(d){
				return '<div style="background-color:#eee;width:60px;text-align:center;margin:0 auto;"><img onclick="showImg(this)" src="/'+d.cover+'" style="width:50px;"/></div>';
			}},
            {field:'', width:140, title: '操作',toolbar:'#barItemAct'}
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

//////////////////////////////////////////////////////

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
                url:global.appurl+'c=News&a=arclist_delete',
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
        var title='编辑文章';
    }else{
        var title='添加文章';
    }
    layer.open({
        title:title,
        type: 1,
        shadeClose: true,
        area: global.screenType < 2 ? ['80%', '300px'] : ['960px', '600px'],
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
			
			layui.laydate.render({elem:'#publish_time_flag', type:'datetime'});//format: 'yyyy-MM-dd '

            if(obj&&obj.data){

				//初始化数据
				//$('#ndesc').val(item.ndesc);
				ajax({
					url:global.appurl+'c=News&a=getArc',
					data:{item_id:item.id},
					success:function(json){
						if(json.code!='1'){
							_alert(json.msg);
							return false;
						}
						$('#content').val(json.data.content);
						iniUeditor();
					}
				});

				$('#publish_time_flag').val(item.publish_time_flag);
                $('input[name="status"][value="'+item.status+'"]').attr('checked',true);
                $('#cid').val(item.cid);
            }else{
				iniUeditor();
			}
            layui.form.render();
        }
    });
}

function iniUeditor(){
	UE.delEditor('content');
	ue = UE.getEditor('content',{
		scaleEnabled:true
	});
}
////////////////////////////////////////////////////////

$('.addBtn').on('click',function(){
    updateView(null);
});

////////////////////////////////////////////////////////



$('body').on('click','#ef_second',function(){
	$(this).blur();
});


//保存更新
function saveBtn(ts){
	var obj=$(ts);
	var item_id=$('#item_id').val();
	var i_index=$('#item_id').attr('i-index');
	var title=$.trim($('#title').val());
	var author=$.trim($('#author').val());
	var cid=$.trim($('#cid').val());
	var ndesc=$.trim($('#ndesc').val());
	var publish_time_flag=$.trim($('#publish_time_flag').val());
	var cover=$.trim($('#cover').val());
	var status=$('input[name="status"]:checked').val();
	var content = ue.getContent();
	if(!title){
		_alert('请填写文章名称');
		return false;
	}
	var has_click=obj.attr('has-click');
	if(has_click=='1'){
		return false;
	}else{
		obj.attr('has-click','1');
	}
	ajax({
		url:global.appurl+'c=News&a=arclist_update',
		data:{item_id:item_id,cid:cid,title:title,author:author,ndesc:ndesc,status:status,publish_time_flag:publish_time_flag,cover:cover,content:content},
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
					cid:cid,
					cat_name:$('#cid').find('option[value="'+cid+'"]').text(),
					title:title,
					author:author,
					ndesc:ndesc,
					cover:cover,
					status:status,
					status_flag:$('input[name="status"][value="'+status+'"]').attr('title'),
					publish_time:json.data.publish_time,
					publish_time_flag:publish_time_flag
				});
			}
		}
	});
}

</script><?php }} ?>
