<?php
declare(strict_types=1);

namespace Avalon\Test\TestCase\Model\Table;

use Avalon\Model\Table\MenusTable;
use Cake\TestSuite\TestCase;

/**
 * Avalon\Model\Table\MenusTable Test Case
 */
class MenusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Avalon\Model\Table\MenusTable
     */
    protected $Menus;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Avalon.Menus',
        'plugin.Avalon.Pages',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Menus') ? [] : ['className' => MenusTable::class];
        $this->Menus = $this->getTableLocator()->get('Menus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Menus);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Avalon\Model\Table\MenusTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
