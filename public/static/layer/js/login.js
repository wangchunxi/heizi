layui.config({
	base : "js/"
}).use(['form','layer'],function(){
	var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		$ = layui.jquery;
	//video背景
	$(window).resize(function(){
		if($(".video-player").width() > $(window).width()){
			$(".video-player").css({"height":$(window).height(),"width":"auto","left":-($(".video-player").width()-$(window).width())/2});
		}else{
			$(".video-player").css({"width":$(window).width(),"height":"auto","left":-($(".video-player").width()-$(window).width())/2});
		}
	}).resize();

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
				var ts = Date.parse(new Date())/1000;
				$('#verify_img').attr("src", "/captcha?id="+ts);
				msg =eval('(' + msg + ')');
				top.layer.close(index);
				top.layer.msg(msg.info);
				if(msg.status==true){
					location.href =msg.url;
				}
			},
		});
	})

})
