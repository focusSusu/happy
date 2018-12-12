<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>联系我们</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/index.css">
    <script src="<?= base_url() ?>style/home/js/flexible.js"></script>
    <script src="<?= base_url() ?>style/home/js/jquery.min.js"></script>
</head>

<body>
    <div class="contact_now">
        <div class="map">
            <iframe src="<?= base_url() ?>h5/api/map" width="360" height="200" frameborder="0" scrolling="no"></iframe>


        </div>
        <div class="contact">
            <div class="info link_person">联系人：<?= $person_man ?></div>
            <div class="info link_tel">联系电话：<?= $person_phone?></div>
            <div class="info link_address">地址：<?= $person_address?></div>
            <div class="qr">
                <img class="code" src="<?= $person_code?> ">
                <p>扫描二维码添加好友</p>
            </div>
        </div>
    </div>
</body>
<script>
    $(function () {

    })
</script>

</html>