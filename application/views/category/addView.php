

<!-- 内容标题 -->
<section class="content-header clearfix">
    <span class="con-header-tit">添加分类</span>
</section>

<section class="content pd-top0">
    <div class="box listPage">
<form class="form-horizontal" id="CreateForm">
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">分类类别：</label>
        <div class="col-sm-8">
            <input type="radio" name="category_type" value="1" title="一级分类" checked="" class="to-url" onchange="">一级分类
<!--            <input type="radio" name="category_type" value="2" title="二级分类" class="to-url">二级分类-->

        </div>
    </div>


    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">分类名称</label>
        <div class="col-sm-8">
            <input type="text" name="name" class="form-control" value="" id="name" placeholder="">
        </div>
    </div>
    <div class="form-group one_type" style="display: none">
        <label for="name" class="col-sm-3 control-label">一级类别：

        </label>
        <div class="col-sm-8">


            <div class="layui-input-inline">
                <select name="parent_id" lay-verify="required" lay-search="" class="form-control">
                    <option value="">请选择</option>
                    <?php foreach ($list as $k=>$v): ?>
                        <option value="<?=$v['id'] ?>"><?=$v['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">icon：

        </label>
        <div class="col-sm-8">
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="test1">上传图片</button>
                <div class="layui-upload-list">
                    <img class="layui-upload-img" src="" id="demo1" width="100px">
                    <p id="demoText"></p>
                </div>
            </div>
            <input type="hidden" name="icon" class="form-control"  id="" placeholder="">
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

<!---->
<!--<div class="layui-upload-drag" id="test10">-->
<!--    <i class="layui-icon"></i>-->
<!--    <p>点击上传，或将文件拖拽到此处</p>-->
<!--</div>-->
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
    $(document).ready(function() {
            $('input[type=radio][name=category_type]').change(function() {
                if (this.value == 1) {
                    $(".one_type").hide();
                }
                if (this.value == 2){
                    $(".one_type").show();
                }
            });
        });


    $("#sub").click(function () {
        var  name = $("input[name='name']").val();
        var parent_id = $("select[name='parent_id']").val();

        var category_type = $("input[name='category_type']:checked").val();

        if (category_type == 1 && name=="") {
            layer.msg('请填写分类名称');
            return false;
        }

        if (category_type == 2 && (parent_id == "" || name=="")) {
            layer.msg('参数有误');
            return false;
        }


        var form=new FormData(document.getElementById("CreateForm"));
        var url = "<?= base_url()."category/addCategory/" ?>";
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
                    location.href="<?= base_url(). 'category/index'?>"
                });
            }
        })

    })
</script>