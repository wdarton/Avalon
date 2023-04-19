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



                    foreach ($resources as $resource => $items) {
                            echo '<strong>C: '.$resource.'</strong><br>';

                        foreach ($items as $key => $item) {
                            if (!is_array($item)) {
                                echo 'I: '.$item.'<br>';
                            } else {
                                // These are controllers under a prefix
                                echo '<strong>K: '.$key.'</strong><br>';
                                foreach ($item as $subResource => $value) {
                                    echo 'I: '.$value.'<br>';

                                }
                            }
                        }
                                echo "<hr>";
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

