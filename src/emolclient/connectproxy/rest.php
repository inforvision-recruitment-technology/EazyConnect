<?php
/**
* 
* abstract proxy for the EazyCore
* 
* @author Rob van der Burgt
*
*/
abstract class emolclient_connectproxy_rest extends emolclient_connectproxy_abstract
{
	// private method to make a call to the soap object
	public function doCall($method, $argu)
	{
		$this->tryCount++;
		
		$time_start = microtime(true);


		// collect post variables for service
		$fields = array(
			// name of instance
            'instance'	=> urlencode( $this->emolConnect->getInstanceName() ),
            
			// key to use for session
            'key' 		=> $this->emolConnect->getKey()
        );
		
		
		// add arugments for method
		if ( is_array( $argu ) ){
			$argumentCounter = -1;
			
			foreach ( $argu as $argument ){
				$argumentCounter++;
				$fields[ 'argument[' .$argumentCounter . ']' ] = $this->encodeArgument( $argument );
			}
		}
		
		// transform the field format to POST format
		$fields_string = http_build_query( $fields );


		// compile url for apicall
		$url = $this->emolConnect->getServiceUrl() . '/v1/' . $this->serviceName . '/' . $method . '.' . $this->format;


		// get requests and requests to the tool controller should not take long
		$shortRequest = substr($method,0,3) == 'get' || $this->serviceName  == 'tool';
		
		//open connection
		$ch = curl_init();
		
		// configure curl connection for api call
		curl_setopt_array( $ch, array(
			// url for api call
			CURLOPT_URL 				=> $url,
            CURLOPT_SSL_VERIFYPEER 	    => false,

			// add post functionality
			CURLOPT_POST 				=> true,
			CURLOPT_POSTFIELDS 			=> $fields_string,
			
			// optimize connection
			CURLOPT_DNS_CACHE_TIMEOUT 	=> 1800, // cache dns requests 30 minutes ( default = 2 )
			CURLOPT_CONNECTTIMEOUT		=> $shortRequest ? 7 : 119,
			CURLOPT_TIMEOUT				=> $shortRequest ? 8 : 120,
			
			// force returning the result into an variable
			CURLOPT_RETURNTRANSFER 		=> true
		) );
		
		
		// execute the api call
		$apiResponse= curl_exec($ch);


		// check if connection error occured
		if( curl_errno($ch) )
		{
			//close connection
			curl_close($ch);
		
		
			// check if this call has trys left
			if ( $this->tryCount < $this->maxTrys )
			{
				// reconnect on connection error
				// wait for 50 miliseconds
				usleep( 50000 );
				
				// reconnect
				return $this->doCall( $method, $argu );
			}
			else
			{
				$e = new emolclient_exception_proxycall('Proxycall prevented, maximum tries reached, core connection failed');
				$e->setInstanceName( $fields['instance'] );
				$e->setServiceName( $this->serviceName );
				$e->setMethod( $method );
				$e->setArguments( $argu );
				
				return $this->emolConnect->processProxyException( $e );
			}
		} 
		else
		{
			//close connection
			curl_close($ch);
		}
		
		// decode the result
		$apiOutput = $this->decodeResult( $apiResponse );

		$time_end = microtime(true);
		$time = $time_end - $time_start;
		
		
		// return good results inmediatly
		if ( is_array( $apiOutput ) && array_key_exists( 'success', $apiOutput ) && $apiOutput['success'] === true  ){
			
			if ( array_key_exists( 'result', $apiOutput ) ){
				return $apiOutput['result'];
			} else {
				return;
			}
		}
		// api output is not a great success, generate an exception and 
		// let the manager / connect client process the exception
		
		$e = new emolclient_exception_response('EazyCore response error');
		$e->setInstanceName( $fields['instance'] );
		$e->setServiceName( $this->serviceName );
		$e->setMethod( $method );
		$e->setArguments( $argu );
		$e->setOriginalResponse( $apiResponse );
		
		
		// check if api call failed because session needs to be restored
		if ( is_array( $apiOutput ) )
		{
			$e->setOutput( $apiOutput );
		}
		// throw generic response error if error not clear
		return $this->emolConnect->processProxyException( $e );
	}
	
	/**
	 * EazyCore rest request format ( should be php/json/jsonp )
	 * 
	 * @var string $format
	 */
	protected $format;
	
	/**
	 * decodes the api call output
	 * 
	 * @param string $input
	 * @return mixed[]
	 */
	abstract protected function decodeResult( $input );
	
	/**
	 * encodes an argument to an string format
	 * 
	 * @param string $input
	 * @return string
	 */
	abstract protected function encodeArgument( $input );
}