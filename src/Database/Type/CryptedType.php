<?php

namespace Avalon\Database\Type;

use Cake\Database\Type\BaseType;
use Cake\Utility\Security;
use Cake\Database\DriverInterface;
use PDO;

class CryptedType extends BaseType
{
	private $prefix = "ENC:";

	public function toDatabase($value, DriverInterface $driver): ?string
	{
		if ($value === null || $value === '') {
			return null;
		}
		$encrypted = $this->prefix . base64_encode(Security::encrypt($value, Security::getSalt()));

		return $encrypted;
	}

	public function toPHP($value, DriverInterface $driver): ?string
	{
		if ($value === null || $value === '') {
			return null;
		}
		if (strpos($value, $this->prefix) === 0) {
			$value = substr($value, strlen($this->prefix));

			return Security::decrypt(base64_decode($value), Security::getSalt());
		} else {
			return $value;
		}
	}

	// Marshals request data into PHP strings
	public function marshal($value): ?string
	{
		if ($value === null || $value === '') {
			return null;
		}

		return (string)$value;
	}
}