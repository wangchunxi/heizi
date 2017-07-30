<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:60:"/home/wwwroot/heizi/public/../app/admin/view/widget/404.html";i:1500154837;}*/ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>404--layui后台管理模板</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" href="<?php echo __ADMIN_LAYER__; ?>/layui/css/layui.css" media="all" />
</head>
<body class="childrenBody">
	<div style="text-align: center; padding:11% 0;">
		<i class="layui-icon" style="line-height:20rem; font-size:20rem; color: #393D50;">
			<img src="<?php echo $data['img']; ?>"></img>
		</i>
		<p style="font-size: 20px; font-weight: 300; color: #999;"><?php echo $data['tips']; ?></p>
	</div>
</body>
</html>