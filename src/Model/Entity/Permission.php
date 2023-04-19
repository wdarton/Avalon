<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permission Entity
 *
 * @property int $id
 * @property int|null $role_id
 * @property int|null $aco_id
 * @property bool|null $allowed
 *
 * @property \App\Model\Entity\Role $role
 * @property \App\Model\Entity\Aco $aco
 */
class Permission extends Entity
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
        'role_id' => true,
        'aco_id' => true,
        'allowed' => true,
        'role' => true,
        'aco' => true
    ];
}
