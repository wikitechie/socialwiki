<?php
	
    // Load Elgg engine
    include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
    
    
    $body = "<iframe src='http://wikilogia.net' width='100%' height='300'></iframe>";
    
    $content = elgg_view('page/components/module', array(
    	'title' => 'Social Browser',
    	'header' => 'Social Browser',
    	'body' => $body,
    	'footer' => 'Footer!',
    	'class' => 'elgg-module-popup',
    	
    ));
    
    echo elgg_view_page("Social Browser", "<p>".$content."</p>");
    
    
    
 

?>