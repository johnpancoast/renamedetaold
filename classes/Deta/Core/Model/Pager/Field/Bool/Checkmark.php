<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Pager_Field_Bool_Checkmark extends Deta_Model_Pager_Field {
	public function render_field(Kohana_ORM $orm)
	{
		return $orm->{$this->name} == 1 ? 'X' : '';
	}
}
