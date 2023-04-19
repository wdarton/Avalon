<?php
namespace Avalon\Model\Entity;

use Cake\ORM\Entity;

/**
 * Page Entity
 *
 * @property int $id
 * @property int $menu_id
 * @property string $label
 * @property string $icon
 * @property string $controller
 * @property string $controller_action
 * @property int $sort_order
 * @property bool $active
 *
 * @property \App\Model\Entity\Menu $menu
 */
class Page extends Entity
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
        'menu_id' => true,
        'label' => true,
        'icon' => true,
        '_plugin' => true,
        'prefix' => true,
        'controller' => true,
        'controller_action' => true,
        'sort_order' => true,
        'active' => true,
        'literal' => true,
        'menu' => true
    ];
}
