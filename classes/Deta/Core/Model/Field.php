<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Deta model field.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 * @abstract
 */
abstract class Deta_Core_Model_Field {
	protected $name = NULL;
	protected $label = NULL;
	protected $placeholder = NULL;
	protected $options = array();

	abstract public function add_form_field(Kohana_ORM $orm, Deta_Core_Form $form);
	abstract public function render_pager_field(Kohana_ORM $orm);

	protected function __construct($name, $label = NULL, $placeholder = NULL, array $options = array())
	{
		$this->name = $name;
		$this->label = $label ? $label : ($name ? ucfirst($name) : NULL);
		$this->placeholder = $placeholder;
		$this->options = $options;
	}

	public static function factory($type, $name, $label = NULL, $placeholder = NULL, array $options = array())
	{
		$class = 'Deta_Model_Field_'.$type;
		$obj = new $class($name, $label, $placeholder, $options);
		if ( ! ($obj instanceof Deta_Core_Model_Field))
		{
			throw new Exception('Deta model field must be an instance of Deta_Core_Model_field');
		}
		return $obj;
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
}