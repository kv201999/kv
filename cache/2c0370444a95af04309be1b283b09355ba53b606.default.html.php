<?php /*%%SmartyHeaderCode:77515f978c01425636-62516971%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c0370444a95af04309be1b283b09355ba53b606' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\admin\\view\\Default\\default.html',
      1 => 1603734859,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '77515f978c01425636-62516971',
  'variables' => 
  array (
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f978c01514241_80358022',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f978c01514241_80358022')) {function content_5f978c01514241_80358022($_smarty_tpl) {?><div class="layui-card">
  <div class="layui-card-header">版本信息</div>
  <div class="layui-card-body layui-text">
    <table class="layui-table">
      <colgroup>
        <col width="100">
        <col>
      </colgroup>
      <tbody>
        <tr>
          <td>当前版本</td>
          <td>
            <script type="text/html" template>
              v2.0.20
            </script>
          </td>
        </tr>
        <tr>
          <td>基于框架</td>
          <td>
            <script type="text/html" template>
              layui-v{{ layui.v }}
            </script>
          </td>
        </tr>
        <tr>
          <td>主要特点</td>
          <td>单页面 / 响应式 / 清爽 / 极简 / 仅供学习参考使用</td>
        </tr>
		        <tr>
          <td style="width:160px;">前台测试地址</td>
          <td><a href="http://127.0.0.1/?c=Pay&a=test&v=v2.0.20" target="_blank">http://127.0.0.1/?c=Pay&a=test&v=v2.0.20</a></td>
        </tr>
		        <!--
        <tr>
          <td>获取渠道</td>
          <td style="padding-bottom: 0;">
            <div class="layui-btn-container">
              <a href="" target="_blank" class="layui-btn layui-btn-danger">获取授权</a>
              <a href="" target="_blank" class="layui-btn">立即下载</a>
            </div>
          </td>
        </tr>
        -->
      </tbody>
    </table>
  </div>
</div><?php }} ?>
