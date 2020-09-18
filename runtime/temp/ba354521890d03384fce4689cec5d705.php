<?php /*a:1:{s:31:"./themes/admin/login\index.html";i:1572165529;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>管理后台</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="/public/static/common/js/layui/css/layui.css">
    <link rel="stylesheet" href="/public/static/common/css/admin.css">
</head>
<body class="login">
<div class="login-title">管理后台</div>
<form class="layui-form login-form" action="<?php echo url('admin/login/login'); ?>" method="post">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
            <input type="text" name="username" required lay-verify="required" autocomplete="off" placeholder="请输入用户名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block">
            <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">验证码</label>
        <div class="layui-input-block">
            <input type="text" name="verify" required lay-verify="required" placeholder="请输入验证码" class="layui-input layui-input-inline">
            <img src="<?php echo captcha_src(); ?>" alt="点击更换" title="点击更换" onclick="this.src='<?php echo captcha_src(); ?>?time='+Math.random()" class="captcha">
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="*">登 录</button>
        </div>
    </div>
</form>
<style type="text/css">
@media screen and (max-width: 450px) {
    .layui-form-label {
        display: none;
    }
    .layui-form-item .layui-input-inline {
        display: inline-block;
        left: 0px;
        width: 48%;
        margin: 0 0 0 0; 
    }
    .login .login-form .captcha {
        width: 50%;
    }
}    
</style>
<script>
    // 定义全局JS变量
    var GV = {
        current_controller: "admin/<?php echo htmlentities((isset($controller) && ($controller !== '')?$controller:'')); ?>/"
    };
</script>
<!--<script src="/public/static/common/js/jquery.min.js"></script>-->
<script src="/public/static/common/js/layui/layui.all.js"></script>
<script src="/public/static/common/js/admin.js"></script>
</body>
</html>