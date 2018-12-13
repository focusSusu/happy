<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>发布历史</title>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>style/home/css/index.css">
    <script src="<?= base_url() ?>style/home/js/flexible.js"></script>
    <script src="<?= base_url() ?>style/home/js/jquery.min.js"></script>
</head>

<body>
    <div class="public_history">
        <div class="article">
            <div class="list_head">
                <?php foreach ($category as $key=>$value): ?>
                    <span <?php if($key == 0): ?> class="active" <?php endif; ?> bute="<?=$value['id'] ?>"><?=$value['name'] ?></span>
                <?php endforeach; ?>
            </div>
            <div class="article_contet _my">
                <center class="_loading">加载中.....</center>


            </div>
            <input type="hidden" value="1" name="curpage" id="_my">

            <input type="hidden" value="0"  id="curType">



<!--            <button id="loading">加载更多</button>-->
        </div>
    </div>
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
                var nextPage = parseInt($("#_my").val()) +1;
                var curpage = $("#_my").val(nextPage);
                getData(types,nextPage);
            }
        },false);

        $("#loading").click(function () {
            var nextPage = parseInt($("#_my").val()) +1;
            var curpage = $("#_my").val(nextPage);
            getData(types,nextPage);

        });
        function getData(bute='',curPage=1) {
            var type = "";
            if (bute==""){
                type = types;
            } else {
                type = bute;
            }

            var slist = {"type":'_my','category_id':types};

            console.log(slist);
            //ajax请求后台数据
            var url = "<?= base_url()."h5/api/getRelaese/" ?>";
            studentInfo(slist,url,curPage);
            // toPage(slist,url);
        }
        
        $('.article .list_head>span').click(function () {
            $(this).addClass('active').siblings().removeClass('active')
            types = $(this).attr('bute');

            if ($("#curType").val() != types){
                $("._my").html('');
            }
            $("#curType").val(types);

            getData(types);
        })
    })
</script>

</html>