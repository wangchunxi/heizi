<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"/home/wwwroot/heizi/public/../app/admin/view/widget/upload_one.html";i:1502820646;}*/ ?>
<!--<div    style="margin: 20px 0px 10px 0px">-->
    <!--<label class="layui-form-label"><?php echo $data['name']; ?></label>-->
    <!--<div class="layui-upload">-->
        <!--<button type="button" class="layui-btn" id="test1" >上传图片</button>-->
        <!--<div class="layui-upload-list">-->
            <!--<img class="layui-upload-img" id="demo1">-->
            <!--<p id="demoText" style="margin: 0 10px 10px 110px;"></p>-->
        <!--</div>-->
    <!--</div>-->
    <!--<button id="testListAction" onclick="return false">重试</button>-->
<!--</div>-->
<style>
    .layui-upload-img{width: 360px; height: 80px;}
</style>
<!--<div class="layui-upload">-->
    <!--<button type="button" class="layui-btn" id="test1">上传图片</button>-->
    <!--<div class="layui-upload-list">-->
        <!--<img class="layui-upload-img" id="demo1">-->
        <!--<p id="demoText"></p>-->
    <!--</div>-->
<!--</div>-->
<!--
<div id="uploader" class="wu-example">
    &lt;!&ndash;用来存放文件信息&ndash;&gt;
    <div id="thelist" class="uploader-list"></div>
    <div class="btns">
        <div id="picker">选择文件</div>
        <button id="ctlBtn" class="btn btn-default">开始上传</button>
    </div>
</div>-->
<link rel="stylesheet" href="<?php echo __ADMIN_WEBUPLOADE__; ?>/css/webuploader.css" media="all" />
<script type="text/javascript" src="<?php echo __ADMIN_WEBUPLOADE__; ?>/js/webuploader.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_WEBUPLOADE__; ?>/js/webuploader.nolog.js"></script>
    <div  style="margin: 20px 0px 10px 25px">
        <div id="uploadBtn" class="btn btn-upload">上传文件</div>
        <div id="list" class="upload-box clearfix"></div>
    </div>
<script>
    var swfUrl =  " <?php echo __ADMIN_WEBUPLOADE__; ?>/js/Uploader.swf";
</script>