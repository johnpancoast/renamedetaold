<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Form_Field_Bool_Checkbox extends Deta_Model_Form_Field {
	public function add_field(Kohana_ORM $orm, Deta_Core_Form $form)
	{
		$form->field(Deta_Form_Field::factory('checkbox', $this->name, $this->label, $this->placeholder)
			->options(
				array(
					array(1, 'Yes', $orm->{$this->name} == 1)
				)
			)
		);
	}
}
