<table class="table table-bordered  _table-condensed text-center">
    <thead>
    <tr>
        <th>序号</th>
        <th>用户名</th>
        <th>真实姓名</th>
        <th>添加时间</th>
        <th>修改时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody id="tableBody">
    <?php foreach ($userlist as $k=>$v): ?>
        <tr>
            <td><?= $v['id'] ?></td>
            <td><?= $v['username'] ?></td>
            <td><?= $v['real_name'] ?></td>
            <td><?= $v['create_time'] ?></td>
            <td><?= $v['update_time'] ?></td>
            <td>
                <a class="layui-btn layui-btn-sm" href="<?=base_url()."user/update?user_id=".$v['id'] ?>" >编辑</a>
                <?php if($v['status'] == 0 ): ?>
                    <button class="layui-btn layui-btn-sm layui-btn-warm status" status="1" course_id="<?=$v['id'] ?>">已禁用</button>
                <?php elseif($v['status'] == 1): ?>
                    <button class="layui-btn layui-btn-sm layui-btn-normal status" status="0" course_id="<?=$v['id'] ?>">已启用</button>
                <?php endif; ?>

                <a class="layui-btn layui-btn-sm" href="<?=base_url()."user/updatePassView?user_id=".$v['id'] ?>" >修改密码</a>

            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<input type="hidden" value="<?=$totalCount ?>" id="total">

