
<!-- 内容标题 -->
<section class="content-header clearfix">
    <span class="con-header-tit">添加活动</span>
</section>

<section class="content pd-top0">
    <div class="box listPage">
<form class="form-horizontal" id="CreateForm">
<div class="form-group">
        <label for="name" class="col-sm-3 control-label">banner名称</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control" value="" id="name" placeholder="">
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">所属模块：

        </label>
        <div class="col-sm-8">


            <div class="layui-input-inline">
                <select name="type" lay-verify="required" lay-search="" class="form-control">
                    <option value="">直接选择或搜索选择</option>
                    <?php foreach ($list as $k=>$v): ?>
                    <option value="<?=$v['keys'] ?>"><?=$v['vals'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">封面图片：

        </label>
        <div class="col-sm-8">
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="test1">上传图片</button>
                <div class="layui-upload-list">
                    <img class="layui-upload-img" id="demo1" width="100px">
                    <p id="demoText"></p>
                </div>
            </div>
            <input type="hidden" name="img_url" class="form-control" id="" placeholder="">
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">生效时间：</label>
        <div class="col-sm-8">
            <input type="text" class="layui-input" name="valid_time" id="test10" placeholder=" - ">
        </div>
    </div>

<!--    <div class="form-group">-->
<!--        <label for="name" class="col-sm-3 control-label">下架时间：-->
<!---->
<!--            ：</label>-->
<!--        <div class="col-sm-8">-->
<!--            <input type="text" name="date" id="date2    " lay-verify="date" placeholder="yyyy-MM-dd" autocomplete="off" class="layui-input">-->
<!--        </div>-->
<!--    </div>-->

    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">添加跳转：</label>
        <div class="col-sm-8">
            <input type="radio" name="link_type" value="2" title="小程序地址" checked="" class="to-url" onchange="">小程序地址
            <input type="radio" name="link_type" value="1" title="H5地址" class="to-url">H5地址
            <input type="radio" name="link_type" value="0" title="不跳转" class="to-url">不跳转

        </div>
    </div>

    <div class="weapp">
        <div class="weapp">
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">app_id：</label>
                <div class="col-sm-8">
                    <input type="text" name="app_id" class="form-control" id="name" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">小程序连接：</label>
                <div class="col-sm-8">
                    <input type="text" name="app_url" class="form-control" id="name" placeholder="">
                </div>
            </div>
        </div>
    </div>


    <div class="form-group link-url"  style="display: none">
        <label for="name" class="col-sm-3 control-label">请填写跳转链接：</label>
        <div class="col-sm-8">
            <input type="text" name="link_url" class="form-control" id="name" placeholder="">
        </div>
    </div>

    <div class="layui-form-item" align="center">
        <div class="layui-input-block">
<!--            <button class="layui-btn" lay-submit="" lay-filter="demo1" id="sub"></button>-->
            <input type="button" class="layui-btn" id="sub" value="立即提交">
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
    </div>
</section>
<script>
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate;

        //日期
        laydate.render({
            elem: '#date'
        });        //日期
        laydate.render({
            elem: '#date2'
        });
        laydate.render({
            elem: '#test10'
            ,type: 'datetime'
            ,range: true
        });


    });
</script>

<script>
    $(document).ready(function() {
        $('input[type=radio][name=link_type]').change(function() {
            if (this.value == 0){
                $(".link-url").hide();
                $(".weapp").hide();
            }
            if (this.value == 2) {
                $(".link-url").hide();
                $(".weapp").show();
            }
            if (this.value == 1){
                $(".link-url").show();
                $(".weapp").hide();
            }
        });
    });

    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            ,url: '<?=base_url() ?>upload/uploadFile/'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo1').attr('src', result); //图片链接（base64）
                });
            }
            ,done: function(res){
                console.log(res)
                //如果上传失败
                if(res.code != 200){
                    return layer.msg('上传失败');
                    return false;
                }
                //上传成功
                $("input[name='img_url']").val(res.data.file_path)
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#demoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });


    });
</script>

<script type="text/javascript">
    $("#sub").click(function () {
        var  username = $("input[name='name']").val();
        var province = $("select[name='type']").val();

        var time = $("input[name='valid_time']").val();

        var app_id = $("input[name='app_id']").val();

        var app_url = $("input[name='app_url']").val();
        var link_url = $("input[name='link_url']").val();

        var link_type = $("input[name='link_type']:checked").val();

        if (username == "") {
            layer.msg('请填写banner名称');
            return false;
        }

        if (province==""){
            layer.msg('请选择所属模块');
            return false;
        }

        if(time==""){
            layer.msg('请选择生效时间');
            return false;
        }
        if(link_type==""){
            layer.msg('请选择跳转方式');
            return false;
        }

        if (link_type == 2 && (app_id=="" || app_url=="")){
                layer.msg('请填写app信息');
                return false;

        }
        if (link_type == 1 && link_url==""){
            layer.msg('请填写app信息');
            return false;
        }



        var form=new FormData(document.getElementById("CreateForm"));
        var url = "<?= base_url()."banner/addBanner/" ?>";
        $.ajax({
            type:"post",
            url:url,
            processData:false,
            contentType:false,
            data:form,
            dataType:"json",
            success:function(data){

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
            }
        })

    })
</script>