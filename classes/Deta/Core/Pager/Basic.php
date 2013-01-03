<?php defined('SYSPATH') or die('No direct script access.');

class Deta_Core_Pager_Basic extends Deta_Core_Pager {
	public function as_array()
	{
		return get_object_vars($this);
	}
}