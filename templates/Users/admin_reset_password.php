<?php

$this->element('Form/Templates/horiz-sm');
?>
<div class="row">
    <div class="col">
        <legend>Reset Password - <?= $user->full_name ?></legend>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card material">
            <div class="card-body">
                <div class="col-sm-6">
                    <div class="alert alert-info text-center" role="alert">
                        The new password must be at least 10 characters long
                    </div>
                    <?= $this->Form->create() ?>
                        <?php
                            echo $this->Form->control('id', [
                                'type' => 'hidden',
                                'value' => $user->id,
                            ]);
                            echo $this->Form->control('password', [
                                'required' => 'required',
                            ]);
                            echo $this->Form->control('password_confirm', [
                                'type' => 'password',
                                'required' => 'required',
                            ]);
                            echo $this->element('Form/Components/Horiz/switch', [
                                'name' => 'reset_password',
                                'entity' => $user,
                                'label' => 'User must change password on next logon',
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


