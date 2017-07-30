<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"/home/wwwroot/heizi/public/../app/admin/view/share/login.html";i:1500044713;}*/ ?>
﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>登录--layui后台管理模板</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/layui/css/layui.css" media="all" />
    <link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/css/login.css" media="all" />
    <script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/layui/layui.js"></script>
    <script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/login.js"></script>
    <script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/jq1.9.js"></script>
</head>
<body>
<video class="video-player" preload="auto" autoplay="autoplay" loop="loop" data-height="1080" data-width="1920" height="1080" width="1920">
    <source src="login.mp4" type="video/mp4">
    <!-- 此视频文件为支付宝所有，在此仅供样式参考，如用到商业用途，请自行更换为其他视频或图片，否则造成的任何问题使用者本人承担，谢谢 -->
</video>
<!--<div class="video_mask"></div>-->
<div class="login">
    <h1>layuiCMS-管理登录</h1>
    <form class="layui-form"  id="form">
        <div class="layui-form-item">
            <input class="layui-input" name="username" placeholder="用户名" lay-verify="required" type="text" autocomplete="off">
        </div>
        <div class="layui-form-item">
            <input class="layui-input" name="password" placeholder="密码" lay-verify="required" type="password" autocomplete="off">
        </div>
        <div class="layui-form-item form_code">
            <input class="layui-input" name="code" placeholder="验证码" lay-verify="required" type="text" autocomplete="off">
            <div class="code"><img id="verify_img" src="<?php echo captcha_src(); ?>" alt="验证码" onclick="refreshVerify()" width="116" height="36"></div>
        </div>
        <a href="javascript:; "  type="button"  lay-submit lay-filter="*" class="layui-btn login_btn">登录</a>
    </form>
</div>
</body>
<script>
    var submit_url = "<?php echo $submit_url; ?>";
    function refreshVerify() {
        var ts = Date.parse(new Date())/1000;
        $('#verify_img').attr("src", "/captcha?id="+ts);
    }
</script>
</html>