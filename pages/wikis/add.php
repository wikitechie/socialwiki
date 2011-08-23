<?php
	
    // Load Elgg engine
    include_once(dirname(dirname(dirname(__FILE__))) . "/engine/start.php");
 
    // make sure only logged in users can see this page	
    gatekeeper();
 
    // set the title
    $title = "Add a new wiki";
 
    // start building the main column of the page
    $area2 = elgg_view_title($title);
    
    elgg_pop_breadcrumb();
    elgg_push_breadcrumb(elgg_echo('socialwiki:wikis'));
    elgg_push_breadcrumb(elgg_echo('socialwiki:addwiki'));
    
    $form_vars = array(
		'enctype' => 'multipart/form-data',
		'class' => 'elgg-form-alt',
	);
		 
    // Add the form to this section
    $area2 .= elgg_view_form("wikis/save", $form_vars);
 
    // layout the page
    $body = elgg_view_layout('two_column_left_sidebar', '', $area2);
 
    // draw the page
    echo elgg_view_page($title, $body);
	
?>