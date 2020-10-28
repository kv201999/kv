<?php /* Smarty version Smarty-3.1.21-dev, created on 2020-10-28 14:37:56
         compiled from "D:\phpstudy_pro\WWW\kv\admin\view\Default\default.html" */ ?>
<?php /*%%SmartyHeaderCode:282545f9911c48a8761-67145103%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6c9c676646c9979739d5cc6bf1c50256a133b098' => 
    array (
      0 => 'D:\\phpstudy_pro\\WWW\\kv\\admin\\view\\Default\\default.html',
      1 => 1603734859,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '282545f9911c48a8761-67145103',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f9911c48cfd68_86062888',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f9911c48cfd68_86062888')) {function content_5f9911c48cfd68_86062888($_smarty_tpl) {?><div class="layui-card">
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
            <?php echo '<script'; ?>
 type="text/html" template>
              <?php echo getConfig('sys_version');?>

            <?php echo '</script'; ?>
>
          </td>
        </tr>
        <tr>
          <td>基于框架</td>
          <td>
            <?php echo '<script'; ?>
 type="text/html" template>
              layui-v{{ layui.v }}
            <?php echo '</script'; ?>
>
          </td>
        </tr>
        <tr>
          <td>主要特点</td>
          <td>单页面 / 响应式 / 清爽 / 极简 / 仅供学习参考使用</td>
        </tr>
		<?php if ($_smarty_tpl->tpl_vars['user']->value['gid']==1) {?>
        <tr>
          <td style="width:160px;">前台测试地址</td>
          <td><a href="<?php echo $_SERVER['REQUEST_SCHEME'];?>
://<?php echo $_SERVER['HTTP_HOST'];?>
/?c=Pay&a=test&v=<?php echo getConfig('sys_version');?>
" target="_blank"><?php echo $_SERVER['REQUEST_SCHEME'];?>
://<?php echo $_SERVER['HTTP_HOST'];?>
/?c=Pay&a=test&v=<?php echo getConfig('sys_version');?>
</a></td>
        </tr>
		<?php }?>
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
