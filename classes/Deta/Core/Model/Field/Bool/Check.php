<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Field_Bool_Check extends Deta_Model_Field {
	public function add_form_field(Kohana_ORM $orm, Deta_Core_Form $form)
	{
		$form->field(Deta_Form_Field::factory('checkbox', $this->name, $this->label, $this->placeholder)
			->options(
				array(
					array(1, 'Yes', $orm->{$this->name} == 1)
				)
			)
		);
	}

	public function render_pager_field(Kohana_ORM $orm)
	{
		// TODO - possibly make this an image
		return $orm->{$this->name} == 1 ? 'X' : '';
	}
}