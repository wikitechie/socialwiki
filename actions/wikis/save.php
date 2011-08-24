<?php
  // get the form input
  $title = get_input('title');
  $url = get_input('url');
  $api = get_input('api');
  $body = get_input('body');
  $guid = get_input('guid');
  
  if(!$guid){  	
	  // create a new wiki object
	  $wiki = new ElggObject();  
	  $wiki->subtype = "wiki";	
  }
  else {
  	//edit existing wiki object
  	$wiki = get_entity($guid);
  } 
  
  
  $wiki->title = $title;
  $wiki->description = $body;
 
  $wiki->access_id = ACCESS_PUBLIC;
 
  // owner is logged in user
  $wiki->owner_guid = elgg_get_logged_in_user_guid();
 
  // save tags as metadata
  $wiki->api = $api;
  $wiki->url = $url;
  
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
		$thumb->close();

		$wiki->icontime = time();
		$wiki->thumbnail = $filehandler->getURL();
		system_message("File passed!");
		
	}
}
 
  // save to database
  $wiki->save();
 
  // forward user to a page that displays the post
  forward($wiki->getURL());
?>