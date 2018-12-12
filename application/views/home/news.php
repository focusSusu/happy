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
        <ul class="news_wrap">
            <?php foreach ($list as $val): ?>

            <li class="news_item">
                    <a href="<?= base_url()?>h5/api/getArticleDetails?id=<?=$val['id'] ?>">

                    <img class="news_image" src="<?=$val['head_img'] ?>">
                    <div class="news_desc">
                        <p class="title">标题：<?=$val['name'] ?></p>
                        <p class="desc">内容：<?=$val['remark'] ?></p>
                        <p class="read_amount">阅读：<?=$val['browse_count'] ?>次</p>
                        <p class="public_time">发布时间：<?=$val['add_time'] ?></p>
                    </div>
                </a>
            </li>
            <?php endforeach; ?>


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

</body>
<script>
    
</script>

</html>