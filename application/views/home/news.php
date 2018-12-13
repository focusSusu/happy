<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>资讯列表</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/index.css">
    <script src="<?= base_url() ?>style/home/js/flexible.js"></script>
    <script src="<?= base_url() ?>style/home/js/jquery.min.js"></script>
</head>

<body>
    <div class="news">
        <ul class="news_wrap _article">

            <center class="_loading">加载中.....</center>





        </ul>
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
    <input type="hidden" value="1" name="curpage" id="_article">

</body>

<script src="<?= base_url() ?>/style/home-data.js"></script>

<script>
    $(function () {
        getData();

        window.addEventListener('scroll',function(){
            var height = document.body.clientHeight;
            var scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTop;
            var windowH =window.innerHeight;
            if(scrollTop+windowH > height-5){
                //加载数据，显示loading
                var nextPage = parseInt($("#_article").val()) +1;
                var curpage = $("#_article").val(nextPage);
                getData(nextPage);
            }
        },false);

        function getData(curPage=1) {

            var slist = {"type":'_article','category_id':'_article'};

            console.log(slist);
            //ajax请求后台数据
            var url = "<?= base_url()."h5/api/getArticleList/" ?>";
            studentInfo(slist,url,curPage);
            // toPage(slist,url);
        }
    });

</script>

</html>