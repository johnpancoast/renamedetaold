<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Deta model.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 */
class Deta_Core_Model {
	/**
	 * @var string ORM model
	 * @access protected
	 */
	protected $model = NULL;

	/**
	 * @var int ORM model object id
	 * @access protected
	 */
	protected $model_id = NULL;

	/**
	 * @var Kohana_ORM An ORM model instance
	 * @access public
	 */
	public $object = NULL;

	/**
	 * @var array An array of model field errors
	 * @access private
	 */
	private $errors = array();

	/**
	 * Constructor.
	 *
	 * Use factory method instead.
	 *
	 * @access protected
	 */
	protected function __construct($id = NULL)
	{
		$this->model_id = $id;
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
		if ( ! ($obj instanceof Deta_Core_Model))
		{
			throw new Exception('Deta model must extend Deta_Model');
		}
		return $obj;
	}

	/**
	 * Get form
	 * @access public
	 * @return Deta_Core_Form
	 */
	public function get_form()
	{
		if ( ! ($this->object instanceof Kohana_ORM))
		{
			throw new Exception('Deta_Model\'s object must be an instance of ORM');
		}

		$form = Deta_Form::factory();

		foreach ($this->fields() AS $f)
		{
			$f->add_form_field($this->object, $form);
		}

		if ( ! $form->get_field(NULL, 'submit'))
		{
			$form->field(Deta_Form_Field::factory('submit', 'submit'));
		}

		$form->errors($this->errors());

		return $form;
	}

	/**
	 * Get pager
	 * @access public
	 * @return array
	 */
	public function get_pager()
	{
		$fields = $this->fields();
		return Deta_Pager::factory()
			->model($this->object)
			->fields($fields)
			->as_array();
	}

	/**
	 * Set or get field errors
	 *
	 * Should be an array of field key's and their errors
	 *
	 * @access public
	 * @param mixed $errors The error array or NULL to act as a getter
	 * @return mixed
	 */
	public function errors($errors = NULL)
	{
		if ($errors === NULL)
		{
			return $this->errors;
		}
		else
		{
			$this->errors = $errors;
		}
	}

	/**
	 * Save a model object using the passed values.
	 * @param array $values The values with field names as keys and values as values
	 * @access public
	 */
	public function save(array $values)
	{
		foreach ($this->form_fields() AS $f)
		{
			$name = $f->name();
			if (isset($values[$name]))
			{
				$this->object->{$name} = $values[$name];
			}
		}

		try
		{
			$this->object->save();
		}
		catch (ORM_Validation_Exception $e)
		{
			// just rethrow for client to handle stuff
			throw $e;
		}
	}
}
