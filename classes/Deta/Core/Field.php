<?php defined('SYSPATH') or die('No direct script access.');

class Deta_Core_Field {
	private $name = NULL;
	private $type = NULL;
	private $label = NULL;
	private $value = NULL;
	private $error = NULL;
	private $placeholder = NULL;

	protected function __construct($type, $name, $label = NULL, $value = NULL, $placeholder = NULL, $error = NULL)
	{
		$this->type($type);
		$this->name($name);
		$this->label($label);
		$this->placeholder($placeholder);
		$this->value($value);
		$this->error($error);
	}

	public static function factory($type, $name, $label = NULL, $value = NULL, $placeholder = NULL, $error = NULL)
	{
		$class = 'Deta_Core_Field_Driver_'.ucfirst($type);
		return new $class($type, $name, $label, $value, $placeholder, $error);
	}

	public function name($name = NULL)
	{
		if ($name === NULL)
		{
			return $this->name;
		}
		$this->name = $name;
		return $this;
	}

	public function type($type = NULL)
	{
		if ($type === NULL)
		{
			return $this->type;
		}
		$this->type = $type;
		return $this;
	}

	public function label($label = NULL)
	{
		if ($label === NULL)
		{
			return $this->label;
		}
		$this->label = $label;
		return $this;
	}

	public function placeholder($placeholder = NULL)
	{
		if ($placeholder === NULL)
		{
			return $this->placeholder;
		}
		$this->placeholder = $placeholder;
		return $this;
	}

	public function value($value = NULL)
	{
		if ($value === NULL)
		{
			return $this->value;
		}
		$this->value = $value;
		return $this;
	}

	public function values($values = NULL)
	{
		return $this->value($values);
	}

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
