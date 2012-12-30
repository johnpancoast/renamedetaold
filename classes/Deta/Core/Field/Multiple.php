<?php defined('SYSPATH') or die('No direct script access.');

class Deta_Core_Field_Multiple extends Deta_Core_Field {
	private $options = NULL;

	public function options($options = NULL)
	{
		if ( ! $options)
		{
			return $this->options;
		}
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

	public function option($value, $text, $active = FALSE)
	{
		if ( ! $this->options)
		{
			$this->options = Deta_Core_Field_Option_Collection::factory();
		}
		$this->options->option($value, $text, $active);
		return $this;
	}

	public function value($value = NULL, $deactivate_others = TRUE)
	{
		if ($this->options)
		{
			$this->options->active_values($value, $deactivate_others);
		}
		return $this;
	}

	public function values($values = NULL, $deactivate_others = TRUE)
	{
		return $this->value($values, $deactivate_others);
	}
}
