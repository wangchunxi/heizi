<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"/home/wwwroot/heizi/public/../app/admin/view/user/info.html";i:1501375585;s:61:"/home/wwwroot/heizi/public/../app/admin/view/public/head.html";i:1501334649;}*/ ?>
﻿<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>文章添加--layui后台管理模板</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    
    <link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/layui/css/layui.css" media="all" />
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/layui/layui.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/public.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/jq1.9.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/List.js"></script>
<link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/css/List.css" media="all" />


    
</head>
<body class="childrenBody">
<fieldset class="layui-elem-field">
    <legend>导航详情</legend>
    <form class="layui-form" id="form">
        <div class="layui-form-item">
            <?php if(is_array($view_plug) || $view_plug instanceof \think\Collection || $view_plug instanceof \think\Paginator): $i = 0; $__LIST__ = $view_plug;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <?php echo widget("admin/Webplug/webplug",$vo['config']); endforeach; endif; else: echo "" ;endif; ?>
            <div class="layui-input-block">
                <a   href="javascript:; "  type="button"  class="layui-btn" lay-submit lay-filter="*">立即提交</a>
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>
</fieldset>
</body>
<script>
    var submit_url = "<?php echo $submit_url; ?>";
</script>
</html>