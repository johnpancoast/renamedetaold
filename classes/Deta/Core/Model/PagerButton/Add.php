<?php defined('SYSPATH') OR die('No direct script access.');

class Deta_Core_Model_PagerButton_Add extends Deta_Core_Model_PagerButton {
	public function render_button()
	{
		$class = isset($this->options['css_class']) ? $this->options['css_class'] : '';
		return array(
			'button' => '<a class="'.$class.'" href="'.$this->link.'">'.$this->text.'</a>',
			'top' => isset($this->options['top']) ? $this->options['top'] : TRUE,
			'bottom' => isset($this->options['bottom']) ? $this->options['bottom'] : FALSE,
		);
	}
}
