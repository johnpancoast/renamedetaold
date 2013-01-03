<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Data pager.
 *
 * This is for gathering and working with lists of data.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 * @abstract
 */
abstract class Deta_Core_Pager {
	/**
	 * @var string The table's css class
	 * @access public
	 */
	public $table_class = 'table table-striped';

	/**
	 * @var array The pager's fields.
	 *
	 * Each element can be a string containing the field or array('field', 'Label').
	 *
	 * @access protected
	 */
	protected $fields = array();

	/** 
	 * @var array A map of field names to their positions in self::$fields.
	 * @access protected
	 */
	protected $field_map = array();

	/**
	 * @var array The pager's data.
	 *
	 * This is simply a multidimensional array. Each row is an array. Each element
	 * in that array should be a value. The order of the values should match self::$fields
	 * and is up to the class (or the client) to make that work.
	 *
	 * @access protected
	 * @link self::data()
	 */
	protected $data = array();

	protected $page = 1;
	protected $total_count = 0;

	public static function factory($driver = 'basic')
	{
		$class = 'Deta_Core_Pager_'.ucfirst($driver);
		return new $class;
	}

	public function data($data)
	{
		$this->data = $data;
	}

	public function fields(array $fields)
	{
		foreach ($fields AS $f)
		{
			$f = is_array($f) ? $f : array($f);
			$this->fields[] = array(
				'name' => $f[0],
				'label' => ( ! empty($f[1]) ? $f[1] : $f[0])
			);
			$this->field_map[$f[0]] = count($this->fields)-1;
		}
		return $this;
	}

	public function page($page)
	{
		$this->page = $page;
	}

	public function total_count($count)
	{
		$this->total_count = $count;
	}

	abstract public function as_array();
}
