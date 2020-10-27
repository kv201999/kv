<?php /*%%SmartyHeaderCode:8965635355f970e3982e813-54373141%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2bf86dea2f97b8363a7fe0864fe46f3426b25574' => 
    array (
      0 => '/www/wwwroot/paofen123.com/admin/view/Default/index.html',
      1 => 1578476498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8965635355f970e3982e813-54373141',
  'variables' => 
  array (
    'user' => 0,
    'menu_json' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_5f970e398ab134_86925783',
  'cache_lifetime' => 300,
),true); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5f970e398ab134_86925783')) {function content_5f970e398ab134_86925783($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>PU支付-管理后台</title>
<meta name="renderer" content="webkit">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
<link rel="stylesheet" href="public/layui/css/layui.css" media="all">
<link rel="stylesheet" href="public/admin/css/admin.css" media="all">
</head>
<body>
<div id="LAY_app">
    <div class="layui-layout layui-layout-admin">
        <div class="layui-header">
            <!-- 头部区域 -->
            <ul class="layui-nav layui-layout-left">
                <li class="layui-nav-item layadmin-flexible" lay-unselect>
                    <a href="javascript:;" layadmin-event="flexible" title="侧边伸缩">
                        <i class="layui-icon layui-icon-shrink-right" id="LAY_app_flexible"></i>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="/" target="_blank" title="前台">
                    <i class="layui-icon layui-icon-website"></i>
                    </a>
                </li>
                <li class="layui-nav-item" lay-unselect>
                    <a href="./ht.php" title="刷新">
                    <i class="layui-icon layui-icon-refresh-3"></i>
                    </a>
                </li>
                <!--
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <input type="text" placeholder="搜索..." autocomplete="off" class="layui-input layui-input-search" layadmin-event="serach"> 
                </li>
                -->
            </ul>

            <ul class="layui-nav layui-layout-right" lay-filter="layadmin-layout-right" style="padding-right:10px;">
                <!--
                <li class="layui-nav-item" lay-unselect>
                    <a lay-href="app/message/" layadmin-event="message">
                        <i class="layui-icon layui-icon-notice"></i>
                        <span class="layui-badge-dot"></span>
                    </a>
                </li>
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="theme">
                    <i class="layui-icon layui-icon-theme"></i>
                    </a>
                </li>
				-->
				
                <li class="layui-nav-item layui-hide-xs" lay-unselect title="清理缓存">
                    <a href="javascript:;" layadmin-event="clearCache">
						<i class="layui-icon layui-icon-delete" style="font-size:22px;"></i>
                    </a>
                </li>

                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="fullscreen">
                    <i class="layui-icon layui-icon-screen-full"></i>
                    </a>
                </li>
                <li class="layui-nav-item userinfoBox" lay-unselect>
                    <a href="javascript:;">
                        <cite id="nicknameTxt">管理员</cite>
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="javascript:;" data-href="Sys/userinfo">基本资料</a></dd>
                        <dd><a href="javascript:;" data-href="Sys/safety">安全设置</a></dd>
                        <hr>
                        <dd style="text-align: center;"><a href="javascript:;">退出</a></dd>
                    </dl>
                </li>
                
                <!--
                <li class="layui-nav-item layui-hide-xs" lay-unselect>
                    <a href="javascript:;" layadmin-event="about"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
                <li class="layui-nav-item layui-show-xs-inline-block layui-hide-sm" lay-unselect>
                    <a href="javascript:;" layadmin-event="more"><i class="layui-icon layui-icon-more-vertical"></i></a>
                </li>
                -->
                
            </ul>
        </div>
        
        <!-- 侧边菜单 -->
        <div class="layui-side layui-side-menu">
            <div class="layui-side-scroll">
                <div class="layui-logo">
                    <a href="./ht.php">
                        <i class="layui-icon layui-icon-fire"></i>
                        <span id="sysName">PU支付</span>
                    </a>
                </div>

                <ul class="layui-nav layui-nav-tree" lay-shrink="" id="LAY-system-side-menu" lay-filter="layadmin-system-side-menu">
                    
                    <script type="text/html" id="SysMenuTpl">
                        {{# layui.each(d.menu,function(index,item){}}
                        <li class="layui-nav-item layui-nav-itemed {{#if((!item.sub_node||item.sub_node.length<1)&&((item.c+'_'+item.a)==d.selectedNav)){}}layui-this{{#}}}">
                            <a href="javascript:;" data-url="{{#if(item.url){}}{{item.url}}{{#}}}" data-href="{{#if(!item.sub_node||item.sub_node.length<1){}}{{item.c}}/{{item.a||'index'}}{{#}}}" lay-tips="{{item.name}}">
                                <i class="layui-icon">{{#if(item.ico){}}{{item.ico}}{{#}else{}}&#xe66e;{{#}}}</i>
                                <cite>{{item.name}}</cite>
                            </a>
                            {{#if(item.sub_node&&item.sub_node.length>0){}}
                            <dl class="layui-nav-child">
                                {{# layui.each(item.sub_node,function(index2,item2){}}
                                <dd class="{{#if((item2.c+'_'+item2.a)==d.selectedNav){}}layui-this{{#}}}"><a href="{{#if(item2.url){}}{{item2.url}}{{#}else{}}javascript:;{{#}}}" data-href="{{item2.c}}/{{item2.a||'index'}}">{{item2.name}}</a></dd>
                                {{#});}}
                            </dl>
                            {{#}}}
                        </li>
                        {{#});}}
                    </script>

                </ul>

            </div>
        </div>
        
        
        <!-- 页面标签 -->
        <script type="text/html" template lay-done="layui.element.render('nav', 'layadmin-pagetabs-nav')">
            {{# if(layui.global.pageTabs){ }}
            <div class="layadmin-pagetabs" id="LAY_app_tabs">
                <div class="layui-icon layadmin-tabs-control layui-icon-prev" layadmin-event="leftPage"></div>
                <div class="layui-icon layadmin-tabs-control layui-icon-next" layadmin-event="rightPage"></div>
                <div class="layui-icon layadmin-tabs-control layui-icon-down">
                    <ul class="layui-nav layadmin-tabs-select" lay-filter="layadmin-pagetabs-nav">
                    <li class="layui-nav-item" lay-unselect>
                        <a href="javascript:;"></a>
                        <dl class="layui-nav-child layui-anim-fadein">
                        <dd layadmin-event="closeThisTabs"><a href="javascript:;">关闭当前标签页</a></dd>
                        <dd layadmin-event="closeOtherTabs"><a href="javascript:;">关闭其它标签页</a></dd>
                        <dd layadmin-event="closeAllTabs"><a href="javascript:;">关闭全部标签页</a></dd>
                        </dl>
                    </li>
                    </ul>
                </div>
                <div class="layui-tab" lay-unauto lay-allowClose="true" lay-filter="layadmin-layout-tabs">
                    <ul class="layui-tab-title" id="LAY_app_tabsheader">
                    <li lay-id="/"><i class="layui-icon layui-icon-home"></i></li>
                    </ul>
                </div>
            </div>
            {{# } }}
        </script>
        
        
        <!-- 主体内容 -->
        <div class="layui-body">
            <div class="layadmin-tabsbody-item layui-show">
                <div class="layui-fluid">
                    <div class="layui-row layui-col-space15" id="LAY_app_body"><!--内容区域--></div>
                </div>
            </div>
        </div>
        
        <!-- 辅助元素，一般用于移动设备下遮罩 -->
        <div class="layadmin-body-shade" layadmin-event="shade"></div>
        
    </div>    
              
</div>

<script src="public/layui/layui.all.js"></script>
<script src="public/js/jquery2.1.js"></script>
<script src="public/js/md5.js"></script>
<script src="public/js/func.js"></script>
<script src="public/admin/js/func.js"></script>
<script src="public/js/global.js"></script>
<script>
var SHOW = 'layui-show', HIDE = 'layui-hide', THIS = 'layui-this', DISABLED = 'layui-disabled', TEMP = 'template'
    , APP_FLEXIBLE = 'LAY_app_flexible'
    ,FILTER_TAB_TBAS = 'layadmin-layout-tabs'
    ,APP_SPREAD_SM = 'layadmin-side-spread-sm', TABS_BODY = 'layadmin-tabsbody-item'
    ,ICON_SHRINK = 'layui-icon-shrink-right', ICON_SPREAD = 'layui-icon-spread-left'
    ,SIDE_SHRINK = 'layadmin-side-shrink', SIDE_MENU = 'LAY-system-side-menu';

//全屏
function fullScreen(){
    var ele = document.documentElement
    ,reqFullScreen = ele.requestFullScreen || ele.webkitRequestFullScreen 
    || ele.mozRequestFullScreen || ele.msRequestFullscreen;      
    if(typeof reqFullScreen !== 'undefined' && reqFullScreen) {
        reqFullScreen.call(ele);
    };
}

//退出全屏
function exitScreen(){
    var ele = document.documentElement
    if (document.exitFullscreen) {  
        document.exitFullscreen();  
    } else if (document.mozCancelFullScreen) {  
        document.mozCancelFullScreen();  
    } else if (document.webkitCancelFullScreen) {  
        document.webkitCancelFullScreen();  
    } else if (document.msExitFullscreen) {  
        document.msExitFullscreen();
    }
}

$('a[layadmin-event="fullscreen"]').on('click',function(){
    var othis=$(this);
    var SCREEN_FULL = 'layui-icon-screen-full'
      ,SCREEN_REST = 'layui-icon-screen-restore'
      ,iconElem = othis.children("i");
      if(iconElem.hasClass(SCREEN_FULL)){
        fullScreen();
        iconElem.addClass(SCREEN_REST).removeClass(SCREEN_FULL);
      } else {
        exitScreen();
        iconElem.addClass(SCREEN_FULL).removeClass(SCREEN_REST);
      }
});

$('a[layadmin-event="clearCache"]').on('click',function(){
	ajax({
		url:global.appurl+'a=clearCache',
		success:function(json){
			_alert(json.msg);
		}
	});
});

function sideFlexible(status){
    var app = $('#LAY_app'),iconElem =  $('#LAY_app_flexible');

    //设置状态，PC：默认展开、移动：默认收缩
    if(status === 'spread'){
        //切换到展开状态的 icon，箭头：←
        iconElem.removeClass(ICON_SPREAD).addClass(ICON_SHRINK);
    
        //移动：从左到右位移；PC：清除多余选择器恢复默认
        if(global.screenType < 2){
            app.addClass(APP_SPREAD_SM);
        } else {
            app.removeClass(APP_SPREAD_SM);
        }
    
        app.removeClass(SIDE_SHRINK)
    } else {
        //切换到搜索状态的 icon，箭头：→
        iconElem.removeClass(ICON_SHRINK).addClass(ICON_SPREAD);

        //移动：清除多余选择器恢复默认；PC：从右往左收缩
        if(global.screenType < 2){
            app.removeClass(SIDE_SHRINK);
        } else {
            app.addClass(SIDE_SHRINK);
        }
    
        app.removeClass(APP_SPREAD_SM);
    }
}

$('a[layadmin-event="flexible"]').on('click',function(){
    var iconElem = $('#LAY_app_flexible')
      ,isSpread = iconElem.hasClass(ICON_SPREAD);
      sideFlexible(isSpread ? 'spread' : null); //控制伸缩
      //resizeTable(350);
});

$('div[layadmin-event="shade"]').on('click',function(){
    sideFlexible(global.screenType < 2 ? '' : 'spread');
});

//窗口resize事件
var resizeSystem = function(){
    layui.layer.closeAll('tips');
    if(!resizeSystem.lock){
        setTimeout(function(){
            sideFlexible(global.screenType < 2 ? '' : 'spread');
            delete resizeSystem.lock;
        }, 100);
    }
    resizeSystem.lock = true;
}

  //tips
$('body').on('mouseenter', '*[lay-tips]', function(){
    var othis = $(this);
    var container=$('#LAY_app');
    if(othis.parent().hasClass('layui-nav-item') && !container.hasClass(SIDE_SHRINK)) return;

    var tips = othis.attr('lay-tips')
    ,offset = othis.attr('lay-offset') 
    ,index = layui.layer.tips(tips, this, {
        tips: 2
        ,time: -1
        ,success: function(layero, index){
            if(offset){
                layero.css('margin-left', offset + 'px');
            }
        }
    });
    othis.data('index', index);
}).on('mouseleave', '*[lay-tips]', function(){
    layui.layer.close($(this).data('index'));
});

//主题设置
function setTheme(options){
    var local = layui.data(global.tableName)
    ,id = 'LAY_layadmin_theme'
    ,style = document.createElement('style')
    ,styleText = layui.laytpl([
    //主题色
    '.layui-side-menu,'
    ,'.layadmin-pagetabs .layui-tab-title li:after,'
    ,'.layadmin-pagetabs .layui-tab-title li.layui-this:after,'
    ,'.layui-layer-admin .layui-layer-title,'
    ,'.layadmin-side-shrink .layui-side-menu .layui-nav>.layui-nav-item>.layui-nav-child'
    ,'{background-color:{{d.color.main}} !important;}'

    //选中色
    ,'.layui-nav-tree .layui-this,'
    ,'.layui-nav-tree .layui-this>a,'
    ,'.layui-nav-tree .layui-nav-child dd.layui-this,'
    ,'.layui-nav-tree .layui-nav-child dd.layui-this a'
    ,'{background-color:{{d.color.selected}} !important;}'

    ,'.layui-nav-tree .layui-nav-bar{background-color:{{d.color.selected}} !important;}'

    //logo
    ,'.layui-layout-admin .layui-logo{background-color:{{d.color.logo || d.color.main}} !important;}'
    
    //头部色
    ,'{{# if(d.color.header){ }}'
        ,'.layui-layout-admin .layui-header{background-color:{{ d.color.header }};}'
        ,'.layui-layout-admin .layui-header a,'
        ,'.layui-layout-admin .layui-header a cite{color: #f8f8f8;}'
        ,'.layui-layout-admin .layui-header a:hover{color: #fff;}'
        ,'.layui-layout-admin .layui-header .layui-nav .layui-nav-more{border-top-color: #fbfbfb;}'
        ,'.layui-layout-admin .layui-header .layui-nav .layui-nav-mored{border-color: transparent; border-bottom-color: #fbfbfb;}'
        ,'.layui-layout-admin .layui-header .layui-nav .layui-this:after, .layui-layout-admin .layui-header .layui-nav-bar{background-color: #fff; background-color: rgba(255,255,255,.5);}'
        ,'.layadmin-pagetabs .layui-tab-title li:after{display: none;}'
    ,'{{# } }}'
    ].join('')).render(options = $.extend({}, local.theme, options))
    ,styleElem = document.getElementById(id);
    
    //添加主题样式
    if('styleSheet' in style){
        style.setAttribute('type', 'text/css');
        style.styleSheet.cssText = styleText;
    } else {
        style.innerHTML = styleText;
    }
    style.id = id;
    var $body=$('body');
    styleElem && $body[0].removeChild(styleElem);
    $body[0].appendChild(style);
    $body.attr('layadmin-themealias', options.color.alias);
    
    //本地存储记录
    local.theme = local.theme || {};
    layui.each(options, function(key, value){
        local.theme[key] = value;
    });
    layui.data(global.tableName, {
        key: 'theme'
        ,value: local.theme
    }); 
}

//初始化主题
function initTheme(index){
    var theme = global.theme;
    index = index || 0;
    if(theme.color[index]){
        theme.color[index].index = index;
        setTheme({
            color: theme.color[index]
        });
    }
}

//纠正路由格式
function correctRouter(href){
    if(!/^\//.test(href)) href = '/' + href;
    return href;
}

function locationHash(elem){
    var url=elem.attr('data-url');
    if(url){
        location.href=url;
        return;
    }
    var dhref=elem.attr('data-href');
    if(!dhref||dhref===undefined){
        return;
    }
    //$('.layui-this').removeClass('layui-this');
    location.hash=correctRouter(dhref);
    routerAct();
}

function rpathArr(rpath){
    var rpath_arr=[];
    for(var pi in rpath){
        if(!rpath[pi]||rpath[pi]==''){
            continue;
        }
        rpath_arr.push(rpath[pi]);
    }
    if(rpath_arr.length<1){
        rpath_arr=global.entry;
    }
    return rpath_arr;
}

function routerAct(){
    var router = layui.router();
    var rpath_arr=rpathArr(router.path);
    //var url='admin/view/'+rpath_arr.join('/')+'.html';
    var url='ht.php?c='+rpath_arr[0]+'&a='+rpath_arr[1];
    global.params=router.search;
    //console.log(url);
    loadView({url:url});
}

//加载视图
function loadView(opt){
    ajax({
        type:'get',
        async: false,
        url:opt.url,
        cache: false,
        dataType:'html',
        success:function(html){

            var elemTitle = $(html).find('title');
            var title = elemTitle.text() || (html.match(/\<title\>([\s\S]*)\<\/title>/)||[])[1];
            if(title){
                global.title=title;
                $('title').text(global.title);
            }

            try{
                $('#LAY_app_body').html(html);

                //template占位符号，自动解析
                var tplarr=$('#LAY_app_body').find('*[template]');
                for(var ti=0;ti<tplarr.length;ti++){
                    var tplObj=tplarr.eq(ti);
                    layui.laytpl(tplObj.html()).render(global,function(thtml){
                        tplObj.after(thtml);
                    });
                }
                
                layui.element.init();
                layui.form.render();

                //时间选择
                layui.laydate.render({elem:'#s_start_time', format: 'yyyy-MM-dd'});
                layui.laydate.render({elem:'#s_end_time', format: 'yyyy-MM-dd'});
            }catch(e){
                console.log(e);
            }
        },
        error:function(){
            $('#LAY_app_body').html('<div>请求异常，请刷新</div>');
        }
    });
}

layui.element.on('nav(layadmin-system-side-menu)', function(elem){
    locationHash(elem);
});

$('.userinfoBox a').on('click',function(){
    var elem=$(this);
    var txt=elem.text();
    if(txt=='退出'){
        ajax({
            url:global.appurl+'c=Login&a=logoutAct',
            success:function(json){
                if(json.code!=1){
                    _alert(json.msg);
                    return;
                }
                _alert(json.msg,{time:1500},function(){
										location.href='ht.php?c=Login&f=1';
					                });
            }
        });
        return;
    }
    locationHash(elem);
});


function init(){
    var menu=JSON.parse('[{"id":"101","pid":"0","name":"\u7528\u6237\u7ba1\u7406","c":"User","a":null,"nkey":"User","ico":"\ue613","public":"0","url":"","sub_node":[{"id":"290","pid":"101","name":"\u6570\u636e\u7edf\u8ba1","nkey":"User_datatj","c":"User","a":"datatj","ico":"","public":"0","url":""},{"id":"291","pid":"101","name":"\u4e0a\u7ea7\u67e5\u8be2","nkey":"User_sjuser","c":"User","a":"sjuser","ico":"","public":"0","url":""},{"id":"304","pid":"101","name":"API\u5bf9\u63a5","nkey":"User_rsaset","c":"User","a":"rsaset","ico":"","public":"0","url":""},{"id":"289","pid":"101","name":"\u7801\u5546\u5217\u8868","nkey":"User_userms","c":"User","a":"userms","ico":"","public":"0","url":""},{"id":"305","pid":"101","name":"\u7801\u5546\u4ee3\u7406","nkey":"User_agent","c":"User","a":"agent","ico":"","public":"0","url":""},{"id":"102","pid":"101","name":"\u7528\u6237\u5217\u8868","nkey":"User_user","c":"User","a":"user","ico":"","public":"0","url":""},{"id":"257","pid":"101","name":"\u5546\u6237\u901a\u9053\u8d39\u7387","nkey":"User_apikey","c":"User","a":"apikey","ico":"","public":"0","url":""},{"id":"269","pid":"101","name":"\u7801\u5546\u5206\u6210\u6bd4\u4f8b","nkey":"User_rate","c":"User","a":"rate","ico":"","public":"0","url":""}]},{"id":"209","pid":"0","name":"\u652f\u4ed8\u7ba1\u7406","c":"Pay","a":null,"nkey":"Pay","ico":"\ue653","public":"0","url":"","sub_node":[{"id":"307","pid":"209","name":"\u901a\u9053\u7ba1\u7406","nkey":"Pay_mtype","c":"Pay","a":"mtype","ico":"","public":"0","url":""},{"id":"249","pid":"209","name":"\u6536\u6b3e\u7801\u5217\u8868","nkey":"Pay_skma","c":"Pay","a":"skma","ico":"","public":"0","url":""},{"id":"285","pid":"209","name":"\u6536\u6b3e\u7801\u56de\u6536\u7ad9","nkey":"Pay_skmaTrash","c":"Pay","a":"skmaTrash","ico":"","public":"0","url":""},{"id":"254","pid":"209","name":"\u8ba2\u5355\u660e\u7ec6","nkey":"Pay_order","c":"Pay","a":"order","ico":"","public":"0","url":""},{"id":"256","pid":"209","name":"\u5206\u6210\u8bb0\u5f55","nkey":"Pay_yong","c":"Pay","a":"yong","ico":"","public":"0","url":""}]},{"id":"272","pid":"0","name":"\u8d44\u91d1\u7ba1\u7406","c":"Finance","a":null,"nkey":"Finance","ico":"\ue65e","public":"0","url":"","sub_node":[{"id":"273","pid":"272","name":"\u6536\u6b3e\u94f6\u884c\u5361","nkey":"Finance_bank","c":"Finance","a":"bank","ico":"","public":"0","url":""},{"id":"274","pid":"272","name":"\u5145\u503c\u8bb0\u5f55","nkey":"Finance_paylog","c":"Finance","a":"paylog","ico":"","public":"0","url":""},{"id":"278","pid":"272","name":"\u63d0\u73b0\u94f6\u884c\u5361","nkey":"Finance_banklog","c":"Finance","a":"banklog","ico":"","public":"0","url":""},{"id":"279","pid":"272","name":"\u8d26\u6237\u4f59\u989d","nkey":"Finance_balance","c":"Finance","a":"balance","ico":"","public":"0","url":""},{"id":"293","pid":"272","name":"\u7801\u5546\u63d0\u73b0\u8bb0\u5f55","nkey":"Finance_cashlogMs","c":"Finance","a":"cashlogMs","ico":"","public":"0","url":""},{"id":"276","pid":"272","name":"\u5546\u6237\u63d0\u73b0\u8bb0\u5f55","nkey":"Finance_cashlog","c":"Finance","a":"cashlog","ico":"","public":"0","url":""},{"id":"282","pid":"272","name":"\u8d44\u91d1\u53d8\u52a8\u660e\u7ec6","nkey":"Finance_balancelog","c":"Finance","a":"balancelog","ico":"","public":"0","url":""}]},{"id":"201","pid":"0","name":"\u6587\u7ae0\u8d44\u8baf","c":"News","a":null,"nkey":"News","ico":"\ue66a","public":"0","url":"","sub_node":[{"id":"202","pid":"201","name":"\u6587\u7ae0\u5217\u8868","nkey":"News_arclist","c":"News","a":"arclist","ico":"","public":"0","url":""}]},{"id":"1","pid":"0","name":"\u7cfb\u7edf\u7ba1\u7406","c":"Sys","a":null,"nkey":"Sys","ico":"&#xe620;","public":"0","url":"","sub_node":[{"id":"2","pid":"1","name":"\u57fa\u7840\u914d\u7f6e","nkey":"Sys_bset","c":"Sys","a":"bset","ico":null,"public":"0","url":""},{"id":"3","pid":"1","name":"\u8282\u70b9\u7ba1\u7406","nkey":"Sys_node","c":"Sys","a":"node","ico":"","public":"0","url":""},{"id":"4","pid":"1","name":"\u6743\u9650\u7ba1\u7406","nkey":"Sys_oauth","c":"Sys","a":"oauth","ico":"","public":"0","url":""},{"id":"5","pid":"1","name":"\u64cd\u4f5c\u65e5\u5fd7","nkey":"Sys_log","c":"Sys","a":"log","ico":"","public":"0","url":""},{"id":"300","pid":"1","name":"\u6570\u636e\u6e05\u7406","nkey":"Sys_cdata","c":"Sys","a":"cdata","ico":"","public":"0","url":""}]}]');
    var router = layui.router();
    var rpath_arr=rpathArr(router.path);
    var rpath_str=rpath_arr.join('_');
    $('#LAY-system-side-menu').html(layui.laytpl($('#SysMenuTpl').html()).render({selectedNav:rpath_str,menu:menu}));

    initTheme(4);
    sideFlexible(global.screenType < 2 ? '' : 'spread');
    $(window).on('resize', resizeSystem);
    routerAct();//路由

    layui.element.init();
}

//################初始化################

init();

</script>

<script src="/public/js/socket.io.js"></script>
<script src="/public/home/js/Music.js"></script>
<script>
window.Databus={pauseSound:0,pauseMusic:0};
$(function(){
	var music=new Music();
	var iouser={
		id:'1',
		nickname:'管理员',
		token:getToken()
	};
	
	var ioapp={
		debug:false,
		ws:null,
		wsUrl:'ws://paofen123.com:9502',
		func:null,//公共函数库
		user:iouser,
		params:{},//参数
		module:function(){},//动作处理模块
		send:function(act,data){
			if(!this.ws){
				return;
			}
			var json={emit:'sendFromClient',act:act,data:data};
			if(this.debug){
				console.log(json);
			}
			var _this=this;
			/*
			//phpsocket.io不支持二进制
			strToBuffer(JSON.stringify(json),function(buffer){
				_this.ws.emit('sendFromClient',buffer);
			});*/
			_this.ws.emit('sendFromClient',JSON.stringify(json));
		},
		login:function(){
			var LoginModule=new this.module.Login();
			LoginModule.loginAct();
		},
		init:function(){
			let _this=this;
			this.ws=io(this.wsUrl);

			this.ws.on('connect',function(){

				_this.login();//发送登录

				_this.ws.on('sendFromServer',function(buffer){
					var json={act:'',data:{}};
					try{
						json=JSON.parse(buffer);
					}catch(e){
						//console.log('数据格式不正确');
					}
					if(_this.debug){
						console.log(json);
					}
					if(!json.act){
						return;
					}
					if(!json.data){
						json.data={};
					}else if(typeof json.data=='string'){
						json.data={_string:json.data};
					}

					let r_params={c:'Default',a:'index'};
					let act_arr=trim(trim(json.act),'/').split('/');
					if(act_arr.length==2){
						r_params.c=ucfirst(trim(act_arr[0]));
						r_params.a=trim(act_arr[1]);
					}else if(act_arr.length==1){
						r_params.a=trim(act_arr[0]);
					}

					_this.params=extend(json.data,r_params);

					var moduleName=_this.params.c;
					if(typeof _this.module[moduleName]!='function'){
						if(_this.debug){
							console.log('缺少模块:'+moduleName);
						}
						return;
					}
					var moduleObj=new _this.module[moduleName]();
					if(typeof moduleObj[_this.params.a]!='function'){
						if(_this.debug){
							console.log('缺少方法:'+_this.params.a);
						}
						return;
					}
					//模块处理
					moduleObj[_this.params.a]();
				});

			});

			this.ws.on('disconnect',function(res){
				//console.log(res);
				_this.ws.close();
				_this.init();
			});

			this.ws.on('error',function(res){
				console.log(res);
			});

		},

		start:function(){
			this.init();
		}
	};
	
	///////////////////////////模块//////////////////////////////////

	ioapp.module.Base=function(){
		ioapp.module.call(this);

		this.params=ioapp.params;
		this.user=ioapp.user;//引用

		this.send=function(act,data){
			ioapp.send(act,data);
		}

		this.index=function(){
			console.log('client bindex');
		}

	}

	ioapp.module.Error=function(){
		ioapp.module.Base.call(this);

		//统一报错消息
		this.msg=function(){
			console.log(this.params);
		}
	}

	ioapp.module.Login=function(){
		ioapp.module.Base.call(this);
		
		//发起登录
		this.loginAct=function(){
			this.send('Login/loginAct',{uid:this.user.id,token:this.user.token});
		}

		//登录成功
		this.loginOk=function(){
			console.log(this.params);
		}
	}
	
	ioapp.module.Admin=function(){
		ioapp.module.Base.call(this);
		//提现通知
		this.noticeCash=function(){
			//console.log(this.params);
			music.play('cash');
			setTimeout(function(){
				music.play('cash');
			},6000);
		}
		
		//充值通知
		this.noticePay=function(){
			//console.log(this.params);
			music.play('pay');
			setTimeout(function(){
				music.play('pay');
			},6000);
		}
		
	}
	
	//开始
	//ioapp.start();
	
});
</script>
</body>
</html><?php }} ?>
