<?php
declare(strict_types=1);

namespace Avalon\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Utility\Inflector;

/**
 * AuthCheck helper
 */
class AuthCheckHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];




    public function isAuthorized($aco)
    {
        $userPermissions = $this->getView()->get('identity')->permissions;
        $plugin = Inflector::camelize($aco['_plugin']);
        $prefix = Inflector::camelize($aco['prefix']);
        $controller = Inflector::camelize($aco['controller']);
        $action = $aco['controller_action'];
        // echo '<pre>'.print_r($aco,true).'</pre>';

        // Check for a plugin first
        if (!is_null($plugin) && $plugin != '') {
            // Check for a prefix 
            if (!is_null($prefix) && $prefix != '') {
                return (bool) $userPermissions[$plugin]['children'][$prefix]['children'][$controller]['allowed'];
            } else {
                return (bool) $userPermissions[$plugin]['children'][$controller]['children'][$action]['allowed'];
            }
        } else {
            if (!is_null($prefix) && $prefix != '') {
                return (bool) $userPermissions[$prefix]['children'][$controller]['children'][$action]['allowed'];
            } else {
                return (bool) $userPermissions[$controller]['children'][$action]['allowed'];
            }
        }
    }
}
