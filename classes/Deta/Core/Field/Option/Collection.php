<?php defined('SYSPATH') or die('No direct script access.');

class Deta_Core_Field_Option_Collection extends ArrayObject {
	/*
	public function field($type, $name, $label = NULL, $value = NULL, $placeholder = NULL, $error = NULL)
	{
		$this->append(Deta_Core_field::factory($type, $name, $label, $value, $placeholder, $error));
		return $this;
	}
	*/

	public function __construct(array $options = array())
	{
		foreach ($options AS $option)
		{
			$this->option($option[0], $option[1], (isset($option[2]) ? $option[2] : FALSE), (isset($option[3]) ? $option[3] : NULL));
		}
	}

	public static function factory(array $options = array())
	{
		return new self($options);
	}

	public function option($value, $text, $active = FALSE, $option_name = NULL)
	{
		$this->append(Deta_Core_Field_Option::factory($value, $text, $active, $option_name));
		return $this;
	}

	/*
	public function active_keys($keys, $deactivate_others = TRUE)
	{
		foreach ($this AS $k => $v)
		{
			if ((is_string($keys) && $k == $key) || (is_array($keys) && in_array($k, $keys)))
			{
				$v->active(TRUE);
			}
			elseif ($deactivate_others)
			{
				$v->active(FALSE);
			}
		}
		return $this;
	}
	*/

	public function active_values($values, $deactivate_others = TRUE)
	{
		foreach ($this AS $v)
		{
			if ((is_string($values) && $v->value() == $values) || (is_array($values) && in_array($v->value(), $values)))
			{
				$v->active(TRUE);
			}
			elseif ($deactivate_others)
			{
				$v->active(FALSE);
			}
		}
		return $this;
	}

	/**
	 * add a value to array by key. overrides parent to ensure value is field instance
	 * @access public
	 * @param $index string An array key
	 * @param $value Deta_Core_Field_Option An instance of Deta_Core_Field_Option
	 * @see http://www.php.net/manual/en/arrayobject.append.php
	 */
	public function offsetSet($index, $value)
	{
		if ( ! ($value instanceof Deta_Core_Field_Option))
		{
			throw new Exception('value must be an instance of Deta_Core_Field_Option');
		}
		return parent::offsetSet($index, $value);
	}

	/**
	 * add a value to array. overrides parent to ensure value is field instance
	 * @access public
	 * @param $value Deta_Core_Field_Option An instance of Deta_Core_Field_Option
	 * @see http://www.php.net/manual/en/arrayobject.append.php
	 */
	public function append($value)
	{
		if ( ! ($value instanceof Deta_Core_Field_Option))
		{
			throw new Exception('value must be an instance of Deta_Core_Field_Option');
		}
		return parent::append($value);
	}
}