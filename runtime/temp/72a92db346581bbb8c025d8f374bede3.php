<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"/home/wwwroot/heizi/public/../app/admin/view/index/index.html";i:1502636690;}*/ ?>
﻿<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>layui后台管理模板</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Access-Control-Allow-Origin" content="*">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="icon" href="favicon.ico">
	<link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/layui/css/layui.css" media="all" />
	<link rel="stylesheet" href="//at.alicdn.com/t/font_tnyc012u2rlwstt9.css" media="all" />
	<link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/css/main.css" media="all" />
</head>
<body class="main_body">
<div class="layui-layout layui-layout-admin">
	<!-- 顶部 -->
	<div class="layui-header header">
		<div class="layui-main">
			<a href="#" class="logo">layui后台管理</a>
			<!-- 显示/隐藏菜单 -->
			<a href="javascript:;" class="iconfont hideMenu icon-menu1"></a>
			<!--<div style="float: left;">-->
			<!--<ul class="layui-nav" lay-filter="">-->
				<!--<li class="layui-nav-item"><a href="">最新活动</a></li>-->
				<!--<li class="layui-nav-item layui-this"><a href="">产品</a></li>-->
				<!--<li class="layui-nav-item"><a href="">大数据</a></li>-->
				<!--<li class="layui-nav-item"><a href="">社区</a></li>-->
			<!--</ul>-->
			<!--</div>-->
			<!-- 天气信息 -->
			<div class="weather" pc>
				<div id="tp-weather-widget"></div>
				<script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
				<script>tpwidget("init", {
					"flavor": "slim",
					"location": "WX4FBXXFKE4F",
					"geolocation": "enabled",
					"language": "zh-chs",
					"unit": "c",
					"theme": "chameleon",
					"container": "tp-weather-widget",
					"bubble": "disabled",
					"alarmType": "badge",
					"color": "#FFFFFF",
					"uid": "U9EC08A15F",
					"hash": "039da28f5581f4bcb5c799fb4cdfb673"
				});
				tpwidget("show");</script>
			</div>
			<!-- 顶部右侧菜单 -->
			<ul class="layui-nav top_menu">
				<li class="layui-nav-item showNotice" id="showNotice" pc>
					<a href="javascript:;"><i class="iconfont icon-gonggao"></i><cite>系统公告</cite></a>
				</li>
				<li class="layui-nav-item" mobile>
					<a href="javascript:;" data-url="page/user/changePwd.html"><i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i><cite>设置</cite></a>
				</li>
				<li class="layui-nav-item" mobile>
					<a href="page/login/login.html"><i class="iconfont icon-loginout"></i> 退出</a>
				</li>
				<li class="layui-nav-item lockcms" pc>
					<a href="javascript:;"><i class="iconfont icon-lock1"></i><cite>锁屏</cite></a>
				</li>
				<li class="layui-nav-item" pc>
					<a href="javascript:;">
						<img src="<?php echo __ADMIN_LAYER__; ?>/images/face.jpg" class="layui-circle" width="35" height="35">
						<cite><?php echo $User_info['nickname']; ?></cite>
					</a>
					<dl class="layui-nav-child">
						<dd><a href="javascript:;" data-url="page/user/userInfo.html"><i class="iconfont icon-zhanghu" data-icon="icon-zhanghu"></i><cite>个人资料</cite></a></dd>
						<dd><a href="javascript:;" data-url="page/user/changePwd.html"><i class="iconfont icon-shezhi1" data-icon="icon-shezhi1"></i><cite>修改密码</cite></a></dd>
						<dd><a href="javascript:;" class="changeSkin"><i class="iconfont icon-huanfu"></i><cite>更换皮肤</cite></a></dd>
						<dd><a href="<?php echo Url('admin/Share/loginout'); ?>"><i class="iconfont icon-loginout"></i><cite>退出</cite></a></dd>
					</dl>
				</li>
			</ul>
		</div>
	</div>
	<!-- 左侧导航 -->
	<div class="layui-side layui-bg-black">
		<div class="user-photo">
			<a class="img" title="我的头像" ><img src="<?php echo __ADMIN_LAYER__; ?>/images/face.jpg"></a>
			<p>你好！<span class="userName"><?php echo $User_info['nickname']; ?></span>, 欢迎登录</p>
		</div>
		<div class="navBar layui-side-scroll"></div>
	</div>
	<!-- 右侧内容 -->
	<div class="layui-body layui-form">
		<div class="layui-tab marg0" lay-filter="bodyTab" id="top_tabs_box">
			<ul class="layui-tab-title top_tab" id="top_tabs">
				<li class="layui-this" lay-id=""><i class="iconfont icon-computer"></i> <cite>后台首页</cite></li>
			</ul>
			<ul class="layui-nav closeBox">
				<li class="layui-nav-item">
					<a href="javascript:;"><i class="iconfont icon-caozuo"></i> 页面操作</a>
					<dl class="layui-nav-child">
						<dd><a href="javascript:;" class="closePageOther"><i class="iconfont icon-prohibit"></i> 关闭其他</a></dd>
						<dd><a href="javascript:;" class="closePageAll"><i class="iconfont icon-guanbi"></i> 关闭全部</a></dd>
					</dl>
				</li>
			</ul>
			<div class="layui-tab-content clildFrame">
				<div class="layui-tab-item layui-show">
					<iframe src="<?php echo Url('admin/index/info'); ?>"></iframe>
				</div>
			</div>
		</div>
	</div>
	<input type="checkbox" name="yyy" lay-skin="switch" lay-text="ON|OFF" checked>
	<!-- 底部 -->
	<div class="layui-footer footer">
		<p>copyright @2017 请叫我马哥　　<a onclick="donation()" class="layui-btn layui-btn-danger l·ayui-btn-small">捐赠作者</a></p>
	</div>
</div>

<script>
	var leftnav_url = "<?php echo Url('admin/Nav/leftnav'); ?>"
</script>
<!-- 移动导航 -->
<div class="site-tree-mobile layui-hide"><i class="layui-icon">&#xe602;</i></div>
<div class="site-mobile-shade"></div>

<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/layui/layui.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/index.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/leftNav.js"></script>
</body>
</html>