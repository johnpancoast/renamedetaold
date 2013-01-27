<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Form_Field_One_Select extends Deta_Model_Form_Field {
	public function add_field(Kohana_ORM $orm, Deta_Core_Form $form)
	{
		// find the options based on model relation
		$options = array();
		foreach ($orm->belongs_to() AS $rel => $arr)
		{
			if (isset($arr['foreign_key']) && $arr['foreign_key'] == $this->name)
			{
				foreach (ORM::factory($arr['model'])->find_all() AS $f)
				{
					$f = $f->as_array();
					$options[] = array(
						$f['id'],
						$f['name'],
						($orm->{$this->name} == $f['id'])
					);
				}
			}
		}
		$field = Deta_Form_Field::factory('select', $this->name, $this->label, $this->placeholder);
		if ( ! empty($options))
		{
			$field->options($options);
		}
		$form->field($field);
	}
}
