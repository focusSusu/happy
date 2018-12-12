
<!-- 内容标题 -->
<section class="content-header clearfix">
    <span class="con-header-tit">分类管理</span>
</section>
<!-- Main content -->
<section class="content pd-top0">
    <div class="box listPage">
        <div class="box-body solist">
            <div class="box-form clearfix" id="search_banner">
                <div class="col-xs-10">
                    <div class="form-inline navbar-form navbar-left" >
<!--                        <form action="">-->
<!--                            <div class="form-group" id="CreateForm">-->
<!--                                <label class="control-label" for="brang_id">专家名称:</label>-->
<!--                                <input type="text" class="form-control" value="" name="username">-->
<!--                            </div>-->
<!---->
<!--                            <div class="form-group">-->
<!--                                <label class="control-label" for="brang_id">创建时间:</label>-->
<!--                                <input type="text" class="form-control" value="" name="create_time" >-->
<!--                            </div>-->
<!--                            <button type="button" class="btn btn-default search-btn" i-click="search">筛选</button>-->
<!--                        </form>-->

                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="form-inline navbar-form navbar-left" >
                        <div class="form-group ">
                            <a href="<?=base_url()?>category/addView">
<!--                                <button type="button" class="btn btn-primary" i-click="search">添加分类</button>-->
                                <button class="layui-btn">
                                    <i class="layui-icon">&#xe608;  添加分类</i>
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
<!--            <div align="center">-->
<!--                <div id="demo8"></div>-->
<!--                <div id="demo9"></div>-->
<!--                <div id="demo10"></div>-->
<!--            </div>-->


            <script src="<?= base_url() ?>/style/admin-data.js"></script>
            <script>
                $(document).ready(function(){

                    var username = $("input[name='username']").val();
                    var create_time = $("input[name='create_time']").val();
                    var slist = {"username":username,"create_time":create_time};

                    console.log(slist);
                    //ajax请求后台数据
                    var url = "<?= base_url()."/category/ajaxindex/" ?>";
                    studentInfo(slist,url);
                    toPage(slist,url);
                });



            </script>


<script>
    $(document).on("click",".show-btn",function () {
        var id = $(this).attr("btn-id");
        var status = $(this).attr("btn-status");
        var type = $(this).attr("btn-type");
        if (status=="" || id==""){
            layer.msg('网络错误');
            return false;
        }
        var allType = ['status','is_home'];
       // console.log($.inArray(type, allType) +1);
        if (!($.inArray(type,allType) +1)){
            layer.msg('网络错误');
            return false;
        }

        var url = "<?= base_url()."/category/updateStatus/" ?>";
        $.post(url,{"id":id,"status":status,"type":type},function (data) {

            console.log(data);
            if (data.code !=  0){
                layer.msg(data.msg);
                return false;
            }
            location.href="<?= base_url(). '/category/index'?>"

        },'json')
    })

    //排序

    $(document).on("blur",".update_sort",function () {
        var oldSort = $(this).val()
        var id = $(this).attr('data-id');
        if (id==""){
            layer.msg('网络错误');
            return false;
        }
        var sort = $(this).val();
        if (sort==""){
            return false;
        }

        // if (oldSort == sort){
        //     return false;
        // }

        var url = "<?= base_url()."category/updateSort/" ?>";
        $.post(url,{"id":id,"sort":sort},function (data) {

            console.log(data);
            if (data.code !=  0){
                layer.msg(data.msg);
                return false;
            }

            location.href="<?= base_url(). 'category/index'?>"

            //layer.alert('success', {
            //    icon: 1,
            //    skin: 'layer-ext-moon'
            //},function (index) {
            //    location.href="<?//= base_url(). '/category/getCategoryList'?>//"
            //});
        },'json')


    })


    //添加分类
    $(document).on("click",".add-category",function () {
        // var category_type = $("input[name='category_type']:checked").val();
        var  category_name = $("input[name='category_name']").val();
        var category_id = $("#category_id").val();
        var url = "<?= base_url()."category/addCategory/" ?>";
        $.post(url,{"category_type":category_type,"name":category_name,'parent_id':category_id},function (data) {

            console.log(data);
            if (data.code !=  0){
                layer.msg(data.msg);
                return false;
            }

            location.href="<?= base_url(). 'category/index'?>"

            //layer.alert('success', {
            //    icon: 1,
            //    skin: 'layer-ext-moon'
            //},function (index) {
            //    location.href="<?//= base_url(). '/category/getCategoryList'?>//"
            //});
        },'json')

    })

</script>










