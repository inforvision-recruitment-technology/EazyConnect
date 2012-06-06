<?php
	class emolclient_exception_proxycall extends emolclient_exception
	{
		var $method = null;
		var $serviceName = null;
		var $arguments = null;
		
		public function setMethod( $method )
		{
			$this->method = $method;
		}
		
		public function getMethod()
		{
			return $this->method;
		}
		
		public function setArguments( $ars )
		{
			$this->arguments = $ars;
		}
		
		public function getArguments()
		{
			return $this->arguments;
		}
		
		public function setServiceName( $serviceName )
		{
			$this->serviceName = $serviceName;
		}
		
		public function getServiceName()
		{
			return $this->serviceName;
		}
	}