<?php defined('SYSPATH') or die('No direct script access.');

class View_Deta_Index extends View_WWW_Base {
	public $pager = NULL;

	public function __construct(array $data = array())
	{
		$model = Deta_Model::factory('Jot_Post');
		$model->buttons($data['buttons']);
		$model->actions($data['actions']);
		$this->pager = $model->get_pager();
	}
}
