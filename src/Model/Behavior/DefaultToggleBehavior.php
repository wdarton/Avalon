<?php
namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\Event\Event;
use ArrayObject;
use Cake\ORM\TableRegistry;
use Cake\Datasource\EntityInterface;

/**
 * DefaultToggle behavior
 */
class DefaultToggleBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
    	$config = $this->config();
    	$default = $config['default'];
    	$table =TableRegistry::get($config['table']);


        if ($entity->$default) {
            // Make sure that this is the only entity set as the default for this user

            $objects = $table->find('all', [
                'conditions' => [
                    'user_id' => $entity->user_id,
                ]
            ]);

            foreach ($objects as $object) {
                if ($object->$default) {
                    $object->$default = 0;
                    $table->save($object);
                }
            }

        }
    }
}
