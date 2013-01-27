<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A collection of field options.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 */
class Deta_Core_Form_Field_Option_Collection extends ArrayObject {
	/**
	 * Constructor.
	 * @access public
	 * @param array $options Field options to load into collection.
	 */
	public function __construct(array $options = array())
	{
		foreach ($options AS $option)
		{
			$this->option($option[0], $option[1], (isset($option[2]) ? $option[2] : FALSE), (isset($option[3]) ? $option[3] : NULL));
		}
	}

	/** 
	 * Factory method for chaining.
	 * @static
	 * @access public
	 * @param array $options Field options to load into collection.
	 */
	public static function factory(array $options = array())
	{
		return new self($options);
	}

	/**
	 * Add an option.
	 * @access public
	 * @param string $value Opiton value.
	 * @param string $text Option text.
	 * @param bool $active Is the field active, as-in, valid or checked.
	 * @param string $option_name Option name.
	 * @return self For chaining.
	 */
	public function option($value, $text, $active = FALSE, $option_name = NULL)
	{
		$this->append(Deta_Form_Field_Option::factory($value, $text, $active, $option_name));
		return $this;
	}

	/**
	 * Set active values.
	 * @access public
	 * @param mixed $values The value(s) to set. Can be array or string.
	 * @param bool $deactivate_others Do we deactivate other values.
	 * @return self For chaining.
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
	 * Add a value to array by key. overrides parent to ensure value is field instance
	 * @access public
	 * @param $index string An array key
	 * @param $value Deta_Core_Form_Field_Option An instance of Deta_Core_Form_Field_Option
	 * @see http://www.php.net/manual/en/arrayobject.append.php
	 */
	public function offsetSet($index, $value)
	{
		if ( ! ($value instanceof Deta_Core_Form_Field_Option))
		{
			throw new Exception('value must be an instance of Deta_Core_Form_Field_Option');
		}
		return parent::offsetSet($index, $value);
	}

	/**
	 * Add a value to array. overrides parent to ensure value is field instance
	 * @access public
	 * @param $value Deta_Core_Form_Field_Option An instance of Deta_Core_Form_Field_Option
	 * @see http://www.php.net/manual/en/arrayobject.append.php
	 */
	public function append($value)
	{
		if ( ! ($value instanceof Deta_Core_Form_Field_Option))
		{
			throw new Exception('value must be an instance of Deta_Core_Form_Field_Option');
		}
		return parent::append($value);
	}
}
