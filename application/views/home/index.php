<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>乐翻天固镇公众信息平台</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/index.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/swiper.min.css">
    <script src="<?= base_url() ?>style/home/js/flexible.js"></script>
    <script src="<?= base_url() ?>style/home/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>style/home/js/swiper.min.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>style/layui/css/layui.css">

    <script src="<?=base_url()?>style/layer/layer.js"></script>
    <link rel="stylesheet" href="<?= base_url() ?>style/layui/css/layui.css">
    <script src="<?= base_url() ?>style/layui/layui.js"></script>
</head>

<body>
    <div class="banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($banner as $k=>$v): ?>
                <div class="swiper-slide">
                    <a>
                        <img src="<?= $v['img_url'] ?>">
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="classify">
        <?php foreach ($category as $val): ?>

        <div class="class">
            <a href="<?= base_url()?>h5/api/imformation_list?id=<?=$val['id'] ?>">
                <img class="class_icon" src="<?=$val['icon'] ?>" class="exs">
            </a>
            <p class="class_desc"><?=$val['name'] ?></p>
        </div>
        <?php endforeach; ?>

    </div>
    <div class="ad_position">
        <div class="left">
            <img src="<?=$advert_left['img_url'] ?>">
        </div>
        <div class="right">
            <?php foreach ($advert_right as $value): ?>

            <img src="<?= $value['img_url']  ?>">
            <?php endforeach; ?>
        </div>
    </div>
    <div class="article">
        <div class="article_head">
            <span class="active types" bute="_hot">热门信息</span>
            <span class="types" bute="_newest">最新消息</span>
        </div>
        <div class="article_contet _hot">


        </div>

        <input type="text" value="1" name="curpage" id="_hot">

        <input type="text" value="1" name="curpage" id="_newest">

        <div class="article_contet _newest" style="display: none">

        </div>

        <button id="loading">加载更多</button>

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

<script src="<?= base_url() ?>/style/home-data.js"></script>
<script>
     types = '_hot';
    $(".types").click(function () {
        types = $(this).attr('bute');

        if (types == '_hot') {
            $("._newest").hide();
            $("._hot").show();
        }
        if (types == '_newest'){
            $("._newest").show();
            $("._hot").hide();
        }
    });

    $("#loading").click(function () {
        console.log(types);
        var nextPage = parseInt($("#"+types).val()) +1;
        var curpage = $("#"+types).val(nextPage);
        getData(types,nextPage);

    });

     getData('_hot');
     getData('_newest');

    function getData(bute='',curPage=1) {
        var type = "";
        if (bute==""){
             type = types;
        } else {
            type = bute;
        }

        var slist = {"type":type};

        console.log(slist);
        //ajax请求后台数据
        var url = "<?= base_url()."h5/api/getRelaese/" ?>";
        studentInfo(slist,url,curPage);
        // toPage(slist,url);
    }



</script>

<script>
    $(function () {

        var mySwiper = new Swiper('.swiper-container', {
            speed: 1000,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            direction: 'horizontal',
            loop: false,
            pagination: {
                el: '.swiper-pagination',
            }
        })
        $('.article_head>span').click(function () {
            $(this).addClass('active').siblings().removeClass('active')
        })
        $('.check_list .list_item').click(function () {
            $(this).addClass('active').siblings().removeClass('active')
        })
    })
</script>

</html>