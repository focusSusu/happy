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
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <!-- 头部信息 -->
    <header class="main-header"></header>
    <!--  左侧导航 -->
    <aside class="main-sidebar"></aside>

    <!-- 内容区域 -->
    <div class="content-wrapper">

      <!-- 内容标题 -->
      <section class="content-header clearfix">
        <span class="con-header-tit">基础信息</span>
      </section>
      <!-- Main content -->
      <section class="content pd-top0">
          <form class="form-horizontal">
              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">用户名</label>
                  <div class="col-sm-8">
                      <input type="text" name="name" class="form-control" id="name" placeholder="">
                  </div>
              </div>
              <div class="form-group">
                  <label for="name" class="col-sm-3 control-label">密码</label>
                  <div class="col-sm-8">
                      <input type="text" name="name" class="form-control" id="name" placeholder="">
                  </div>
              </div>
              <button type="button" class="btn btn-confirm">登陆</button>
          </form>
      </section>
      <!-- /.content -->
    </div>
  </div>
  <!-- ./wrapper -->


  <script src="<?= base_url() ?>/style/plugins/jQuery/jquery-2.2.3.min.js"></script>
  <script src="<?= base_url() ?>/style/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?= base_url() ?>/style/plugins/fastclick/fastclick.js"></script>
  <script src="<?= base_url() ?>/style/plugins/daterangepicker/moment.min.js"></script>
  <!--日期选择js-->
  <script src="<?= base_url() ?>/style/plugins/daterangepicker/daterangepicker_ch.js"></script>
  <!--日期选择js-->
  <script src="<?= base_url() ?>/style/dist/js/app.min.js"></script>

  <script type="text/javascript">
    var pageMenu = { "active": [4,41] };
    //日期控件2默认值为空
    $('.data-time-rang').daterangepicker().val('');
    // 添加清空按钮
    $('.data-time-rang').on('cancel.daterangepicker', function (ev, picker) {
      $(this).val('');
    });
  </script>
  <script src="<?= base_url() ?>/style/js/vendors.js" type="text/javascript"></script>
  <!-- <script src="<?= base_url() ?>/style/js/examine.js" type="text/javascript"></script> -->
</body>
</html>