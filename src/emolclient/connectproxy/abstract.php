<?php
/**
* 
* abstract proxy for the EazyCore
* 
* @author Rob van der Burgt
*
*/
abstract class emolclient_connectproxy_abstract
{
	/**
	 *  EazyCore root url
	 * 
	 * @var string $serviceUrl
	 */
	protected $serviceUrl = 'https://core.eazymatch.net';
	
	/**
	 * reference to emolclient_connect instance
	 * 
	 * @var emolclient_connect $emolConnect
	 */
	protected $emolConnect;
	
	/**
	 * servicename this proxy connects to
	 * 
	 * @var string $serviceName
	 */
	protected $serviceName = '';
	
	/**
	 * Maximum number of trys an core call can have ( should be atleast 1 )
	 * 
	 * @var int $maxTrys
	 */
	public $maxTrys = 3;
	
	/**
	 * current retrys issued
	 * 
	 * @var int $tryCount
	 */
	private $tryCount = 0;

	/**
	 * contructe the connection to the eazycore
	 *
	 * @param reference to the emolConnect
	 * @param string $serviceName name of Core service
	 */
	public function __construct(&$emolConnect, $serviceName)
	{
		$this->emolConnect = $emolConnect;
		$this->serviceName 	= $serviceName;
	}
	
	
	/**
	 * magic method to catch all funtion calls
	 */
	public function __call($name, $argu){
		$this->tryCount = 0;
		
		$greatSucces = false;
		
		do {
			$this->tryCount++;
			
			try {
				
				$greatSucces = true;
			} catch ( emolclient_exception $e ) {
				
			}
		} while( $greatSucces == false && $this->tryCount < $this->maxTrys );
		
		$result = $this->doCall( $name, $argu );
		
		return $result;
	}
	
	/**
	 * create an call to the eazycore and return the results
	 * 
	 * @param string $name of method to call
	 * @param mixed[] $argu arguments to pass to the method
	 * 
	 * @return mixed
	 */
	abstract protected function doCall($name, $argu);
}
