<?php

$this->element('Form/Templates/horiz-sm');
?>
<div class="row">
    <div class="col">
        <legend>Add User</legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <div class="col-sm-6">
                    <?= $this->Form->create($user) ?>
                        <?php
                            echo $this->Form->control('first_name');
                            echo $this->Form->control('last_name');
                            echo $this->Form->control('email');
                            echo $this->Form->control('username');
                            echo $this->Form->control('password');
                            echo $this->Form->control('password_confirm', [
                                'type' => 'password',
                                'required' => 'required',
                            ]);
                            echo $this->Form->control('role_id', ['options' => $userRoles]);
                            echo $this->Element('Form/Components/Horiz/default_timezone_input');
                            echo $this->element('Form/Components/Horiz/switch', [
                                'name' => 'reset_password',
                                'entity' => $user,
                                'checked' => true,
                                'label' => 'User must change password on next logon',
                            ]);
                            echo $this->element('Form/Components/Horiz/switch', [
                                'name' => 'locked',
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


