<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Data pager coupled with Kohana ORM.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 * @abstract
 */
class Deta_Core_Pager_ORM extends Deta_Core_Pager {
	/**
	 * @var Kohana_Model ORM model instance.
	 * @access protected
	 */
	protected $model = NULL;

	/**
	 * @var array An array of where's for ORM query.
	 * @access protected
	 */
	protected $where = array();

	/**
	 * @var array An array of order by's for ORM query.
	 * @access protected
	 */
	protected $order_by = array();

	/**
	 * @var int ORM query limit.
	 * @access protected
	 */
	protected $limit = 20;

	/**
	 * @var int ORM query limit offset.
	 * @access protected
	 */
	protected $limit_offset = 0;

	/**
	 * @var array An array of query operators.
	 * @access protected
	 * @static
	 */
	protected static $operators = array(
		'eq' => '=',
		'ne' => '<>',
		'lt' => '<',
		'lte' => '<=',
		'gt' => '>',
		'gte' => '>=',
		'in' => 'IN',
		'like' => 'LIKE',
	);

	/**
	 * @var string Query string key that all pager values are held in.
	 * @access public
	 * @static
	 */
	public static $query_string_key = 'pgr';

	/**
	 * @var string String that separates a search operator from a search value.
	 * @access public
	 */
	public static $search_operator_separator = ';';

	/**
	 * @var string String that separates multiple search values mainly for IN searches.
	 * @access public
	 * @static
	 */
	public static $search_separator = ',';

	/**
	 * Set ORM model
	 * @access public
	 * @param Kohana_Model $model
	 * @return self
	 */
	public function set_model(Kohana_Model $model)
	{
		$this->model = $model;
		return $this;
	}

	/**
	 * Get ORM model
	 * @access public
	 * @return Kohana_Model
	 */
	public function get_model()
	{
		return $this->model;
	}

	/**
	 * Set or get ORM model.
	 * @access public
	 * @param mixed $model Null makes method as getter. Passing Kohana_Model acts as setter.
	 * @return mixed
	 */
	public function model(Kohana_Model $model = NULL)
	{
		if ( ! $model)
		{
			return $this->get_model();
		}
		return $this->set_model($model);
	}

	/**
	 * Set ORM where
	 * @access public
	 * @param string $field The field.
	 * @param string $op The operator.
	 * @param mixed $value The value to query on.
	 * @return self
	 */
	public function where($field, $op = '=', $value)
	{
		$this->where[$field] = array($op, $value);
		return $this;
	}

	/**
	 * Set ORM order by.
	 * @access public
	 * @param string $field The field.
	 * @param bool $ascending Is the order by ascending? If false, it's descending.
	 * @return self
	 */
	public function order_by($field, $ascending = TRUE)
	{
		$this->order_by[$field] = $ascending;
		return $this;
	}

	/**
	 * Set ORM limit.
	 * @access public
	 * @param int $limit The limit amoint.
	 * @return self
	 */
	public function limit($limit)
	{
		$this->limit = (int)$limit;
		return $this;
	}

	/**
	 * Set ORM limit offset.
	 * @access public
	 * @param int $offset The limit offset amoint.
	 * @return self
	 */
	public function offset($offset)
	{
		$this->limit_offset = (int)max(0, $offset);
	}

	/**
	 * Set the pager's search and sort params from an array of data.
	 *
	 * This will typically be passed an array of $_GET or $_POST data. The
	 * array should be constructed like so.
	 *
	 * 	array(
	 *		// where params
	 *		'q' => array(
	 *			'field' => '<operator>;<value>',
	 *			'otherfield' => '<operator>;<value>,<value>,...',
	 *		),
	 *
	 *		// order by
	 *		's' => array(
	 *			// sort ascending
	 *			'field' => 1,
	 *			// sort descending
	 *			'otherfield' => 0 or empty
	 *		),
	 *
	 *		// page
	 *		'p' => (int),
	 *
	 *		// limit
	 *		'l' => (int),
	 *
	 *		// offset (only applicable if page 'p' wasn't passed)
	 *		'o' => (int)
	 *	)
	 */
	public function set_search_params(array $params)
	{
		if (isset($params['l']))
		{
			$this->limit($params['l']);
		}

		// note that the above limit must be set first
		if (isset($params['p']) && $params['p'] != '')
		{
			$this->page($params['p']);
			$this->offset(($params['p']-1) * $this->limit);
		}
		elseif (isset($params['o']))
		{
			$this->offset($params['o']);
		}

		if (isset($params['q']))
		{
			foreach ($params['q'] AS $k => $v)
			{
				$val = explode(self::$search_operator_separator, $v);
				if (count($val) == 1)
				{
					$op = '=';
					$value = $val[0];
				}
				elseif (count($val) == 2)
				{
					$op = $val[0];
					$value = $val[1];
				}
				if (strpos($value, self::$search_separator) !== FALSE)
				{
					$value = explode(self::$search_separator, $value);
				}

				$this->where($k, $this->get_query_operator($op), $value);
			}
		}
		if (isset($params['s']))
		{
			foreach ($params['s'] AS $k => $v)
			{
				$ascending = $v != '0' ? TRUE : FALSE;
				$this->order_by($k, $ascending);
			}
		}

		return $this;
	}

	/**
	 * construct search params from current search and sort values.
	 * @access public
	 * @return array Constructed how set_search_params() expects array.
	 * @link self::set_search_params()
	 */
	public function get_search_params()
	{
		$ret = array();

		// page
		if ($this->page && $this->page != '')
		{
			$ret['p'] = $this->page;
		}

		// search
		if ( ! empty($this->where))
		{
			foreach ($this->where AS $field => $search)
			{
				$op = $this->get_public_operator($search[0]);
				$value = is_array($search[1]) ? implode(self::$search_separator, $search[1]) : $search[1];
				$ret['q'][$field] = $op.self::$search_operator_separator.$value;
			}
		}

		// order_by
		if ( ! empty($this->order_by))
		{
			foreach ($this->order_by AS $field => $asc)
			{
				$ret['s'][$field] = $asc;
			}
		}

		// limits
		if ( ! empty($this->limit))
		{
			$ret['l'] = $this->limit;
		}

		if ( ! empty($this->limit_offset) && ! isset($ret['p']))
		{
			$ret['o'] = $this->limit_offset;
		}

		return $ret;
	}

	/**
	 * Get an operator suitable for ORM query.
	 * @access public
	 * @param string $public_operator A key in self::$operators.
	 * @return string Operator
	 */
	public function get_query_operator($public_operator = NULL)
	{
		if (isset(self::$operators[$public_operator]))
		{
			$op = self::$operators[$public_operator];
		}
		return isset($op) ? $op : 'eq';
	}

	/**
	 * Get an operator suitable for public query string.
	 * @access public
	 * @param string $public_operator A value in self::$operators.
	 * @return string Operator
	 */
	public function get_public_operator($query_operator = NULL)
	{
		$ops = array_flip(self::$operators);
		if (isset($ops[$query_operator]))
		{
			$op = $ops[$query_operator];
		}
		return isset($op) ? $op : '=';
	}

	/**
	 * Make a link to the pager given our current search/sort and the changed values passed.
	 * @access public
	 * @param int $changed_page Changed page of the link.
	 * @param array $changed_sort Changed sort of the link.
	 * @return string Link.
	 * @uses self::get_search_params()
	 */
	public function make_link($changed_page = NULL, $changed_sort = array())
	{
		$params = $this->get_search_params();
		$page = $changed_page ? $changed_page : $this->page;
		$params['p'] = $changed_page ? $changed_page : $params['p'];
		if ($changed_sort)
		{
			if (is_bool($changed_sort[1]))
			{
				$params['s'][$changed_sort[0]] = $changed_sort[1];
			}
			else
			{
				unset($params['s'][$changed_sort[0]]);
			}
		}
		$params = self::$query_string_key ? array(self::$query_string_key => $params) : $params;
		return '/'.Request::current()->uri().'?'.http_build_query($params);
	}

	/**
	 * Given our current search/sort data, prepare an array of data for pagination.
	 * @access public
	 */
	public function prepare_pagination()
	{
		$page_count = (int)ceil($this->total / $this->limit);
		$page = max(1, min($page_count, $this->page));

		// where we start the loop
		$start_potential = max(1, $page-(floor(($this->page_display_total - 1) / 2)));
		$start = max(1, min(($page_count-$this->page_display_total+1), $start_potential));

		// set our pages
		$this->pagination['first'] = array('page' => 1, 'first' => TRUE, 'active' => TRUE, 'href' => $this->make_link(1), 'disabled' => $page == 1);
		$this->pagination['last'] = array('page' => $page_count, 'last' => TRUE, 'active' => TRUE, 'href' => $this->make_link($page_count), 'disabled' => $page == $page_count);
		$this->pagination['previous'] = array('page' => max($page, 1), 'previous' => TRUE, 'disabled' => (($page-1) > 0 ? FALSE : TRUE), 'href' => $this->make_link($page-1));
		$this->pagination['next'] = array('page' => min($page, $page_count), 'next' => TRUE, 'disabled' => (($page+1 <= $page_count) ? FALSE : TRUE), 'href' => $this->make_link($page+1));
		for ($i = $start, $end = $i + $this->page_display_total; $i < $end && $i <= $page_count; ++$i)
		{
			$this->pagination['pages'][] = array('page' => $i, 'active' => ($i == $page ? TRUE : FALSE), 'href' => $this->make_link($i));
		}
	}

	/**
	 * Given our current search/sort data, prepare the fields adding relevant sort and link data.
	 * @access public
	 */
	public function prepare_fields()
	{
		for ($i = 0, $c = count($this->fields); $i < $c; ++$i)
		{
			$name = $this->fields[$i]['name'];
			if (isset($this->order_by[$name]))
			{
				if ($this->order_by[$name] === TRUE)
				{
					$asc = FALSE;
					$this->fields[$i]['sort_asc'] = TRUE;
				}
				elseif ($this->order_by[$name] === FALSE)
				{
					$asc = NULL;
					$this->fields[$i]['sort_desc'] = TRUE;
				}
			}
			else
			{
				$asc = TRUE;
			}
			$this->fields[$i]['label_href'] = $this->make_link(NULL, array($name, $asc));
		}
	}

	/**
	 * Executes final code, prepares array of data for views.
	 * @access public
	 * @return array An array of data like so...
	 * 	array(
	 *		'fields' => self::$fields,
	 *		'data' => self::$data,
	 *		'pagination' => self::$pagination,
	 *	)
	 */
	public function as_array()
	{
		$data = array();

		$this->set_search_params((array)Request::current()->query(self::$query_string_key));

		foreach ($this->where AS $field => $search)
		{
			$this->model->where($field, $search[0], $search[1]);
		}

		foreach ($this->order_by AS $field => $ascending)
		{
			$this->model->order_by($field, ($ascending ? 'ASC' : 'DESC'));
		}

		// get the count of records before applying the limits
		$this->total($this->model->count_all());

		$page_count = (int)ceil($this->total / $this->limit);
		$params = $this->get_search_params();
		if ( ! isset($params['q']) && ($this->page < 1 || $this->page > $page_count))
		{
			throw HTTP_Exception::factory(404, 'Error');
		}

		// due to ORM's functionality, we have to add these back in
		// after getting our count.
		foreach ($this->where AS $field => $search)
		{
			$this->model->where($field, $search[0], $search[1]);
		}

		foreach ($this->order_by AS $field => $ascending)
		{
			$this->model->order_by($field, ($ascending ? 'ASC' : 'DESC'));
		}

		if ($this->limit)
		{
			$this->model->limit($this->limit);
		}

		if ($this->limit_offset)
		{
			$this->model->offset(min($this->limit_offset, $this->total));
		}

		// get our records and make a nice array
		$res = $this->model->find_all();
		foreach ($res AS $d)
		{
			$row = array();
			foreach ($this->fields AS $f)
			{
				$row[] = $d->{$f['name']};
			}
			$data[] = $row;
		}

		$this->data($data);
		$this->prepare_fields();
		$this->prepare_pagination();

		return get_object_vars($this);
	}
}