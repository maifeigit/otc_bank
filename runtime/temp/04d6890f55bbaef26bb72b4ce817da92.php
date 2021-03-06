<?php /*a:1:{s:33:"./themes/default/index\index.html";i:1599448946;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
  <link rel="icon" type="image/png" href="/public/static/default/images/favicon.png">
  <title>Quantumex</title>
  <link rel="stylesheet" href="/public/static/default/js/layui/css/layui.css" />
  <link rel="stylesheet" href="/public/static/default/css/reset.css" />
  <link rel="stylesheet" href="/public/static/default/css/main.css?ve=3.9" />
</head>

<body>
  <div id="rechargeWait" class="container">
    <header>
      <img src="/public/static/default/images/logo.png" style="height:60px;">
    </header>
    <div class="main-wrapper">
      <p class="fz_weight"><span class="fz20">USDT入金登记</span></p>
      <p class="fz_weight fz16">订单总额：</span><span class="fc60"><?php echo htmlentities($amount); ?></span> USDT</p>      

      <form class="layui-form" action="/index/certificate" method="post">
        <div autocomplete="off" class="form-container-inner">
          <div class="input-inner-container">
            <label class="label-txt">真实姓名</label>
            <div class="input-control-inner">
              <input type="text" value="" name="username" lay-verify="required" placeholder="请输入姓名" class="ivu-input">
            </div>
          </div>

          <div class="input-inner-container">
            <label class="label-txt">交易账号</label>
            <div class="input-control-inner">
              <input type="text" value="" name="account" lay-verify="required" placeholder="请输入交易账号" class="ivu-input">
            </div>
          </div>

          <div class="input-inner-container">
            <label class="label-txt">钱包地址</label>
            <div class="input-control-inner">
              <input type="text" value="" name="address" lay-verify="required" placeholder="请输入转出钱包地址" class="ivu-input">
            </div>
          </div>

          <input type="hidden" name="order" value="<?php echo htmlentities($order); ?>">
          <input type="hidden" name="amount" value="<?php echo htmlentities($amount); ?>">
          <input type="hidden" name="wallet" value="<?php echo htmlentities($address); ?>">

          <div class="otc-btn-sytle fill">
            <button type="button" class="layui-btn" id="test1">+上传转账凭证</button>
            <div class="layui-upload-list">
              <img class="layui-upload-img" id="demo1" style="width:280px;">
            </div>
            <input type="hidden" name="image" value="" id="image">
          </div>

          <div class="otc-btn-sytle fill">
            <button class="btn font12 cursor bigger default" lay-submit lay-filter="ajax">提 交</button>
          </div>

        </div>
      </form>

    </div>
  </div>

  <style type="text/css">

    .main-wrapper {
       margin-top: 20px; 
    }
    .fz_weight {
      text-align: center;
    }
    .addr{
      margin: 0 auto;
    }
    .addressQR {
      margin: 0 auto;
      margin-left: 90px;
    }
    .address{
      text-align: center;
      font-weight: 600;
      line-height: 50px;
      font-size: 16px;
      color: #353332;
    }
    header {
      background: #231a1a;
    }

    .layui-btn {
      background: linear-gradient(90deg,#5fb878,#05b471) #15b979;
      margin-top: 20px;
    }

    @media screen and (max-width: 1000px){
      .main-wrapper {
        margin-top: 10px;
      }
      header {
        background: #231a1a;
      }
      header img {
        width: 210px;
      }
      .addressQR {
        margin-left: 10px;
      }
      .address{
        width: 250px;
        margin-top: 20px;
        margin-left: 10px;
        line-height: 20px;
        word-wrap:break-word; 
        word-break:break-all; 
        overflow: hidden;
      }
    }
  </style>

<script src="/public/static/default/js/jquery.min.js"></script>
<script src="/public/static/default/js/layui/layui.all.js"></script>
<script type="text/javascript">
  $(function(){
    var $ = layui.jquery,
    layer = layui.layer,
    form = layui.form;
    upload = layui.upload;

    form.on('submit(ajax)', function (data) {
      $.ajax({
          url: data.form.action,
          type: data.form.method,
          data: $(data.form).serialize(),
          success: function (info) {
              console.log(info)
              if (info.code == 0) {
                  layer.msg(info.msg);
              }
              layer.msg(info.msg);
          }
      },'json');
      return false;
    });
  })




</script>


<script>
layui.use('upload', function(){
  var $ = layui.jquery
  ,upload = layui.upload;

  var order = $("#order").val();
  
  //普通图片上传
  var uploadInst = upload.render({
    elem: '#test1'
    ,url: '/api.php/upload/index?order='+order //改成您自己的上传接口
    ,before: function(obj){
      //预读本地文件示例，不支持ie8
      obj.preview(function(index, file, result){
        $('#demo1').attr('src', result); //图片链接（base64）
      });
    }
    ,done: function(res){
      //如果上传失败
      if(res.code > 0){
        return layer.msg('上传失败');
      }
      //上传成功
      console.log(res)
      if(res.error==0){
        $("#image").val(res.url);
      }
    }
    ,error: function(){
      //演示失败状态，并实现重传
    }
  });
});
</script>


</body>
</html>