<?php

elgg_register_event_handler('init', 'system', 'socialwiki_init');

function socialwiki_init() {
	// add a site navigation item
	$item = new ElggMenuItem('wikis', 'Wikis', 'wiki/all');
	elgg_register_menu_item('site', $item);
	
	//registering entiities
	elgg_register_entity_type("object","wiki");
	elgg_register_entity_type("object","wikiactivity");
	elgg_register_entity_type("object","wikiuser");
	
	//registering actions
	elgg_register_action("wikis/save", dirname(__FILE__) . "/actions/wikis/save.php");
	elgg_register_action("wikis/delete", dirname(__FILE__) . "/actions/wikis/delete.php");
	elgg_register_action("wikiusers/save", dirname(__FILE__) . "/actions/wikiusers/save.php");
	
	//registering libs
	elgg_register_library('elgg:socialwiki', elgg_get_plugins_path() . 'socialwiki/lib/socialwiki.php');
	elgg_register_library('elgg:wikimate', elgg_get_plugins_path() . 'socialwiki/lib/wikimate/globals.php');
	
	elgg_load_library("elgg:socialwiki");
	elgg_register_plugin_hook_handler('cron', 'minute', 'sw_update_all_changes');
	
	//registering page handlers
	elgg_register_page_handler('wiki', 'wiki_page_handler');
	elgg_register_page_handler("wikiuser", "wikiuser_page_handler");
	
	//registering url handlers
	elgg_register_entity_url_handler("object", "wiki", "wiki_url_handler");
	
	// entity menu
	elgg_register_plugin_hook_handler('register', 'menu:entity', 'wiki_entity_menu_setup');
	
	
}
 
 
function wiki_page_handler($segments) {

	switch($segments[0]) {
		case 'add':
			include (dirname(__FILE__) . '/pages/wikis/add.php');
			break;
		case "edit":
			set_input('wiki_guid', $segments[1]);		
			include (dirname(__FILE__) . '/pages/wikis/edit.php');
			break;
		case 'all':
			include (dirname(__FILE__) . '/pages/wikis/all.php');				
			break;
		case 'recentchanges':
			set_input('context',$segments[2]);
			set_input('wiki_guid', $segments[1]);
			include (dirname(__FILE__) . '/pages/wikis/recentchanges.php');
			break;
		case "view":
			set_input('wiki_guid', $segments[1]);
			if (isset($segments[2])) set_input("wiki_page", $segments[2]);
			else set_input("wiki_page", "Main Page");
			#FIXME: "replace Main Page" with the real main page name
			include (dirname(__FILE__) . '/pages/wikis/view.php');	
			break;			
	}
	
	
}

function wikiuser_page_handler($segments) {
	include (dirname(__FILE__) . '/pages/wikiusers/add.php');

}

/**
 * Add particular blog links/info to wiki menu
 */
function wiki_entity_menu_setup($hook, $type, $return, $params) {
	if (elgg_in_context('widgets')) {
		return $return;
	}

	$entity = $params['entity'];
	$handler = elgg_extract('handler', $params, false);
	if ($handler != 'wiki') {
		return $return;
	}

	$options = array(
		'name' => 'permalink',
		'text' => 'Permalink',
		'href' => $entity->getURL(),
		'priority' => 150,
	);
	array_push($return, ElggMenuItem::factory($options));
	
	$options = array(
		'name' => 'url',
		'text' => 'URL',
		'href' => $entity->url,
		'priority' => 150,
	);
	array_push($return, ElggMenuItem::factory($options));	
	
	$options = array(
		'name' => 'recentchanges',
		'text' => 'Recent changes',
		'href' => elgg_normalize_url('activity/all?type=object&subtype=wikiactivity'),
		'priority' => 150,
	);
	array_push($return, ElggMenuItem::factory($options));	
	

	return $return;
}

/**
* Format and return the URL for wikis.
*
* @param ElggObject $entity Blog object
* @return string URL of blog.
*/
function wiki_url_handler($entity) {
	if (!$entity->getOwnerEntity()) {
		// default to a standard view if no owner.
		return FALSE;
	}

	$friendly_title = elgg_get_friendly_title($entity->title);

	return "wiki/view/{$entity->guid}/$friendly_title";
}

?>
