<?php
namespace Avalon\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Log\Log;

/**
 * Ajax component
 */
class AjaxComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    public $controller;

    public function initialize(array $config): void
    {
        $this->controller = $this->_registry->getController();
    }

    public function sendToView($entity)
    {
        $this->controller->set('entity', json_encode($entity));
        $this->controller->viewBuilder()->setClassName('Json');
        $this->controller->viewBuilder()->setOption('serialize', 'entity');
    }

    public function sendErrors($entity)
    {
        $errors = ['errors' => $entity->getErrors()];

        $this->controller->set('errors', json_encode($errors));
        $this->controller->viewBuilder()->setClassName('Json');
        $this->controller->viewBuilder()->setOption('serialize', 'errors');
    }

    public function sendSuccess()
    {
        $response = ['success' => 1];

        $this->controller->set('response', json_encode($response));
        $this->controller->viewBuilder()->setClassName('Json');
        $this->controller->viewBuilder()->setOption('serialize', 'response');
    }

    public function sendSuccessEntity($entity)
    {
        $response = [
            'success' => 1,
            'entity' => $entity,
        ];

        $this->controller->set('response', json_encode($response));
        $this->controller->viewBuilder()->setClassName('Json');
        $this->controller->viewBuilder()->setOption('serialize', 'response');
    }
}
