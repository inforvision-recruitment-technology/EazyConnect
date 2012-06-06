<?php
/**
* emolclient_connectManager
*/
class emolclient_manager_base extends emolclient_connect
{
    private static $instanceObj;
    private static $initialConfig = array(
		'instance' 	=> '',
		'key' 		=> '',
		'secret' 	=> '',
		'debug' 	=> false,
	);

    private $emolclientConnectAttempts = 0;
    private $emolclientConnect = null;


	function __construct( $config = array() )
	{
		
	}
	
	/**
	 * set the connection manager configuration array
	 * this is extracted from config.php
	 * this method can only be used before the first getInstance call
	 * 
	 * @param mixed $config
	 */
	public static function setConfig( $config, $value = null )
	{
		if ( !is_array( $config ) )
		{
			$config = array( $config => $value );
		}
		
		self::$initialConfig = array_merge(self::$initialConfig, $config);
	}

    /**
    * @return emolclient_connectManager
    */
    public static function getInstance()
    {
        if (!isset(self::$instanceObj))
        {
        	$config = self::$initialConfig;
            self::$instanceObj = new emolclient_manager_base( self::$initialConfig );
        }
        return self::$instanceObj;
    }
}