<?php
declare(strict_types=1);

namespace Avalon\Test\TestCase\Model\Table;

use Avalon\Model\Table\UserLoginsTable;
use Cake\TestSuite\TestCase;

/**
 * Avalon\Model\Table\UserLoginsTable Test Case
 */
class UserLoginsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Avalon\Model\Table\UserLoginsTable
     */
    protected $UserLogins;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Avalon.UserLogins',
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
        $config = $this->getTableLocator()->exists('UserLogins') ? [] : ['className' => UserLoginsTable::class];
        $this->UserLogins = $this->getTableLocator()->get('UserLogins', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UserLogins);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Avalon\Model\Table\UserLoginsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \Avalon\Model\Table\UserLoginsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
