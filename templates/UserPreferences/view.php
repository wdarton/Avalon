<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $userPreference
 */

$this->Html->css('Avalon.datatables/dataTables.bootstrap4.min.css');
?>

<div class="row">
    <div class="col">
        <legend>View - <?= h('') ?></legend>
        <?= $this->Html->link(__('Edit User Preference'), ['action' => 'edit', $userPreference->id]) ?>
        <hr>
    </div>
</div>



<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <h4><?= h('') ?></h4>
                <hr>
                <table class="table table-hover table-sm">
                    <tr>
                        <th scope="row"><?= __('User Timezone') ?></th>
                        <td><?= h($userPreference->user_timezone) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($userPreference->id) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('User Id') ?></th>
                        <td><?= $this->Number->format($userPreference->user_id) ?></td>
                    </tr>
                </table>




            </div>
        </div>
    </div>
</div>
