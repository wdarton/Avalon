<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Route\DashedRoute;

$routes->plugin(
    'Avalon',
    ['path' => '/avalon'],
    function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    }
);
$routes->prefix('avalon', function ($routes) {
    $routes->fallbacks(DashedRoute::class);
});

$routes->connect('/admin/{controller}/{action}', ['plugin' => 'Avalon', 'prefix' => 'Admin']);
$routes->connect('/admin/{controller}/{action}/*', ['plugin' => 'Avalon', 'prefix' => 'Admin']);
$routes->connect('/admin/{controller}/', ['plugin' => 'Avalon', 'prefix' => 'Admin']);

$routes->connect('/dashboard', ['controller' => 'Pages', 'action' => 'display', 'dashboard']);
$routes->connect('/login', ['plugin' => 'Avalon', 'controller' => 'Users', 'action' => 'login']);
$routes->connect('/logout', ['plugin' => 'Avalon', 'controller' => 'Users', 'action' => 'logout']);

$routes->connect('/user-settings/*', ['plugin' => 'Avalon', 'controller' => 'UserPreferences']);
$routes->connect('/user-settings/{action}', ['plugin' => 'Avalon', 'controller' => 'UserPreferences']);
$routes->connect('/user-settings/{action}/*', ['plugin' => 'Avalon', 'controller' => 'UserPreferences']);


// Router::prefix('admin', function ($routes)  {
//     $routes->connect('avalon/admin/{controller}/{action}', ['prefix' => 'Admin', 'plugin' => 'Avalon']);
//     $routes->fallbacks('DashedRoute');
// });

// $routes->plugin(
//     'Avalon',
//     ['path' => '/avalon'],
//     function ($routes) {
//         $routes->setRouteClass(DashedRoute::class);

//         $routes->get('/admin/{controller}/{action}', ['prefix' => 'Admin']);
//         // $routes->get('/admin/{controller}', ['prefix' => 'admin']);
//         // $routes->get('/contacts/{id}', ['controller' => 'Contacts', 'action' => 'view']);
//         // $routes->put('/contacts/{id}', ['controller' => 'Contacts', 'action' => 'update']);
//     }
// );