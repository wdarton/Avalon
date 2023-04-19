<?php
declare(strict_types=1);

namespace Avalon\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity
 *
 * @property int $id
 * @property string $label
 * @property string|null $_plugin
 * @property string|null $prefix
 * @property string|null $controller
 * @property string|null $controller_action
 * @property int $sort_order
 * @property int $active
 * @property int $literal
 * @property int $visible
 *
 * @property \Avalon\Model\Entity\Page[] $pages
 */
class Menu extends Entity
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
        'label' => true,
        'icon' => true,
        '_plugin' => true,
        'prefix' => true,
        'controller' => true,
        'controller_action' => true,
        'sort_order' => true,
        'active' => true,
        'literal' => true,
        'visible' => true,
        'pages' => true,
    ];
}
