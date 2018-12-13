<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>信息列表</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/index.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/swiper.min.css">
    <script src="<?= base_url() ?>style/home/js/flexible.js"></script>
    <script src="<?= base_url() ?>style/home/js/jquery.min.js"></script>
    <script src="<?= base_url() ?>style/home/js/swiper.min.js"></script>
</head>

<body>
    <div class="information_list">
        <div class="banner">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <a>
                            <?php foreach ($banner as $k=>$v): ?>
                            <img src="<?= $v['img_url'] ?>">
                            <?php endforeach; ?>

                        </a>
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
        <div class="article">
            <div class="list_head">
                <?php foreach ($category as $key=>$value): ?>
                <span
                    <?php
                    if(!$id) {
                        if ($key == 0 ){
                            echo " class='active'";
                        }
                    } else {
                        if ($value['id'] == $id){
                            echo " class='active'";
                        }
                    }
                    ?>
                        bute="<?=$value['id'] ?>"><?=$value['name'] ?></span>
                <?php endforeach; ?>

            </div>
            <div class="article_contet _list">
                <center class="_loading">加载中.....</center>


            </div>
            <input type="hidden" value="1" name="curpage" id="_list">

            <input type="hidden" value="0"  id="curType">


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

<script src="<?= base_url() ?>/style/home-data.js"></script>
<script>

    types = $(".active").attr('bute');

    $(function () {
        getData();

        window.addEventListener('scroll',function(){
            var height = document.body.clientHeight;
            var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
            var windowH =window.innerHeight;
            if(scrollTop+windowH > height-5){
                //加载数据，显示loading
                var nextPage = parseInt($("#_list").val()) +1;
                var curpage = $("#_list").val(nextPage);
                getData(types,nextPage);
            }
        },false);


        $("#loading").click(function () {
            var nextPage = parseInt($("#_list").val()) +1;
            var curpage = $("#_list").val(nextPage);
            getData(types,nextPage);

        });
        function getData(bute='',curPage=1) {
            var type = "";
            if (bute==""){
                type = types;
            } else {
                type = bute;
            }

            var slist = {"type":'_list','category_id':type};

            console.log(slist);
            //ajax请求后台数据
            var url = "<?= base_url()."h5/api/getRelaese/" ?>";
            studentInfo(slist,url,curPage);
            // toPage(slist,url);
        }


        var mySwiper = new Swiper('.swiper-container', {
            loop:false,
            speed:1000,
            autoplay: {
                delay:3000,
                disableOnInteraction:false
            },
            direction: 'horizontal', 
            // pagination: {
            //     el: '.swiper-pagination',
            // }
        });
        $('.article .list_head>span').click(function () {
            $(this).addClass('active').siblings().removeClass('active')
            types = $(this).attr('bute');

            if ($("#curType").val() != types){
                $("._list").html('');
            }
            $("#curType").val(types);

            getData(types);

        })
    })
</script>

</html>