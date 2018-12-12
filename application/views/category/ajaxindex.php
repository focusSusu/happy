
<table class="table table-bordered text-center solidTab" id='IndexTab'>
    <thead>
    <tr>
        <th>分类名称</th>
        <th>首页显示</th>
        <th>一级分类排序</th>
        <th>二级分类排序</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php
    if(!empty($list)){
        foreach ($list as $key=>$value) {
            ?>
            <tr style='text-align: center;'>
                <td style='text-align: left;padding-left: <?= $value['upstage']*20?>px;'> ├─ <?= $value['name']?></td>
                <td>
                    <?php if ($value['is_home'] == 1): ?>
                        <button btn-status="0" btn-id="<?=$value['id'] ?>" btn-type="is_home" class="layui-btn layui-btn-primary layui-btn-sm show-btn">显示</button>
                    <?php elseif ($value['is_home'] == 0): ?>
                    <button btn-status="1" btn-id="<?=$value['id']?>" btn-type="is_home" class="layui-btn layui-btn-primary layui-btn-sm show-btn">不显示<button>
                            <?php endif; ?>
                </td>
                <td style=" width: 50px;"><input type="text" class="form-control update_sort" data-id="<?= $value['id']?>" style="width: 50px; text-align: center; border: 1px dashed #ccc;" value="<?= $value['sort']?>"></td>
                <td style=" width: 50px;">-</td>
                <td><?php if (1 == $value['status']) { ?>
                        已启用
                    <?php } else { ?>
                        已禁用
                    <?php } ?></td>
                <td><?= $value['create_time']?></td>
                <td>
                    <a href="<?=base_url()."category/updateView?category_id=".$value['id'] ?>" class="layui-btn layui-btn-sm" >编辑</a>

                    <?php if ($value['status'] == 1): ?>
                        <button btn-status="0" class="layui-btn layui-btn-sm layui-btn-normal show-btn" btn-type="status" btn-id="<?= $value['id'] ?>">已启用</button>
                    <?php elseif ($value['status'] == 0): ?>
                        <button btn-status="1" class="layui-btn layui-btn-sm layui-btn-warm show-btn"  btn-type="status" btn-id="<?= $value['id'] ?>">已禁用</button>

                    <?php endif; ?>
                </td>
            </tr>
            <?php if(count($value['child'])>0) {
                $child=$value['child'];
                for($i=0;$i<count($child);$i++) {
                    ?>
                    <tr style='text-align: center;'>
                        <td style='text-align: left;padding-left: <?= $child[$i]['upstage'] * 20 ?>px;'>
                            　　　 └─ <?= $child[$i]['name'] ?></td>
                        <td>
                            <?php if ($child[$i]['is_home'] == 1): ?>
                                <button btn-status="0" class="layui-btn layui-btn-primary layui-btn-sm show-btn" btn-type="is_home" btn-id="<?= $child[$i]['id'] ?>">显示</button>
                            <?php elseif ($child[$i]['is_home'] == 0): ?>
                                <button btn-status="1" class="layui-btn layui-btn-primary layui-btn-sm show-btn" btn-type="is_home" btn-id="<?= $child[$i]['id'] ?>">不显示</button>

                            <?php endif; ?>
                        </td>
                        <td style=" width: 50px;">-</td>
                        <td style=" width: 50px;"><input type="text" class="form-control update_sort" data-id="<?= $child[$i]['id']?>" style="width: 50px; text-align: center; border: 1px dashed #ccc;" value="<?= $child[$i]['sort']?>"></td>
                        <td><?php if (1 == $child[$i]['status']) { ?>
                                已启用
                            <?php } else { ?>
                                已禁用
                            <?php } ?></td>
                        <td><?= $child[$i]['create_time'] ?></td>
                        <td>
                            <a href="<?=base_url()."category/updateView?category_id=".$child[$i]['id'] ?>" class="layui-btn layui-btn-sm" >编辑</a>
                            <?php if ($child[$i]['status'] == 1): ?>
                                <button btn-status="0" class="layui-btn layui-btn-sm layui-btn-normal layui-btn-norma show-btn" btn-type="status" btn-id="<?= $child[$i]['id'] ?>"> 已启用</button>
                            <?php elseif ($child[$i]['status'] == 0): ?>
                                <button btn-status="1" class="layui-btn layui-btn-sm layui-btn-warm show-btn"  btn-type="status" btn-id="<?= $child[$i]['id'] ?>">已禁用</button>

                            <?php endif; ?>

                        </td>
                    </tr>
                    <?php
                }
            }?>
            <?php
        }
    }
    ?>
    </tbody>
</table>

<!--<input type="hidden" value="--><?//=$totalCount ?><!--" id="total">-->



