<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:67:"/home/wwwroot/heizi/public/../app/admin/view/widget/upload_one.html";i:1502668221;}*/ ?>

<div    style="margin: 20px 0px 10px 0px">
    <label class="layui-form-label"><?php echo $data['name']; ?></label>
    <div class="layui-upload">
        <button type="button" class="layui-btn" id="test1" >上传图片</button>
        <div class="layui-upload-list">
            <img class="layui-upload-img" id="demo1">
            <p id="demoText" style="margin: 0 10px 10px 110px;"></p>
        </div>
    </div>
</div>
<style>
    .layui-upload-img{width: 360px; height: 80px; margin: 0 10px 10px 110px;}
</style>
<!--<div class="layui-upload">-->
    <!--<button type="button" class="layui-btn" id="test1">上传图片</button>-->
    <!--<div class="layui-upload-list">-->
        <!--<img class="layui-upload-img" id="demo1">-->
        <!--<p id="demoText"></p>-->
    <!--</div>-->
<!--</div>-->