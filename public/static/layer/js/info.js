/**
 * Created by Administrator on 2017/7/12.
 */
layui.config({
    base : "/static/layer/js/"
}).use(['form','layer','jquery','upload'],function(){
    var form = layui.form,
        layer = parent.layer === undefined ? layui.layer : parent.layer,
        upload = layui.upload,
        $ = layui.jquery;


    form.on("submit(*)",function(data){
        //是否添加过信息
        var index = top.layer.msg('数据提交中，请稍候',{icon: 16,time:false,shade:0.5});
        //console.log(submit_url);
        $.ajax({
            type: "POST",
            url: submit_url,
            data:$('#form').serialize(),
            success: function(msg){
                //弹出loading
                    msg =eval('(' + msg + ')');
                    top.layer.close(index);
                    top.layer.msg(msg.info);
                    if(msg.status==true){
                        layer.closeAll("iframe");
                        //刷新父页面
                        parent.location.reload();
                    }
                    if($('div').hasClass('cause_html') === false){
                        $('.wu-example').append('<div class ="cause_html" style="color: orangered;font-size:16px;"></div>');
                    }
                    if(msg.status == false && msg.cause){
                        $('.cause_html').html(msg.cause);
                    }
            },
        });
    })
    /**
     * 监听复选框事件
     */
    form.on('checkbox(goods_name)', function(data){
        var title = data.elem.title;/*选择物品的名称*/
        var value = data.value;/*物品的值*/
        var status = data.elem.checked;/*物品的选择状态*/
        var obj = $(this);
        /*只有选择物品才开启JQ*/
        if($('div').hasClass('emblem_goods_name')){
            var goods_id = new RegExp(value);
            /*如果是选中状态*/
            if(status === true){
                /*判断是否是第一次选中*/
                if($('div').hasClass('emblem') === false){
                    /*第一次选中创建最开始的容器*/
                    var html = "<div class='emblem'  style='padding: 15px 0px 20px 35px;'><span>选中的货物:</span></div>" +
                        "<input type='hidden' class='goods_id' name ='goods_id' value=''>";
                    /*追加到指定位置*/
                    $(".emblem_goods_name").append(html);
                }
                /*把选中的值进行页面展示*/
                var emblem_html = '<span  class="emblem_'+value+'"><span class="layui-badge-rim"><span>'+title+'</span>&numsp;' +
                    '<span class="del_goods_id_'+value+'" href="javascript:;" >X</span></span>&numsp;&numsp;</span>';
                $(".emblem").append(emblem_html);
                /*获取隐藏域的参数值*/
                var array  = $('.goods_id').val();
                /*判断是否存在存在就不添加*/
                if(goods_id.test(array)!=true){
                    array+=value+',';
                    $('.goods_id').val(array);
                }
            }else{
                $(".emblem_"+value).remove();
                /*获取隐藏域的参数值*/
                var array  = $('.goods_id').val();
                if(goods_id.test(array)==true){
                    array= array.replace(new RegExp(value+','),'');
                    $('.goods_id').val(array);
                }
            }
            $('.del_goods_id_'+value).on('click',function(){
                $(obj).next().attr('class','layui-unselect layui-form-checkbox');
                $(obj).attr('checked',false);
                $(".emblem_"+value).remove();
                var array  = $('.goods_id').val();
                if(goods_id.test(array)==true){
                    array= array.replace(new RegExp(value+','),'');
                    $('.goods_id').val(array);
                }
            })
        }
    });

    //普通图片上传
    var uploadInst = upload.render({
        elem: '#test1'
        ,url:''
        ,method:'post'
        ,data: {md5: $("input[name^='class']").val()} //可选项。额外的参数，如：{id: 123, abc: 'xxx'}
        ,before: function(obj){
            //预读本地文件示例，不支持ie8
            obj.preview(function(index, file, result){
                $('#demo1').attr('src', result); //图片链接（base64）
                calculate(file,callback=function(md5){
                    ajax_var_imag(md5);
                });
            });
        }
        ,done: function(res){
           var md511 =  $("input[name^='class']").val();
            console.log(md511);
            //如果上传失败
            if(res.code > 0){
                return layer.msg('上传失败');
            }
            //上传成功
        }
        ,error: function(){
            //演示失败状态，并实现重传
            var demoText = $('#demoText');
            demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
            demoText.find('.demo-reload').on('click', function(){
                uploadInst.upload();
            });
        }
    });

})
function calculate(file,callback){
    var fileReader = new FileReader(),
        blobSlice = File.prototype.mozSlice || File.prototype.webkitSlice || File.prototype.slice,
        chunkSize = 2097152,
        chunks = Math.ceil(file.size / chunkSize),
        currentChunk = 0,
        spark = new SparkMD5();
        //var md5 = spark.end()
    var md5 =  fileReader.onload = function(e) {
        spark.appendBinary(e.target.result); // append binary string
        currentChunk++;

        if (currentChunk < chunks) {
            loadNext();
        }
        else {
           return callback(spark.end());
        }
    };
    function loadNext() {
        var start = currentChunk * chunkSize,
            end = start + chunkSize >= file.size ? file.size : start + chunkSize;

        fileReader.readAsBinaryString(blobSlice.call(file, start, end));
    };
    loadNext();
    console.log(md5);
}
function ajax_var_imag(md5){
    $("input[name^='class']").val('1');
    return md5;
}
//function callback(md5){
//    console.log(md5+'回调值');
//    return md5;
//}
function uniq_array(array){
    for(var i = 0 ;i<array.length;i++)
    {
        if(array[i] == "" || typeof(array[i]) == "undefined")
        {
            array.splice(i,1);
            i= i-1;
        }
    }
    return array;
}