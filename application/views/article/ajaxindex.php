<table class="table table-bordered  _table-condensed text-center">
    <thead>
    <tr>
        <th>序号</th>
        <th>咨询名称</th>
        <th>简介</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="tableBody">
    <?php foreach ($list as $k=>$v): ?>
        <tr>
            <td><?= $v['id'] ?></td>
            <td><?= $v['name'] ?></td>
            <td><?= $v['remark'] ?></td>
            <td><?= $v['create_time'] ?></td>
            <td>
                <a class="layui-btn layui-btn-sm layui-btn" href="<?=base_url()."article/updateView?expert_id=".$v['id'] ?>" >编辑</a>
                <a class="layui-btn layui-btn-sm layui-btn" href="<?=base_url()."course/index?expert_id=".$v['id'] ?>" >查看课程</a>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<input type="hidden" value="<?=$totalCount ?>" id="total">
