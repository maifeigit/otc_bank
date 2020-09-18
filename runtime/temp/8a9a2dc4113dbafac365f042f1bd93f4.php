<?php /*a:2:{s:30:"./themes/admin/index\edit.html";i:1600400091;s:24:"./themes/admin/base.html";i:1599447919;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>管理后台</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <link rel="stylesheet" href="/public/static/common/js/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/public/static/common/css/font-awesome.min.css">
    <!--CSS引用-->
    
    <link rel="stylesheet" href="/public/static/common/css/admin.css">
</head>
<body>
<div class="layui-layout layui-layout-admin">
    <!--头部-->
    <div class="layui-header header">
        <a href=""><img class="logo" src="/public/static/common/images/admin_logo.png" alt=""></a>
        <ul class="layui-nav" style="position: absolute;top: 0;right: 20px;background: none;">
            <li class="layui-nav-item"><a href="javascript:void(0)" data-url="<?php echo url('admin/system/clear'); ?>" id="clear-cache">清除缓存</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;"><?php echo session('user_name'); ?></a>
                <dl class="layui-nav-child">
                    <dd><a href="<?php echo url('admin/change_password/index'); ?>">修改密码</a></dd>
                    <dd><a href="<?php echo url('admin/login/logout'); ?>">退出登录</a></dd>
                </dl>
            </li>
        </ul>
    </div>

    <!--侧边栏-->
    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <ul class="layui-nav layui-nav-tree">
                <li class="layui-nav-item">
                    <a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-home"></i> 网站首页</a>
                </li>
                <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): if( count($menu)==0 ) : echo "" ;else: foreach($menu as $key=>$vo): if(isset($vo['children'])): ?>
                <li class="layui-nav-item">
                    <a href="javascript:;"><i class="<?php echo htmlentities($vo['icon']); ?>"></i> <?php echo htmlentities($vo['title']); ?></a>
                    <dl class="layui-nav-child">
                        <?php if(is_array($vo['children']) || $vo['children'] instanceof \think\Collection || $vo['children'] instanceof \think\Paginator): if( count($vo['children'])==0 ) : echo "" ;else: foreach($vo['children'] as $key=>$v): ?>
                        <dd><a href="<?php echo url($v['name'],$v['param']); ?>"> <?php echo htmlentities($v['title']); ?></a></dd>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </dl>
                </li>
                <?php else: ?>
                <li class="layui-nav-item">
                    <a href="<?php echo url($vo['name']); ?>"><i class="<?php echo htmlentities($vo['icon']); ?>"></i> <?php echo htmlentities($vo['title']); ?></a>
                </li>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                <li class="layui-nav-item" style="height: 30px; text-align: center"></li>
            </ul>
        </div>
    </div>

    <!--主体-->
    
<div class="layui-body">
    <!--tab标签-->
    <div class="layui-tab layui-tab-brief">
        <ul class="layui-tab-title">
            <li class=""><a href="<?php echo url('admin/index/index'); ?>">银行卡列表</a></li>
            <li class="layui-this">编辑银行卡</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form form-container" action="<?php echo url('admin/index/update'); ?>" method="post">
                    <div class="layui-form-item">
                        <label class="layui-form-label">银行</label>
                        <div class="layui-input-block">
                            <input type="text" name="bank_name" value="<?php echo htmlentities($bank['bank_name']); ?>" lay-verify="required" placeholder="请输入银行名称" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">卡号</label>
                        <div class="layui-input-block">
                            <input type="text" name="bank_card" value="<?php echo htmlentities($bank['bank_card']); ?>" lay-verify="required" placeholder="请输入银行卡号" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">姓名</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="<?php echo htmlentities($bank['name']); ?>" lay-verify="required" placeholder="请输入持卡人姓名" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">额度</label>
                        <div class="layui-input-block">
                            <input type="text" name="quota" value="<?php echo htmlentities($bank['quota']); ?>" placeholder="请输入卡累计交易额度" class="layui-input">
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-block">
                            <input type="radio" name="status" value="1" title="启用" <?php if($bank['status']==1): ?>checked="checked"<?php endif; ?>>
                            <input type="radio" name="status" value="0" title="停用" <?php if($bank['status']==0): ?>checked="checked"<?php endif; ?>>
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="id" value="<?php echo htmlentities($bank['id']); ?>">
                            <button class="layui-btn" lay-submit lay-filter="*">更新</button>
                            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    // 定义全局JS变量
    var GV = {
        current_controller: "admin/<?php echo htmlentities((isset($controller) && ($controller !== '')?$controller:'')); ?>/",
        base_url: "/public/static"
    };
</script>
<!--JS引用-->
<script src="/public/static/common/js/jquery.min.js"></script>
<script src="/public/static/common/js/layui/layui.all.js"></script>
<script src="/public/static/common/js/global.js"></script>
<script src="/public/static/common/js/admin.js"></script>

<!--页面JS脚本-->

</body>
</html>