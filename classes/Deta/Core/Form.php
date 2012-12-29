<?php defined('SYSPATH') or die('No direct script access.');

/**
 * form builder
 */
class Deta_Core_Form {
	/**
	 * @var string form action
	 * @access public
	 */
	public $action = NULL;

	/** 
	 * @var string form method
	 * @access public
	 */
	public $method = 'POST';

	/**
	 * @var array form sections
	 * @access public
	 */
	public $sections = array();

	/**
	 * @var array field map of name to index (we leave fields as index'd array for kostache looping purposes)
	 * @access private
	 */
	private $field_map = array();

	/**
	 * construct
	 * @param string $action Form action
	 * @param string $method Form method
	 */
	public function __construct($action = NULL, $method = 'POST')
	{
		$this->action = $action;
		$this->method = $method;
	}

	/**
	 * factory method whose main purpose is for chaining
	 * @access public
	 * @static
	 */
	public static function factory($action = NULL, $method = 'POST')
	{
		return new self($action, $method);
	}

	public function section_input($label, $field)
	{
		if ( ! ($field instanceof Deta_Core_Field) && ! ($field instanceof Deta_Core_Field_Collection))
		{
			throw new Exception('Field must be an instance of Deta_Core_Field or Deta_Core_Field_Collection');
		}

		if ( ! ($field instanceof Deta_Core_Field_Collection))
		{
			$collection = new Deta_Core_Field_Collection;
			$collection->append($field);
		}
		else
		{
			$collection = $field;
		}

		for ($i = 0, $c = count($collection); $i < $c; ++$i)
		{
			$this->field_map[$collection[$i]->name()] = array($label, $i);
		}

		$this->sections[$label] = array(
			'fields' => $collection
		);

		return $this;
	}

	public function field($name)
	{
		$map = $this->field_map[$name];
		return $this->sections[$map[0]]['fields'][$map[1]];
	}

	public function field_key($field, $key, $value = NULL)
	{
		if (isset($this->field_map[$field]))
		{
			$this->fields[$this->field_map[$field]][$key] = $value;
		}
	}

	public function value($field, $value)
	{
		$this->field_key($field, 'value', $value);
	}

	public function values($values)
	{
		foreach ($values as $k => $v)
		{
			$this->value($k, $v);
		}
	}

	public function error($field, $error)
	{
		$this->field_key($field, 'error', $error);
	}

	/** 
	 * set form errors
	 * @param array $errors Should be in format returned by Validation::errors() (field as key, message as value, _external allowed as well)
	 */
	public function errors($errors)
	{
		// loop externals first
		if (isset($errors['_external']))
		{
			foreach ($errors['_external'] as $k => $v)
			{
				$this->error($k, $v);
			}
		}
		foreach ($errors as $k => $v)
		{
			if (isset($this->field_map[$k]))
			{
				$this->error($k, $v);
			}
		}

		return $this;
	}
}