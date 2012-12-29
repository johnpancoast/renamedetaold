<?php defined('SYSPATH') or die('No direct script access.');

class Deta_Core_Field_Multiple extends Deta_Core_Field {
	private $options = NULL;

	public function options($options)
	{
		if (array($options))
		{
			$options = Deta_Core_Field_Option_Collection::factory($options);
		}
		elseif ( ! ($options instanceof Deta_Core_Field_Option_Collection))
		{
			throw new Exception('options must be an array or an instance of Deta_Core_Field_Option_Collection');
		}
		$this->options = $options;
		return $this;
	}

	public function option($key, $value, $active = FALSE)
	{
		if ( ! $this->options)
		{
			$this->options = Deta_Core_Field_Option_Collection::factory();
		}
		$this->options->option($key, $value, $active);
	}

	public function value($value = NULL)
	{
		if ($this->options)
		{
			$this->options->active_values($value);
		}
	}
}
