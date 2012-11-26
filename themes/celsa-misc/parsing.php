<?php
/*
Template Name: parsing
*/

get_header();


require_once 'GoogleAgenda.php';
require_once 'GoogleAgendaEvent.php';
require_once 'GoogleAgendaException.php';
 


try {
    $oAgenda = new GoogleAgenda("https://www.google.com/calendar/feeds/ovsrjpggq361h5hbmkg4g3ap4c%40group.calendar.google.com/public/basic");
    // Le tableau d'options suivant contient les valeurs par défaut
    $aEvents = $oAgenda->getEvents(array(
        'startmin' => date('Y-m-d'),
        'startmax' => '',
        'sortorder' => 'ascending',
        'orderby' => 'starttime',
        'maxresults' => '10',
        'startindex' => '1',
        'search' => '',
        'singleevents' => 'true',
        'futureevents' => 'false',
        'timezone' => 'Europe/Paris',
        'showdeleted' => 'false'
    ));
 
    foreach ($aEvents as $oEvent) {


		
// Create post object
  $my_post = array(
     'post_title' => $oEvent->getTitle(),
     'post_content' => $oEvent->getDescription(),
     'post_status' => 'draft',
     'post_author' => 1,
     'post_category' => array(1)
  );

 $post_id = wp_insert_post($my_post);

	add_post_meta($post_id, 'Du', $oEvent->getStartDate(), true);
	add_post_meta($post_id, 'Au', $oEvent->getEndDate(), true);


// Insert the post into the database

  
    }
 
    $aEventsNext = $oAgenda->getNextEvents();
}
catch (GoogleAgendaException $e) {
    echo $e->getMessage();

}

echo 'Okay, posté !';

?>
