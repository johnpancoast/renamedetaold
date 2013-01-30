<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_PagerAction_Delete extends Deta_Core_Model_PagerAction {
	public function render_action(array $values = array())
	{
		$class = isset($this->options['css_class']) ? $this->options['css_class'] : '';
		return '<span class="pager_delete_link">'
		. '<form method="POST" action="'.$this->link.'"">'
		. '<input type="hidden" name="id" value="'.$values['id'].'" />'
		. '<button type="submit" class="'.$class.'" onclick="if(!confirm(\'Are you sure you want to delete this entry?\')) { return false; }">Delete</button>'
		. '</form>'
		. '</span>';
	}
}
