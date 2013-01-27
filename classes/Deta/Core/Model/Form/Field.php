<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Deta model form field.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 * @abstract
 */
abstract class Deta_Core_Model_Form_Field {
	protected $name = NULL;
	protected $label = NULL;
	protected $placeholder = NULL;

	abstract public function add_field(Kohana_ORM $orm, Deta_Core_Form $form);

	protected function __construct($name, $label = NULL, $placeholder = NULL)
	{
		$this->name = $name;
		$this->label = $label;
		$this->placeholder = $placeholder;
	}

	public static function factory($type, $name, $label = NULL, $placeholder = NULL)
	{
		$class = 'Deta_Model_Form_Field_'.$type;
		$obj = new $class($name, $label, $placeholder);
		if ( ! ($obj instanceof Deta_Core_Model_Form_Field))
		{
			throw new Exception('Deta model field must be an instance of Deta_Core_model_Form_field');
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
}