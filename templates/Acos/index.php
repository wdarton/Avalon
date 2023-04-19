<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Aco[]|\Cake\Collection\CollectionInterface $acos
 */
?>

<?= $this->Html->css('Avalon.datatables/dataTables.bootstrap4.min.css') ?>


<div class="row">
    <div class="col">
        <legend>Acos</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <?php
                    $b = '<br>';
                    $t = '&nbsp;&nbsp;&nbsp;&nbsp;';
                    foreach ($acos as $aco) {
                        echo '<strong>'.$aco[0]->alias.'</strong>'.$b;

                        foreach ($aco['children'] as $children) {
                            echo $t.$children[0]->alias.$b;

                            if (isset($children['children'])) {
                                foreach ($children['children'] as $child) {
                                    echo $t.$t.$child->alias.$b;
                                }

                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?= $this->Html->script('Avalon.datatables/jquery.dataTables.min.js') ?>
<?= $this->Html->script('Avalon.datatables/dataTables.bootstrap4.min.js') ?>

<?= $this->Element('Avalon.Datatables/datatable', [
    'tableId' => 'acos-index',
    ]) ?>

