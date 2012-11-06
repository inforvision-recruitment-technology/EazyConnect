<?php
/**
 * Provides a proxy to the EazyCore, 
 * 
 * 
 * @author Rob van der Burgt
 *
 */
class emolclient_connect 
{
	/**
	 * Key to use while connecting to the EazyCore
	 * 
	 * @var string $apiKey
	 */
    private $apiKey;
	
	/**
	 * Name of instance to connect to, please use the
	 * constructor to set this
	 * 
	 * @var string $instanceName
	 */
    private  $instanceName;
	
	/**
	 * collection of services contacted
	 * used to set connection keys on change 
	 * 
	 * @var string[] $serviceNames
	 */
    private $serviceNames = array();
	
	/**
	 * should connecproxy's be opened in debug mode ?
	 * 
	 * @var boolean $debug
	 */
    private $debug;
	
	/**
	 * connectproxy to be used 
	 * this defines the connection method with the EazyCore
	 * 
	 * @var string $connectproxyClass
	 */
	protected $connectproxyClass = 'emolclient_connectproxy_php';

    /**
    * contruct the connection to the eazycore
    *
    * @param string $key key to use for requests
    * @param string $instance name of eazymatch instance
    * @param boolean $debug true enables debug mode
    */
    public function __construct($key,$instance, $debug = false)
    {
        $this->apiKey         	= $key;
        $this->instanceName 	= $instance;
        $this->debug 			= $debug;
		
    	// check if apiKey is present and instanceName is not empty
        if ( strlen( $this->apiKey ) < 3 || strlen( $this->instanceName ) < 3 )
        {
        	return;
            throw new emolclient_exception('Eazymatch connection settings incorrect.');
        }
    }

    /**
     * Magic function to autocreate class objects for connect proxys
	 * 
	 * @param string $serviceName
	 * @return emolclient_connectproxy_rest
     */
    public function &__get($serviceName)
    {
        // generate a new emolclient_connectProxy to provide access to the Core controller
        $this->{$serviceName} = new $this->connectproxyClass(
        	$this,
        	$serviceName
		);

        if ( !in_array($serviceName, $this->serviceNames ) )
            $this->serviceNames[] = $serviceName;

        // return the object
        return $this->{$serviceName};
    }

	/**
	 * get the reference tot he service connectproxy
	 * ( essentially the same as asking the public variable )
	 * 
	 * @param string $serviceName
	 * @return emolclient_connectproxy_rest
	 */
    public function get($serviceName)
    {
        if ( in_array($serviceName, $this->serviceNames ) && isset( $this->{$serviceName} ) )
            return $this->{$serviceName};
        else 
            return $this->__get($serviceName);
    }
	
	/**
	 * reset set the key
	 * 
	 * @param string $key
	 */
    public function setKey( $key )
    {
        $this->apiKey = $key;
    }
	
	/**
	 * get the current key
	 * 
	 * @param string $key
	 */
    public function getKey()
    {
        return $this->apiKey;
    }
	
	/**
	 * reset set the instance name
	 * 
	 * @param string $key
	 */
    public function setInstanceName( $instanceName )
    {
        $this->instanceName = $instanceName;
    }
	
	/**
	 * get the instance name
	 * 
	 * @param string $key
	 */
    public function getInstanceName()
    {
       return $this->instanceName;
    }
	
	/**
	 * function wich rethrows all exceptions
	 * this method is overwritten by managers
	 * 
	 * @param Exception
	 */
	public function processProxyException( $e )
	{
		throw $e;
		return null;
	}
	
	
	/**
	 * create an trunk request, see emolclient_trunk class for examples
	 * 
	 * @return emolclient_trunk
	 */
	public function createTrunk()
	{
		return new emolclient_trunk( $this );
	}
}