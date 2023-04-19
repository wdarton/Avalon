<?php
$this->element('Form/Templates/horiz-sm');
?>

<div class="row">
    <div class="col">
        <legend>Edit - <?= $user->full_name ?></legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <div class="col-sm-6">
                    <?= $this->Form->create($user, ['id' => 'user-form']) ?>
                        <?php
                            echo $this->Form->control('first_name');
                            echo $this->Form->control('last_name');
                            echo $this->Form->control('email');
                            echo $this->Form->control('username');
                            echo $this->Form->control('role_id', ['options' => $roles]);
                            echo $this->element('Form/Components/Horiz/switch', [
                                'name' => 'locked',
                                'entity' => $user,
                            ]);
                        ?>
                    <div class="text-center">
                        <?= $this->Form->button(__('Submit')) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$(function() {
    updateRolesList();
});

$('#user-group-id').change(function(){
    updateRolesList();
});

function updateRolesList() {
    $.post(
    {
        url: $('#user-form').prop('action'),
        async: true,
        data: $('#user-form').serialize(),
        success: function(json)
        {
            var data = JSON.parse(json);
            // console.log(data);

            var ids = []
            $(data).each(function() {
                ids.push(this.id);
            });

            // console.log(ids);

            $("#user-role-id > option").each(function() {
                // console.log(this.value + ' ' + ids.indexOf(parseInt(this.value)));
                if (ids.indexOf(parseInt(this.value)) !== -1) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        }
    });
}

</script>