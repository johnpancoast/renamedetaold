<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_Pager_Field_Actions extends Deta_Model_Pager_Field {
	public function render_field(Kohana_ORM $orm)
	{
		if ( ! isset($this->options['edit_link']) || ! isset($this->options['add_link']))
		{
			throw new Exception('Action field must have links set');
		}

		$callback = function($found) use ($orm)
		{
			return $orm->{$found[1]};
		};
		$edit_link = preg_replace_callback('/{(\w+)}/u', $callback, $this->options['edit_link']);

		$ret = '<span class="pager_add_link"><a href="'.URL::site($this->options['add_link']).'">Add</a></span> '
		. '<span class="pager_edit_link"><a href="'.URL::site($edit_link).'">Edit</a></span>';
		return $ret;
	}
}
