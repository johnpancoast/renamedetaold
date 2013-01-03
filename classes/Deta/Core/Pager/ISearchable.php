<?php defined('SYSPATH') or die('No direct script access.');

interface Deta_Core_Pager_ISearchable {
	public function order_by($field, $ascending = TRUE);
	public function where($field, $op = '=', $value);
	public function limit($limit);
	public function offset($offset);
	public function set_search_params(array $array);
}