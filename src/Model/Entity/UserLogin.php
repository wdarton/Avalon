<?php
declare(strict_types=1);

namespace Avalon\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserLogin Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $username
 * @property \Cake\I18n\FrozenTime $created
 * @property int $success
 *
 * @property \Avalon\Model\Entity\User $user
 */
class UserLogin extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'user_id' => true,
        'username' => true,
        'created' => true,
        'success' => true,
        'user' => true,
    ];
}
