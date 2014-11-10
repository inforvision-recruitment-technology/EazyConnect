<?php
/**
 * example to connect with eazymatch and get a list of published jobs and details
 * this will perform a single request to the api executing multiple calls
 */
header('Content-Type: text/html; charset=utf-8');


include(dirname(__FILE__).'/setup.php');

//results container
$results = array();

//first fetch all published job ids (all without filter) for filtering see joblist.php
$jobs = $apiConnect->job->getPublishedIds(array());

//create the trunk object
$trunk = new emolclient_trunk($apiConnect);

$i = 0;
foreach ($jobs as $job) {

    // full job
    $results[$i]['fullJob'] = & $trunk->request('job', 'getFullPublished', array($job));

    // all textareas
    $results[$i]['texts'] = & $trunk->request('job', 'getCustomTexts', array($job));

    // competence tree
    $results[$i]['competences'] = & $trunk->request('job', 'getPublishedCompetence', array($job));

    // manager / consultant information
    $results[$i]['manager'] = & $trunk->request('job', 'getManagerPublished', array($job));

    $i++;
}

// execute the trunk request
$trunk->execute();

//dump results
echo '<pre>';
var_dump($results);
echo '</pre>';
?>