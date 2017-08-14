<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"/home/wwwroot/heizi/public/../app/admin/view/widget/button.html";i:1502565276;}*/ ?>
<?php
    if($type =='head'){
if(is_array($Button) || $Button instanceof \think\Collection || $Button instanceof \think\Paginator): $i = 0; $__LIST__ = $Button;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <!--<button class="<?php echo $vo['css']; ?>"><?php echo $vo['menu_name']; ?></button>-->
        <a class="layui-btn <?php echo $vo['class']; ?>" href="javascript:;"><?php echo $vo['menu_name']; ?></a>
    <?php endforeach; endif; else: echo "" ;endif; 
    }else{
?>
    <button class="layui-btn-mini">迷你按钮</button>
<?php
    }
?>