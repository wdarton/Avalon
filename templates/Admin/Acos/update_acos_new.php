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
                    $tab = "&nbsp;&nbsp;&nbsp;&nbsp;";
                    foreach ($resources as $resource => $items) {
                        echo '<strong>C: '.$resource.'</strong><br>';

                        foreach ($items as $item => $itemValue) {

                            if (!is_array($itemValue)) {
                                echo $tab.'I: '.$itemValue.'<br>';
                            } else {
                                // These are controllers under a prefix
                                echo $tab.'<strong>CK: '.$item.'</strong><br>';

                                foreach ($itemValue as $subItem => $subValue) {
                                    // echo '$subItem TYPE: '.gettype($subItem);
                                    if (!is_array($subValue)) {
                                        echo $tab.$tab.'I: '.$subValue.'<br>';
                                    } else {
                                        echo $tab.$tab.'<strong>CV: '.$subItem.'</strong><br>';

                                        foreach ($subValue as $prefixItem => $prefixValue) {
                                            if (!is_array($prefixValue)) {
                                                echo $tab.$tab.$tab.'I: '.$prefixValue.'<br>';
                                            }
                                        }
                                    }

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

