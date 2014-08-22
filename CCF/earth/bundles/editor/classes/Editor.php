<?php namespace Earth\Editor;
/**
 * Editor
 **
 * 
 * @package       Earth
 * @author        Mario Döring <mario@clancats.com>
 * @version       1.0.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Editor implements Editor_Interface 
{
	/**
	 * The editors raw content
	 *
	 * @var string
	 */
	protected $content = null;
	
	/**
	 * The editors form key
	 *
	 * @var string
	 */
	protected $key = null;
	
	/**
	 * New editor instance constructor
	 * 
	 * @param string 		$key
	 * @return void
	 */
	public function __construct( $key )
	{
		$this->key = $key;
	}
	
	/**
	 * Recive the raw editors content
	 * 
	 * @param string 		$content
	 * @return self
	 */
	public function content( $content )
	{
		$this->content = $content; return $this;
	}
	
	/**
	 * Return the editors frontend view 
	 *
	 * @return CCView
	 */
	public function view()
	{
		return \CCView::create( 'Earth\\Editor::base', array(
			'content' => $this->content,
			'key' => $this->key,
		));
	}
}
