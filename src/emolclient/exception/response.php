<?php
	class emolclient_exception_response extends emolclient_exception_proxycall
	{
		var $originalResponse = null;
		var $apiOutput = null;
		
		public function setOriginalResponse( $originalResponse )
		{
			$this->originalResponse = $originalResponse;
		}
		
		public function getOriginalResponse()
		{
			return $this->originalResponse;
		}
		
		public function setOutput( $apiOutput )
		{
			$this->apiOutput = $apiOutput;
		}
		
		public function getOutput()
		{
			return $this->apiOutput;
		}
		
		public function getCoreErrorCode()
		{
			$apiOutput = $this->getOutput();
			
			if (
				is_array( $apiOutput['result']['error_code'] )
				&& array_key_exists( 'result', $apiOutput ) 
                && is_array( $apiOutput['result'] )
                && array_key_exists( 'error_code', $apiOutput['result'] )
            )
			{
				return $apiOutput['result']['error_code'];
			}
                
			return null;
		}
	}