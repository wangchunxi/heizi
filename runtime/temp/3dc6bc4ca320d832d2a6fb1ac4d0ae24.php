<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:70:"/home/wwwroot/heizi/public/../app/admin/view/public/table_list_cp.html";i:1502880387;}*/ ?>

<?php
    if(isset($config['list'])){
if(is_array($config['list']) || $config['list'] instanceof \think\Collection || $config['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $config['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
            <td>
                <input type="checkbox" name="ids" lay-skin="primary" lay-filter="choose">
            </td>
            <?php if(is_array($config['config']) || $config['config'] instanceof \think\Collection || $config['config'] instanceof \think\Paginator): $i = 0; $__LIST__ = $config['config'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vs): $mod = ($i % 2 );++$i;
                    $news_array = null ;
                    $news_array=array(
                        'config'=>$vs['config'],
                        'vo'=> $vo,
                    );
                ?>
                <?php echo widget("admin/Webplug/table_list",  json_encode($news_array )); endforeach; endif; else: echo "" ;endif; ?>
            <td>
                <?php
                    if(!empty($Button_arr)){
                       $Button_arr = json_encode($Button_arr);
                ?>
                <?php echo widget("admin/Webplug/Button",$Button_arr); 
                    }
                ?>
            </td>
        </tr>
    <?php endforeach; endif; else: echo "" ;endif; ?>
<input id="total_page" value="<?php echo $config['total_page']; ?>" type="hidden">
<?php
    }
?>

<script>
        layui.config({
            base : "/static/layer/js/"
        })
            //添加
            function test (obj) {
                var id = $(obj).attr('data-id');
                var url = "<?php echo $request_url['edit']; ?>"+id
                var index = layui.layer.open({
                    title: "添加文章",
                    type: 2,
                    content: url,
                    id:12,
                    success: function (layero, index) {
                        setTimeout(function () {
                            layui.layer.tips('点击此处返回文章列表', '.layui-layer-setwin .layui-layer-close', {
                                tips: 3
                            });
                        }, 500)
                    }
                })
                //改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
                $(window).resize(function () {
                    layui.layer.full(index);
                })
                layui.layer.full(index);
            }
</script>