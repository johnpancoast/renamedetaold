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
	 * Executs ORM query, prepares array of data.
	 * @access public
	 * @return array Array of rendered data from query. Will be passed to self::data().
	 */
	public function render_data()
	{
		if ( ! $this->model || ! ($this->model instanceof Kohana_Model))
		{
			throw new Exception('no model set.');
		}

		$data = array();

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
			$row[] = $this->render_actions($d);
			foreach ($this->fields AS $f)
			{
				if ($f['model_field'])
				{
					$row[] = array(
						'data' => $f['model_field']->render_pager_field($d),
						'escape' => (isset($f['options']['escape']) && $f['options']['escape'] === FALSE) ? FALSE : TRUE
					);
				}
				else
				{
					$row[] = array(
						'data' => $d->{$f['name']}
					);
				}
			}
			$data[] = $row;
		}

		return $data;
	}
}
