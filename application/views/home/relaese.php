<?php foreach ($list as $k=>$v): ?>
<div class="article_item">
    <a href="<?= base_url()?>h5/api/details?id=<?=$v['id'] ?>">
        <p class="title">
            <span>标题：</span>
            <span class="title_content"><?= $v['title']?></span>
        </p>
        <p class="short_desc">
                        <span class="description">
                            <span>内容：</span>
                            <?= $v['content']?>
                        </span>
            <span class="open">
                            展开全文
                            <img class="arrow" src="<?= base_url() ?>style/home/img/arrow_down.png">
                        </span>
        </p>
        <div class="img_area">
            <div class="img_block">
                <?php foreach ($v['img_list'] as $value):?>
                <img src="<?= $value ?>">
                <?php endforeach; ?>
            </div>
            <div class="call_me">
                <img src="<?= base_url() ?>style/home/img/call_me.png">
            </div>
        </div>
        <p class="read_amount">
            阅读： <?= $v['browse_count']?> 次

        </p>
        <p class="time">
            发布时间：  <?= $v['create_time']?>
        </p>
    </a>
</div>

<?php endforeach; ?>


