<?php
declare(strict_types=1);

namespace Avalon\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserPreferencesFixture
 */
class UserPreferencesFixture extends TestFixture
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
                'user_timezone' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
