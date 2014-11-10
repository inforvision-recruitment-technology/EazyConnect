<?php
/**
* emolclient_connectManager
*/
class emolclient_manager_base extends emolclient_connect
{
	/**
	 * core connection keys
	 */
    protected $config = array(
		'serviceurl' 	=> '',
		'instance' 	=> '',
		'key' 		=> '',
		'secret' 	=> '',
		'debug' 	=> false,
	);

	public function __construct( $config = array() )
	{
		$this->setConfig( $config );
		
		/**
		* construct emolclient_connect with the current configuration
		* 
		* @var emolclient_connect
		*/

		$result = parent::__construct(
            $this->config['serviceurl'],  //core location

            $this->config['key'], //api key

			$this->config['instance'],  //instance name

            $this->config['debug'] //debugging
		);
		
		$this->initialValues();
		
		//return an instance of emolclient_connect
		return $result;
	}
	
	/**
	* rest initial values?
	* 
	*/
	protected function initialValues(){
		$this->resetKey();
	}
	
	/**
	 * set the connection manager configuration array
	 * this is extracted from config.php
	 * this method can only be used before the first getInstance call
	 * 
	 * @param mixed $config
	 */
	public function setConfig( $config, $value = null )
	{
		if ( !is_array( $config ) )
		{
			$config = array( $config => $value );
		}
		
		$this->config = array_merge($this->config, $config);
	}
	
	public function processProxyException( $e )
	{
		if ( $e instanceof emolclient_exception_response )
		{
			// if accesskey is invalid, the session is propably lost, retry in the background
			if ( $e->getCoreErrorCode() == 'accesskey_invalid' ){
				$this->resetKey();
				return $this->get( $e->getServiceName() )->doCall( $e->getMethod(), $e->setArguments()  );
			}
		}
		
		return parent::processProxyException( $e );
	}
	
	/**
	* when a token is returned we need to hash this and keep it for further calls
	* 
	*/
	public function resetKey(){
		$key = $this->config['key'];
		
		$this->setKey( $key );
		$tempToken = $this->get('session')->getToken( $key );
        $tempToken = hash('sha256', $tempToken . $this->config['secret']);
		
		$this->setKey( $tempToken );
	}
	
	public function setToken( $token )
	{
		return $this->setKey( hash('sha256', $token . $this->config['secret']) );
	}
}