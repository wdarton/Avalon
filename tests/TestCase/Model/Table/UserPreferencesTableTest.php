<?php
declare(strict_types=1);

namespace Avalon\Test\TestCase\Model\Table;

use Avalon\Model\Table\UserPreferencesTable;
use Cake\TestSuite\TestCase;

/**
 * Avalon\Model\Table\UserPreferencesTable Test Case
 */
class UserPreferencesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Avalon\Model\Table\UserPreferencesTable
     */
    protected $UserPreferences;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Avalon.UserPreferences',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('UserPreferences') ? [] : ['className' => UserPreferencesTable::class];
        $this->UserPreferences = $this->getTableLocator()->get('UserPreferences', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->UserPreferences);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \Avalon\Model\Table\UserPreferencesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
