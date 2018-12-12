
<!-- 内容标题 -->
<section class="content-header clearfix">
    <span class="con-header-tit">资讯管理</span>
</section>
<!-- Main content -->
<section class="content pd-top0">
    <div class="box listPage">
        <div class="box-body solist">
            <div class="box-form clearfix" id="search_banner">
                <div class="col-xs-10">
                    <div class="form-inline navbar-form navbar-left" >
                        <form action="">
                            <div class="form-group" id="CreateForm">
                                <label class="control-label" for="brang_id">咨询名称:</label>
                                <input type="text" class="form-control" value="" name="username">
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="brang_id">创建时间:</label>
                                <input type="text" class="form-control data-time-rang " name="create_time" id="" style="width: 200px;">
                            </div>
                            <button type="button" class="btn btn-default search-btn" i-click="search">筛选</button>
                        </form>

                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="form-inline navbar-form navbar-left" >
                        <div class="form-group ">
                            <a href="<?=base_url()?>article/addView">
<!--                                <button type="button" class="btn btn-primary" i-click="search">添加专家</button>-->
                                <button class="layui-btn">
                                    <i class="layui-icon">&#xe608;  添加资讯</i>
                                </button>
                            </a>
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

        </div>

    </div>
</section>


<script src="<?= base_url() ?>/style/admin-data.js"></script>
<script>
    $(document).ready(function(){

        var username = $("input[name='username']").val();
        var create_time = $("input[name='create_time']").val();
        var slist = {"username":username,"create_time":create_time};

        console.log(slist);
        //ajax请求后台数据
        var url = "<?= base_url()."article/ajaxindex/" ?>";
        studentInfo(slist,url);
        toPage(slist,url);
    });



</script>

<script>

    //搜索
    $(document).on("click",".search-btn",function () {
        var username = $("input[name='username']").val();
        var create_time = $("input[name='create_time']").val();
        var slist = {"username":username,"create_time":create_time};

        var url = "<?= base_url()."/article/ajaxindex/" ?>";
        studentInfo(slist,url);
        toPage(slist,url);

    });


        $(document).on("click",".status",function () {
        var status = $(this).attr('status');
        var id = $(this).attr('course_id');
        if (status=="" || id==""){
            layer.msg('网络错误');
            return false;
        }
        var url = "<?= base_url()."user/updateStatus/" ?>";
        $.post(url,{"id":id,"status":status},function (data) {

            console.log(data);
            if (data.code !=  0){
                layer.msg(data.msg);
                return false;
            }
            layer.alert('success', {
                icon: 1,
                skin: 'layer-ext-moon'
            },function (index) {
                location.href="<?= base_url(). 'user/getUserList'?>"
            });
        },'json')
    })
</script>