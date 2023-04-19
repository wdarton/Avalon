<?php
declare(strict_types=1);

namespace Avalon\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserLoginsFixture
 */
class UserLoginsFixture extends TestFixture
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
                'user_id' => 1,
                'username' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-03-06 17:24:47',
                'success' => 1,
            ],
        ];
        parent::init();
    }
}
