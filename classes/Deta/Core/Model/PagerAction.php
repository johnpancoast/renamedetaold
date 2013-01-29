<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Deta_Core_Model_PagerAction {
	/**
	 * @var string Action text
	 *
	 * @accesc protected
	 */
	protected $text = '';

	/**
	 * @var string Action name
	 *
	 * @accesc protected
	 */
	protected $name = '';

	/**
	 * @var array Action options
	 *
	 * @accesc protected
	 */
	protected $options = array();

	/** 
	 * Render the action
	 *
	 * @abstract
	 * @access public
	 * @param array $values An array of values passed to action. Will typically be from an ORM instance.
	 * @return void
	 */
	abstract public function render_action(array $values = array());

	/**
	 * Constructor
	 *
	 * Use factory method instead
	 *
	 * @access protected
	 * @param string 
	 */
	protected function __construct($text, $link, array $options = array())
	{
		$this->text = $text;
		$this->link = $link;
		$this->options = $options;
	}

	/**
	 * Factory method.
	 * @access public
	 * @param string $action_name The PagerAction to load.
	 * @param string $text The action text.
	 * @param string $link The action link.
	 * @param array $options Action options
	 * @return self
	 */
	public static function factory($name, $text, $link, array $options = array())
	{
		$class = 'Deta_Model_PagerAction_'.$name;
		$obj = new $class($text, $link, $options);
		if ( ! ($obj instanceof Deta_Core_Model_PagerAction))
		{
			throw new Exception('Pager action must extend PagerAction');
		}
		return $obj;
	}
}
