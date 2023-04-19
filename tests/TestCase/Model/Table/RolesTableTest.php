<?php
declare(strict_types=1);

namespace Avalon\Test\TestCase\Model\Table;

use Avalon\Model\Table\RolesTable;
use Cake\TestSuite\TestCase;

/**
 * Avalon\Model\Table\RolesTable Test Case
 */
class RolesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Avalon\Model\Table\RolesTable
     */
    protected $Roles;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Avalon.Roles',
        'plugin.Avalon.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Roles') ? [] : ['className' => RolesTable::class];
        $this->Roles = $this->getTableLocator()->get('Roles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Roles);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Avalon\Model\Table\RolesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test savePermissions method
     *
     * @return void
     * @uses \Avalon\Model\Table\RolesTable::savePermissions()
     */
    public function testSavePermissions(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getEffectiveRolePermissions method
     *
     * @return void
     * @uses \Avalon\Model\Table\RolesTable::getEffectiveRolePermissions()
     */
    public function testGetEffectiveRolePermissions(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test getEffectivePermissions method
     *
     * @return void
     * @uses \Avalon\Model\Table\RolesTable::getEffectivePermissions()
     */
    public function testGetEffectivePermissions(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
