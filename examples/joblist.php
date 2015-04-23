<?php
/**
 * example to connect with eazymatch and get a list of published jobs
 *
 */
header('Content-Type: text/html; charset=utf-8');

include(dirname(__FILE__) . '/setup.php');

/**
 * list all published jobs
 */

//the limit on how many jobs to fetch, ordered by date
$limit = 10;

//to fetch all competences run $apiConnect->competence->tree();

//filters, a manager function 50km round Amsterdam
$filters = array(
    'free' => array(
        'manager'
    ),
    'location' => array(
        'city' => 'Amsterdam',
        'range' => 50000 //range in meters
    ),
    'compentence'=> array(
        124,187,882,492 //the ids of competences in the competence table     
    )
);

//default ordering
$orderBy = '';

//get the results
//  TheConnection -> TheController -> TheMethod ( Parameters );
$resultArray = $apiConnect->job->getPublished($limit, $filters, $orderBy);

echo '<pre>';
var_dump($resultArray);
echo '</pre>';
?>
