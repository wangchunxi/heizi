<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"/home/wwwroot/heizi/public/../app/admin/view/widget/password.html";i:1500025126;}*/ ?>
<div  style="margin: 20px 0px 10px 0px">
    <label class="layui-form-label"><?php echo $data['name']; ?></label>
    <div class="layui-input-block">
        <input type="password" name="<?php echo $data['submit_name']; ?>" lay-verify="<?php echo $data['verify']; ?>" autocomplete="off" class="layui-input" lay-verify="required">
    </div>
</div>