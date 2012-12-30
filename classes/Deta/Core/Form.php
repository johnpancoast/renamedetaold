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

	private $fields = array();

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

	public function fields()
	{
		return $this->fields;
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

	public function field($field)
	{
		if (is_string($field))
		{
			return $this->get_field($field);
		}
		elseif ($field instanceof Deta_Core_Field)
		{
			$this->add_field($field);
			return $this;
		}
		else
		{
			throw new Exception('field must be a string to get a field or a Deta_Core_Field instance to add it');
		}
	}

	public function add_field(Deta_Core_Field $field)
	{
		$this->fields[] = $field;
		$this->field_map[$field->name()] = count($this->fields)-1;
		return $this;
	}

	public function custom($html)
	{
		$this->add_field(Deta_Core_Field::factory('html')->value($html));
		return $this;
	}

	public function get_field($name)
	{
		if (isset($this->field_map[$name]) && isset($this->fields[$this->field_map[$name]]))
		{
			return $this->fields[$this->field_map[$name]];
		}
		elseif (isset($this->fields[$this->field_map[$name.'[]']]))
		{
			return $this->fields[$this->field_map[$name.'[]']];
		}
		return NULL;
	}

	public function value($field, $value, $deactivate_others = TRUE)
	{
		$f = $this->field($field);
		if ($f)
		{
			$f->value($value, $deactivate_others);
		}
		return $this;
	}

	public function values($field, $values, $deactivate_others = TRUE)
	{
		$f = $this->field($field);
		if ($f && method_exists($f, 'values'))
		{
			$f->values($values, $deactivate_others);
		}
		return $this;
	}

	public function error($field, $error)
	{
		$f = $this->field($field);
		if ($f)
		{
			$f->error($error);
		}
		return $this;
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
				if (isset($this->field_map[$k]))
				{
					$this->error($k, $v);
				}
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