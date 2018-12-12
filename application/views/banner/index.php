
<!-- 内容标题 -->
<section class="content-header clearfix">
    <span class="con-header-tit">活动管理</span>
</section>
<!-- Main content -->
<section class="content pd-top0">
    <div class="box listPage">
        <div class="box-body solist">
            <div class="box-form clearfix" id="search_banner">
                <div class="col-xs-10">
                    <div class="form-inline navbar-form navbar-left" >
                        <div class="form-group">
                            <label class="control-label" for="brang_id">活动名称:</label>
                            <input type="text" class="form-control" value="" name="name">
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="brang_id">活动状态:</label>
                            <select name="banner_status" id="banner_status" class="form-control">
                                <option value="0">全部</option>
                                <option value="1">未开始</option>
                                <option value="2">轮播中</option>
                                <option value="3">已结束</option>
                            </select>
                        </div>



                        <div class="form-group">
                            <label class="control-label" for="brang_id">所属模块:</label>
                            <select name="status_vals" id="status_vals" class="form-control">
                                <option value="">全部</option>
                                <?php foreach ($picklist as $k=>$v): ?>
                                <option value="<?=$v['keys'] ?>"><?=$v['vals'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="brang_id">生效时间:</label>
                            <input type="text" class="form-control data-time-rang " name="valid_time" id="" style="width: 200px;">


                        </div>
                        <button type="button" class="btn btn-default search-btn" i-click="search">筛选</button>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="form-inline navbar-form navbar-left" >
                        <div class="form-group ">
                            <a href="<?=base_url()?>banner/addView">
<!--                                <button type="button" class="btn btn-primary" i-click="search">添加Banner</button>-->
                            <button class="layui-btn">
                                <i class="layui-icon">&#xe608;  添加Banner</i>
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

        var name = $("input[name='name']").val();
        var banner_status = $("#banner_status").val();
        var status_vals = $("#status_vals").val();
        var valid_start_time = $("input[name='valid_start_time']").val();
        var valid_end_time = $("input[name='valid_end_time']").val();
        var slist = {
            "name":name,
            "banner_status":banner_status,
            "status_vals":status_vals,
            "valid_start_time":valid_start_time,
            "valid_end_time":valid_end_time
        };

        console.log(slist);
        //ajax请求后台数据
        var url = "<?= base_url()."/banner/ajaxindex/" ?>";

        studentInfo(slist,url);
        toPage(slist,url);
    });



</script>
<script>
    //搜索
    $(document).on("click",".search-btn",function () {
        var name = $("input[name='name']").val();
        var banner_status = $("#banner_status").val();
        var status_vals = $("#status_vals").val();
        var valid_time = $("input[name='valid_time']").val();
        // var valid_end_time = $("input[name='valid_end_time']").val();
        var slist = {
            "name":name,
            "banner_status":banner_status,
            "status_vals":status_vals,
            "valid_time":valid_time
        };

        var url = "<?= base_url()."banner/ajaxindex/" ?>";
        studentInfo(slist,url);
        toPage(slist,url);

    });

    $(document).on("click",".btn-del",function () {
        var id = $(this).attr('banner_id');
        if (id==""){
            layer.msg('网络错误');
            return false;
        }

        //询问框

        layer.confirm('确定删除？', {
            btn: ['是','否'] //按钮
        }, function(){

            var url = "<?= base_url()."banner/delBanner/" ?>";
            $.post(url,{"id":id,"status":status},function (data) {
                console.log(data);
                if (data.code !=  0){
                    layer.msg(data.msg);
                    return false;
                }
                location.href="<?= base_url(). 'banner/index'?>"

            },'json')
        }, function(){

        });


    });


    $(document).on("click",".btn-status",function () {
        var id = $(this).attr('banner_id');
        var status = $(this).attr('btn-status');
        if (id==""){
            layer.msg('网络错误');
            return false;
        }
        var url = "<?= base_url()."banner/updateBannerStatus/" ?>";
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
                location.href="<?= base_url(). 'banner/index'?>"
            });
        },'json')
    })
</script>