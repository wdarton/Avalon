<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

/**
 * SystemSetting Entity
 *
 * @property int $id
 * @property string $system_timezone
 * @property string $current_course_id
 *
 * @property \App\Model\Entity\CurrentCourse $current_course
 */
class SystemSetting extends Entity
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
        'system_timezone' => true,
        'current_course_id' => true,
        'current_course' => true
    ];

}
