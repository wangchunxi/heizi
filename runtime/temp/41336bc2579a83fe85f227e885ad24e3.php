<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:65:"/home/wwwroot/heizi/public/../app/admin/view/widget/textarea.html";i:1499956969;}*/ ?>
<div class="layui-form-item layui-form-text" style="margin-top: 10px">
    <label class="layui-form-label"><?php echo $data['name']; ?></label>
    <div class="layui-input-block">
        <textarea placeholder="请输入内容" class="layui-textarea" name="<?php echo $data['submit_name']; ?>"></textarea>
    </div>
</div>