<?php
declare(strict_types=1);

namespace Avalon\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity
 *
 * @property int $id
 * @property int $role_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string $username
 * @property string|null $password
 * @property int|null $login_count
 * @property \Cake\I18n\FrozenTime|null $last_logon
 * @property int|null $locked
 * @property bool|null $reset_password
 * @property \Cake\I18n\FrozenTime|null $created
 * @property string|null $created_by
 * @property \Cake\I18n\FrozenTime|null $modified
 * @property string|null $modified_by
 *
 * @property \Avalon\Model\Entity\Role $role
 */
class User extends Entity
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
        'role_id' => true,
        'first_name' => true,
        'last_name' => true,
        'email' => true,
        'username' => true,
        'password' => true,
        'login_count' => true,
        'last_logon' => true,
        'locked' => true,
        'reset_password' => true,
        'created' => true,
        'created_by' => true,
        'modified' => true,
        'modified_by' => true,
        'role' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];

        protected function _getFullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    protected function _setPassword($value)
    {
        if (strlen($value)) {
            $hasher = new DefaultPasswordHasher();

            return $hasher->hash($value);
        }
    }
}
