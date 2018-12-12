<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>详情</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/index.css">
    <script src="<?= base_url() ?>style/home/js/flexible.js"></script>
    <script src="<?= base_url() ?>style/home/js/jquery.min.js"></script>
</head>

<body>
    <div class="news_detail">
        <p class="title">标题：<?=$list['name'] ?></p>
        <p class="desc">
            <span class="read_amount">阅读：：<?=$list['browse_count'] ?>次</span>
            <span class="publish_time">发布时间：<?=$list['add_time'] ?></span>
        </p>
        <p class="content">
            <?=$list['content'] ?>
        </p>
    </div>
</body>
<script>
    $(function () {

    })
</script>

</html>