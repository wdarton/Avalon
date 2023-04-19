<?php
declare(strict_types=1);

namespace Avalon\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'role_id' => 1,
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'username' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'login_count' => 1,
                'last_logon' => '2023-03-03 21:30:43',
                'locked' => 1,
                'reset_password' => 1,
                'created' => '2023-03-03 21:30:43',
                'created_by' => 'Lorem ipsum dolor sit amet',
                'modified' => '2023-03-03 21:30:43',
                'modified_by' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
