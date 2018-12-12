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
        <span class="con-header-tit">图片审核</span>
      </section>
      <!-- Main content -->
      <section class="content pd-top0">
        <div class="box listPage">
          <div class="box-body solist">
            <div class="box-form clearfix" id="search_banner">
              <form class="form-inline navbar-form navbar-left" >
                <div class="form-group">
                  <label class="control-label" for="creat_time">创建时间:</label>
                  <input type="text" class="form-control data-time-rang " id="creat_time" style="width: 200px;">
                </div>
                <div class="form-group">
                  <label class="control-label" for="brang_id">品牌:</label>
                  <select type="text" class="form-control" id="brang_id" >
                    <option value="">99</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="control-label" for="creat_time">活动名称:</label>
                  <input disabled type="text" class="form-control" value="绫致图片审核" style="width: 200px;">
                </div>
                <button type="button" class="btn btn-default" i-click="search">查询</button>
              </form>
            </div>
            <div style="text-align:right; padding: 20px 0;">
              <button i-click="audit" style="width:135px; height:28px; border:0; outline:0; background-color:#354151; color:#fff;">查看未审核50条</button>
            </div>
            <table class="table table-bordered  _table-condensed text-center">
              <thead>
                <tr>
                  <th>序号</th>
                  <th>品牌</th>
                  <th>活动名称</th>
                  <th>图片</th>
                  <th>创建时间</th>
                  <th>状态</th>
                  <th>操作</th>
                </tr>
              </thead>
              <tbody id="tableBody">
                <td colspan="10">
                  正在请求数据...
                </td>
              </tbody>
            </table>
          </div>

          <div class="pagination" style="text-align:center">
            <button class="btn" style="background-color: black;color: white;" type="button">上一页</button>
            <span>页数：</span>
            <span>1</span>
            <span>/</span>
            <span>1</span>
            <button class="btn" style="background-color: black;color: white;" type="button">下一页</button>
            <input type="text" style="width:50px;">
            <button type="button" class="btn" style="background-color: black;color: white;" type="button">跳转</button>
          </div>
        </div>
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
    var pageMenu = { "active": [5,52] };
    //日期控件2默认值为空
    $('.data-time-rang').daterangepicker().val('');
    // 添加清空按钮
    $('.data-time-rang').on('cancel.daterangepicker', function (ev, picker) {
      $(this).val('');
    });
  </script>
  <script src="<?= base_url() ?>/style/js/vendors.js" type="text/javascript"></script>
  <script src="<?= base_url() ?>/style/js/examine.js" type="text/javascript"></script>
</body>
</html>