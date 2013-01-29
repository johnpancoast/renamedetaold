<?php defined('SYSPATH') or die('No direct script access.');

class View_Deta_Edit {
	public $form = null;
	
	public function __construct($data = array())
	{
		$model = isset($data['model']) ? $data['model'] : Deta_Model::factory('Jot_Post', Request::current()->param('id'));
		$this->id = Request::current()->param('id');
		$this->form = $model->get_form();
	}
}
