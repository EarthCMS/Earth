<?php namespace Admin;
/**
 * PanelResposne
 **
 * 
 * @package       ClanCats Earth Admin Panel
 * @author        
 * @version       1.0
 * @copyright     2010 - 2014 ClanCats GmbH
 */
class Panel
{
	/**
	 * Panel Response
	 * 
	 * @param string 			$body
	 * @return Panel
	 */
	public static function create( $body = null ) 
	{
		return new static( $body );
	}
	
	/**
	 * Panel close Response
	 * 
	 * @param string 			$body
	 * @return Panel
	 */
	public static function create_close() 
	{
		return static::create()->close( true );
	}
	
	/**
	 * The panel response structure
	 *
	 * @param array
	 */
	protected $response_json = array(
		'body' => '',
		'close' => false,
	);
	
	/**
	 * Does the panel have a close button
	 *
	 * @var bool
	 */
	protected $has_close = true;
	
	/**
	 * The panel topic
	 *
	 * @var bool
	 */
	protected $topic = '';
	
	/**
	 * Panel constructor
	 *
	 * @param string 			$body
	 * @return void
	 */
	public function __construct( $body )
	{
		$this->body( $body );
	}
	
	/**
	 * Set the reponse body
	 *
	 * @param string			$body
	 * @return self
	 */
	public function body( $body )
	{
		$this->response_json['body'] = $body; return $this;
	}
	
	/**
	 * Set the reponse body
	 *
	 * @param bool			$tf
	 * @return self
	 */
	public function close( $tf = true )
	{
		$this->response_json['close'] = (bool) $tf;  return $this;
	}
	
	/**
	 * Add a close button to the panel
	 *
	 * @param bool			$tf
	 * @return self
	 */
	public function close_button( $tf = true )
	{
		$this->has_close = (bool) $tf; return $this;
	}
	
	/**
	 * Set the panel topic
	 *
	 * @param bool			$tf
	 * @return self
	 */
	public function topic( $topic = '' )
	{
		$this->topic = $topic; return $this;
	}
	
	/**
	 * Get the CCResponse for the panel
	 *
	 * @return CCResponse
	 */
	public function response()
	{
		$this->response_json['body'] = \CCView::create( 'Admin::panel.view', array(
			'body' => $this->response_json['body'],
			'close' => $this->has_close,
			'topic' => $this->topic,
		))->render();
		
		return \CCResponse::json( $this->response_json );
	}
}