<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Form_Field_Text extends Deta_Model_Form_Field {
	public function add_field(Kohana_ORM $orm, Deta_Core_Form $form)
	{
		$field = Deta_Form_Field::factory('text', $this->name, $this->label, $this->placeholder);
		$field->value($orm->{$this->name});
		$form->field($field);
	}
}
