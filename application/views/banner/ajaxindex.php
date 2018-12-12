<table class="table table-bordered  _table-condensed text-center">
    <thead>
    <tr>
        <th>序号</th>
        <th>所属模块</th>
        <th>活动名称</th>
        <th>生效时间</th>
        <th>过期时间</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="tableBody">
    <?php foreach ($list as $k=>$v): ?>
        <tr>
            <td><?= $v['id'] ?></td>
            <td><?= $v['name'] ?></td>
            <td><?= $v['bannername'] ?></td>
            <td><?= $v['valid_start_time'] ?></td>
            <td><?= $v['valid_end_time'] ?></td>
            <td>

                <?php if ($v['is_valid_time'] == 0): ?> 无限制
                <?php else: ?>
                    <?php if (time()>strtotime($v['valid_start_time'])   &&  time() < strtotime($v['valid_end_time']) ): ?> 轮播中
                    <?php elseif (time() > strtotime($v['valid_end_time']) ): ?> 已下架
                    <?php elseif (time() < strtotime($v['valid_start_time'])): ?> 未开始
                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td><?= $v['create_time'] ?></td>
            <td>
                <a class="layui-btn layui-btn-sm" href="<?=base_url()."banner/updateView?banner_id=".$v['id'] ?>" >编辑</a>
                <?php if($v['status'] == 0 ): ?>
                    <button class="layui-btn layui-btn-sm layui-btn-warm btn-status" btn-status="1" banner_id="<?=$v['id'] ?>">已停用</button>
                <?php elseif($v['status'] == 1): ?>
                    <button class="layui-btn layui-btn-sm layui-btn-normal btn-status" btn-status="0" banner_id="<?=$v['id'] ?>">已启用</button>
                <?php endif; ?>

                <button class="layui-btn layui-btn-sm layui-btn-danger btn-del" banner_id="<?=$v['id'] ?>">删除</button>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<input type="hidden" value="<?=$totalCount ?>" id="total">
