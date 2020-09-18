<?php /*a:2:{s:29:"./themes/admin/menu\edit.html";i:1587007519;s:24:"./themes/admin/base.html";i:1599066344;}*/ ?>
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
            <li class=""><a href="<?php echo url('admin/menu/index'); ?>">后台菜单</a></li>
            <li class=""><a href="<?php echo url('admin/menu/add'); ?>">添加菜单</a></li>
            <li class="layui-this">编辑菜单</li>
        </ul>
        <div class="layui-tab-content">
            <div class="layui-tab-item layui-show">
                <form class="layui-form form-container" action="<?php echo url('admin/menu/update'); ?>" method="post">
                    <div class="layui-form-item">
                        <label class="layui-form-label">上级菜单</label>
                        <div class="layui-input-block">
                            <select name="pid" lay-verify="required">
                                <option value="0">一级菜单</option>
                                <?php if(is_array($admin_menu_level_list) || $admin_menu_level_list instanceof \think\Collection || $admin_menu_level_list instanceof \think\Paginator): if( count($admin_menu_level_list)==0 ) : echo "" ;else: foreach($admin_menu_level_list as $key=>$vo): ?>
                                <option value="<?php echo htmlentities($vo['id']); ?>" <?php if($admin_menu['id']==$vo['id']): ?> disabled="disabled"<?php endif; if($admin_menu['pid']==$vo['id']): ?> selected="selected"<?php endif; ?>><?php if($vo['level'] != '1'): ?>|<?php for($i=1;$i<$vo['level'];$i++){echo ' ----';} endif; ?> <?php echo htmlentities($vo['title']); ?></option>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">菜单名称</label>
                        <div class="layui-input-block">
                            <input type="text" name="title" value="<?php echo htmlentities($admin_menu['title']); ?>" required  lay-verify="required" placeholder="请输入菜单名称" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">控制器方法</label>
                        <div class="layui-input-block">
                            <input type="text" name="name" value="<?php echo htmlentities($admin_menu['name']); ?>" required  lay-verify="required" placeholder="请输入控制器方法 如：admin/Index/index" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">控制器参数</label>
                        <div class="layui-input-block">
                            <input type="text" name="param" value="<?php echo htmlentities($admin_menu['param']); ?>" placeholder="请输入参数方法 如：id=5&name=startbbs" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">图标</label>
                        <div class="layui-input-block">
                            <input type="text" name="icon" value="<?php echo htmlentities($admin_menu['icon']); ?>" placeholder="（选填）如：fa fa-home" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">状态</label>
                        <div class="layui-input-block">
                            <input type="radio" name="status" value="1" title="显示" <?php if($admin_menu['status']==1): ?> checked="checked"<?php endif; ?>>
                            <input type="radio" name="status" value="0" title="隐藏" <?php if($admin_menu['status']==0): ?> checked="checked"<?php endif; ?>>
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <label class="layui-form-label">排序</label>
                        <div class="layui-input-block">
                            <input type="text" name="sort" value="<?php echo htmlentities($admin_menu['sort']); ?>" required  lay-verify="required" class="layui-input">
                        </div>
                    </div>
                    <div class="layui-form-item">
                        <div class="layui-input-block">
                            <input type="hidden" name="id" value="<?php echo htmlentities($admin_menu['id']); ?>">
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