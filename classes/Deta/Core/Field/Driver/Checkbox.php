<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Checkbox field.
 *
 * Note it must extend Deta_Core_Field_Multiple since it allows multiple possibilities.
 *
 * @package Deta
 * @author John Pancoast <shideon@gmail.com>
 * @copyright 2012-2013 John Pancoast
 * @license http://opensource.org/licenses/MIT MIT
 */
class Deta_Core_Field_Driver_Checkbox extends Deta_Core_Field_Multiple {
	protected function __construct($type, $name = NULL, $label = NULL, $placeholder = NULL)
	{
		// checkboxes always set name to html array. note we set label by name first because of this.
		$label = $label ? $label : ucfirst($name);
		$name .= '[]';
		parent::__construct($type, $name, $label, $placeholder);
	}
}
