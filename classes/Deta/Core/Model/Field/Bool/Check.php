<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Field_Bool_Check extends Deta_Model_Field {
	protected $always_save = TRUE;

	public function add_form_field(Kohana_ORM $orm, Deta_Core_Form $form)
	{
		$form->field(Deta_Form_Field::factory('checkbox', $this->name, $this->label, $this->placeholder, $this->options)
			->options(
				array(
					array(1, 'Yes', $orm->{$this->name} == 1)
				)
			)
		);
	}

	public function render_pager_field(Kohana_ORM $orm)
	{
		return $orm->{$this->name} == 1 ? isset($this->options['pager_image']) ? $this->options['pager_image'] : 'X' : '';
	}

	public function set_value(Kohana_ORM $orm, $value)
	{
		$orm->{$this->name} = $value[0] == 1 ? 1 : 0;
	}
}