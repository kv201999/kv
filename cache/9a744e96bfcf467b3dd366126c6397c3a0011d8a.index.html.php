<?php /*%%SmartyHeaderCode:102685f978bf3907636-73842675%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9a744e96bfcf467b3dd366126c6397c3a0011d8a' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\admin\\view\\Login\\index.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '102685f978bf3907636-73842675',
  'variables' => 
  array (
    's' => 0,
    'callback' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f978bf39b42d1_40378980',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f978bf39b42d1_40378980')) {function content_5f978bf39b42d1_40378980($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>后台登录</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="public/layui/css/layui.css" media="all">
<link rel="stylesheet" href="public/admin/css/login.css" media="all">
<style>
.smsBtn{
width:100%;box-sizing:border-box;text-align:center;
border:1px solid #009688;color:#009688;display:inline-block;
height:38px;line-height:38px;padding:0;cursor:pointer;
}
</style>
</head>
<body>
<div id="LAY_app">
  <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

    <div class="layadmin-user-login-main">
      <div class="layadmin-user-login-box layadmin-user-login-header">
        <h2>后台登录</h2>
        <!--<p>。。。。</p>-->
      </div>
      <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
          <input type="text" name="username" id="LAY-user-login-username" lay-verify="required" placeholder="手机号/账号" class="layui-input">
        </div>
		        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
          <input type="password" name="password" id="LAY-user-login-password" lay-verify="required" placeholder="登录密码" class="layui-input">
        </div>
        <div class="layui-form-item">
          <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-password"></label>
          <input type="text" name="gcode" id="LAY-user-login-gcode" lay-verify="required" placeholder="谷歌验证码-未开启可忽略" class="layui-input">
        </div>
        <div class="layui-form-item">
          <div class="layui-row">
            <div class="layui-col-xs7">
              <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
              <input type="text" name="vercode" id="LAY-user-login-vercode" lay-verify="required" placeholder="图形验证码" class="layui-input">
            </div>
            <div class="layui-col-xs5">
              <div style="margin-left: 10px;">
                <img src="ht.php?c=Login&a=varify_code" class="layadmin-user-login-codeimg" id="LAY-user-get-vercode">
              </div>
            </div>
          </div>
        </div>
        <!--
        <div class="layui-form-item" style="margin-bottom: 20px;">
          <input type="checkbox" name="remember" lay-skin="primary" title="记住密码">
          <a lay-href="/user/forget" class="layadmin-user-jump-change layadmin-link" style="margin-top: 7px;">忘记密码？</a>
        </div>
        -->
        <div class="layui-form-item">
          <span class="layui-btn layui-btn-fluid" id="LAY-user-login-submit">登录</span>
        </div>
        <!--
        <div class="layui-trans layui-form-item layadmin-user-login-other">
          <label>社交账号登入</label>
          <a href="javascript:;"><i class="layui-icon layui-icon-login-qq"></i></a>
          <a href="javascript:;"><i class="layui-icon layui-icon-login-wechat"></i></a>
          <a href="javascript:;"><i class="layui-icon layui-icon-login-weibo"></i></a>
          <a lay-href="/user/reg" class="layadmin-user-jump-change layadmin-link">注册帐号</a>
        </div>
        -->
      </div>
    </div>
    
    <div class="layui-trans layadmin-user-login-footer">
      
      <p>© 2019 <a href="javascript:;" target="_blank"></a></p>
      <!--
      <p>
        <span><a href="javascript:;" target="_blank">获取授权</a></span>
        <span><a href="javascript:;" target="_blank">在线演示</a></span>
        <span><a href="javascript:;" target="_blank">前往官网</a></span>
      </p>
      -->
    </div>
    
    <!--<div class="ladmin-user-login-theme">
      <script type="text/html" template>
        <ul>
          <li data-theme=""><img src="{{ layui.global.base }}style/res/bg-none.jpg"></li>
          <li data-theme="#03152A" style="background-color: #03152A;"></li>
          <li data-theme="#2E241B" style="background-color: #2E241B;"></li>
          <li data-theme="#50314F" style="background-color: #50314F;"></li>
          <li data-theme="#344058" style="background-color: #344058;"></li>
          <li data-theme="#20222A" style="background-color: #20222A;"></li>
        </ul>
      </script>
    </div>-->
    
  </div>
</div>

<script src="public/layui/layui.all.js"></script>
<script src="public/js/jquery2.1.js"></script>
<script src="public/js/md5.js"></script>
<script src="public/js/func.js"></script>
<script src="public/admin/js/func.js"></script>
<script src="public/js/global.js"></script>
<script>
layui.form.render();

$('.smsBtn').on('click',function(){
	var obj=$(this);
	var phone=$.trim($('#LAY-user-login-username').val());
	if(!phone){
		_alert('请填写手机账号');
		return false;
	}
	if(obj.attr('is-timer')){
		return true;
	}
	ajax({
		url:global.appurl+'a=getPhoneCode',
		data:{phone:phone,stype:2},
		success:function(json){
			if(json.code!=1){
				_alert(json.msg);
				return;
			}
			smsTimer(obj);
		}
	});
});

//更换验证码
$('#LAY-user-get-vercode').on('click',function(){
  var varify_code=global.appurl+'c=Login&a=varify_code';
  $(this).attr('src',varify_code+'&rt='+Math.random());
});

$('#LAY-user-login-submit').on('click',function(){
  var obj=$(this);
  var acname=$.trim($('#LAY-user-login-username').val());
  var pwd=$.trim($('#LAY-user-login-password').val());
  var code=$.trim($('#LAY-user-login-vercode').val());
  var gcode=$.trim($('#LAY-user-login-gcode').val());
  var smscode=$.trim($('#LAY-user-login-smscode').val());
  var seccd='';//安全码
  var save_state=$('#save_state').prop('checked')?1:0;
  
  if(!acname){
    _alert('请输入您的账号');
    return false;
  }
  
  if(!pwd){
    _alert('请填写您的密码');
    return false;
  }
  if(!code){
    _alert('请填写图形验证码');
    return false;
  }
  pwd=md5(pwd);
  var has_click=obj.attr('has-click');
  if(has_click=='1'){
    return false;
  }else{
    obj.attr('has-click','1');
  }
  ajax({
    url:global.appurl+'c=Login&a=loginAct',
    data:{acname:acname,pwd:pwd,code:code,save_state:save_state,seccd:seccd,gcode:gcode,smscode:smscode,f:'0'},
    success:function(json){
      if(json.code!='1'){
        _alert(json.msg);
        obj.attr('has-click','0');
        $('#LAY-user-get-vercode').trigger('click');
        return;
      }

      layui.data(global.tableName, {
        key: global.tokenName,
        value: json.data.token
      });
      _alert(json.msg,{icon:1},function(){
        //location.href=global.appurl;
		location.href='http://127.0.0.1/ht.php';
      });

    }
  });

});


$('#LAY-user-login-vercode,#LAY-user-login-password,#LAY-user-login-username').on('keyup',function(e){
  if(e.keyCode==13){
    $('#LAY-user-login-submit').trigger('click');
  }
});

</script>

</body>
</html><?php }} ?>
