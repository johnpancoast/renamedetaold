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
		$view_data = array(
			'buttons' => array(
				'Add' => array(
					'text' => 'Add New',
					'link' => $this->deta_controller_namespace.'add',
					'options' => array(
						'css_class' => 'btn btn-primary',
						'top' => TRUE,
						'bottom' => TRUE,
					)
				)
			),
			'actions' => array(
				'Edit' => array(
					'text' => 'Edit',
					'link' => $this->deta_controller_namespace.'edit/{id}',
					'options' => array(
						'css_class' => 'btn btn-link btn-small',
					)
				),
				'Delete' => array(
					'text' => 'Delete',
					'link' => $this->deta_controller_namespace.'delete',
					'options' => array(
						'css_class' => 'btn btn-link btn-small',
					)
				) 
			)
		);
		$this->set_view('Deta_Index', $view_data);
	}

	public function action_add()
	{
		// same as edit
		$this->action_edit();
	}

	public function action_edit()
	{
		$id = $this->request->param('id');
		$model = Deta_Model::factory($this->deta_model, $id);
		if ($id && ! $model->object->loaded())
		{
			throw HTTP_Exception::factory(404, 'Not found');
		}
		if ($_POST)
		{
			try
			{
				$model->save($_POST);
				HTTP::redirect($this->deta_controller_namespace);
			}
			catch (ORM_Validation_Exception $e)
			{
				$errors = $e->errors('validation');
				$model->errors($errors);
				Notice::add(Notice::ERROR, 'Please correct the errors below.');
			}
		}

		$view_data = array(
			'model' => $model,
		);

		$this->set_view('Deta_Edit', array('model' => $model));
	}

	public function action_delete()
	{
		$id = $this->request->post('id');
		$obj = ORM::factory($this->deta_model, $id);
		if ($id && $obj->loaded())
		{
			try
			{
				$obj->delete();
			}
			catch (Kohana_Exception $e)
			{
				throw HTTP_Exception::factory(503, 'Error occured.');
			}

			Notice::add(Notice::INFO, 'Item '.$id.' was deleted.');
			HTTP::redirect($this->deta_controller_namespace);
		}
		else
		{
			throw HTTP_Exception::factory(404, 'Not found');
		}
	}
}
