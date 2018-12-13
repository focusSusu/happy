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