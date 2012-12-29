<?php defined('SYSPATH') or die('No direct script access.');

class Deta_Core_Field_Option {
	private $key = NULL;
	private $value = NULL;
	private $active = FALSE;

	public function __construct($key, $value = NULL, $active = FALSE)
	{
		$this->key($key);
		$this->value($value);
		$this->active($active);
	}

	public static function factory($key, $value = NULL, $active = FALSE)
	{
		return new self($key, $value, $active);
	}

	public function key($key = NULL)
	{
		if ( ! $key)
		{
			return $this->key;
		}
		$this->key = $key;
	}

	public function value($value = NULL)
	{
		if ( ! $value)
		{
			return $this->value;
		}
		$this->value = $value;
	}

	public function active($active = NULL)
	{
		if ($active === NULL)
		{
			return $this->value;
		}
		$this->active = (bool)$active;
	}
}