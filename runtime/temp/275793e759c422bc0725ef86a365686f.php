<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:60:"/home/wwwroot/heizi/public/../app/admin/view/user/index.html";i:1499909490;s:61:"/home/wwwroot/heizi/public/../app/admin/view/public/head.html";i:1501334649;}*/ ?>
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
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/List.js"></script>
<link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/css/List.css" media="all" />


  
</head>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 50px;">
    <legend >面板嵌套</legend>
</fieldset>
<div class="" style="margin:10px 0 18px 90%;">
  <button class="layui-btn Add_btn"><i class="layui-icon"></i> 添加导航</button>
</div>
<div class="layui-collapse" >
  <div class="layui-colla-item">
    <button class="layui-colla-title" style="border:0px; width: 85%;  text-align: left;">文豪</button>
    <button class="layui-btn layui-btn-primary layui-btn-small" ><i class="layui-icon"></i></button>
    <button class="layui-btn layui-btn-primary layui-btn-small"><i class="layui-icon"></i></button>
    <button class=" layui-btn  layui-btn-primary layui-btn-small">隐藏</button>
    <button class=" layui-btn  layui-btn-primary layui-btn-small">禁用</button>
      <div class="layui-colla-content">

      <div class="layui-collapse" >
        <div class="layui-colla-item">
          <h2 class="layui-colla-title">唐代</h2>
          <div class="layui-colla-content ">

            <div class="layui-collapse" >
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">杜甫</h2>
                <div class="layui-colla-content ">
                  伟大的诗人
                </div>
              </div>
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">李白</h2>
                <div class="layui-colla-content">
                  <p>据说是韩国人</p>
                </div>
              </div>
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">王勃</h2>
                <div class="layui-colla-content">
                  <p>千古绝唱《滕王阁序》</p>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="layui-colla-item">
          <h2 class="layui-colla-title">宋代</h2>
          <div class="layui-colla-content">
            <p>比如苏轼、李清照</p>
          </div>
        </div>
        <div class="layui-colla-item">
          <h2 class="layui-colla-title">当代</h2>
          <div class="layui-colla-content">
            <p>比如贤心</p>
          </div>
        </div>
      </div>
    </div>
    </div>
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">科学家</h2>
    <div class="layui-colla-content">
      <p>伟大的科学家</p>
    </div>
  </div>
  <div class="layui-colla-item">
    <h2 class="layui-colla-title">艺术家</h2>
    <div class="layui-colla-content">
      <p>浑身散发着艺术细胞</p>
    </div>
  </div>
</div>

<br>
<!-- 注意：如果你直接复制所有代码到本地，上述js路径需要改成你本地的 -->
<script>
  var add_url = "<?php echo Url('info'); ?>"
layui.use(['element', 'layer'], function(){
  var element = layui.element();
  var layer = layui.layer;
  //监听折叠
  element.on('collapse(test)', function(data){
    layer.msg('展开状态：'+ data.show);
  });
});
</script>

</body>
</html>
