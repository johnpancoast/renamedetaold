<?php defined('SYSPATH') or die('No direct script access.');

class Deta_Core_Field_Collection extends ArrayObject {
	public function field($type, $name, $label = NULL, $value = NULL, $placeholder = NULL, $error = NULL)
	{
		$this->append(Deta_Core_field::factory($type, $name, $label, $value, $placeholder, $error));
		return $this;
	}

	public static function factory()
	{
		return new self;
	}

	/**
	 * add a value to array by key. overrides parent to ensure value is field instance
	 * @access public
	 * @param $index string An array key
	 * @param $value Deta_Core_Field An instance of Deta_Core_Field
	 * @see http://www.php.net/manual/en/arrayobject.append.php
	 */
	public function offsetSet($index, $value)
	{
		if ( ! ($value instanceof Deta_Core_Field))
		{
			throw new Exception('value must be an instance of Deta_Core_Field');
		}
		return parent::offsetSet($index, $value);
	}

	/**
	 * add a value to array. overrides parent to ensure value is field instance
	 * @access public
	 * @param $value Deta_Core_Field An instance of Deta_Core_Field
	 * @see http://www.php.net/manual/en/arrayobject.append.php
	 */
	public function append($value)
	{
		if ( ! ($value instanceof Deta_Core_Field))
		{
			throw new Exception('value must be an instance of Deta_Core_Field');
		}
		return parent::append($value);
	}
}