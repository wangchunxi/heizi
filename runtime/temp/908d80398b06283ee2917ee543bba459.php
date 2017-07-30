<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:61:"/home/wwwroot/heizi/public/../app/admin/view/widget/text.html";i:1499962875;}*/ ?>
<div  style="margin: 20px 0px 10px 0px">
    <label class="layui-form-label"><?php echo $data['name']; ?></label>
    <div class="layui-input-block">
        <input type="text" name="<?php echo $data['submit_name']; ?>" lay-verify="<?php echo $data['verify']; ?>" autocomplete="off" class="layui-input" lay-verify="required">
    </div>
</div>