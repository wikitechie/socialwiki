<?php
define('DEBUG',1);
define("WIKI_USERNAME", "");
define("WIKI_PASSWORD", "");
/**
 * 
 * increment one second
 * @param string $base time to be incremented
 * @param string $format
 * @deprecated
 * @return string
 */
function inc_time_str($base,$format="Y-m-d H:i:s")
{
	$temp	=strtotime($base);
	$newtime=strtotime("+1 second",$temp);
	$newtime=gmdate($format,$newtime);
	return $newtime;
}
/**
 * Returns an array of each object member
 * 
 * @param string $member_name the name of the field that you want to extract { e.g: $object->name , name is the member_name}
 * @package socialwiki
 */
function sw_extract($array,$member_name){
	$ext = array();
	foreach ($array as $obj){
		$ext[]=$obj->$member_name;
	}
	return $ext;
}
/**
 * 
 * gets all wikiusers of a wiki as array
 * @param ElggObject $wiki_guid
 * @return array of ElggObject
 */
function sw_get_wikiusers($wiki_guid)
{
	$options = array(
			'type'		=> 'object',
			'subtype'	=> 'wikiuser',
			'metadata_name_value_pairs' => array(
				array('name' => 'wiki_id','value' => $wiki_guid)
			),
			'metadata_name_value_pairs_operator' => 'AND'
	);
	$users = elgg_get_entities_from_metadata($options);
	return $users;
}

/**
 * 
 * gets new recent changes on a wiki .
 * returns array of recent changes
 * @param ElggObject $wiki
 * @param ElggObject $rclimit
 * @return array
 */
function sw_get_recent_changes($wiki,$rclimit=10)
{
	$requester = new Wikimate($wiki->api);
	$data = array(
					'list' => 'recentchanges',
					'rcprop' => 'user|comment|timestamp|title|ids|sizes|redirect|loginfo|flags',
					'rcend' => $wiki->rcstart,		
					'rclimit' => $rclimit
	);
	$results = $requester->query( $data );
	$recent_changes = $results['query']['recentchanges'];
	return $recent_changes;	
}

/**
 * 
 * creates a new wikiactivity object and fills it from a recent change
 * @param ElggOject	$wiki
 * @param int		$actor_guid
 * @param array		$recentChange
 * @return ElggObject
 */
function sw_get_wikiactivity($wiki,$actor_guid,$recentChange){
	$activity = new ElggObject();
	$activity->subtype = "wikiactivity";
	$activity->title =  $recentChange['title'];
	$activity->descritption =  $recentChange['comment'];
	$activity->access_id = ACCESS_PUBLIC;
	$activity->wiki_id = $wiki->guid;
	//$activity->owner_guid = $actor_guid;
	return $activity;
}

/**
 * saves new wikiactivities from a wiki to elgg database
 * @param ElggObject $wiki
 */
function sw_update_wiki($wiki) {
	elgg_load_library("elgg:wikimate");
	
	// looking for wikiusers 
	$users = sw_get_wikiusers($wiki->guid);
	$users_names = sw_extract($users,'wikiuser_name');
	$users_names = array_flip($users_names);// this will be sth like ('Mhd'=>4)
	
	#FIXME do not permit to add users with the same name (file actions/wikiusers/add.php)
	
	// querying wikimate
	$recent_changes = sw_get_recent_changes($wiki); //limit 10
	sw_log(print_r($recent_changes,true));
	if (count($recent_changes) == 0) return false;  // no changes 
	
	foreach ($recent_changes as $recentChange){
		//if it's an old change
		if ((int)$recentChange['rcid'] <= (int)$wiki->last_rcid) continue;
		sw_log("pass_rcid");
		//if change is for non defined wikiuser
		if (! isset($users_names[$recentChange['user']])) continue ;
		sw_log("user checked");
		// searching for author and actor
		$author_id = $users_names[$recentChange['user']];
		$author = $users[$author_id];
		$actor_guid = $author->getOwnerGUID();
		
		// creating wikiactivity Object
		$activity = sw_get_wikiactivity($wiki, $actor_guid, $recentChange);
		
		// adding activity to the river after saving
		if (! $activity->save()) continue;
		add_to_river("river/object/wikiactivity/create",
					"create",
					$actor_guid,
					$activity->guid
		);
		sw_log("saved");
	}
	$rcts=$recent_changes[0]['timestamp'];
	$wiki->rcstart = $rcts;
	$wiki->last_rcid = $recent_changes[0]['rcid'];
	$wiki->save();
	return true;
}
/**
 * updates all wikis
 * saves all new wikiactivities to elgg database
 */
function sw_update_all_wikis() {
	$wikis = elgg_get_entities(array(
				'type' => 'object',
				'subtype' => 'wiki'
				)
	);
	foreach ($wikis as $wiki){
		sw_update_wiki($wiki);
	}
	
}

function sw_log($str){
	if (DEBUG) echo "<pre>$str</pre>";
}