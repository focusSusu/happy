
<!-- 内容标题 -->
<section class="content-header clearfix">
    <span class="con-header-tit">联系我们</span>
</section>
<!-- Main content -->
<section class="content pd-top0">
    <div class="box listPage">
        <form class="form-horizontal" id="CreateForm">
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">联系人</label>
                <div class="col-sm-8">
                    <input type="text" name="person_man" class="form-control" value="<?=$list['person_man'] ?>" id="name" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">联系电话</label>
                <div class="col-sm-8">
                    <input type="text" name="person_phone" class="form-control" value="<?= $list['person_phone'] ?>" id="name" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">联系地址</label>
                <div class="col-sm-8">
                    <input type="text" name="person_address" class="form-control" value="<?= $list['person_address'] ?>" id="name" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">二维码</label>
                <div class="col-sm-8">
                    <div class="layui-upload">
                        <button type="button" class="layui-btn" id="test1">上传图片</button>
                        <div class="layui-upload-list">
                            <img class="layui-upload-img" id="demo1" width="100px" src="<?= $list['person_code'] ?>">
                            <p id="demoText"></p>
                        </div>
                    </div>
                    <input type="hidden" name="person_code" value="<?= $list['person_code'] ?>" class="form-control" id="" placeholder="">
                    <input type="hidden" name="id" value="<?= $list['id'] ?>" class="form-control" id="" placeholder="">
                </div>
            </div>



            <div class="btn_footer">
                <button type="button" class="btn btn-primary" a-click="postData" id="sub">确定</button>
                <button type="button" class="btn btn-default" a-click="back" data-dismiss="modal">取消</button>
            </div>
        </form>
    </div>
</section>



<!-- /.content -->
<script>
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
                $("input[name='person_code']").val(res.data.file_path)
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
            var  person_man = $("input[name='person_man']").val();


            if (person_man == "") {
                layer.msg('请填写联系人');
                return false;
            }

            var form=new FormData(document.getElementById("CreateForm"));
            var url = "<?= base_url()."setting/addSetting/" ?>";
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
                        location.href="<?= base_url(). 'setting/index'?>"
                    });
                }
            })



        })
    })

</script>



