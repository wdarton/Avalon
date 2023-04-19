<?php
declare(strict_types=1);

namespace Avalon\Test\TestCase\Controller;

use Avalon\Controller\UserPreferencesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * Avalon\Controller\UserPreferencesController Test Case
 *
 * @uses \Avalon\Controller\UserPreferencesController
 */
class UserPreferencesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'plugin.Avalon.UserPreferences',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \Avalon\Controller\UserPreferencesController::index()
     */
    public function testIndex(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \Avalon\Controller\UserPreferencesController::view()
     */
    public function testView(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \Avalon\Controller\UserPreferencesController::add()
     */
    public function testAdd(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \Avalon\Controller\UserPreferencesController::edit()
     */
    public function testEdit(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \Avalon\Controller\UserPreferencesController::delete()
     */
    public function testDelete(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
