<?php
namespace Avalon\Model\Behavior;

use Cake\ORM\Behavior;
use Avalon\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\Entity;
use ArrayObject;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;


class UserActionLogsBehavior extends Behavior
{
	// public function beforeSave(Event $event, Entity $entity, ArrayObject $options)
	// {
	// 	Log::debug('UserActionLogsBehavior beforeSave');
	// 	Log::debug('entity: '.$entity->id);
	// 	$this->logAction($_SERVER['REQUEST_URI'], $entity->id);
	// }

	public function beforeSave(Event $event, Entity $entity, ArrayObject $options)
	{
		// Log::debug('UserActionLogsBehavior afterSave');
		// Log::debug('entity: '.$entity->id);
		// Log::debug(json_encode($entity->getDirty()));
		$this->logAction('Model: '.$_SERVER['REQUEST_URI'], $entity->id, $entity->getDirty(), $entity);
	}

	public function beforeDelete(Event $event, Entity $entity, ArrayObject $options)
	{
		// Log::debug('UserActionLogsBehavior beforeDelete');
		// Log::debug('behavior???');
		// Log::debug('entity: '.$entity);
		$this->logAction('Behavior: '.$_SERVER['REQUEST_URI'], $entity->id);
	}

	public function logAction($file, $entityId = null, $dirtyFields = null, $dirtyEntity = null)
    {
    	global $config;

    	// Log::debug(json_encode($config));

    	// $userActionLogs = TableRegistry::get('userActionLogs');
        $userActionLogs = TableRegistry::getTableLocator()->get('Avalon.UserActionLogs');

    	$userAction = $userActionLogs->newEmptyEntity();

        $userAction->user_id = $config['user_id'];
    	$userAction->controller = $config['controller'];
        $action = $config['controller_action'];
        if ($config['controller'] === 'Pages' && !empty($config['pass'])) {
            $action = $config['pass'][0];
        }
    	$userAction->controller_action = $action;
    	$userAction->file_location = $file;
    	$userAction->entity_id = $entityId;

    	if (!is_null($entityId)) {
    		$plugin = '';
    		if (!is_null($config['plugin'])) {
    			$plugin = $config['plugin'].'.';
    		}
	    	$entities = TableRegistry::getTableLocator()->get($plugin.$userAction->controller);
	    	$entity = $entities->find('all', [
	    		'conditions' => [
	    			'id' => $entityId,
	    		],
	    		'limit' => '1',
	    	])->first();

	    	$displayField = $entities->getdisplayField();
	    	$userAction->entity_display_field = $entity->$displayField;

	        if (!is_null($dirtyEntity) && !empty($dirtyEntity->isDirty())) {
	            $dirtyValues = [];
	            // Log::debug('Dirty fields detected');

	            $changedFields = [];

	            foreach ($dirtyEntity->getDirty() as $field) {
	            	// Log::debug('field '.$field);
	            	// Log::debug('value '.$entity->$field);
	                $dirtyValues[$field] = $dirtyEntity->$field;
	            	$changedFields['old value'][$field] = $entity->$field;
	            	// $changedFields['old'][$field] += 'asdfasdf';
	            }

	            $changedFields += [
	            	'new value' => $dirtyValues,
	            ];

	            // Log::debug(print_r($changedFields, true));

	            // foreach ($dirtyValues as $field) {

	            // }


	            // Log::debug(print_r($dirtyValues, true));
	            // $userAction->dirty_fields = print_r($dirtyValues, true);
	            $userAction->dirty_fields = print_r($changedFields, true);
	        } else {
	        	$entityValues = [];
	        	// Log::debug('No dirty fields detected');
	        	// Log::debug(print_r($entity, true));
	        	// foreach ($entity as $field) {
	        	//     $entityValues[$field] = $dirtyEntity->$field;
	        	// }
	        	// Log::debug(print_r($entityValues, true));
	        	$userAction->dirty_fields = print_r($entity, true);
	        }
    	} else {
    		$entityValues = [];
    		// Log::debug('No dirty fields detected');
    		// Log::debug(print_r($entity, true));
    		// foreach ($entity as $field) {
    		//     $entityValues[$field] = $dirtyEntity->$field;
    		// }
    		// Log::debug(print_r($entityValues, true));
    		$userAction->dirty_fields = print_r($dirtyEntity, true);
    	}
    	// Log::debug(print_r($entity, true));
        // if (!is_null($dirtyEntity)) {

    	$userActionLogs->save($userAction);
    }
}