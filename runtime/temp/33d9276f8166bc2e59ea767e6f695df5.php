<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:66:"/home/wwwroot/heizi/public/../app/admin/view/widget/listtable.html";i:1501381715;}*/ ?>
<div class="layui-form news_list">
    <table class="layui-table">
      <!--  <colgroup>
            <col>
        </colgroup>-->
        <thead>
        <tr>
            <th>
                <input type="checkbox" name="" lay-skin="primary" lay-filter="allChoose" id="allChoose">
            </th>
            <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <th class="<?php echo $vo['class']; ?>" style="<?php echo $vo['style']; ?>" ><?php echo $vo['name']; ?></th>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </tr>
        </thead>
        <tbody class="news_content"></tbody>
    </table>
</div>
<div id="page">
</div>