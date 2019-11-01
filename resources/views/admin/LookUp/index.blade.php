<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
>
<script type="text/javascript" src="/admin/lib/respond.min.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/html5shiv.js"></script>

	
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
<!--[if IE 6]>
<script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>用户管理</title>
	<script type="text/javascript">
        $(document).ready(function(){
            $("#hide").click(function(){
                $("p").hide();
            });
            $("#show").click(function(){
                $("p").show();
            });
        });
	</script>

</head>
<body>
<p>如果点击“隐藏”按钮，我就会消失。</p>
<button id="hide" type="button">隐藏</button>
<button id="show" type="button">显示</button>
    用户名：<input type="text" name="name" id="name">
	年  龄：<input type="text" name="age" id="age">
			<input type="button" name="btn" id="btn" value="点击">


	{{--<p>电话号码: <input type="text" name="fname" /></p>--}}
	{{--<input class="btn btn-primary radius" type="submit" value="用户中心"><br/><br/>--}}
	{{--<p>用户ID: <input type="text" name="lname" /></p>--}}
	{{--<input class="btn btn-danger radius" type="button" value="用户信息"><br/><br/>--}}
	{{--<p>订单号: <input type="text" name="lname" /></p>--}}
	{{--<input class="btn radius btn-secondary" type="button" value="balance"><br/><br/>--}}
	{{--<p>拍品ID: <input type="text" name="lname" /></p>--}}
	{{--<input class="btn btn-success radius" type="button" value="拍品信息"><br/><br/>--}}
	{{--<p>订单号: <input type="text" name="lname" /></p>--}}
	{{--<input class="btn radius btn-warning" type="button" value="警告">--}}

	<script type="text/javascript">
		$('#btn').click(function(){
			$.ajax({
				url:"/response/index",
				datatype:"json",
				success:function(msg){
					$('#name').val(msg.name);
					$('#age').val(msg.age);
				}
			});
		});
	</script>
</body>
</html>