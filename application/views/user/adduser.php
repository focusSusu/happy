
<!-- 内容标题 -->
<section class="content-header clearfix">
    <span class="con-header-tit">添加用户</span>
</section>
<!-- Main content -->
<section class="content pd-top0">
    <div class="box listPage">
        <form class="form-horizontal" id="CreateForm">
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">用户名</label>
                <div class="col-sm-8">
                    <input type="text" name="username" class="form-control" value="" id="name" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">真实姓名</label>
                <div class="col-sm-8">
                    <input type="text" name="real_name" class="form-control" value="" id="name" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">密码</label>
                <div class="col-sm-8">
                    <input type="password" name="password" class="form-control" id="name" placeholder="">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">确认密码</label>
                <div class="col-sm-8">
                    <input type="password" name="repassword" class="form-control" id="name" placeholder="">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label">设置权限</label>
                <div class="col-sm-4">
                    <div class="checkbox">

                        <?php foreach ($menus as $k=>$v): ?>
                            <label>
                                <input type="checkbox" name="permis_id[]" value="<?= $v['id'] ?>" lay-skin="primary" title="<?= $v['name'] ?>"><?= $v['name'] ?>
                            </label>
                        <?php endforeach; ?>


                    </div>
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
    $(function () {
        $("#sub").click(function () {
            var permis_id = [];
            var  username = $("input[name='username']").val();
            var  user_id = $("input[name='user_id']").val();
            var  real_name = $("input[name='real_name']").val();
            var  password = $("input[name='password']").val();
            var  repassword = $("input[name='repassword']").val();
            if (user_id == ""){
                layer.msg('网络错误');
                return false;
            }

            if (username == "") {
                layer.msg('请填写用户名');
                return false;
            }

            if (real_name == "") {
                layer.msg('请填写用户名');
                return false;
            }
            if (password == "") {
                layer.msg('请填写密码');
                return false;
            }
            if (repassword == "") {
                layer.msg('请填写确认密码');
                return false;
            }

            if (password != repassword) {
                layer.msg('密码不一致');
                return false;
            }
            if (password.length <6){
                layer.msg('密码长度不够');
                return false;
            }

            $("input:checkbox[name='permis_id[]']:checked").each(function() { // 遍历name=test的多选框
                permis_id.push($(this).val());
            });

            console.log(permis_id);
            if (permis_id.length <=0){
                layer.msg('请选择权限');
                return false;
            }

            var form=new FormData(document.getElementById("CreateForm"));
            var url = "<?= base_url()."user/addUser/" ?>";
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
                        location.href="<?= base_url(). 'user/index'?>"
                    });
                }
            })



        })
    })

</script>

