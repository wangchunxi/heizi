<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"/home/wwwroot/heizi/public/../app/admin/view/widget/button.html";i:1502860712;}*/ ?>
<?php
    if($type =='head'){
if(is_array($Button) || $Button instanceof \think\Collection || $Button instanceof \think\Paginator): $i = 0; $__LIST__ = $Button;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <!--<button class="<?php echo $vo['css']; ?>"><?php echo $vo['menu_name']; ?></button>-->
        <a
                class="layui-btn" id="head_button"  href="javascript:;"  data-opentype="<?php echo $vo['class']; ?>"
                data-name="<?php echo $vo['menu_name']; ?>" data-url="<?php echo Url('/'.$vo['url'].'/menu_id/'.$vo['id']);?>"
        ><?php echo $vo['menu_name']; ?></a>
    <?php endforeach; endif; else: echo "" ;endif; 
    }else{
?>
    <button class="layui-btn-mini">迷你按钮</button>
<?php
    }
?>