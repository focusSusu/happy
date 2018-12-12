
  <!-- ./wrapper -->
  <!-- 内容标题 -->
  <section class="content-header clearfix">
      <span class="con-header-tit">课程管理/添加课程</span>
  </section>
  <!-- Main content -->
  <section class="content pd-top0">
      <div class="box listPage">
          <!-- 渲染页面 -->
      </div>
  </section>


  <script type="text/javascript">
      var menu = '<?= $this->common->getMenuInfo(); ?>';

      var menuinfo = eval('('+ menu +')')?eval('('+ menu +')'):JSON.parse(menu);
      console.log(menuinfo);

      var pageMenu = { "active": menuinfo.active};
      console.log(pageMenu);

      var username = '<?= $this->common->getuserInfo();?>';
      console.log(username);

  </script>


  <script>
    // 添加清空按钮
    $('.data-time-rang').on('cancel.daterangepicker', function (ev, picker) {
      $(this).val('');
    });
  </script>

  <script src="<?= base_url() ?>style/js/vendors.js"></script>
  <script src="<?= base_url() ?>style/js/addCourse.js"></script>

