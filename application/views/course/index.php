
      <!-- 内容标题 -->
      <section class="content-header clearfix">
        <span class="con-header-tit">课程管理</span>
      </section>
      <!-- Main content -->
      <section class="content pd-top0">
        <div class="box listPage">
          <div class="box-body solist">
            <div class="box-form clearfix" id="search_banner">
              <form class="form-inline navbar-form navbar-left" >
                <div class="form-group">
                  <label class="control-label" for="creat_time">课程名称:</label>
                  <input type="text" class="form-control " name="name" id="" style="width: 200px;">
                </div>

                  <div class="form-group">
                  <label class="control-label" for="creat_time">创建时间:</label>
                  <input type="text" class="form-control data-time-rang " name="create_time" id="" style="width: 200px;">
                </div>
                  <div class="form-group">
                  <label class="control-label" for="creat_time">有效时间:</label>
                  <input type="text" class="form-control data-time-rang " name="valid_time" id="" style="width: 200px;">
                </div>


                <div class="form-group">
                  <label class="control-label" for="brang_id">课程属性:</label>
                  <select type="text"  name="type"class="form-control" id="type" >
                    <option value="0">全部</option>
                    <option value="1">图文</option>
                    <option value="2">音频</option>
                    <option value="3">视频</option>
                  </select>
                </div>

                  <input type="hidden" name="expert_id" value="<?=$expert_id ?>">

                <button type="button" class="btn btn-default search-btn" i-click="search">查询</button>
              </form>
                <div class="col-xs-2">
                    <div class="form-inline navbar-form navbar-left" >
                        <div class="form-group ">
                            <a href="<?=base_url()?>course/addView">
                                <button class="layui-btn">
                                    <i class="layui-icon">&#xe608;  添加课程</i>
                                </button>

<!--                                <button type="button" class="btn btn-primary" i-click="search">添加专家</button>-->
                            </a>
                        </div>
                    </div>
                </div>
            </div>

          </div>


              <div id="table-data">

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
              <div align="center">
                  <div id="demo8"></div>
                  <div id="demo9"></div>
                  <div id="demo10"></div>
              </div>



<script src="<?= base_url() ?>/style/admin-data.js"></script>

<script>
        $(document).ready(function(){
            // var index = layer.load(3);

            var uname = $("input[name='username']").val();
            var create_time = $("input[name='create_time']").val();
            var expert_id = $("input[name='expert_id']").val();

            var slist = {"username":uname,"create_time":create_time,"expert_id":expert_id};

            console.log(slist);
            //ajax请求后台数据
            var url = "<?= base_url()."course/ajaxindex/" ?>";
            studentInfo(slist,url);
            toPage(slist,url);
            // layer.close(index);

        });

 </script>



            <script>

                //搜索
                $(document).on("click",".search-btn",function () {

                    var name = $("input[name='name']").val();
                    var type = $("#type").val();
                    var create_time = $("input[name='create_time']").val();
                    var valid_time = $("input[name='valid_time']").val();
                    var expert_id = $("input[name='expert_id']").val();
                    var slist = {
                        "name":name,
                        "type":type,
                        "create_time":create_time,
                        "valid_time":valid_time,
                        "expert_id":expert_id
                    };

                    var url = "<?= base_url()."course/ajaxindex/" ?>";
                    studentInfo(slist,url);
                    toPage(slist,url);
                });

          $(document).on("click",".status-btn",function () {
              var status = $(this).attr('status');
              var id = $(this).attr('status_id');
              if (status=="" || id==""){
                  layer.msg('网络错误');
                  return false;
              }
              var url = "<?= base_url()."course/updateStatus/" ?>";
              $.post(url,{"id":id,"status":status},function (data) {

                  console.log(data);
                  if (data.code !=  0){
                      layer.msg(data.msg);
                      return false;
                  }

                  location.href="<?= base_url(). 'course/index'?>"

                  //layer.alert('success', {
                  //    icon: 1,
                  //    skin: 'layer-ext-moon'
                  //},function (index) {
                  //    location.href="<?//= base_url(). '/course/index'?>//"
                  //});
              },'json')
          })
      </script>