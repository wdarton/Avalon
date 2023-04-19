<?php
$t = '&nbsp;&nbsp;&nbsp;&nbsp;';
?>
<table class="table table-striped table-hover table-sm" id="roles-index">
    <thead>
        <tr>
            <th scope="col"><?= __('ACO') ?></th>
            <th></th>
            <th scope="col"><?= __('Setting') ?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($acos as $aco): ?>
            <tr>
                <td><strong><?= $aco[0]->alias ?></strong></td>
                <?= $this->Element('Acl/permission_select',['acoId' => $aco[0]->id]) ?>
            </tr>
            <?php foreach ($aco['children'] as $children): ?>
                <tr>
                    <td><?= $t.$children[0]->alias ?></td>
                    <?= $this->Element('Acl/permission_select',['acoId' => $children[0]->id]) ?>
                </tr>

                <?php if (isset($children['children'])): ?>
                    <?php foreach ($children['children'] as $child): ?>
                        <tr>
                            <td><?= $t.$t.$child->alias ?></td>
                            <?= $this->Element('Acl/permission_select',['acoId' => $child->id]) ?>
                        </tr>
                    <?php endforeach;?>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>