<?php /*%%SmartyHeaderCode:10335f969b51990809-29771010%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b1bd6ee0e2579478cb3b4ba8f6a2037b65efd69' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\admin\\view\\User\\user.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10335f969b51990809-29771010',
  'variables' => 
  array (
    'sys_group' => 0,
    'skey' => 0,
    'vo' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f969b51b2ed46_54412464',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f969b51b2ed46_54412464')) {function content_5f969b51b2ed46_54412464($_smarty_tpl) {?><div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>用户列表</span><span class="layui-btn layui-btn-sm layui-btn-normal addBtn">+添加用户</span></div>
<div class="layui-card-body">


    <form class="layui-form" id="searchForm" action="">
        <div class="layui-form-item" style="margin-bottom:5px;">
			
            <div class="layui-inline">
                <label class="layui-form-label" style="width:40px;">分组</label>
                <div class="layui-input-inline" style="width:100px;">
					<select id="s_gid" name="s_gid">
						<option value="0">全部</option>
												<option value="1">超管</option>
												<option value="11">运营</option>
												<option value="31">财务</option>
												<option value="41">客服</option>
												<option value="61">商户代理</option>
												<option value="81">商户</option>
											</select>
                </div>
            </div>
			<!--
            <div class="layui-inline">
                <label class="layui-form-label" style="width:70px;">是否在线</label>
                <div class="layui-input-inline" style="width:80px;">
					<select id="s_is_online" name="s_is_online">
						<option value="all">全部</option>
												<option value="1">是</option>
												<option value="0">否</option>
											</select>
                </div>
            </div>
			-->
            <div class="layui-inline">
                <label class="layui-form-label" style="width:60px;">搜索团队</label>
                <div class="layui-input-inline" style="width:160px;">
                    <input type="text" name="s_keyword2" id="s_keyword2" autocomplete="off" class="layui-input" placeholder="请输入">
                </div>
            </div>
            <div class="layui-inline">
                <label class="layui-form-label" style="width:50px;">关键词</label>
                <div class="layui-input-inline" style="width:160px;">
                    <input type="text" name="s_keyword" id="s_keyword" autocomplete="off" class="layui-input" placeholder="请输入关键词">
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
    <script type="text/html" id="barItemAct">
        {{#if(d.del==1){}}
        <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="del">删除</a>
        {{#}}}
        {{#if(d.kick==1){}}
        <a class="layui-btn layui-btn-xs layui-btn-warm" lay-event="kick">踢下线</a>
        {{#}}}
        {{#if(d.edit==1){}}
        <a class="layui-btn layui-btn-xs layui-btn-primary" lay-event="edit">编辑</a>
        {{#}}}
		{{#if(d.pay==1){}}
		<a class="layui-btn layui-btn-xs" lay-event="pay">充值</a>
		{{#}}}
    </script>
	
</div>
</div>
</div>

<!--弹层-->
<script type="text/html" id="layerTpl">
	<form class="layui-form LayerForm" onsubmit="return false;">
		<div class="layui-form-item">
			<label class="layui-form-label">账号：</label>
			<div class="layui-input-block">
				<input type="text" id="account" placeholder="" autocomplete = 'off' class="layui-input" disabled  value="{{d.item.account||''}}" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">登录密码：</label>
			<div class="layui-input-block">
				<input type="password" id="password" placeholder="" autocomplete = 'new-password' class="layui-input" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">二级密码：</label>
			<div class="layui-input-block">
				<input type="password" id="password2" placeholder="" autocomplete = 'new-password' class="layui-input" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">手机号：</label>
			<div class="layui-input-block">
				<input type="text" id="phone" placeholder="绑定的手机号不填则忽略" autocomplete="off" class="layui-input" value="{{d.item.phone||''}}" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">分组：</label>
			<div class="layui-input-block" style="width:120px;">
				<select id="gid">
					<option value="0">请选择分组</option>
										<option value="1">超管</option>
										<option value="11">运营</option>
										<option value="31">财务</option>
										<option value="41">客服</option>
										<option value="61">商户代理</option>
										<option value="81">商户</option>
									</select>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">邀请人：</label>
			<div class="layui-input-block">
				<input type="text" id="paccount" placeholder="邀请人账号不填则忽略" autocomplete="off" class="layui-input" value="{{d.item.paccount||''}}" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">姓名：</label>
			<div class="layui-input-block">
				<input type="text" id="realname" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.realname||''}}" />
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">昵称：</label>
			<div class="layui-input-block">
				<input type="text" id="nickname" placeholder="" autocomplete="off" class="layui-input" value="{{d.item.nickname||''}}" />
			</div>
		</div>
				<div class="layui-form-item" style="margin-bottom:0;">
			<label class="layui-form-label">谷歌验证：</label>
			<div class="layui-input-block">
								<input type="radio" name="is_google" value="1" title="开启" >
								<input type="radio" name="is_google" value="0" title="关闭" checked>
								<input type="radio" name="is_google" value="2" title="重置谷歌密钥">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">状态：</label>
			<div class="layui-input-block">
				<input type="radio" name="status" value="1" title="禁用">
				<input type="radio" name="status" value="2" title="正常" checked="checked">
			</div>
		</div>
				<div class="layui-form-item">
			<div class="layui-input-block">
				<input type="hidden" id="item_id" value="{{d.item.id}}" />
				<span class="layui-btn" onclick="saveBtn(this)">提交保存</span>
			</div>
		</div>
	</form>
</script>

<script type="text/html" id="layerTpl3">
	<form class="layui-form LayerForm" onsubmit="return false;">
		<div class="layui-form-item layui-form-text" style="margin-bottom:0;">
			<label class="layui-form-label">账号：</label>
			<div class="layui-form-label userNicknameTxt" style="text-align:left;padding-left:0;">
				{{d.item.account}}
			</div>
		</div>
		<div class="layui-form-item layui-form-text" style="margin-bottom:0;">
			<label class="layui-form-label">可提余额：</label>
			<div class="layui-form-label userNicknameTxt" style="text-align:left;padding-left:0;">
				{{d.item.balance}}
			</div>
		</div>
		<div class="layui-form-item layui-form-text" style="margin-bottom:0;">
			<label class="layui-form-label">冻结余额：</label>
			<div class="layui-form-label userNicknameTxt" style="text-align:left;padding-left:0;">
				{{d.item.fz_balance}}
			</div>
		</div>
		<div class="layui-form-item" style="margin-bottom:0;">
			<label class="layui-form-label">充值类型：</label>
			<div class="layui-input-block">
				<input type="radio" name="ptype" value="1" title="可提余额" checked="checked">
				<input type="radio" name="ptype" value="2" title="冻结余额">
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">额度：</label>
			<div class="layui-inline">
				<input type="text" id="money" placeholder="" autocomplete="off" class="layui-input" />
				<span style="color:#f60;">充值正数为增加，负数为扣除，只是单纯增减对应额度</span>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">备注：</label>
			<div class="layui-inline" style="width:70%;">
				<textarea id="remark" class="layui-textarea"></textarea>
			</div>
		</div>
		<div class="layui-form-item">
			<label class="layui-form-label">二级密码：</label>
			<div class="layui-inline" style="width:70%;">
				<input type="password" id="paypwd2" placeholder="" autocomplete="off" class="layui-input" />
			</div>
		</div>
		<div class="layui-form-item">
			<div class="layui-input-block">
				<input type="hidden" id="user_id" value="{{d.item.id}}" />
				<span class="layui-btn" onclick="paySaveBtn(this)">提交</span>
			</div>
		</div>
	</form>
</script>



<script>

$('#searchBtn').on('click',function(){
	var obj=$(this);
	var pdata={
		s_keyword:$.trim($('#s_keyword').val()),
		s_keyword2:$.trim($('#s_keyword2').val()),
		s_gid:$('#s_gid').val(),
		s_is_online:$('#s_is_online').val(),
	};
	dataPage({
		where:pdata,
        url:global.appurl+'c=User&a=user_list',
        cols:[[
            {field:'id', width:70, title: 'ID'},
            {field:'nickname',width:180, title: '用户',align:'left',style:'text-align:left;',templet:function(d){
                return '<img style="height:40px;" src="'+d.headimgurl+'"/> '+d.nickname;
            }},
            {field:'account',width:140, title: '账号'},
            {field:'phone',width:120, title: '手机号'},
            {field:'gname',width:100, title: '分组'},
            {field:'paccount', title: '邀请人',width:140,templet:function(d){
                if(d.paccount||d.prealname){
                    return d.paccount+ '<br>'+ d.prealname;
                }else{
                    return '';
                }
            }},
            {field:'icode',width:100, title: '邀请码'},
            {field:'balance',width:160, title: '可提余额'},
            {field:'fz_balance',width:140, title: '冻结中'},
			{field:'yong_money',width:120, title: '累计佣金',templet:function(d){
				if(d.gid<61){
					return '/';
				}
				if(!d.yong_money){
					return '0';
				}
				return d.yong_money;
			}},
            {field:'td_money',width:240,title: '今日收款',templet:function(d){
				if(d.gid<61){
					return '/';
				}
				var html='<div style="text-align:left;line-height:18px;">';
					html+='<div>金额：<b>'+d.td_money_ok+'</b> / <b>'+d.td_money+'</b></div>';
					html+='<div>订单：<b>'+d.td_cnt_ok+'</b> / <b>'+d.td_cnt+'</b></div>';
					html+='<div>成功：<b>'+d.td_percent+'<b></div>';
				html+='</div>';
				return html;
			}},
            {field:'all_money',width:240,title: '累计收款',templet:function(d){
				if(d.gid<61){
					return '/';
				}
				var html='<div style="text-align:left;line-height:18px;">';
					html+='<div>金额：<b>'+d.all_money_ok+'</b> / <b>'+d.all_money+'</b></div>';
					html+='<div>订单：<b>'+d.all_cnt_ok+'</b> / <b>'+d.all_cnt+'</b></div>';
					html+='<div>成功：<b>'+d.all_percent+'<b></div>';
				html+='</div>';
				return html;
			}},
            {field:'reg_time',width:140, title: '注册时间'},
            {field:'status_flag',width:90, title: '状态'},
            {field:'', width:260, title: '操作',toolbar:'#barItemAct'}
        ]],
        done:function(res, curr, count){
            //console.log(res);
            if($('.sumLine').length<1){
                var html='<div class="sumLine">';
					html+='<span>用户数：'+res.odata.count+'</span>';
					html+='<span>可提余额：'+res.odata.balance+'</span>';
					html+='<span>冻结中：'+res.odata.fz_balance+'</span>';
				html+='</div>';
				$('.layui-table-page').before(html);   
            }
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
                url:global.appurl+'c=User&a=user_delete',
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
    }else if(layEvent=='kick'){//踢下线
        layer.confirm('确定要踢下线么？',{title:'系统提示',icon: 3},function(index){
            ajax({
                url:global.appurl+'c=User&a=user_kick',
                data:{item_id:item.id},
                success:function(json){
                    _alert(json.msg);
                    if(json.code!=1){
                        return;
                    }
                    layer.close(index);
                }
            });
        });
    }else if(layEvent=='pay'){//充值赠送
        layer.open({
            title:'充值',
            type: 1,
            shadeClose: true,
            area: global.screenType < 2 ? ['80%', '300px'] : ['590px', '600'],
            content: layui.laytpl($('#layerTpl3').html()).render({item:item}),
            success:function(){
				//
				layui.form.render();
            }
        });
    }
});

function updateView(obj){
    var item={};
    if(obj&&obj.data){
        item=obj.data;
        var title='编辑用户';
    }else{
        var title='添加用户';
    }
    layer.open({
        title:title,
        type: 1,
        shadeClose: true,
        area: global.screenType < 2 ? ['80%', '300px'] : ['540px', '600'],
        content: layui.laytpl($('#layerTpl').html()).render({item:item}),
        success:function(){
			
            $('#account').prop('disabled',false);
            if(obj&&obj.data){
                $('input[name="is_google"][value="'+item.is_google+'"]').attr('checked',true);
                $('input[name="status"][value="'+item.status+'"]').attr('checked',true);
                $('#gid').val(item.gid);
                $('#account').prop('disabled',true);
            }
            layui.form.render();
        }
    });
}
////////////////////////////////////////////////////////

$('.addBtn').on('click',function(){
    updateView(null);
});



//保存更新
function saveBtn(ts){
	var obj=$(ts);
	var item_id=$('#item_id').val()*1;
	var i_index=$('#item_id').attr('i-index');
	var account=$.trim($('#account').val());
	var paccount=$.trim($('#paccount').val());
	var password=$.trim($('#password').val());
	var password2=$.trim($('#password2').val());
	var phone=$.trim($('#phone').val());
	var realname=$.trim($('#realname').val());
	var nickname=$.trim($('#nickname').val());
	var gid=$.trim($('#gid').val());
	var is_google=$('input[name="is_google"]:checked').val();
	var status=$('input[name="status"]:checked').val();
	if(isNaN(item_id)||item_id<1){
		item_id=false;
	}
	if(!item_id){
		if(!account){
			_alert('请填写账号');
			return false;
		}
	}
	if(gid<1){
		_alert('请选择用户分组');
		return false;
	}
	if(!realname){
		_alert('请填写姓名');
		return false;
	}
	if(!nickname){
		_alert('请填写昵称');
		return false;
	}
	if(password){
		password=md5(password);
	}
	if(password2){
		password2=md5(password2);
	}
	var has_click=obj.attr('has-click');
	if(has_click=='1'){
		return false;
	}else{
		obj.attr('has-click','1');
	}
	ajax({
		url:global.appurl+'c=User&a=user_update',
		data:{
			item_id:item_id,gid:gid,status:status,account:account,paccount:paccount,
			realname:realname,nickname:nickname,phone:phone,password:password,password2:password2,
			is_google:is_google
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
                //同步更新
                var uitem={
                    realname:realname,
                    nickname:nickname,
                    gid:gid,
                    gname: $('#gid').find('option[value="'+gid+'"]').text()
                }
                if(paccount){
                    uitem.paccount=paccount;
                    uitem.prealname=json.data.prealname;
                }
                if(phone){
                    uitem.phone=phone;
                }
				if(is_google!=undefined&&is_google<2){
					uitem.is_google=is_google;
				}
                if(status){
                    uitem.status=status;
                    uitem.status_flag=$('input[name="status"][value="'+status+'"]').attr('title');
                }
				//console.log(uitem);
                nowActItem.update(uitem);
			}
		}
	});
}



//导出操作
$('#downloadBtn').on('click',function(){
	$('#is_download').val(1);
	var params=$('#searchForm').serialize();
	var url='ht.php?c=User&a=user_list&'+params;
	window.open(url,'_blank');
	$('#is_download').val(0);
});

///////////////////////////////////////////////////////////////

//充值保存
function paySaveBtn(ts){
	var obj=$(ts);
	var ptype=$('input[name="ptype"]:checked').val();
	var uid=$('#user_id').val();
	var money=$.trim($('#money').val());
	var remark=$.trim($('#remark').val());
	var password2=$.trim($('#paypwd2').val());
	if(!money){
		_alert('请填写额度');
		return;
	}else if(money==0){
		_alert('额度不能为0');
		return;
	}
	var has_click=obj.attr('has-click');
	if(has_click=='1'){
		return;
	}else{
		obj.attr('has-click','1');
	}
	password2=md5(password2);
	ajax({
		url:global.appurl+'c=User&a=pay_balance',
		data:{uid:uid,money:money,ptype:ptype,remark:remark,password2:password2},
		success:function(json){
            obj.attr('has-click','0');
            _alert(json.msg);
			if(json.code!=1){
				return;
			}
			layer.closeAll('page');
			var uitem={};
			if(ptype==1){
				uitem.balance=json.data.balance;
			}else if(ptype==2){
				uitem.fz_balance=json.data.fz_balance;
			}else{
				return;
			}
			nowActItem.update(uitem);
		}
	});
}


</script><?php }} ?>
