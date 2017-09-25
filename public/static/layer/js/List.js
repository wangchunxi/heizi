layui.config({
	base : "js/"
}).use(['form','layer','jquery','laypage'],function(){
	var form = layui.form,
		layer = parent.layer === undefined ? layui.layer : parent.layer,
		laypage = layui.laypage,
		$ = layui.jquery;


	//加载页面数据
	var newsData = '';
	$.get(get_list, function(msg){
		$(".news_content").html(msg);
		var total_page =  $("#total_page").val();
		pages(total_page);
		form.render();
		form.render('checkbox');
		$(".news_list").find(".head_button").each(function () {
			var $that = $(this);
			$that.on('click', function () {
				addButton($(this));
			});
		});

	})
	/*翻页设置*/
	function pages(total_page){
		var pageNum;
		if(total_page>4){
			pageNum = 4;
		}else{
			pageNum = 2;
		}
		laypage.render({
			elem : "page"
			,count : total_page*10/*总页数*/
			,first: 1/*首页*/
			,last: total_page/*尾页*/
			,prev: '<em><</em>'
			,next: '<em>></em>'
			,skip:true
			,groups:pageNum
			,jump : function(obj,first){
				if(!first){
					ajax_url_page(obj.curr);
				}
			}
		})
	}
	form.on('checkbox(allChoose)', function(data){
		var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
		child.each(function(index, item){
			item.checked = data.elem.checked;
		});
		form.render('checkbox');
	});
	form.on('checkbox(choose)',function(data){
		var sib = $(data.elem).parents('table').find('tbody input[type="checkbox"]:checked').length;
		var total = $(data.elem).parents('table').find('tbody input[type="checkbox"]').length;
		if(sib == total){
			$(data.elem).parents('table').find('thead input[type="checkbox"]').prop("checked",true);
			form.render();
		}else{
			$(data.elem).parents('table').find('thead input[type="checkbox"]').prop("checked",false);
			form.render();
		}
	});
	//通过判断文章是否全部选中来确定全选按钮是否选中
	form.on("checkbox(choose)",function(data){
		var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"])');
		var childChecked = $(data.elem).parents('table').find('tbody input[type="checkbox"]:not([name="show"]):checked')
		if(childChecked.length == child.length){
			$(data.elem).parents('table').find('thead input#allChoose').get(0).checked = true;
		}else{
			$(data.elem).parents('table').find('thead input#allChoose').get(0).checked = false;
		}
		form.render('checkbox');
	})

	function ajax_url_page(page){
		$.ajax({
			type: "GET",
			url: get_list,
			data: 'page='+page,
			success: function(msg){
				$(".news_content").html(msg);
				form.render();
			}
		});
	}

	//是否展示
	form.on('switch(isShow)', function(data){
		var index = layer.msg('修改中，请稍候',{icon: 16,time:false,shade:0.8});
		var id = data.value;
		var status = Change_status(id);
			setTimeout(function(){
				layer.close(index);
				layer.msg("展示状态修改成功！");
			},500);
	})
	/*改变数据状态*/
	function Change_status(obj){
		var web_class = '.onchage'+obj;
		var url = $(web_class).attr('data-url');
		var table =$(web_class).attr('data-tab');
		var field = $(web_class).attr('data-field');
		var status = $(web_class).attr('data-status');
		var id = obj;
		var data = {};
		data['table'] = table;data['field_name'] = field;data['id'] = id;
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			success: function(msg){
				msg =eval('(' + msg + ')');
				if(msg.status == true){
                   	return true;
				}
			}
		});
	}
	$(".head_button").click(function(){
		addButton($(this));
	})
	//添加页面
	function addButton($obj){
		var OpenType=$obj.attr("data-OpenType");
		var add_url=$obj.attr("data-url");
		var menu_name=$obj.attr("data-name");
		switch (OpenType){
			case 'Pop':
				var index = layui.layer.open({
					title : menu_name,
					type : 2,
					area: ['700px', '450px'],
					maxmin: true,
					fixed: false, //不固定
					content : add_url,
					success : function(layero, index){
						setTimeout(function(){
							layui.layer.tips('点击此处返回列表', '.layui-layer-setwin .layui-layer-close', {
								tips: 3
							});
						},500)
					}
				});
				break;
		}
		//改变窗口大小时，重置弹窗的高度，防止超出可视区域（如F12调出debug的操作）
		$(window).resize(function(){
			layui.layer.full(index);
		})
		layui.layer.full(index);
	}
})
