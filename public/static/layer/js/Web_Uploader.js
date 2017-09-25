/**
 * Created by Administrator on 2017/9/12.
 */
    //webuploader上传图片
$(function(){

    //验证数组方法
     Array.prototype.contains = function (obj) {
         var i = this.length;
         while (i--) {
             if (this[i] === obj) {
                return true;
             }
         }
         return false;
        }
    var arr_md5 = [];//加载页面时，将已上传成功的分片数组化
    var chunks = 0;//分片总数量，用来上传成功以后校验分片文件总数
    var repart_chunks = 0;
    var  curr_uploader;
    var upload_success = false;
    var times = 0;
    var interval = 0;
    var thumbnailWidth =200;
    var thumbnailHeight = 200;
    //注册组件
    WebUploader.Uploader.register({
        'before-send': 'preupload'
    }, {
        preupload: function( block ) {
            var me = this,
                owner = this.owner,
                deferred = WebUploader.Deferred();
                chunks = block.chunks;
                owner.md5File(block.blob);
                //及时显示进度
                //.progress(function(percentage) {
                //    console.log('Percentage:', percentage);
                //})
                ////如果读取出错了，则通过reject告诉webuploader文件上传出错。
                //.fail(function() {
                //    deferred.reject();
                //    console.log("==1==");
                //})
                //md5值计算完成
                //.then(function( md5 ) {
                //    if(arr_md5.contains(md5)){//数组中包含+(block.chunk+1)
                //        deferred.reject();
                //        console.log("分片已上传"+block.file.id);
                //        $("#speed_"+block.file.id).text("正在断点续传中...");
                //        if(block.end == block.total){
                //            $("#speed_"+block.file.id).text("上传完毕");
                //            $("#pro_"+block.file.id).css( 'width', '100%' );
                //        }else{
                //            $("#pro_"+block.file.id).css( 'width',(block.end/block.total) * 100 + '%' );
                //        }
                //    }else{
                //        deferred.resolve();
                //        console.log("开始上传分片："+md5);
                //    }
                //});
                owner.md5File(block.file).then(function(val){
                $.ajax({
                    type: "POST",
                    url: verify_image,
                    data: {
                        md5: val
                    },
                    cache: false,
                    timeout: 10000, // 超时的话，只能认为该文件不曾上传过
                    dataType: "json"
                }).then(function(res, textStatus, jqXHR){
                    res  = eval('(' + res + ')');
                    console.log(res.code);
                    if(res.code){
                        // 已上传，触发上传完成事件，实现秒传
                        deferred.reject();
                        curr_uploader.trigger('uploadSuccess', block.file, res);
                        curr_uploader.trigger('uploadComplete', block.file);
                    }else{
                        // 文件不存在，触发上传
                        deferred.resolve();
                        $("#speed_"+block.file.id).html('<span class="text-info">正在上传...</span>');
                    }
                }, function(jqXHR, textStatus, errorThrown){
                    // 任何形式的验证失败，都触发重新上传
                    deferred.resolve();
                    $("#speed_"+block.file.id).html('<span class="text-info">正在上传...</span>');
                });
            });

            return deferred.promise();
        }
    });

    //初始化WebUploader
    var uploader = WebUploader.create({
        //swf文件路径
        swf: swfUrl,
        //文件接收服务端。
        server: '',
        //选择文件的按钮，可选。内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#uploadBtn',
        //不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false,
        auto:true,
        //是否分片
        chunked :false,
        //分片大小
        chunkSize :1024*1024*2,
        chunkRetry :3,
        threads :3,//最大并发
        fileNumLimit :1,
        fileSizeLimit :1024*1024*1024*1024,
        fileSingleSizeLimit: 1024*1024*1024,
        duplicate :true,
        accept: {
            title: 'file',
            extensions: 'jpg,png,ai,zip,rar,psd,pdf,cdr,psd,tif',
            mimeTypes: 'image/jpg,image/jpeg,image/png',
        }
    });

//当文件被加入队列之前触发，此事件的handler返回值为false，则此文件不会被添加进入队列。
    uploader.on('beforeFileQueued',function(file){
        if(",jpg,png,ai,zip,rar,psd,pdf,cdr,psd,tif,".indexOf(","+file.ext+",")<0){
            alert("不支持的文件格式");
        }
    });

//当有文件添加进来的时候
    uploader.on( 'fileQueued', function( file ) {
        times = 1;
        upload_success = false;
        $("#list").html(
            '<div class="clearfix"><img src="" class="icon-file" id="imgs" ></img>'+
            '<div class="fl" style="margin-left: 70px;">'+
            '<p class="speed font-12" id="speed_'+file.id+'">校验文件...</p>'+
            '<div class="progress">'+
            '<span id="pro_'+file.id+'" class="progressing"></span>'+
            '</div>'+
            '<span class="file-size">'+(file.size/1024/1024).toFixed(2)+'MB</span>'+
            '<a href="javascript:void(0);" id="stopOretry_'+file.id+'" onclick="stop(\''+file.id+'\');" class="a-pause">暂停</a>'+
            '<br/><span style="text-align:center" class="file-name">'+file.name+'</span>'+
            '</div></div>' );
        //文件开始上传后开始计时，计算实时上传速度
        interval = setInterval(function(){times++;},1000);
        uploader.makeThumb( file, function( error, src ) {   //webuploader方法
             $('#imgs').attr( 'src', src );
        }, thumbnailWidth, thumbnailHeight );
        curr_uploader = uploader;
    });

//上传过程中触发，携带上传进度。文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var status_pre = file.size*percentage-arr_md5.length*2*1024*1024;
        if(status_pre<=0){
            return;
        }
        $("#pro_"+file.id).css( 'width', percentage * 100 + '%' );
        var speed = ((status_pre/1024)/times).toFixed(0);
        $("#speed_"+file.id).text(speed +"KB/S");
        if(percentage == 1){
            $("#speed_"+file.id).text("上传完毕");
        }
    });

//文件上传成功时触发
    uploader.on( 'uploadSuccess', function( file,response) {
        console.log("成功上传"+file.name+"  res="+response);
        $.ajax({
            type:'get',
            url:'',
            dataType: 'json',
            data: {
                methodName:'composeFile',
                name:file.name,
                chunks:chunks,
                tokenid:$("#tokenid").val()
            },
            async:false,
            success: function(data) {
                console.log("==compose=="+data.status);
                if(data.status == "success"){
                    upload_success = true;
                    $("#url").val(data.url);
                    console.log(data.url);
                }else{
                    upload_success = false;
                    alert(data.errstr);
                }
            }
        });
    });

//文件上传异常失败触发
    uploader.on( 'uploadError', function( file,reason ) {
        console.log("失败"+reason );
    });

//某个文件开始上传前触发，一个文件只会触发一次。
    uploader.on( 'uploadStart', function(file) {
        console.info("file="+file.name);
        //分片文件上传之前
        $.ajax({
            type:'get',
            url:'',
            dataType: 'json',
            data: {
                methodName:'md5Validation',
                name:file.name,
                tokenid:$("#tokenid").val()
            },
            async:false,
            success: function(data) {
                if(data.md5_arr != ""){
                    arr_md5 = data.md5_arr.split(",")
                }else{
                    arr_md5 = new Array();
                }
            }
        });
    });

//当所有文件上传结束时触发。
    uploader.on( 'uploadFinished', function() {

    });

    function stop(id){
        uploader.stop(true);
        $("#stopOretry_"+id).attr("onclick","retry('"+id+"')");
        $("#stopOretry_"+id).text("恢复");
        clearInterval(interval);
    }
    function retry(id){
        uploader.retry();
        $("#stopOretry_"+id).attr("onclick","stop('"+id+"')");
        $("#stopOretry_"+id).text("暂停");
        interval = setInterval(function(){times++;},1000);
    }

  //  var uploader = WebUploader.create({
  //      // 选完文件后，是否自动上传。
  //      auto: true,
  //      // swf文件路径
  //      swf:swfUrl,
  //      // 文件接收服务端。
  //      server: '',
  //      pick: '#filePicker',
  //      noCompressIfLarger: false,
  //      quality: 90,
  //      // 只允许选择图片文件。
  //      accept: {
  //          title: 'Images',
  //          extensions: 'gif,jpg,jpeg,bmp,png',
  //          mimeTypes: 'image/jpg,image/jpeg,image/png',
  //      }
  //  });
  //  /*图片预览*/
  //  uploader.on( 'fileQueued', function( file ) {
  //      var thumbnailWidth = 200;   //缩略图高度和宽度 （单位是像素），当宽高度是0~1的时候，是按照百分比计算，具体可以看api文档
  //      var thumbnailHeight = 200;
  //      var $list=$("#uploader-demo");
  //      var $li = $(
  //              '<div id="' + file.id + '" class="file-item thumbnail">' +
  //              '<img>' +
  //              '<div class="info">' + file.name + '</div>' +
  //              '</div>'
  //          ),
  //          $img = $li.find('img');
  //      // $list为容器jQuery实例
  //      $list.append( $li );
  //      // 创建缩略图
  //      // 如果为非图片文件，可以不用调用此方法。
  //      // thumbnailWidth x thumbnailHeight 为 100 x 100
  //      uploader.makeThumb( file, function( error, src ) {
  //          if ( error ) {
  //              $img.replaceWith('<span>不能预览</span>');
  //              return;
  //          }
  //
  //          $img.attr( 'src', src );
  //      }, thumbnailWidth, thumbnailHeight );
  //  });
  //var md5 =   uploader.on( 'fileQueued', function( file ) {
  //      uploader.md5File( file )
  //          // 及时显示进度
  //          .progress(function(percentage) {
  //              console.log('Percentage:', percentage);
  //          })
  //          // 完成
  //          .then(function(val) {
  //            //  console.log('md5 result:', val);
  //              return val;
  //          });
  //  });
})