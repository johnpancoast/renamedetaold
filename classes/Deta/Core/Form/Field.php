<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Form field
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 */
class Deta_Core_Form_Field {
	/**
	 * @var string Field name
	 * @access private
	 */
	private $name = NULL;

	/**
	 * @var string Field type
	 * @access private
	 */
	private $type = NULL;

	/**
	 * @var string Field label
	 * @access private
	 */
	private $label = NULL;

	/**
	 * @var string Field value
	 * @access private
	 */
	private $value = NULL;

	/**
	 * @var string Field error
	 * @access private
	 */
	private $error = NULL;

	/**
	 * @var string Field placeholder
	 * @access private
	 */
	private $placeholder = NULL;

	/**
	 * Constructor.
	 *
	 * You should not instantiate this class yourself. You should use {@link self::factory()} instead
	 * which will load an appropriate type driver.
	 *
	 * @access protected
	 * @param string $type Field type.
	 * @param string $name Field name.
	 * @param string $label Field label.
	 * @param string $placeholder Field placeholder.
	 */
	protected function __construct($type, $name = NULL, $label = NULL, $placeholder = NULL)
	{
		$name = $name ? $name : $type.'-noname-'.mt_rand(0000, 9999);
		$this->type($type);
		$this->name($name);
		$this->label($label ? $label : ucfirst($name));
		$this->placeholder($placeholder);

		// a special property for mustache to test for the type
		$this->{$type} = TRUE;
	}

	/**
	 * Factory method.
	 *
	 * Instantiates and returns a Driver class. Use this in place of direct instantiation of ths class.
	 *
	 * @static
	 * @access public 
	 * @param string $type Field type.
	 * @param string $name Field name.
	 * @param string $label Field label.
	 * @param string $placeholder Field placeholder.
	 * @return mixed A field driver class.
	 */
	public static function factory($type, $name = NULL, $label = NULL, $placeholder = NULL)
	{
		$class = 'Deta_Form_Field_Driver_'.ucfirst($type);
		return new $class($type, $name, $label, $placeholder);
	}

	/**
	 * Set or get field name.
	 * @access public
	 * @param string $name Field name.
	 * @return mixed Field name if $name not provided or self otherwise (for chaining).
	 */
	public function name($name = NULL)
	{
		if ($name === NULL)
		{
			return $this->name;
		}
		$this->name = $name;
		return $this;
	}

	/**
	 * Set or get field type.
	 * @access public
	 * @param string $type Field type.
	 * @return mixed Field type if $type not provided or self otherwise (for chaining).
	 */
	public function type($type = NULL)
	{
		if ($type === NULL)
		{
			return $this->type;
		}
		$this->type = $type;
		return $this;
	}

	/**
	 * Set or get field label.
	 * @access public
	 * @param string $label Field label.
	 * @return mixed Field label if $label not provided or self otherwise (for chaining).
	 */
	public function label($label = NULL)
	{
		if ($label === NULL)
		{
			return $this->label;
		}
		$this->label = $label;
		return $this;
	}

	/**
	 * Set or get field placeholder.
	 * @access public
	 * @param string $placeholder Field placeholder.
	 * @return mixed Field placeholder if $placeholder not provided or self otherwise (for chaining).
	 */
	public function placeholder($placeholder = NULL)
	{
		if ($placeholder === NULL)
		{
			return $this->placeholder;
		}
		$this->placeholder = $placeholder;
		return $this;
	}

	/**
	 * Set or get field value.
	 * @access public
	 * @param string $value Field value.
	 * @return mixed Field value if $value not provided or self otherwise (for chaining).
	 */
	public function value($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->value;
		}
		$this->value = $value;
		return $this;
	}

	/**
	 * Set or get field error.
	 * @access public
	 * @param string $error Field error.
	 * @return mixed Field error if $error not provided or self otherwise (for chaining).
	 */
	public function error($error = NULL)
	{
		if ($error === NULL)
		{
			return $this->error;
		}
		$this->error = $error;
		return $this;
	}
}
