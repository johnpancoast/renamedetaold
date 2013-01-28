<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Deta_Core_Model_Pager_Field {
	protected $name = NULL;
	protected $label = NULL;
	protected $options = array();

	abstract public function render_field(Kohana_ORM $orm);

	protected function __construct($name, $label = NULL, array $options = array())
	{
		$this->name = $name;
		$this->label = $label ? $label : ($name ? ucfirst($name) : NULL);
		$this->options = $options;
	}

	public static function factory($type, $name, $label = NULL, array $options = array())
	{
		$class = 'Deta_Model_Pager_Field_'.$type;
		$obj = new $class($name, $label, $options);
		if ( ! ($obj instanceof Deta_Core_Model_Pager_Field))
		{
			throw new Exception('Deta model field must be an instance of Deta_Core_Model_Pager_Field');
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