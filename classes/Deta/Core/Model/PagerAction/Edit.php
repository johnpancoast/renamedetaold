<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_PagerAction_Edit extends Deta_Core_Model_PagerAction {
	public function render_action(array $values = array())
	{
		// TODO - this is seen a couple places so could probably be moved to 
		// a static in Deta_Core_model_PagerAction
		$callback = function($found) use ($values)
		{
			return $values[$found[1]];
		};

		$link = preg_replace_callback('/{(\w+)}/u', $callback, $this->link);

		$class = isset($this->options['css_class']) ? $this->options['css_class'] : '';

		return '<span class="pager_link"><a class="'.$class.'" href="'.URL::site($link).'">'.$this->text.'</a></span>';
	}
}
