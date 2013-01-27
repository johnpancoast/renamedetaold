<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Deta model.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 * @abstract
 */
class Deta_Core_Model {
	protected $model = NULL;
	protected $model_id = NULL;
	public $object = NULL;

	/**
	 * Constructor.
	 *
	 * Use factory method instead.
	 *
	 * @access protected
	 */
	protected function __construct($id = NULL)
	{
		$this->object = ORM::factory($this->model, $id);
	}

	/**
	 * Factory method.
	 * @access public
	 * @param string $deta_model The deta model to load.
	 * @param int $id The model object id
	 * @return self
	 */
	public static function factory($deta_model = NULL, $id = NULL)
	{
		$class = 'Deta_Model_'.$deta_model;
		$obj = new $class($id);
		if ( ! ($obj instanceof Deta_Model))
		{
			throw new Exception('Deta model must extend Deta_Model');
		}
		return $obj;
	}

	public function get_form()
	{
		if ( ! ($this->object instanceof ORM))
		{
			throw new Exception('Deta_Model\'s object must be an instance of ORM');
		}

		$form = Deta_Form::factory();

		foreach ($this->form_fields() AS $f)
		{
			$f->add_field($this->object, $form);
		}

		return $form;
	}
}