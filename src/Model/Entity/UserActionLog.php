<?php
namespace Avalon\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserActionLog Entity
 *
 * @property int $id
 * @property int $user_id
 * @property string $controller
 * @property string $controller_action
 * @property int $entity_id
 * @property string $file_location
 * @property \Cake\I18n\FrozenTime $created
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Entity $entity
 */
class UserActionLog extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'user_id' => true,
        'controller' => true,
        'controller_action' => true,
        'entity_id' => true,
        'entity_display_field' => true,
        'dirty_fields' => true,
        'file_location' => true,
        'created' => true,
        'user' => true,
        'entity' => true
    ];
}
