<?php
namespace Avalon\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\I18n\FrozenDate;
use Cake\Event\Event;
use ArrayObject;
use Cake\Error\Debugger;

/**
 * MySQLDateConversion behavior
 */
class MySQLDateConversionBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
    	'dates' => [],
    ];

    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
    {
        $config = $this->config();

        foreach ($config['dates'] as $date) {
            if (isset($data[$date]) && !empty($data[$date])) {
                $frozenDate = new FrozenDate($data[$date]);
                $data[$date] = $frozenDate->format('Y-m-d');
                Debugger::log($data[$date]);
            }
        }

    }

    public function dateToString($entity)
    {
    	$config = $this->config();

        foreach ($entity as &$data) {
            foreach ($config['dates'] as $date) {
                if (isset($data[$date]) && !empty($data[$date])) {
                    $frozenDate = new FrozenDate(strtotime($data[$date]));
                    $data[$date] = $frozenDate->format('Y-m-d');
                }
            }
        }

        return $entity;
    }
}
