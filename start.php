<?php

elgg_register_event_handler('init', 'system', 'socialwiki_init');

elgg_register_action("wikis/save", dirname(__FILE__) . "/actions/wikis/save.php");

elgg_register_action("wikis/delete", dirname(__FILE__) . "/actions/wikis/delete.php");

elgg_register_page_handler('socialwiki', 'socialwiki_page_handler');
 
function socialwiki_init() {
	// add a site navigation item
	$item = new ElggMenuItem('wikis', 'Wikis', 'socialwiki/wikis/all');
	elgg_register_menu_item('site', $item);
} 
 
function socialwiki_page_handler($segments) {

	//wiki management pages
    if ($segments[0] == 'wikis') {
		switch($segments[1]) {
			case 'add':
				include (dirname(__FILE__) . '/pages/wikis/add.php');
				break;
				
			case 'manage':			
				include (dirname(__FILE__) . '/pages/wikis/manage.php');
				break;
				
			case 'all':
				include (dirname(__FILE__) . '/pages/wikis/all.php');				
				break;
				
			default: //then we have a wiki name
				$wikiname = $segments[1];
				$type = $segments[2];
				$wikipage = $segments[3];
				
				//connecting with MediaWiki API
				$wiki = get_entity($wikiname);						
						$_GET["api"] = $wiki->api;
						$_SERVER['REQUEST_METHOD']="GET";
						include ('wikimate/globals.php');
						$requester = new Wikimate();
						$page = $requester->getPage($wikipage);
				
				switch ($type){
					case "view":
						include (dirname(__FILE__) . '/pages/wikis/view.php');				
						break;

					case "edit":
						break;
						
					case "recentchanges":
						include (dirname(__FILE__) . '/pages/wikis/recentchanges.php');			
						break;
				}				
				
				break;
			}
		}
	
	//view page
	else {
	
	}
	
}

?>