<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\View\JsonView;
// use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Log\Log;
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public static $sessionUserFullName = null;
    public static $appDescription = "Avalon";
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        // Add this line to check authentication result and lock your site
        $this->loadComponent('Authentication.Authentication');

        if ($this->Authentication->getIdentity()) {
            $this->loadComponent('Avalon.UserAction', [
                'user_id' => $this->Authentication->getIdentity()->id,
                'controller' => $this->request->getParam('controller'),
                'controller_action' => $this->request->getParam('action'),
                'pass' => $this->request->getParam('pass'),
                'plugin' => $this->request->getParam('plugin'),
            ]);

            self::$sessionUserFullName = $this->Authentication->getIdentity()->first_name.' '.$this->Authentication->getIdentity()->last_name;
        }

        // Log::debug("Testing???");

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');

    }

    public function beforeRender(EventInterface $event)
    {
        $this->viewBuilder()->setTheme('Avalon');
        // $this->viewBuilder()->setLayout('Avalon.dashboard');

    }

    public function beforeFilter(EventInterface $event)
    {
        $this->loadModel('Avalon.Users');
        $this->loadModel('Avalon.Menus');
        $this->loadModel('Avalon.Pages');
    //     // $this->loadModel('SystemSettings');

        $controller = $this->request->getParam('controller');

        // Info about the user
        // $this->set('role', $this->Auth->user('role'));
        // $this->set('authUser', $this->Auth->user());

        // // Prevents auth error from being shown when the user is not logged in
        // if (!$this->Auth->user()) {
        //     $this->Auth->config('authError', false);
        // }

        // if($this->Auth->user('id')) {


        //     $currentUser = $this->Users->get($this->Auth->user('id'), [
        //         // 'contain' => ['UserRoles']
        //     ]);

        //     $systemSettings = $this->SystemSettings->find()->first();

        //     $this->set('currentUser', $currentUser);
        //     $this->set('systemSettings', $systemSettings);
        // } else {
        //     $this->set('currentUser', null);
        // }

        if (!$this->request->is('ajax')) {
            // Navigation

            $loggingOut = false;
            $currentMenu = false;

            // Check to see if we are loggint out
            if ($this->request->getParam('action') == 'logout') {
                $loggingOut = true;
            }

            // Only compile if there is a logged in user!
            // And if we are not logging the user out
            // if ($this->Auth->user() && !$loggingOut) {
            if (!$loggingOut) {
                // // Do we need to force a password reset?

                // if ($currentUser->reset_password) {

                //     if ($this->request->getParam(['controller']) != 'Users' ||
                //     $this->request->getParam(['action']) != 'resetPassword') {

                //         $this->Flash->warning(__('You must reset your password before continuing'));

                //         return $this->redirect([
                //             'prefix' => false,
                //             'controller' => 'users',
                //              'action' => 'reset-password',
                //         ]);

                //     }
                // }

                // Do we have a prefix in the URL?
                if (!is_null($this->request->getParam('prefix')) && $this->request->getParam('prefix')) {
                    $prefix = $this->request->getParam('prefix');

                    $currentMenu = $this->Menus->find('all', [
                        'conditions' => [
                            'Menus.controller' => $controller,
                            'Menus.prefix' => $prefix,
                            'active' => 1,
                        ],
                    ])->first();

                // Are we inside a plugin?
                } elseif (!is_null($this->request->getParam('plugin'))) {
                    $plugin = $this->request->getParam('plugin');

                    $currentMenu = $this->Menus->find('all', [
                        'conditions' => [
                            'Menus._plugin' => $plugin,
                            'Menus.controller' => $controller,
                            'active' => 1,
                        ],
                    ])->first();

                // Are we in the pages controller?
                } elseif (stripos($this->request->getRequestTarget(), '/pages/') !== false) {
                    $rTarget = explode('/', $this->request->getRequestTarget());

                    $currentMenu = $this->Menus->find('all', [
                        'conditions' => [
                            'Menus.controller' => 'pages',
                            'Menus.controller_action' => $rTarget[2],
                            'active' => 1,
                        ],
                    ])->first();

                // We are not in a prefix or a plugin, but a standard controller
                } else {
                    $prefix = false;

                    $currentMenu = $this->Menus->find('all', [
                        'conditions' => [
                            'Menus.controller' => $controller,
                            'active' => 1,
                        ],
                    ])->first();
                }
                // Log::debug(strval(__LINE__));
                $menus = $this->Menus->find('all', [
                    'conditions' => ['active' => 1, 'visible' => 1, 'sort_order <' => 900],
                    'order' => ['Menus.sort_order' => 'ASC'],
                    'contain' => [
                        'Pages' => [
                            'conditions' => ['active' => 1],
                            'sort' => ['Pages.sort_order' => 'ASC'],
                        ],
                    ],
                ])->toArray();

                // Log::debug(strval($menus));
                // Complile the list of nav menus that the user is currently
                // authorized to access

                $navMenus = $menus;

                $adminNavMenus = [];

                // Log::debug(strval(__LINE__));
                $adminMenus = $this->Menus->find('all', [
                    'conditions' => ['active' => 1, 'visible' => 1, 'sort_order >=' => 900],
                    'order' => ['Menus.sort_order' => 'ASC'],
                    'contain' => [
                        'Pages' => [
                            'conditions' => ['active' => 1],
                            'sort' => ['Pages.sort_order' => 'ASC'],
                        ],
                    ],
                ])->toArray();

                // Log::debug(strval($adminMenus));
                // Complile the list of nav menus that the user is currently
                // authorized to access

                $adminNavMenus = $adminMenus;

                $navPages = [];

                // foreach ($menus as $menu) {

                //     // $this->loadModel('Avalon.Users');
                //     // $user = $this->Users->get($this->Auth->user('id'));

                //     if ($menu->controller == 'pages' && $menu->prefix == '') {
                //         $mAllowed = true;
                //     } else {

                //         // $mAllowed = $this->aclCheck($menu);
                //         $mAllowed = true;
                //     }

                //     if ($mAllowed) {
                //         $navMenus[] = $menu;
                //     }
                // }

                if (isset($currentMenu->id)) {
                // Log::debug(strval(__LINE__));
                // Log::debug(strval($currentMenu->id));
                    // $pages = $this->Menus->Pages->find('all', [
                    //     'conditions' => [
                    //         'Pages.menu_id' => $currentMenu->id,
                    //         'active' => 1,
                    //     ],
                    //     'order' => ['Pages.sort_order' => 'ASC'],
                    // ])->toArray();


                $pages = $this->Pages->find('all')->all()->toArray();
                    // Compile a list of the pages for the current menu that the
                    // user is authorized to access
                    foreach ($pages as $page) {

                        $aco = [
                            'prefix' => $page->prefix,
                            'controller' => $page->controller,
                            'controller_action' => $page->controller_action,
                        ];

                        // if ($this->AuthCheck->isAuthorized($this->Auth->user(), $aco)) {
                            $navPages[] = $page;
                        // }
                    }

                }

            } else {
                $navMenus = [];
                $adminNavMenus = [];
                $navPages = [];
            }

            // $navMenus = [];
            // $navPages = [];

            if ($this->Authentication->getIdentity()) {
                $userPreferences = $this->Users->UserPreferences->find('all', [
                    'conditions' => [
                        'user_id' => $this->Authentication->getIdentity()->id,
                    ],
                ])->firstOrFail();
                $this->set('authUser', $this->Authentication->getIdentity());
                $this->set('userPreferences', $userPreferences);
            }

            $this->set('navMenus', $navMenus);
            $this->set('adminNavMenus', $adminNavMenus);
            $this->set('navPages', $navPages);
            $this->set('params', $this->request->getAttribute('params'));
            $this->set('currMenu', $currentMenu);
            $this->set('appDescription', self::$appDescription);
    //         // $this->set('acl', $this->Acl);
        }
    }

    public function viewClasses(): array
{
    return [JsonView::class];
}
}
