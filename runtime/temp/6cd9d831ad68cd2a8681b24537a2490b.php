<?php /*a:2:{s:30:"./themes/admin/menu\index.html";i:1587007519;s:24:"./themes/admin/base.html";i:1599066344;}*/ ?>
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
                    <a href="<?php echo url('admin/index/index'); ?>"><i class="fa fa-home"></i> 网站信息</a>
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
            <li class="layui-this">后台菜单</li>
            <li class=""><a href="<?php echo url('admin/menu/add'); ?>">添加菜单</a></li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th style="width: 30px;">ID</th>
                        <th style="width: 30px;">排序</th>
                        <th>菜单名称</th>
                        <th>控制器方法</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($admin_menu_level_list) || $admin_menu_level_list instanceof \think\Collection || $admin_menu_level_list instanceof \think\Paginator): if( count($admin_menu_level_list)==0 ) : echo "" ;else: foreach($admin_menu_level_list as $key=>$vo): ?>
                    <tr>
                        <td><?php echo htmlentities($vo['id']); ?></td>
                        <td><?php echo htmlentities($vo['sort']); ?></td>
                        <td><?php if($vo['level'] != '1'): ?>|<?php for($i=1;$i<$vo['level'];$i++){echo ' ----';} endif; ?> <?php echo htmlentities($vo['title']); ?></td>
                        <td><?php echo htmlentities($vo['name']); ?></td>
                        <td><?php echo $vo['status']==1 ? '显示' : '隐藏'; ?></td>
                        <td>
                            <a href="<?php echo url('admin/menu/add',['pid'=>$vo['id']]); ?>" class="layui-btn layui-btn-mini">添加子菜单</a>
                            <a href="<?php echo url('admin/menu/edit',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-normal layui-btn-mini">编辑</a>
                            <a href="<?php echo url('admin/menu/delete',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-danger layui-btn-mini ajax-delete">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
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