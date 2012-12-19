<?php
	/**
	* example to connect with eazymatch and do a subscription (with job_id)
	*/
	
	$rootDir = dirname(dirname(__FILE__));
	
	//include the autoloader for eazymatch classes
	include_once( $rootDir . '/bootstrap.autoload.php' );
	
	//create a new connection using our private configuration
	$apiConnect = new emolclient_manager_base( include( $rootDir . '/config.php' )  );
	
	
	/**
	* create a structure for the subscription, this is just an example. 
	* 
	* The only mandatory fields are: 
	* [Applicant]intakedate
	* [Applicant][Person]firstname
	* [Applicant][Person]lastname
	* array => [Applicant][Person][Emailaddresses]
	* 
	*/
	$newSubscription = array(
		'Applicant' => array(
			'intakedate' => '2012-11-01', //always use this dateformat
			'available' => 1, //1 = yes, 0 = no
			'availablehours' => 40, //numeric
			'availablefrom' => '2012-11-01',
			'availableto' => '2019-11-01',
			'title' => 'Test manager',
			'contactvia' => 'Google',
			'Person' => array(
				'firstname' => 'John',
				'middlename' => '',
				'lastname' => 'Doe',
				'birthdate' => '1978-04-24',
				'gender' => 'm', //m=male, f=female
				'Emailaddresses' => array( //at least 1
					array(
						'id' => -1, //minus 1 will tell the core to set this address as the default address
						'email' => 'johndoe@eazymatch.nl'
					),
					array(
						'id' => null,
						'email' => 'johndoe@eazymatch-at-home.nl'
					)
				),
				'Addresses' => array(
					array(
						'id' => -1, //minus 1 will tell the core to set this address as the default address
						'street' => 'Mainstreet',
						'housenumber' => '1',
						'extension' => 'bis',
						'zipcode' => '1017PR',
						'city' => 'Amsterdam',
					)
					
				),
				'Phonenumbers' => array(
					array(
						'id' => -1, //minus 1 will tell the core to set this address as the default address
						'phonenumber' => '020-123456789',
					),
					array(
						'id' => null,
						'phonenumber' => '06-1234567890',
					)
				),
				'Identifications' => array(
					array(
						'id' => null,
						'experationdate' => '2028-10-01',
						'number' => 'NL28939B0,2373',
					),
				),
				'preferedemailaddress_id' => -1,
				'preferedaddress_id' => -1,
				'preferedphonenumber_id' => -1,
				
			)
		),
		'Profile' => array(
			'Onlineprofile' => array(
				array(
					'url' => 'www.mywebsite.com'
				)
			),
			'Experience' => array(
				array(
					'function' => 'Accountmanager test 1',
					'startdate' => '1998-02-01',
					'enddate' => '2004-02-01',
					'description' => 'My function here was to be an accountmanager',
					'company' => 'Employer way back',
				),
				array(
					'function' => 'Accountmanager test 2',
					'startdate' => '2004-02-01',
					'enddate' => '2010-12-01',
					'description' => 'My second function, now im searching for something new',
					'company' => 'Other company',
				)
			),
			'Schooling' => array(
				array(
					'degree' => 'Havo',
					'startdate' => '1988-02-01',
					'enddate' => '1992-12-01',	
				),
				array(
					'degree' => 'HBO',
					'startdate' => '1992-02-01',
					'enddate' => '1994-02-01',	
				)
			)
		),
		'Documents' => array(
			'CV' => array(
	            'name' => 'Mijn-geupload-CV.doc',
	            'type' => 'doc', //doc / pdf / rtf / txt / docx
	            'content' => 'XXXXXXXXXXX' //base64 encoded content of file !important
	        ),
	        'Picture' => array(
		        'name' => 'Mijn-Pasfoto.jpg',
		        'type' => 'jpg', //jpg,gif,png
		        'content' => 'XXXXXXXXXXX' //base64 encoded content of image !important
		    )
		),
        'Application' => array(
            'job_id' => $jobId,
            'motivation' => 'Motivation textfield entered by subscriber',
            'url' => 'www.myrecruitmentsite.com' //not mandatory
        )
	);
	
	//  TheConnection -> TheController -> TheMethod ( Parameters );
	$result = $apiConnect->applicant->subscription( $newSubscription );
	
	echo '<pre>';
	var_dump($result);
	echo '</pre>';
?>