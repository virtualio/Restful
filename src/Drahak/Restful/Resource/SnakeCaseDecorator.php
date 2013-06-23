<?php
namespace Drahak\Restful\Resource;

use Drahak\Restful\Utils\Strings;

/**
 * SnakeCaseDecorator
 * @package Drahak\Restful\Resource
 * @author Drahomír Hanák
 */
class SnakeCaseDecorator extends Decorator
{

	/**
	 * Get data with converted keys to snake case
	 * @return array|\stdClass|\Traversable|void
	 */
	public function getData()
	{
		$data = parent::getData();
		$this->convertToSnake($data);
		return $data;
	}

	/**
	 * Convert array keys to snake case
	 * @param array|\Traversable $array
	 */
	private function convertToSnake(&$array)
	{
		if ($array instanceof \Traversable) {
			$array = iterator_to_array($array);
		}

		foreach (array_keys($array) as $key) {
			$value = &$array[$key];
			unset($array[$key]);

			$transformedKey = Strings::toSnakeCase($key);
			if (is_array($value) || $value instanceof \Traversable) {
				$this->convertToSnake($value);
			}
			$array[$transformedKey] = $value;
			unset($value);
		}
	}

}