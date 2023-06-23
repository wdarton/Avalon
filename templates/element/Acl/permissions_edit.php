<?php
$tab = '&nbsp;&nbsp;&nbsp;&nbsp;';
?>
<!-- <pre><?= print_r($acos) ?></pre> -->
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
                <?= $this->Element('Avalon.Acl/permission_select',
                        [
                            'acoId' => $aco[0]->id,
                            'value' => $permissions[$aco[0]->id]['allowed'],
                            'parentAcoId' => $permissions[$aco[0]->id]['parent_aco_id'],
                        ]
                    )
                ?>
            </tr>
            <?php foreach ($aco['children'] as $children): ?>
                <tr>
                    <?php if (isset($children['children'])): ?>
                        <td><strong><?= $tab.$children[0]->alias ?></strong> <small>(<?= $aco[0]->alias ?>)</small></td>
                    <?php else: ?>
                        <td><?= $tab.$children[0]->alias ?></td>
                    <?php endif; ?>
                    <?= $this->Element('Avalon.Acl/permission_select',
                            [
                                'acoId' => $children[0]->id,
                                'value' => $permissions[$children[0]->id]['allowed'],
                                'parentAcoId' => $permissions[$children[0]->id]['parent_aco_id'],
                            ]
                        )
                    ?>
                </tr>

                <?php if (isset($children['children'])): ?>
                    <?php foreach ($children['children'] as $child): ?>
                        <?php if (!isset($child['children'])): ?>
                            <tr>
                                <?php if (isset($child['children'])): ?>
                                    <td><strong>cc <?= $tab.$tab.$child->alias ?></strong> <small>(<?= $aco[0]->alias ?>)</small></td>
                                <?php else: ?>
                                <?php endif; ?>
                                    <td><?= $tab.$tab.$child->alias ?> <small>(<?= $children[0]->alias ?>)</small></td>

                                <!-- <td>c <?= $tab.$tab.$child->alias ?></td> -->
                                <?= $this->Element('Avalon.Acl/permission_select',
                                        [
                                            'acoId' => $child->id,
                                            'value' => $permissions[$child->id]['allowed'],
                                            'parentAcoId' => $permissions[$child->id]['parent_aco_id'],
                                        ]
                                    )
                                ?>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($child['children'] as $grandChild): ?>
                                <tr>
                                    <!-- <td>gc <?= $tab.$tab.$tab.$grandChild->alias ?> <small>(<?= $acos[3][0]['children'][$grandChild->parent_id]->alias ?>)</small></td> -->
                                    <td><?= $tab.$tab.$tab.$grandChild->alias ?></td>
                                    <?= $this->Element('Avalon.Acl/permission_select',
                                            [
                                                'acoId' => $grandChild->id,
                                                'value' => $permissions[$grandChild->id]['allowed'],
                                                'parentAcoId' => $permissions[$grandChild->id]['parent_aco_id'],
                                            ]
                                        )
                                    ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach;?>
                <?php endif; ?>

            <?php endforeach; ?>
        <?php endforeach; ?>
    </tbody>
</table>