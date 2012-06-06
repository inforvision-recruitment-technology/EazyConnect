<?php
	class emolclient_manager_codeignitersession extends emolclient_manager_base
	{
		private $session = null;
		
		public function __construct( $config )
		{
			// load the codeigniter session library and create reference
			$CI =& get_instance();
			$CI->load->library('session');
			
			$this->session =& $CI->session;
			
			// add default session-key to config, the parent will overwrite this if 
			// present in config
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
			$sessionKey = $this->session->userdata( $this->getSessionKey() );
			
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
			
			$this->session->set_userdata( $this->getSessionKey(), $this->getKey() );
			
			return $result;
		}
		
		public function setKey( $key )
		{
			$this->session->set_userdata( $this->getSessionKey(), $key );
			$result = parent::setKey( $key );
		}
	}