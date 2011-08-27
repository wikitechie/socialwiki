<?php
elgg_make_sticky_form('wiki_edit');
// get the form input
$values = array(
	'guid'			=> (int)get_input('guid'),
	'title'			=> get_input('title'),
	'url'			=> sw_validate_url(get_input('url')),
	'api'			=> sw_validate_url(get_input('api')),
	'description'	=> get_input('body'),
);

$error_forward_url = REFERER;
$error = FALSE;

#FIXME get_input filter xss ??!!
$guid = $values['guid']; 
if(! $guid ){  	
  // create a new wiki object
  $wiki = new ElggObject();  
  $wiki->subtype = "wiki";	
}
else {
	//edit existing wiki object
  	$entity = get_entity($guid);
  	if (elgg_instanceof($entity, 'object', 'wiki') && $entity->canEdit()) {
  		$wiki = $entity;
  	} else {
  		register_error(elgg_echo('wiki:error:wiki_not_found'));
  		forward(get_input('forward', REFERER));
  	}
} 
  
// assigning and checking
$required = array('title','api','url');
foreach ($values as $name => $value) {
	if (in_array($name, $required) && empty($value)) {
		$error = elgg_echo("wiki:error:wrong:$name");
		break;
	}
	$values[$name] = $value;
}

if (!$error) {
	foreach ($values as $name => $value) {
		if (FALSE === ($wiki->$name = $value)) {
			$error = elgg_echo('wiki:error:cannot_save' . "$name=$value");
			break;
		}
	}
}
$wiki->access_id = ACCESS_PUBLIC;
  // owner is logged in user
$wiki->owner_guid = elgg_get_logged_in_user_guid();
 
  // Now see if we have a file icon
if ((isset($_FILES['icon'])) && (substr_count($_FILES['icon']['type'],'image/'))) {
	$prefix = "wikis/".$wiki->guid;

	$filehandler = new ElggFile();
	$filehandler->owner_guid = $wiki->owner_guid;
	$filehandler->setFilename($prefix . ".jpg");
	$filehandler->open("write");
	$filehandler->write(get_uploaded_file('icon'));
	$filehandler->close();
	
	$thumbtiny = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),25,25, true);
	$thumbsmall = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),40,40, true);
	$thumbmedium = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),100,100, true);
	$thumblarge = get_resized_image_from_existing_file($filehandler->getFilenameOnFilestore(),200,200, false);
	
	if ($thumbtiny) {

		$thumb = new ElggFile();
		$thumb->owner_guid = $wiki->owner_guid;
		$thumb->setMimeType('image/jpeg');

		$thumb->setFilename($prefix."tiny.jpg");
		$thumb->open("write");
		$thumb->write($thumbtiny);
		$thumb->close();

		$thumb->setFilename($prefix."small.jpg");
		$thumb->open("write");
		$thumb->write($thumbsmall);
		$thumb->close();

		$thumb->setFilename($prefix."medium.jpg");
		$thumb->open("write");
		$thumb->write($thumbmedium);
		$thumb->close();

		$thumb->setFilename($prefix."large.jpg");
		$thumb->open("write");
		$thumb->write($thumblarge);
		$return = $thumb->getFilenameOnFilestore();
		$thumb->close();
		

		$wiki->icontime = time();
		
		system_message("d".$wiki->icontime."d");
		
	}
}
 
  // save to database
if (! $error) {
	if ($wiki->save()){
		elgg_clear_sticky_form('wiki_edit');
		system_message(elgg_echo('wiki:message:saved'));
		// forward user to a page that displays the post
		forward($wiki->getURL());
	}
	else{
		register_error(elgg_echo('wiki:error:cannot_save'));
		forward($error_forward_url);
	}
}
else{
	register_error($error);
	forward($error_forward_url);
}
	
?>