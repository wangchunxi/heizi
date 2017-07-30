<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"/home/wwwroot/heizi/public/../app/admin/view/widget/select.html";i:1501330422;}*/ ?>
<div >
    <label class="layui-form-label"><?php echo $data['name']; ?></label>
    <div class="layui-input-block" >
        <select class="layui-input-inline"  style="" lay-verify="required" name="<?php echo $data['submit_name']; ?>">
            <option value="0">请选择</option>
            <?php if(is_array($data['option']) || $data['option'] instanceof \think\Collection || $data['option'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['option'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['id']; ?>"><?php echo $vo['title']; ?></option>
            <?php
              //  $children_array =
                if(isset($vo['children'])){
            ?>
                <?php echo recursion_web($vo['children']); ?>;
            <?php
                }
            endforeach; endif; else: echo "" ;endif; ?>
        </select>
    </div>
</div>