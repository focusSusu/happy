
<!-- 内容标题 -->
<section class="content-header clearfix">
    <span class="con-header-tit">基础信息</span>
</section>
<!-- Main content -->
<section class="content pd-top0">
    <div class="box listPage">
        <form class="form-horizontal" id="CreateForm">
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">专家名称</label>
                <div class="col-sm-8">
                    <input type="text" name="name" class="form-control" value="<?=$list['name'] ?>" id="name" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">专家简介</label>
                <div class="col-sm-8">
     <textarea name="remark" id="" cols="100" rows="10">
<?=$list['remark'] ?>
                    </textarea>            </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">专家头像</label>
                <div class="col-sm-8">
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="test1">上传图片</button>
                            <div class="layui-upload-list">
                                <img class="layui-upload-img" src="<?=$list['head_img'] ?>" id="demo1" width="100px">
                                <p id="demoText"></p>
                            </div>
                        </div>
                        <input type="hidden" name="head_img" class="form-control" id="" placeholder="">
                </div>
            </div>
            <input type="hidden" name="id" value="<?=$id ?>">

            <div class="btn_footer">
                <button type="button" class="btn btn-primary" a-click="postData" id="sub">确定</button>
                <button type="button" class="btn btn-default" a-click="back" data-dismiss="modal">取消</button>
            </div>
        </form>
    </div>
</section>
<!-- /.content -->
<!-- /.content -->
<script>
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#test1'
            ,url: '<?=base_url() ?>course/uploadFile/'
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
                $("input[name='head_img']").val(res.data.file_path)
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

<script>
    $(function () {
        $("#sub").click(function () {
            var permis_id = [];
            var  username = $("input[name='name']").val();


            if (username == "") {
                layer.msg('请填写用户名');
                return false;
            }

            var form=new FormData(document.getElementById("CreateForm"));
            var url = "<?= base_url()."expert/updateExpert/" ?>";
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
                        location.href="<?= base_url(). 'expert/index'?>"
                    });
                }
            })



        })
    })

</script>

