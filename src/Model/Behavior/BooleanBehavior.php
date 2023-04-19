<?php
namespace Avalon\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Event\Event;
use Cake\ORM\Entity;
use ArrayObject;


class BooleanBehavior extends Behavior
{
	protected $_defaultConfig = [
		'booleans' => ['active'],
	];

	public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options)
	{
		$config = $this->getConfig();

		foreach ($config['booleans'] as $boolean) {

			if (!isset($data[$boolean])) {
				$data[$boolean] = 0;
			}
		}
	}

}