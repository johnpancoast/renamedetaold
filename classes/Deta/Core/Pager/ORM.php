<?php defined('SYSPATH') or die('No direct script access.');

class Deta_Core_Pager_ORM extends Deta_Core_Pager implements Deta_Core_Pager_ISearchable {
	protected $sorts = array();
	protected $searches = array();
	protected $limit = 20;
	protected $limit_offset = 0;
	protected $model = NULL;

	public function set_model(Kohana_Model $model)
	{
		$this->model = $model;
		return $this;
	}

	public function get_model()
	{
		return $this->model;
	}

	public function model(Kohana_Model $model = NULL)
	{
		if ( ! $model)
		{
			return $this->get_model();
		}
		return $this->set_model($model);
	}

	public function order_by($field, $ascending = TRUE)
	{
		$this->sorts[$field] = $ascending;
	}

	public function where($field, $op = '=', $value)
	{
		$this->searches[$field] = array($op, $value);
	}

	public function limit($limit)
	{
		$this->limit = $limit;
	}

	public function offset($offset)
	{
		$this->limit_offset = $offset;
	}

	public function set_search_params(array $params)
	{
		if (isset($params['l']))
		{
			$this->limit($params['l']);
		}

		// note that the above limit must be set first
		if (isset($params['p']) && ! empty($params['p']))
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
				// TODO allow the operator to be passed to us.
				$this->where($k, '=', $v);
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

	public function as_array()
	{
		$data = array();

		foreach ($this->searches AS $field => $search)
		{
			$this->model->where($field, $search[0], $search[1]);
		}

		foreach ($this->sorts AS $field => $ascending)
		{
			$this->model->order_by($field, ($ascending ? 'ASC' : 'DESC'));
		}

		// get the count of records before applying the limits
		$this->total_count($this->model->count_all());

		if ($this->limit)
		{
			$this->model->limit($this->limit);
		}

		if ($this->limit_offset)
		{
			$this->model->offset($this->limit_offset);
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

		// set data
		$this->data($data);

		return get_object_vars($this);
	}
}