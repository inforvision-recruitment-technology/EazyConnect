<?php
	/**
	* example to connect with eazymatch and do a company subscription (with applicant_id)
	*/
	
	$rootDir = dirname(dirname(__FILE__));
	
	//include the autoloader for eazymatch classes
	include_once( $rootDir . '/bootstrap.autoload.php' );
	
	//include the data class for companys
	include_once( $rootDir . '/examples/company-data-structure.php' );
	
	//create a new connection using our private configuration
	$apiConnect = new emolclient_manager_base( include( $rootDir . '/config.php' )  );
	
	//create a new instance for the subscription
	$newCompany = new emol_CompanyMutation();
	
	//basis gegegvens
	$newCompany->setCompany(null,'Bedrijfsnaam','Bedrijfsprofiel',null,null,'KVK10202039');
	
	//add a contact
	$newCompany->setContact(null,'Afdeling HR');
	
	//add a person to this contact
	$newCompany->setPerson(null,'Jan','','Jansen','1972-12-30','jan.jansen','Password23','m');
	
	//add a job / function to the company
	$newCompany->setJob('Vacature HR Manager');
	
	//add 2 phonenumbers
	$newCompany->addPhonenumber(null,null,'012-34567890');
	$newCompany->addPhonenumber(null,null,'012-09876543');
	
	//add email
	$newCompany->addEmailaddresses(null,null,'info@new-company.com');
	
	//add a cv, reaction to published applicant
	$newCompany->setApplication(null,1002,'We are very interested in this applicant');
	
	//put it all together, this returns an array wich can be posted to the api
	$subscription = $newCompany->createSubscription();
	
	//send the data to EazyMatch
	$apiConnect->company->subscription($subscription);
	
?>