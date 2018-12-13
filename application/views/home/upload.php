<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>详情介绍</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/index.css">
    <script src="<?= base_url() ?>style/home/js/flexible.js"></script>
    <script src="<?= base_url() ?>style/home/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>style/home/js/swiper.min.js"></script>

    <link rel="stylesheet" href="<?= base_url() ?>style/layui/css/layui.css">

    <script src="<?=base_url()?>style/layer/layer.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>style/layui/css/layui.css">
    <script src="<?= base_url() ?>style/layui/layui.js"></script>
</head>

<body>
    <div class="upload">
        <form action="" id="CreateForm">

        <div class="type">
            <div class="title">
                <span>请选择分类：</span>
                <select name="type" id="">
                    <option value="">请选择：</option>
                    <?php foreach ($category as $v):?>
                        <option value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

        </div>
        <div class="content_title">
            <input autofocus placeholder="请填写标题" name="title">
        </div>
        <div class="content_area">
            <textarea placeholder="请填写内容..." name="content"></textarea>
        </div>
        <div class="upload_img">
            <p class="desc">请上传图片</p>

            <div class="layui-upload-list" id="demo2">

            </div>

            <i class="layui-icon layui-icon-upload-circle" style="font-size: 30px; color: #1E9FFF;" id="test2"></i>

        </div>
        <div class="content_tel" >
            <input placeholder="请填写联系电话" name="phone">
        </div>
        <div class="content_address" >
            <input placeholder="请填写联系地址" name="address">
        </div>
        <div class="submit" id="sub">
            提交
        </div>
        <div class="float">
            <div class="mask"></div>
            <div class="chs">
                <div class="msg">发布成功!</div>
                <div class="choose">
                    <div class="option_1"><a href="" class="to_details">去详情页</a></div>
                    <div class="option_2"><a href="<?=base_url() ?>h5/api/index">返回首页</a></div>
                </div>
            </div>
        </div>
        </form>

    </div>
    <ul class="check_list">
        <li class="list_item active">
            <a href="<?= base_url()?>h5/api/index">

                <span class="wrap">
                    <img src="<?= base_url() ?>style/home/img/home_icon.png">
                    <span>首页</span>
                </span>
            </a>
        </li>
        <li class="list_item">
            <a href="<?= base_url()?>h5/api/imformation_list">
                <span class="wrap">
                    <img src="<?= base_url() ?>style/home/img/home_list_icon.png">
                    <span>列表</span>
                </span>
            </a>
        </li>
        <li class="list_item">
            <a href="<?= base_url()?>h5/api/release_view">
                <span class="wrap">
                    <img src="<?= base_url() ?>style/home/img/home_pub_icon.png">
                    <span>发布</span>
                </span>
            </a>
        </li>
        <li class="list_item">
            <a href="<?= base_url()?>h5/api/getArticle">

                <span class="wrap">
                    <img src="<?= base_url() ?>style/home/img/home_news_icon.png">
                    <span>资讯</span>
                </span>
            </a>
        </li>
        <li class="list_item">
            <a href="<?= base_url()?>h5/api/me">
                <span class="wrap">
                    <img src="<?= base_url() ?>style/home/img/home_me_icon.png">
                    <span>我的</span>
                </span>
            </a>
        </li>
    </ul>

</body>
<script>
     img =  new Array()
    layui.use('upload', function(){
        var $ = layui.jquery
            ,upload = layui.upload;

        //多图片上传
        upload.render({

            elem: '#test2'
            ,url: '<?=base_url() ?>upload/uploadFile/'
            ,multiple: true
            ,before: function(obj){
                alert(1)

                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#demo2').append('<img src="'+ result +'" alt="'+ file.name +'" class="layui-upload-img" width="20%" height="20%">')
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
                //上传成功
                img.push(res.data.file_path);
                console.log(img)
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


     $("#sub").click(function () {
         var  title = $("input[name='title']").val();
         var  phone = $("input[name='phone']").val();
         var  address = $("input[name='address']").val();
         var  content = $("textarea[name='content']").val();
         var  type = $("select[name='type']").val();
         if (
             title =="" ||
             phone == "" ||
             address == "" ||
             content == "" ||
             type == ""
         ) {
             layer.msg("参数有误");
         }
        var data = {
             "title":title,
            "phone":phone,
            "address":address,
            "content":content,
            "category_id":type,
            "img":img
        };
         var url = "<?= base_url()."h5/api/release/" ?>";
         $.ajax({
             type:"post",
             url:url,
             data:data,
             dataType:"json",
             success:function(data){

                 console.log(data);
                 if (data.code !=  0){
                     layer.msg(data.msg);
                     return false;
                 }
                 var to_url  = "<?= base_url()."h5/api/details?id=" ?>"+data.data;
                 console.log(url);
                 $(".to_details").attr('href',to_url);

                 $(".float").css("z-index", "100").css("opacity", "1");

             }
         })



     })

</script>

<script>
    $(function () {
        // $('.type .title').click(function () {
        //     $('.arrow').toggleClass('rotate')
        //     $('.type_list').toggleClass('hide')
        // });
        // $('.submit').click(function(){
        //     $(".float").css("z-index", "100").css("opacity", "1");
        // });
        // $('.mask').click(function(){
        //     $(".float")
        //         .css("z-index", "-1")
        //         .css("opacity", "0");
        // })
    })
</script>

</html>