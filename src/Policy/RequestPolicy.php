<?php
namespace App\Policy;

use Authorization\Policy\RequestPolicyInterface;
use Cake\Http\ServerRequest;
use Cake\Log\Log;

class RequestPolicy implements RequestPolicyInterface
{
    /**
     * Method to check if the request can be accessed
     *
     * @param \Authorization\IdentityInterface|null $identity Identity
     * @param \Cake\Http\ServerRequest $request Server Request
     * @return bool
     */
    public function canAccess($identity, ServerRequest $request)
    {
        if (is_null($identity)) {
            // return false;
        }

        $controller = $request->getParam('controller');
        $action = $request->getParam('action');
        $path = $request->getParam('pass');
        $prefix = $request->getParam('prefix');
        $plugin = $request->getParam('plugin');

        Log::debug('Controller: '.$controller);
        Log::debug('Action: '.$action);
        Log::debug('Path: '.print_r($path, true));
        Log::debug('Prefix: '.print_r($prefix, true));
        Log::debug('Params: '.print_r($request->getAttribute('params'), true));

        // if ($identity->get('full_name') == 'Wesley Darton') {
        //     return false;
        // }

        // if ( $controller == 'Pages'
        //     && $action == 'display'
        //     && in_array('dashboard', $path, true)
        // ) {
        //     return true;
        // }

        if ($plugin == 'DebugKit') {
            return true;
        }

        if ($controller == 'Users' && $action == 'login') {
            return true;
        }

        if (is_null($identity)) {
            return false;
        }
        $userPermissions = $identity->get('permissions');

        // Check for a plugin first
        if (!is_null($plugin)) {
            // Check for a prefix 
            if (!is_null($prefix)) {
                return (bool) $userPermissions[$plugin]['children'][$prefix]['children'][$controller]['allowed'];
            } else {
                return (bool) $userPermissions[$plugin]['children'][$controller]['children'][$action]['allowed'];
            }
        } else {
            if (!is_null($prefix)) {
                return (bool) $userPermissions[$prefix]['children'][$controller]['children'][$action]['allowed'];
            } else {
                return (bool) $userPermissions[$controller]['children'][$action]['allowed'];
            }
        }



        return true;
    }
}