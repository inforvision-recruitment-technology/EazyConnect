<?php
	/**
	* example to connect with eazymatch and get a list of published jobs
	* 
	* minimal version of php needed : 5.2.17
	*/
	
	//include the autoloader for eazymatch classes
	include_once( dirname(__FILE__) . '/EazyConnect/bootstrap.autoload.php' );
	
	//create a new connection using our private configuration
	$apiConnect = new emolclient_manager_base( include( dirname(__FILE__) . '/EazyConnect/config.php' )  );
	
	
	
	
	/**
	* list all published jobs
	*/
	
	//the limit on how many jobs to fetch, ordered by date
	$limit = 10;
	
	//filters, a manager function 50km round Amsterdam
	$filters = array(
		'free' => array(
			'manager'
		),
		'location' => array(
			'city' => 'Amsterdam',
			'range' => 50000 //range in meters
		)
	);
	
	//default ordering
	$orderBy = '';
	
	//get the results
	//  TheConnection -> TheController -> TheMethod ( Parameters );
	$resultArray = $apiConnect->job->getPublished( $limit , $filters , $orderBy );
	
	var_dump($resultArray);
?>