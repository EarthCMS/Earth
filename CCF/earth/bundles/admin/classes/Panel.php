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
	 * The panel headers
	 *
	 * @var bool
	 */
	protected $headers = array();
	
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
	 * Add a header item to the panel
	 *
	 * @param string			$header
	 * @return self
	 */
	public function header( $header )
	{
		$args = func_get_args();
		
		$header = array_shift( $args );
		
		if ( is_string( $header ) )
		{
			$method = 'header_'.$header;
			
			if ( method_exists( $this, $method ) )
			{
				$header = call_user_func_array( array( $this, $method ), $args );
			}
		}
		
		$this->headers[] = $header; return $this;
	}
	
	/**
	 * Default seve header
	 *
	 * @return string
	 */
	public function header_save( $form_id )
	{
		return \UI\HTML::a( '<i class="el-icon-ok-circle"></i> '.
			__( 'Earth::common.save' ) )
			->class( 'btn btn-success panel-form-submit-trigger' )
			->data( 'target', $form_id );
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
			'headers' => $this->headers,
		))->render();
		
		return \CCResponse::json( $this->response_json );
	}
}