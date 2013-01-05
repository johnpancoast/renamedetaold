<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Data pager.
 *
 * This is for gathering and working with lists of data that a view can work with later.
 * You call this class using Deta_Pager::factory('<Driver>');. At present, there's a
 * basic driver that just allows you to set the data but doesn't allow sorting/searching.
 * Then there's an extension for working with ORM models which allows searching, sorting,
 * and paging.
 * 
 * The pager classes do not render html. They prepare an array of data for a view. This
 * allows view template designers to do what they wish.
 *
 *	// pager example using an ORM model
 * 	$pager = Deta_Pager::factory('ORM')
 *		->model(ORM::factory('user'))
 *  	->fields(array(
 *			id, // strings are ok
 *      	array('username', 'Username Label'), // arrays allow labels to be set manually
 *      	array('email', 'Email'),
 *   	))
 *		// executes final code/search, prepares data for view to work with
 *		->as_array();
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 * @abstract
 */
abstract class Deta_Core_Pager {
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
	 * and is up to the class (or the client) to make that happen.
	 *
	 * @access protected
	 * @link self::data()
	 */
	protected $data = array();

	/** 
	 * @var int The page we're on.
	 * @access protected
	 */
	protected $page = 1;

	/**
	 * @var int The total count of "rows".
	 * @access protected
	 */
	protected $total = 0;

	/**
	 * @var int The total number of pages printed in the pagination.
	 *
	 * Setting this to 5 would produce a pagination array like so:
	 * First Prev 1 2 3 4 5 Next Last
	 *
	 * @access protected
	 */
	protected $page_display_total = 5;

	/**
	 * Prepare the pager object as an array.
	 * @access public
	 * @abstract
	 */
	abstract public function as_array();

	/**
	 * Constructor.
	 *
	 * Use factory method instead.
	 *
	 * @access protected
	 */
	protected function __construct()
	{
		// use factory method
	}

	/**
	 * Factory method.
	 * @access public
	 * @param string $driver The driver class to load.
	 * @return self
	 */
	public static function factory($driver = 'basic')
	{
		$class = 'Deta_Pager_'.$driver;
		return new $class;
	}

	/**
	 * Set the pager's fields.
	 *
	 * $fields should contain an array of fields. Each field can either be
	 * a string or an array whose first element is the field and last element
	 * is the field's label.
	 *
	 * @access public
	 * @param array $fields The fields.
	 * @return self
	 */
	public function fields(array $fields)
	{
		foreach ($fields AS $f)
		{
			$f = is_array($f) ? $f : array($f);
			$this->fields[] = array(
				'name' => $f[0],
				'label' => (isset($f[1]) && ! empty($f[1])) ? $f[1] : $f[0]
			);
			$this->field_map[$f[0]] = count($this->fields)-1;
		}
		return $this;
	}


	/**
	 * Set the pager's data.
	 *
	 * This is up to child or client to set. Each element is a "row"
	 * of data. Each row should contain an array of field values. The values
	 * should match the order of fields.
	 *
	 * @access public
	 * @param array $data The array of data.
	 * @return self
	 */
	public function data(array $data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * Set the current page.
	 * @access public
	 * @param int $page The page
	 * @return self
	 */
	public function page($page)
	{
		$this->page = (int)$page;
		return $this;
	}

	/**
	 * Set the total count of "rows".
	 *
	 * This is not the total amount of rows passed to self::date() but instead
	 * is a count of total amount of rows of your entire data set. Useful so we
	 * know how many pages the pager has.
	 *
	 * @access public
	 * @param int $total The total.
	 * @return self
	 */
	public function total($count)
	{
		$this->total = (int)$count;
		return $this;
	}
}
