<?php
	class emolclient_exception extends Exception {
		private $instanceName = null;
		
		public function setInstanceName( $instanceName )
		{
			$this->instanceName = $instanceName;
		}
		
		public function getInstanceName()
		{
			return $this->instanceName;
		}
		
	}