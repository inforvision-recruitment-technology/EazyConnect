<?php
/**
 * example to connect with eazymatch and get a published jobs (all data)
 */
header('Content-Type: text/html; charset=utf-8');

include(dirname(__FILE__).'/setup.php');

//get the results seperate
// WRONG WAY
/*
$jobData 			= $apiConnect->job->getFullPublished( 1000 );
$jobTexts 			= $apiConnect->job->getCustomTexts( 1000 );

//combine all job data
$resultArray = array(
    'job' => $jobData,
    'texts' => $jobTexts,
    'competenties' => $jobCompetences
);
*/

$jobId = 1001;
//get the results trunked
//RIGHT WAY
$resultArray = array();
$trunk = new emolclient_trunk($apiConnect);
$resultArray['job'] = & $trunk->request('job', 'getFullPublished', array($jobId));
$resultArray['texts'] = & $trunk->request('job', 'getCustomTexts', array($jobId));
$trunk->execute();

echo '<pre>';
print_r($resultArray);
echo '</pre>';
?>