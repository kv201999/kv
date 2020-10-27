<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-27 01:57:53
         compiled from "/www/wwwroot/paofen123.com/admin/view/Sys/userinfo.html" */ ?>
<?php /*%%SmartyHeaderCode:11593022385f970e210b46d3-78559216%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '880fd771056ca5a6da6886291e551dab28b4eddd' => 
    array (
      0 => '/www/wwwroot/paofen123.com/admin/view/Sys/userinfo.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11593022385f970e210b46d3-78559216',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f970e210eca00_24349430',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f970e210eca00_24349430')) {function content_5f970e210eca00_24349430($_smarty_tpl) {?><div class="layui-col-md12">
<div class="layui-card">
<div class="layui-card-header"><span>基本资料</span></div>
<div class="layui-card-body">
    
    <div id="appContentBox"></div>
    
    <?php echo '<script'; ?>
 type="text/html" id="appContentTpl">
        <table class="layui-table">
            <colgroup>
                <col width="20%">
                <col>
            </colgroup>
            <tbody>
                <tr>
                    <td>头像</td>
                    <td><img style="height:50px;" src="{{d.user.headimgurl}}"/></td>
                </tr>
                <tr>
                    <td>账号</td>
                    <td>{{d.user.account}}</td>
                </tr>
                <tr>
                    <td>手机号</td>
                    <td>{{d.user.phone||''}}</td>
                </tr>
                <tr>
                    <td>邀请码</td>
                    <td>{{d.user.icode}}</td>
                </tr>
                <tr>
                    <td>姓名/昵称</td>
                    <td>{{d.user.realname}}/{{d.user.nickname}}</td>
                </tr>
                <tr>
                    <td>分组</td>
                    <td>{{d.user.gnmae}}</td>
                </tr>
                <tr>
                    <td>登录时间</td>
                    <td style="padding-bottom: 0;">{{d.user.login_time}}</td>
                </tr>
                <tr>
                    <td>登录IP</td>
                    <td style="padding-bottom: 0;">{{d.user.login_ip}}</td>
                </tr>
            </tbody>
        </table>
    <?php echo '</script'; ?>
>

</div>
</div>
</div>

<?php echo '<script'; ?>
>
ajax({
    url:global.appurl+'c=Login&a=userinfo',
    success:function(json){
        if(json.code!='1'){
            _alert(json.msg);
            return;
        }
        $('#appContentBox').html(layui.laytpl($('#appContentTpl').html()).render({user:json.data.user}));
    }
});
<?php echo '</script'; ?>
><?php }} ?>
