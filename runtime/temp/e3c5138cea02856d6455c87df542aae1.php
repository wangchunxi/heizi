<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:59:"/home/wwwroot/heizi/public/../app/admin/view/view/info.html";i:1501384891;s:61:"/home/wwwroot/heizi/public/../app/admin/view/public/head.html";i:1501810562;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>layui</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!-- 注意：如果你直接复制所有代码到本地，上述css路径需要改成你本地的 -->
    
    <link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/layui/css/layui.css" media="all" />
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/layui/layui.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/public.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/jq1.9.js"></script>


    
</head>
<body>
<fieldset class="layui-elem-field">
    <legend>模型</legend>
    <form class="layui-form" id="form">
        <div  style="margin: 20px 0px 10px 0px">
            <label class="layui-form-label">模板名称</label>
            <div class="layui-input-block">
                <input type="text" name="view_name" lay-verify="required" autocomplete="off" class="layui-input" lay-verify="required">
            </div>
        </div>


        <div  id="web_plug">
            <div class="layui-form-item" id="plug">
                <div class="layui-inline">
                    <label class="layui-form-label">插件名称</label>
                    <div class="layui-input-inline">
                        <select class="layui-input-inline"  style="" lay-verify="required" name="plug[]">
                            <option>请选择</option>
                            <?php if(is_array($plug) || $plug instanceof \think\Collection || $plug instanceof \think\Paginator): $i = 0; $__LIST__ = $plug;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <option value="<?php echo $vo; ?>"><?php echo $vo; ?></option>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">排序</label>
                    <div class="layui-input-inline">
                        <input type="text" name="sort[]" lay-verify="required" autocomplete="off" class="layui-input">
                    </div>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <a   href="javascript:; "  type="button"  class="layui-btn" lay-submit lay-filter="*">立即提交</a>
                <a  href="javascript:; "  type="button" class="layui-btn layui-btn-primary " onclick="add_plug()">添加</a>
            </div>
        </div>
    </form>
    <!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
</fieldset>
</body>
<script>
    var submit_url = "<?php echo $submit_url; ?>";
    function add_plug(){
        var html_plug =$('#plug').html();
        var html =" <div class='layui-form-item' >";
        html +=   html_plug;
        html += "</div>";
        //console.log(html);
        $('#web_plug').append(html);
        var form = layui.form();
        form.render('select');
    }
</script>
</html>