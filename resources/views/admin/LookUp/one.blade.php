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
    </script>

</head>
<body>
<input type="checkbox" name="love"/>C语言
<input type="checkbox" name="love"/>C++语言
<input type="checkbox" name="love"/>C#语言
<input type="checkbox" name="love"/>Object-C语言
<input type="checkbox" name="love"/>PHP语言
<input type="checkbox" name="love"/>JavaScript语言<br/>
<input type="button" id="boxId" value="全选" onclick="selectALLNO();"/>
<script type="text/javascript">
    function selectALLNO() {
        // 获取要操作的复选框
        var box1=document.getElementsByName("love");
        for (var x = 0; x < box1.length; x++) {
            var value1=box1[x];
            if (value1.checked == false){
               value1.checked=true;
            }else {
               value1.checked=false;
            }
        }
    }
</script>
</body>
</html>
