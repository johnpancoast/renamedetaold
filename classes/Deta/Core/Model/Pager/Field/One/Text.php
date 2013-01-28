<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Pager_Field_One_Text extends Deta_Model_Pager_Field {
	public function render_field(Kohana_ORM $orm)
	{
		foreach ($orm->belongs_to() AS $rel => $arr)
		{
			if (isset($arr['foreign_key']) && $arr['foreign_key'] == $this->name)
			{
				return $orm->{$rel}->name;
			}
		}
	}
}
