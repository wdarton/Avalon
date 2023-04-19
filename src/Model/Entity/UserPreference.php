<?php
declare(strict_types=1);

namespace Avalon\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserPreference Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $user_timezone
 */
class UserPreference extends Entity
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
        'user_timezone' => true,
    ];
}
