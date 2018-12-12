
<!-- 内容标题 -->
<section class="content-header clearfix">
    <span class="con-header-tit">添加咨询</span>
</section>
<!-- Main content -->
<section class="content pd-top0">
    <div class="box listPage">
        <form class="form-horizontal" id="CreateForm">
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">标题</label>
                <div class="col-sm-8">
                    <input type="text" name="name" class="form-control" value="<?=$list['name']?>" id="name" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">简介</label>
                <div class="col-sm-8">
     <textarea name="remark" id="" cols="100" rows="10">
<?=$list['remark']?>
                    </textarea>                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">封面图</label>
                <div class="col-sm-8">
                    <div class="layui-upload">
                        <button type="button" class="layui-btn" id="test1">上传图片</button>
                        <div class="layui-upload-list">
                            <img class="layui-upload-img" id="demo1" width="100px" src="<?=$list['head_img'] ?>">
                            <p id="demoText"></p>
                        </div>
                    </div>
                    <input type="hidden" name="head_img" class="form-control" id="" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">详情：</label>
                <div class="col-sm-8">
                    <script id="editor" type="text/plain">
                        <?php echo $list['content'] ?>
                    </script>
                    <!--                    --><?php
                    //                    $list['content']
                    //                    ?>
                    <input type="hidden" name="content" fld='content' id="contents" value="">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">发布时间：</label>
                <div class="layui-input-inline">
                    <input type="text" class="layui-input" name="add_time" id="test2" value="<?=$list['add_time'] ?>" placeholder="yyyy-MM-dd">
                </div>
            </div>



            <div class="btn_footer">
                <button type="button" class="btn btn-primary" a-click="postData" id="sub">确定</button>
                <button type="button" class="btn btn-default" a-click="back" data-dismiss="modal">取消</button>
            </div>
        </form>
    </div>
</section>



<script type="text/javascript" charset="utf-8" src="<?= base_url()?>public/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="<?= base_url()?>public/ueditor/ueditor.all.min.js"> </script>


<script>
    var ue = UE.getEditor('editor');


</script>

<script>
    layui.use('laydate', function() {
        var laydate = layui.laydate;

        //常规用法
        laydate.render({
            elem: '#test2'
        });

    })
</script>

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
            $("#contents").val(UE.getEditor('editor').getContent());


            var permis_id = [];
            var  username = $("input[name='name']").val();


            if (username == "") {
                layer.msg('请填写用户名');
                return false;
            }

            var form=new FormData(document.getElementById("CreateForm"));
            var url = "<?= base_url()."article/addArticle/" ?>";
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
                        location.href="<?= base_url(). 'article/index'?>"
                    });
                }
            })



        })
    })

</script>



