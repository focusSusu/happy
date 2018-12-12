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
</head>

<body>
    <div class="detail">
        <p class="title">
            标题：<?=$list['title']?>
        </p>
        <p class="note">
            <span>发布时间：<?=$list['create_time']?>&nbsp;阅读<?=$list['browse_count']?>次</span>
            <a><img class="call_me" src="<?= base_url() ?>style/home/img/call_me.png"></a>
        </p>
        <p class="content">
            <span>内容：</span>
            <span>
                <?=$list['content']?>
            </span>
        </p>
        <?php foreach ($list['img_list'] as $val): ?>
        <img class="desc_img" src="<?= $val?>">
        <?php endforeach; ?>
    </div>
</body>
<script>
    $(function () {
        $('.article .list_head>span').click(function () {
            $(this).addClass('active').siblings().removeClass('active')
        })
    })
</script>

</html>