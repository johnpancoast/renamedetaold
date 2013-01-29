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
	/**
	 * @var string Field name
	 *
	 * @access protected
	 */
	protected $name = NULL;

	/**
	 * @var string Field label
	 *
	 * @access protected
	 * @todo allow for array to make different label for form and pager
	 */
	protected $label = NULL;

	/**
	 * @var string Field placeholder (only relevant for form)
	 *
	 * @access protected
	 */
	protected $placeholder = NULL;

	/**
	 * @var array Field options
	 *
	 * @access protected
	 */
	protected $options = array();

	/**
	 * Add a field to our form
	 *
	 * @abstract
	 * @access public
	 * @param Kohana_ORM $orm An ORM model instance
	 * @param Deta_Core_Form $form A Deta form instance to add the field to
	 * @return void
	 */
	abstract public function add_form_field(Kohana_ORM $orm, Deta_Core_Form $form);

	/**
	 * Render a field in a pager
	 *
	 * @abstract
	 * @access public
	 * @param Kohana_ORM $orm An ORM model instance
	 * @return void
	 */
	abstract public function render_pager_field(Kohana_ORM $orm);

	/**
	 * Constructor
	 *
	 * Cannot instantiate class using "new". Use the factory method.
	 *
	 * @access protected
	 * @param string $name Field name
	 * @param string $label Field label name. See @todo.
	 * @param string $placeholder Field placeholder (only relevant in forms).
	 * @param array $options Field options to be passed to field instance.
	 * @todo allow for $label to be array to make different label for form and pager
	 */
	protected function __construct($name, $label = NULL, $placeholder = NULL, array $options = array())
	{
		$this->name = $name;
		$this->label = $label ? $label : ($name ? ucfirst($name) : NULL);
		$this->placeholder = $placeholder;
		$this->options = $options;
	}

	/**
	 * Factory method used for class instantiation.
	 *
	 * @param string $type The field type class to load relative to Deta/Model/Field/*.
	 * @param string $name Field name.
	 * @param string $label Field label name. See @todo.
	 * @param string $placeholder Field placeholder (only relevant in forms).
	 * @param array $options Field options to be passed to field instance.
	 * @todo allow for $label to be array to make different label for form and pager
	 */
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