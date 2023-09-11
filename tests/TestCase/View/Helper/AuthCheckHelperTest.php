<?php
declare(strict_types=1);

namespace Avalon\Test\TestCase\View\Helper;

use Avalon\View\Helper\AuthCheckHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * Avalon\View\Helper\AuthCheckHelper Test Case
 */
class AuthCheckHelperTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \Avalon\View\Helper\AuthCheckHelper
     */
    protected $AuthCheck;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $view = new View();
        $this->AuthCheck = new AuthCheckHelper($view);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AuthCheck);

        parent::tearDown();
    }
}
