<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:63:"/home/wwwroot/heizi/public/../app/admin/view/widget/td_btn.html";i:1501930374;}*/ ?>
<td>
    <a class="layui-btn layui-btn-mini Add_btn" href="javascript:;">
        <i class="iconfont icon-edit"></i>编辑
    </a>
<!--    <a class="layui-btn layui-btn-normal layui-btn-mini news_collect">
        <i class="layui-icon"></i> 收藏
    </a>
    <a class="layui-btn layui-btn-danger layui-btn-mini news_del" data-id="1">
        <i class="layui-icon"></i> 删除
    </a>-->
</td>
<script>
    var add_url = "<?php echo url('info'); ?>"
    layui.config({
        base : "/static/layer/js/"
    }).use(['form','layer','jquery','laypage'],function() {
        //添加
        $(".Add_btn").click(function () {
            var index = layui.layer.open({
                title: "添加文章",
                type: 2,
                content: add_url,
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
        })
    })
</script>