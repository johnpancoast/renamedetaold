<?php defined('SYSPATH') or die('No direct script access.');

class Deta_Core_Field_Option {
	private $value = NULL;
	private $text = NULL;
	private $active = FALSE;
	private $option_name = NULL;

	public function __construct($value, $text, $active = FALSE, $option_name = NULL)
	{
		$this->value($value);
		$this->text($text);
		$this->active($active);
		$this->option_name($option_name);
	}

	public static function factory($value, $text, $active = FALSE, $option_name = NULL)
	{
		return new self($value, $text, $active, $option_name);
	}

	public function value($value = NULL)
	{
		if ( ! $value)
		{
			return $this->value;
		}
		$this->value = $value;
	}

	public function text($text = NULL)
	{
		if ( ! $text)
		{
			return $this->text;
		}
		$this->text = $text;
	}

	public function active($active = NULL)
	{
		if ($active === NULL)
		{
			return $this->active;
		}
		$this->active = (bool)$active;
	}

	public function option_name($option_name = NULL)
	{
		if ($option_name === NULL)
		{
			return $this->option_name;
		}
		$this->option_name = $option_name;
	}
}