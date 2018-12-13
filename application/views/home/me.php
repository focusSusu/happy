<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>我的</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/index.css">
    <script src="<?= base_url() ?>style/home/js/flexible.js"></script>
    <script src="<?= base_url() ?>style/home/js/jquery.min.js"></script>

    <script src="<?=base_url()?>style/layer/layer.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>style/layui/css/layui.css">
    <script src="<?= base_url() ?>style/layui/layui.js"></script>
</head>

<body>
    <div class="me">
        <div class="user_info">
            <div class="user_img">
                <img src="<?=$headimgurl ?>">
            </div>
            <p class="nickname">
                昵称：<?=$nickname ?>
            </p>
        </div>
        <p class="history">
            <a href=" <?= base_url()?>h5/api/getMyRelease">

                <span>我的发布历史</span>

                <img class="arrow" src="<?= base_url() ?>style/home/img/arrow_left.png">
            </a>
        </p>
        <p class="ad">
            <a>
                <span>我要投广告</span>
                <img class="arrow" src="<?= base_url() ?>style/home/img/arrow_left.png">
            </a>
        </p>
        <p class="link">
            <a>
                <span>联系客服</span>
                <span>0552-6056895</span>
            </a>
        </p>
        <p class="contact">
            <a href="contact_us.html">
                <span>联系我们</span>
                <img class="arrow" src="<?= base_url() ?>style/home/img/arrow_left.png">
            </a>
        </p>
        <div class="float">
            <div class="mask"></div>
            <div class="form">
                <input class="name" autofocus placeholder="请填写联系人" name="personal">
                <input class="tel" placeholder="请填写电话" name="phone">
                <textarea class="demands" placeholder="请填写您的需求" name="demand"></textarea>
                <div class="submit">
                    提交
                </div>
                <img class="close" src="<?= base_url() ?>style/home/img/close.png">
            </div>

        </div>
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
    $(function () {
        $('.ad').click(function () {
            $(".float")
                .css("z-index", "100")
                .css("opacity", "1");
        })
        $('.close').click(function () {
            $(".float")
                .css("z-index", "-1")
                .css("opacity", "0");
        })

        $(".submit").click(function () {
            var phone =  $("input[name='phone']").val();
            var personal =  $("input[name='personal']").val();
            var demand =  $("textarea[name='demand']").val();
            var data = {
                "personal":personal,
                "demand":demand,
                "phone":phone,
            };
            var url = "<?= base_url()."h5/api/advertising/" ?>";

            $.post(url,data,function (res) {

                if (res.code !=  0){
                    layer.msg(res.msg);
                    return false;
                }
                layer.msg('成功');

                $(".float")
                    .css("z-index", "-1")
                    .css("opacity", "0");
            },'json')

        })
    })
</script>

</html>