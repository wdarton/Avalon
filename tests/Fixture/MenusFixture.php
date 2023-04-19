<?php
declare(strict_types=1);

namespace Avalon\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MenusFixture
 */
class MenusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'menus';
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
                'label' => 'Lorem ipsum dolor sit amet',
                '_plugin' => 'Lorem ipsum dolor sit amet',
                'prefix' => 'Lorem ipsum dolor sit amet',
                'controller' => 'Lorem ipsum dolor sit amet',
                'controller_action' => 'Lorem ipsum dolor sit amet',
                'sort_order' => 1,
                'active' => 1,
                'literal' => 1,
                'visible' => 1,
            ],
        ];
        parent::init();
    }
}
