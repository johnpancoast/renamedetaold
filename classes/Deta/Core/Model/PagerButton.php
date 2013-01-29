<?php defined('SYSPATH') OR die('No direct script access.');

abstract class Deta_Core_Model_PagerButton {
	/**
	 * @var string Button text
	 *
	 * @accesc protected
	 */
	protected $text = '';

	/**
	 * @var string Button name
	 *
	 * @accesc protected
	 */
	protected $name = '';

	/**
	 * @var array Button options
	 *
	 * @accesc protected
	 */
	protected $options = array();

	/** 
	 * Render the button
	 *
	 * @abstract
	 * @access public
	 * @return void
	 */
	abstract public function render_button();

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
	 * @param string $button_name The PagerButton to load.
	 * @param string $text The button text.
	 * @param string $link The button link.
	 * @param array $options Button options
	 * @return self
	 */
	public static function factory($name, $text, $link, array $options = array())
	{
		$class = 'Deta_Model_PagerButton_'.$name;
		$obj = new $class($text, $link, $options);
		if ( ! ($obj instanceof Deta_Core_Model_PagerButton))
		{
			throw new Exception('Pager button must extend PagerButton');
		}
		return $obj;
	}
}
