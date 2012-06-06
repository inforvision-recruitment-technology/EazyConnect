<?php
	session_start();

	class emolclient_manager_session extends emolclient_manager_base
	{
		private $session = null;
		
		public function __construct( $config )
		{
			$this->setConfig( 'session-key', 'emol-{instancename}-apihash' );
			
			$result = parent::__construct( $config );
		}
		
		private function getSessionKey()
		{
			$key = $this->config['session-key'];
			$key = str_replace( '{instancename}', $this->config['instance'], $key );

			return $key;
		}
		
		protected function initialvalues()
		{
			$sessionKey = $_SESSION[  $this->getSessionKey() ];
			
			if ( is_string( $sessionKey ) )
			{
				$this->setKey( $sessionKey );
			}
			else
			{
				$this->resetKey();
			}
		}
		
		public function resetKey()
		{
			$result = parent::resetKey();
			
			$_SESSION[ $this->getSessionKey() ] = $this->getKey();
			
			return $result;
		}
		
		public function setKey( $key )
		{
			$_SESSION[ $this->getSessionKey() ] = $key ;
			$result = parent::setKey( $key );
		}
	}