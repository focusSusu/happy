<table class="table table-bordered  _table-condensed text-center">
    <thead>
    <tr>
        <th>课程名称</th>
        <th>创建时间</th>
        <th>课程属性</th>
        <th>会员限制</th>
        <th>推荐课程</th>
        <th>生效时间</th>
        <th>标签</th>
        <th>所属专家</th>
        <th>状态</th>
        <th>编辑</th>
    </tr>
    </thead>
    <tbody id="tableBody">

    <?php foreach ($list as $k=>$v): ?>
        <tr>
            <td colspan=""><?=$v['name'] ?></td>
            <td colspan=""><?=$v['create_time'] ?></td>
            <td colspan="">
                <?php if ($v['type'] == 1): ?>图文
                <?php elseif ($v['type'] == 2): ?>音频
                <?php elseif ($v['type'] == 3): ?>视频
                <?php endif; ?>
            </td>
            <td>
                <?php if ($v['type'] == 1): ?>无限制
                <?php else: ?>
                    <?php if ($v['is_vip'] == 1): ?>有限制  <?php endif; ?>
                    <?php if ($v['is_vip'] == 0): ?>无限制  <?php endif; ?>

                <?php endif; ?>
            </td>

            <td>
                <?php if ($v['is_recommend'] == 1): ?>是
                <?php elseif ($v['is_recommend'] == 0): ?>否
                <?php endif; ?>
            </td>

            <td>
                <?=$v['valid_start_time'] ?> ~ <?=$v['valid_end_time'] ?>
            </td>

            <td><?= $v['category_str'] ?></td>
            <td><?= $v['expert_name'] ?></td>
            <td>
                <?php if($v['is_valid_time'] == 0): ?> 未生效
                <?php elseif($v['is_valid_time'] == 1): ?>
                    <?php if(strtotime($v['valid_start_time']) < time() && time() < strtotime($v['valid_end_time'])): ?>  进行中
                    <?php elseif(strtotime($v['valid_start_time']) > time()): ?>  未开始
                    <?php elseif(strtotime($v['valid_end_time']) < time()): ?>  已结束
                    <?php endif; ?>
                <?php endif; ?>
            </td>


            <td>
                <a class="layui-btn layui-btn-sm" href="<?= base_url()?>course/addView?id=<?=$v['id'] ?>" >编辑</a>
                <?php if($v['status'] == 1): ?>
                    <button class="layui-btn layui-btn-sm layui-btn-normal status-btn" status="0" status_id="<?=$v['id'] ?>">已启用</button>
                <?php elseif($v['status'] == 0): ?>
                    <button class="layui-btn layui-btn-sm layui-btn-warm status-btn" status="1" status_id="<?=$v['id'] ?>">已禁用</button>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>


    </tbody>
</table>

<input type="hidden" value="<?=$totalCount ?>" id="total">
