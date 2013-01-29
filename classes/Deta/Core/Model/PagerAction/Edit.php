<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_PagerAction_Edit extends Deta_Core_Model_PagerAction {
	public function render_action(array $values = array())
	{
		$callback = function($found) use ($values)
		{
			return $values[$found[1]];
		};
		$edit_link = preg_replace_callback('/{(\w+)}/u', $callback, $this->link);
		return '<span class="pager_edit_link"><a href="'.URL::site($edit_link).'">'.$this->text.'</a></span>';
	}
}
