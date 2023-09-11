<?php

namespace Avalon\Panel;

use DebugKit\DebugPanel;
use Cake\Event\EventInterface;

/**
 * My Custom Panel
 */
class AvalonPanel extends DebugPanel
{
    public $plugin = 'Avalon';
    private $request;

    public function __construct() {
        // $this->setConfig(Config::all());
    }

     /**
     * Data collection callback.
     *
     * @param \Cake\Event\EventInterface $event The shutdown event.
     *
     * @return void
     */
    public function shutdown(EventInterface $event): void {
        $controller = $event->getSubject();
        $request = $controller->getRequest();
        $this->request = $request;

        $vars = $controller->viewBuilder()->getVars();

        $params = $this->_getParams($request->getAttribute('params'));

        if (!is_null($request->getAttribute('identity'))) {
            $identity = $request->getAttribute('identity');
        } else {
            $identity = null;
        }

        $data = [
            'params' => $params,
            'path' => $this->_getPath($params),
            'identity' => $identity,
        ];

        $this->_data = $data;
    }

    /**
     * Get the summary data for a panel.
     *
     * This data is displayed in the toolbar even when the panel is collapsed.
     *
     * @return string
     */
    public function summary() {
        if (!isset($this->request)) {
            return 'no request';
        }
        if (!is_null($this->request->getAttribute('identity'))) {
            $identity = $this->request->getAttribute('identity');
        } else {
            $identity = null;
        }
        $params = $this->request->getAttribute('params');
        $controller = $params['controller'];
        $action = $params['action'];
        $prefix = null;
        if (isset($params['prefix'])) {
            $prefix = $params['prefix'];
        }
        $plugin = $params['plugin'];

        // Check for a plugin first
        
        if (is_null($identity)) {
            return 'Not logged in';
        }

        if (!is_null($plugin)) {
            // Check for a prefix 
            if (!is_null($prefix)) {
                return  (bool) $identity['permissions'][$plugin]['children'][$prefix]['children'][$controller]['allowed'] ? 'Allowed' : 'Denied';
            } else {
                return (bool) $identity['permissions'][$plugin]['children'][$controller]['children'][$action]['allowed'] ? 'Allowed' : 'Denied';
            }
        } else {
            if (!is_null($prefix)) {
                return (bool) $identity['permissions'][$prefix]['children'][$controller]['children'][$action]['allowed'] ? 'Allowed' : 'Denied';
            } else {
                return (bool) $identity['permissions'][$controller]['children'][$action]['allowed'] ? 'Allowed' : 'Denied';
            }
        }

    }

    /**
     * @param array $params
     *
     * @return array
     */
    protected function _getParams(array $params) {
        $params += [
            'prefix' => null,
            'plugin' => null,
        ];
        unset($params['isAjax']);
        unset($params['_csrfToken']);
        unset($params['_Token']);

        return $params;
    }

    /**
     * @param array $params
     *
     * @return string
     */
    protected function _getPath(array $params) {
        $path = $params['controller'];
        if ($params['prefix']) {
            $path = $params['prefix'] . '/' . $path;
        }
        if ($params['plugin']) {
            $path = $params['plugin'] . '.' . $path;
        }

        return $path;
    }
}