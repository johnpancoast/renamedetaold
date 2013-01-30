<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Field_Id extends Deta_Model_Field {
	public function render_pager_field(Kohana_ORM $orm)
	{
		return $orm->{$this->name};
	}

	public function add_form_field(Kohana_ORM $orm, Deta_Core_Form $form)
	{
		$field = Deta_Form_Field::factory('hidden', 'id');
		$field->value($orm->{$this->name});
	}

	public function set_value(Kohana_ORM $orm, $value)
	{
		$orm->{$this->name} = $value;
	}
}
