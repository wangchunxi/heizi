<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"/home/wwwroot/heizi/public/../app/admin/view/public/table_list.html";i:1502615317;s:61:"/home/wwwroot/heizi/public/../app/admin/view/public/head.html";i:1502659999;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>文章列表--layui后台管理模板</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <script>
        var get_list = "<?php echo $request_url['get_list']; ?>";
        var add_url = "<?php echo $request_url['add_url']; ?>";
    </script>
    
    <link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/layui/css/layui.css" media="all" />
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/layui/layui.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/jq1.9.js"></script>


    
    <link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/css/List.css" media="all" />
    <script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/List.js"></script>

</head>
<body class="childrenBody">
    <form class="layui-form" action="">
        <blockquote class="layui-elem-quote news_search">
            <div class="layui-inline">
                <div class="layui-input-inline">
                    <input type="text" value="" placeholder="请输入关键字" class="layui-input search_input">
                </div>
                <a class="layui-btn search_btn">查询</a>
            </div>
            <div class="layui-inline" style=" float: right;">
                <?php
                    if(!empty($Button_arr)){
                       $Button_arr = json_encode($Button_arr);
                ?>
                    <?php echo widget("admin/Webplug/Button",$Button_arr); 
                    }
                ?>
            </div>
        </blockquote>
        <div class="layui-form news_list">
            <table class="layui-table">
                <!--  <colgroup>
                      <col>
                  </colgroup>-->
                <thead>
                    <?php if(is_array($config) || $config instanceof \think\Collection || $config instanceof \think\Paginator): $i = 0; $__LIST__ = $config;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <?php echo widget("admin/Webplug/webplug",$vo['config']); endforeach; endif; else: echo "" ;endif; ?>
                </thead>
                <tbody class="news_content">

                </tbody>
            </table>
        </div>
        <div id="page">

        </div>
    </form>
</body>
</html>
