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
		'relationshiop' => 'wiki_member',
		'relationship_guid' => $wiki_guid,				
	);
	
	$users = elgg_get_entities_from_relationship($options);
	
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
	$activity->container_guid = $wiki->guid;
	
	$requester = new Wikimate($wiki->api);
	$data = array(
					'prop' => 'revisions',
					'titles' => $recentChange['title'],
					'rvdiffto' => 'prev'
	);
	$results = $requester->query( $data );
	
	$page = array_pop($results['query']['pages']);
	
	$myrev = array_pop($page['revisions']);
	
	$diff = $myrev['diff']['*'];
		
	$diff = "<table class='diff'>
	<col class='diff-marker' />
	<col class='diff-content' />
	<col class='diff-marker' />
	<col class='diff-content' />". $diff . "</table>";	
		
	$activity->diff = $diff;
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
	
	print_r($users_names);
	
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
	sw_log($wiki->rcstart);
	// returning to the last context

	return true;
}
/**
 * updates all wikis
 * saves all new wikiactivities to elgg database
 */
function sw_update_all_wikis() {
	$context = elgg_get_context();
	// setting cron context to granting WRITE access to wiki Objects
	elgg_set_context("cron_wiki_update");
	$wikis = elgg_get_entities(array(
				'type' => 'object',
				'subtype' => 'wiki'
				)
	);
	foreach ($wikis as $wiki){
		sw_update_wiki($wiki);
	}
	elgg_set_context($context);
}

function sw_log($str){
	if (DEBUG) echo "<pre>$str</pre>";
}

function sw_validate_url($url)
{
	if ( preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url))
		return $url;
	else
		return "";
}
function sw_user_check($username,$password,$wiki_id)
{
	elgg_load_library("elgg:wikimate");
	$wiki=get_entity($wiki_id);
	@$checker= new Wikimate($wiki->api,$username,$password);
	 $error = $checker->getError();
     if (isset($error['login'])) {
		register_error("username or password is invaild !");
		return FALSE;
	}
	
	else{
		system_message("Wikiuser added!");
		return TRUE;
	}
	
}
