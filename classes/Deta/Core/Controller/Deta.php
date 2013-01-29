<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Deta CRUD controller
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 */
class Deta_Core_Controller_Deta extends Controller_Base {
	protected $deta_model = NULL;
	protected $deta_controller_namespace = NULL;

	public function before()
	{
		if ( ! $this->deta_model || ! $this->deta_controller_namespace)
		{
			throw new Exception('Must set deta controller params.');
		}
	}

	public function action_index()
	{
		$this->set_view('Deta_Index');
	}

	public function action_add()
	{
		// same as edit
		$this->action_edit();
	}

	public function action_edit()
	{
		$model = Deta_Model::factory($this->deta_model, $this->request->param('id'));
		if ($_POST)
		{
			try
			{
				$model->save($_POST);
				HTTP::redirect($this->deta_controller_namespace.'index');
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('validation');
				$model->errors($errors);
				Notice::add(Notice::ERROR, 'Please correct the errors below.');
			}
		}

		$this->set_view('Deta_Edit', array('model' => $model));
	}
}
