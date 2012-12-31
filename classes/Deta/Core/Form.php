<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Form builder
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 */
class Deta_Core_Form {
	/**
	 * @var string Form action
	 * @access public
	 */
	public $action = NULL;

	/** 
	 * @var string Form method
	 * @access public
	 */
	public $method = 'POST';

	/**
	 * @var array Form fields
	 * @access public
	 */
	public $fields = array();

	/**
	 * @var array field map of name to index (we leave fields as index'd array for kostache looping purposes)
	 * @access private
	 */
	private $field_map = array();

	/**
	 * constructor
	 * @access public
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

	/**
	 * Add a field to, or retrieve one from, a form
	 * @access public
	 * @param mixed $field If retrieving a field, pass its string name. If adding a field,
	 * must be an instance of Deta_Core_Field.
	 * @return mixed Either a Deta_Core_Field instance of getting or self if adding.
	 * @uses self::add_field() If adding
	 * @uses self::get_field() If getting
	 */
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

	/**
	 * Add a field to the form
	 * @access public
	 * @param Deta_Core_Field $field
	 * @return self For chaining
	 */
	public function add_field(Deta_Core_Field $field)
	{
		$this->fields[] = $field;
		$this->field_map[$field->name()] = count($this->fields)-1;
		return $this;
	}

	/**
	 * Get a field
	 * @access public
	 * @param string $field The name of the field that we're targeting.
	 * @return mixed Deta_Core_Field if found, NULL otherwise.
	 */
	public function get_field($field)
	{
		if (isset($this->field_map[$field]) && isset($this->fields[$this->field_map[$field]]))
		{
			return $this->fields[$this->field_map[$field]];
		}
		elseif (isset($this->fields[$this->field_map[$field.'[]']]))
		{
			return $this->fields[$this->field_map[$field.'[]']];
		}
		return NULL;
	}

	/** 
	 * Add custom code to the form
	 * @access public
	 * @param string $custom Custom code to be added to the form.
	 * @return self For chaining
	 */
	public function custom($custom)
	{
		$this->add_field(Deta_Core_Field::factory('html')->value($custom));
		return $this;
	}

	/** 
	 * Set a field's value
	 * @access public
	 * @param string $field The name of the field that we're targeting.
	 * @param string $value The value.
	 * @return self For chaining
	 */
	public function field_value($field, $value)
	{
		$f = $this->field($field);
		if ($f)
		{
			$f->value($value);
		}
		return $this;
	}

	/**
	 * Set a field's values.
	 * 
	 * Note that this is only applicable to field's that can have multiple value's (select, radio, checkbox).
	 * 
	 * @access public
	 * @param string $field The name of the field that we're targeting.
	 * @param mixed $values The values.
	 * @param bool $deactivate_others Do we deactivate other value's that were previously set for this field.
	 * @return self For chaining
	 */
	public function field_values($field, $values, $deactivate_others = TRUE)
	{
		$f = $this->field($field);
		if ($f && method_exists($f, 'values'))
		{
			$f->values($values, $deactivate_others);
		}
		return $this;
	}

	/**
	 * Set an error for a field.
	 * @access public
	 * @param string $field The name of the field that we're targeting.
	 * @param string $error The error.
	 * @return self For chaining.
	 */
	public function field_error($field, $error)
	{
		$f = $this->field($field);
		if ($f)
		{
			$f->error($error);
		}
		return $this;
	}

	/** 
	 * Set form values for many fields at once.
	 *
	 * Note that $values should be an array of arrays with keys representing field names and values which are value strings.
	 *
	 * access public
	 * @param array $values Should be in format seen above.
	 * @return self For chaining
	 */
	public function values(array $values)
	{
		foreach ($values AS $k => $v)
		{
			$this->field_value($k, $v);
		}
	}

	/**
	 * Set form errors for many fields at once.
	 *
	 * Note that $errors should be an array of arrays with keys representing field names and values which are error strings.
	 * This field can take an array generated from {@link Validation::errors()}.
	 * 
	 * @access public
	 * @param array $errors Should be in format seen above.
	 * @return self For chaining
	 */
	public function errors(array $errors)
	{
		// loop externals first
		if (isset($errors['_external']))
		{
			foreach ($errors['_external'] as $k => $v)
			{
				if (isset($this->field_map[$k]))
				{
					$this->field_error($k, $v);
				}
			}
		}
		foreach ($errors as $k => $v)
		{
			if (isset($this->field_map[$k]))
			{
				$this->field_error($k, $v);
			}
		}
		return $this;
	}
}
