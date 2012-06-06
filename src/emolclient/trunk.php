<?php
/**
* emolclient_trunk    
*/
Class emolclient_trunk {
	/**
	 * reference to an emolclient_connect instance
	 * 
	 * @var emolclient_connect $emolclient_connect
	 */
    private $emolclient_connect;
	
	/**
	 * collection of core calls to be made during execution
	 * 
	 * @var mixed[] $calls
	 */
    private $calls = array();
	
	/**
	 * collection of responses from the executed call
	 * 
	 * @var mixed[] $calls
	 */
    private $response = array();

    /**
    * request an emolclient_connect object for requesting Trunks
    * 
    * @param emolclient_connect $emolclient_connect
    * @return emolclient_trunk
    */
    public function __construct( &$emolclient_connect ){
        $this->emolclient_connect = $emolclient_connect;
    }

	/**
	 * adds an core call to the request
	 * 
	 * @param string $class name of core class/controller to be called
	 * @param string $method name of core method to be called
	 * @param mixed[] $arguments optional arguments used for the method
	 *  
	 * @return mixed reference to the response
	 */
    public function &request($class, $method, $arguments = array()){
        $this->calls[] = array(
	        'class' => $class,
	        'method' => $method,
	        'arguments' => $arguments
        );

        $this->response[] = null;
        return $this->response[count($this->response) - 1];
    }

	/**
	 * execute the requested core calls
	 */
    public function execute(){
        $responses = $this->emolclient_connect->tool->trunk( $this->calls );

        if( $responses !== null){
            $counter = -1; 
            foreach($responses as $response){
                $counter++;
                $this->response[$counter] = $response;
            }
        } else {
            $this->response = array('error: null response');
        }
    }
}