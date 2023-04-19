<?php
namespace Avalon\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Auth helper
 */
class AuthCheckComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function isAuthorized($user, $aco)
    {
        // Log::debug('============================');
        // Log::debug('Checking '.$aco['controller']);
        $this->_user = $user;

        // assume false
        $authorized = false;


        // if (is_object($aco)) {
        //     $controller = $aco->controller;
        //     $action = $aco->action;
        // } elseif (is_array($aco)) {
        // }
        $controller = $aco['controller'];
        $action = $aco['controller_action'];

        // Temp pass
        // if ($controller == 'Users') {
        //     return true;
        // }

        if (!empty($aco['prefix']) && !is_null($aco['prefix'])) {
            $prefix = ucwords($aco['prefix']);

            $contAuth = $user['permissions'][$prefix]['children'][$controller]['allowed'];
            // Log::debug('Controller '.$user['permissions'][$prefix]['children'][$controller]['allowed']);
            if ($controller !== 'Pages') {
                $actionAuth = $user['permissions'][$prefix]['children'][$controller]['children'][$action]['allowed'];
            } else {
                $actionAuth = -1;
            }
        } else {
            $contAuth = $user['permissions'][$controller]['allowed'];
            // Log::debug('Controller '.$user['permissions'][$controller]['allowed']);
            if ($controller !== 'Pages') {
                $actionAuth = $user['permissions'][$controller]['children'][$action]['allowed'];
            } else {
                $actionAuth = -1;
            }

        }

        if ($actionAuth == -1) {
            $authorized = $contAuth ? true : false;
        } else {
            $authorized = $actionAuth ? true : false;
        }
        // Log::debug('Result '.($authorized ? 'true' : 'false'));
        return $authorized;
    }

}
