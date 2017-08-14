<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:62:"/home/wwwroot/heizi/public/../app/admin/view/widget/input.html";i:1502535761;}*/ ?>
<div  style="margin: 20px 0px 10px 0px">
    <label class="layui-form-label"><?php echo $data['name']; ?></label>
    <div class="layui-input-block">
        <input type="<?php echo $data['type']; ?>" name="<?php echo $data['submit_name']; ?>" lay-verify="<?php echo $data['verify']; ?>" autocomplete="off" class="layui-input" lay-verify="required"
               value="<?php  echo isset($data['value']) ? $data['value']: '';  ?>"
        >
    </div>
</div>