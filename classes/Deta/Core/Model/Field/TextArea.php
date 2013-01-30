<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Field_TextArea extends Deta_Model_Field {
	public function add_form_field(Kohana_ORM $orm, Deta_Core_Form $form)
	{
		$field = Deta_Form_Field::factory('textarea', $this->name, $this->label, $this->placeholder, $this->options);
		$field->value($orm->{$this->name});
		$form->field($field);
	}

	public function render_pager_field(Kohana_ORM $orm)
	{
		$max = isset($this->options['max_length']) ? $this->options['max_length'] : 100;
		$value = $orm->{$this->name};
		return strlen($value) >= $max ? substr($value, 0, $max).'...' : $value;
	}

	public function set_value(Kohana_ORM $orm, $value)
	{
		$orm->{$this->name} = $value;
	}
}
