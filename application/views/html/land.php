<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>伊利微课堂后台</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url() ?>/style/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/style/dist/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/style/dist/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/style/plugins/daterangepicker/daterangepicker.css">
  <!--日期选择css-->
  <link rel="stylesheet" href="<?= base_url() ?>/style/dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="<?= base_url() ?>/style/dist/css/skins/_all-skins.min.css">
  <!-- 自定义样式 -->
  <link rel="stylesheet" href="<?= base_url() ?>/style/css/admin.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
      <div class="home_page_bg">
          <div class="login">
             <div class="login_tit">伊利微课堂后台管理系统</div>
             <div class="login_content">
                 <form class="form-horizontal">
                     <div class="form-group">
                         <label for="name" class="col-sm-3 control-label">用户名</label>
                         <div class="col-sm-8">
                             <input type="text" name="name" class="form-control" id="name" placeholder="">
                         </div>
                     </div>
                     <div class="form-group">
                         <label for="password" class="col-sm-3 control-label">密码</label>
                         <div class="col-sm-8">
                             <input type="password" name="name" class="form-control" id="password" placeholder="">
                         </div>
                     </div>
                     <button type="button" class="btn btn-confirm">登陆</button>
                 </form>
             </div>
          </div>
        </div>
  </div>
  <!-- ./wrapper -->


  <script src="<?= base_url() ?>/style/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?= base_url() ?>/style/bootstrap/js/bootstrap.min.js"></script>
  <!--日期选择js-->
  <script src="<?= base_url() ?>/style/dist/js/app.min.js"></script>

  <script type="text/javascript">
    var pageMenu = { "active": [1] };
  </script>
  <script src="<?= base_url() ?>/style/js/vendors.js" type="text/javascript"></script>
</body>
</html>