<?php /*a:2:{s:33:"./themes/admin/deposit\index.html";i:1600432057;s:24:"./themes/admin/base.html";i:1599447919;}*/ ?>
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
            <li class=""><a href="<?php echo url('admin/index/index'); ?>">返回</a></li>
            <li class="layui-this">入金记录 - [<?php echo htmlentities($bank['bank_name']); ?>] - <?php echo htmlentities($bank['bank_card']); ?></li>
        </ul>
        <div class="layui-tab-content">

            <div class="layui-tab-item layui-show">
                <table class="layui-table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>用户ID</th>
                        <th>金额</th>
                        <th>第三方单号</th>
                        <th>平台单号</th>
                        <th>提交时间</th>
                        <th>转账截图</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($dataList) || $dataList instanceof \think\Collection || $dataList instanceof \think\Paginator): if( count($dataList)==0 ) : echo "" ;else: foreach($dataList as $key=>$vo): ?>
                    <tr>
                        <td><?php echo htmlentities($key+1); ?></td>
                        <td><?php echo htmlentities($vo['uid']); ?></td>
                        <td><?php echo htmlentities($vo['amount']); ?></td>
                        <td><?php echo htmlentities($vo['sn']); ?></td>
                        <td><?php echo htmlentities($vo['platform_sn']); ?></td>
                        <td><?php echo htmlentities(date("Y-m-d H:i:s",!is_numeric($vo['create_time'])? strtotime($vo['create_time']) : $vo['create_time'])); ?></td>
                        <td><img src="<?php echo htmlentities($vo['pic']); ?>" style="cursor:pointer;" onclick="zoom('<?php echo htmlentities($vo['pic']); ?>')"></td>
                        <td>
                            <?php if($vo['status']==0): ?>
                                未审核
                            <?php elseif($vo['status']==1): ?>
                                已审核
                            <?php elseif($vo['status']==2): ?>
                                审核不通过
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($vo['status']==0): ?>
                            <a href="javascript:;" class="layui-btn" onclick="review(<?php echo htmlentities($vo['id']); ?>)">审核</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    /*
     * 入金审核
     */
    function review(id)
    {
        layer.open({
            type: 2,
            title: '入金审核',
            content: '/admin.php/deposit/review/id/'+id+'.html',
            area: ['500px', '350px'],
            shade: false,
            success: function(layero, index){
                console.log(layero, index);
            },
            end: function(){
                location.reload();
            }
        });
    }

    function zoom(img)
    {
        layer.open({
            type: 1,
            title: '转账截图',
            content: '<div style="padding: 20px 10px;"><img src="'+ img +'"></div>',
            shade: true,
            yes: function(){
              layer.closeAll();
            }
        });
    }

</script>

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