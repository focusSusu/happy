<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>伊利微课堂后台</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?= base_url() ?>style/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>style/dist/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>style/dist/css/ionicons.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>style/plugins/daterangepicker/daterangepicker.css">
    <!--日期选择css-->
    <link rel="stylesheet" href="<?= base_url() ?>style/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="<?= base_url() ?>style/dist/css/skins/_all-skins.min.css">
    <!-- 自定义样式 -->
    <link rel="stylesheet" href="<?= base_url() ?>style/css/admin.css">
    <link rel="stylesheet" href="<?= base_url() ?>style/layui/css/layui.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="<?= base_url() ?>style/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="<?=base_url()?>style/layer/layer.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>style/layui/css/layui.css">
    <script src="<?= base_url() ?>style/layui/layui.js"></script>
    <script src="<?= base_url() ?>style/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>style/plugins/fastclick/fastclick.js"></script>
    <script src="<?= base_url() ?>style/plugins/daterangepicker/moment.min.js"></script>
    <!--日期选择js-->
    <script src="<?= base_url() ?>style/plugins/daterangepicker/daterangepicker_ch.js"></script>
    <!--日期选择js-->
    <script src="<?= base_url() ?>style/dist/js/app.min.js"></script>
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- 头部信息 -->
    <header class="main-header"></header>
    <!--  左侧导航 -->
    <aside class="main-sidebar"></aside>
    <div class="content-wrapper">

        <?php include 'application/views/'.$view . ".php"; ?>


    </div>



    <script type="text/javascript">
        var menu = '<?= $this->common->getMenuInfo(); ?>';

        var menuinfo = eval('('+ menu +')')?eval('('+ menu +')'):JSON.parse(menu);

        var pageMenu = { "active": menuinfo.active};

        var username = '<?= $this->common->getuserInfo();?>';

        var base_url = "<?= base_url() ?>";

        console.log(base_url);


        //日期控件2默认值为空
        $('.data-time-rang').daterangepicker().val('');
        // 添加清空按钮
        $('.data-time-rang').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
        });
    </script>
    <script src="<?= base_url() ?>style/js/vendors.js" type="text/javascript"></script>

</body>
</html>