<?php defined('SYSPATH') or die('No direct script access.');

/**
 * A field option.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 */
class Deta_Core_Field_Option {
	/**
	 * @var string Option value.
	 * @access private
	 */
	private $value = NULL;

	/**
	 * @var string Option text.
	 * @access private
	 */
	private $text = NULL;

	/**
	 * @var bool Is the option active, as-in, selected or checked.
	 * @access private
	 */
	private $active = FALSE;

	/**
	 * @var string Option name. Only applicable for some field types.
	 * @access private
	 */
	private $option_name = NULL;

	/** 
	 * Constructor
	 * @access public
	 * @param string $value Option value.
	 * @param string $text Option text.
	 * @param bool $active Is the option active.
	 * @param string $option_name The option name.
	 */
	public function __construct($value, $text, $active = FALSE, $option_name = NULL)
	{
		$this->value($value);
		$this->text($text);
		$this->active($active);
		$this->option_name($option_name);
	}

	/**
	 * Factory method that's mainly as a convenience for chaining
	 * @static
	 * @access public 
	 * @param string $value Option value.
	 * @param string $text Option text.
	 * @param bool $active Is the option active.
	 * @param string $option_name The option name.
	 * @return self
	 */
	public static function factory($value, $text, $active = FALSE, $option_name = NULL)
	{
		return new self($value, $text, $active, $option_name);
	}

	/**
	 * Set or get option value.
	 * @access public
	 * @param string $value The option value. If not set, value is returned.
	 * @return mixed Either the value or self 
	 */
	public function value($value = NULL)
	{
		if ( ! $value)
		{
			return $this->value;
		}
		$this->value = $value;
		return $this;
	}

	/**
	 * Set or get option text.
	 * @access public
	 * @param string $text The option text. If not set, value is returned.
	 * @return mixed Either the text or self
	 */
	public function text($text = NULL)
	{
		if ( ! $text)
		{
			return $this->text;
		}
		$this->text = $text;
		return $this;
	}

	/**
	 * Set or get option 'active'.
	 * @access public
	 * @param mixed $active The option 'active'. If not set, value is returned.
	 * @return mixed Either the active or self
	 */
	public function active($active = NULL)
	{
		if ($active === NULL)
		{
			return $this->active;
		}
		$this->active = (bool)$active;
		return $this;
	}

	/**
	 * Set or get option option_name.
	 * @access public
	 * @param string $option_name The option option_name. If not set, value is returned.
	 * @return mixed Either the option_name or self
	 */
	public function option_name($option_name = NULL)
	{
		if ($option_name === NULL)
		{
			return $this->option_name;
		}
		$this->option_name = $option_name;
		return $this;
	}
}
