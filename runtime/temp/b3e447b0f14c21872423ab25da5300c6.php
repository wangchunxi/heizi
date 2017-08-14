<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"/home/wwwroot/heizi/public/../app/admin/view/view/index.html";i:1502672109;}*/ ?>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/spark-md5.min.js"></script>
<script type="text/javascript" src="<?php echo __ADMIN_LAYER__; ?>/js/jq1.9.js"></script>
<div>
  <input type="file" id="uploadFile">
</div>
<div>
  <input type="button" id="btnFile" value="测试">
</div>
<script>

  $("#btnFile").click(function(){
    var dom = document.getElementById("uploadFile");
    processFiles(dom.files);
  })

  function processFiles(files) {
    var file = files[0];
    console.log(file);

    var reader = new FileReader();
    reader.onload = function (e) {
      // 这个事件发生，意为着数据准备好了
      alert(SparkMD5.hashBinary(e.target.result));
    };
    reader.readAsBinaryString(file)
  }
</script>