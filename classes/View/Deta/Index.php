<?php defined('SYSPATH') or die('No direct script access.');

class View_Deta_Index {
	public $pager = NULL;

	public function __construct(array $data = array())
	{
		$model = Deta_Model::factory('Jot_Post');
		$this->pager = $model->get_pager();
	}
}
