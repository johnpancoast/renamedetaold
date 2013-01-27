<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A field that has multiple options & values.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 */
class Deta_Core_Form_Field_Multiple extends Deta_Core_Form_Field {
	/**
	 * @var array The field's options
	 * @access private
	 */
	private $options = NULL;

	/**
	 * Set or get field options.
	 * 
	 * $options, if passed, should be in form...
	 * array(
	 *   array('field_value', 'field_text', (booL)active)
	 *   array('field_value', 'field_text', (booL)active)
	 * )
	 * Active represents the field being selected or checked.
	 *
	 * @access public
	 * @param mixed $options Field options. If NULL, method acts as a getter.
	 * @return mixed Deta_Core_Form_Field_Option_Collection instance if acting as a getter or self as a setter (for chaining).
	 */
	public function options($options = NULL)
	{
		if ( ! $options)
		{
			return $this->options;
		}
		if (array($options))
		{
			$options = Deta_Form_Field_Option_Collection::factory($options);
		}
		elseif ( ! ($options instanceof Deta_Core_Form_Field_Option_Collection))
		{
			throw new Exception('options must be an array or an instance of Deta_Core_Form_Field_Option_Collection');
		}
		$this->options = $options;
		return $this;
	}

	/**
	 * Set an option
	 * @access public
	 * @param string $value The option's value.
	 * @param string $text The option's dipslay text.
	 * @param bool $active Is the option active, as-in, selected or checked.
	 * @return self
	 */
	public function option($value, $text, $active = FALSE)
	{
		if ( ! $this->options)
		{
			$this->options = Deta_Form_Field_Option_Collection::factory();
		}
		$this->options->option($value, $text, $active);
		return $this;
	}

	/**
	 * Set the field's value(s).
	 * @access public
	 * @param mixed $value The field's active value's as an array or string.
	 * @param bool $deactivate_others Do we deactivate the other field's that may be presently set.
	 * @return self
	 */
	public function value($value = NULL, $deactivate_others = TRUE)
	{
		if ($this->options)
		{
			$this->options->active_values($value, $deactivate_others);
		}
		return $this;
	}

	/**
	 * Just an alias to value that makes more sense for clients.
	 * @see self::value()
	 */
	public function values($values = NULL, $deactivate_others = TRUE)
	{
		return $this->value($values, $deactivate_others);
	}
}
