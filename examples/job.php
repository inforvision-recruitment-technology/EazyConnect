<?php
	/**
	* example to connect with eazymatch and get a published jobs (all data)
	*/
	
	$rootDir = dirname(dirname(__FILE__));
	
	//include the autoloader for eazymatch classes
	include_once( $rootDir . '/bootstrap.autoload.php' );
	
	//create a new connection using our private configuration
	$apiConnect = new emolclient_manager_base( include( $rootDir . '/config.php' )  );
	
	//get the results
	//  TheConnection -> TheController -> TheMethod ( Parameters );
	$resultArray = $apiConnect->job->getFullPublished( 1000 );
	
	echo '<pre>';
	var_dump($resultArray);
	echo '</pre>';
?>