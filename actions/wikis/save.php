<?php
  // get the form input
  $title = get_input('title');
  $url = get_input('url');
  $api = get_input('api');
  $body = get_input('body');
 
  // create a new blog object
  $wiki = new ElggObject();
  $wiki->subtype = "wiki";
  $wiki->title = $title;
  $wiki->description = $body;
 
  $wiki->access_id = ACCESS_PUBLIC;
 
  // owner is logged in user
  $wiki->owner_guid = elgg_get_logged_in_user_guid();
 
  // save tags as metadata
  $wiki->api = $api;
  $wiki->wikiurl = $url;
 
  // save to database
  $wiki->save();
 
  // forward user to a page that displays the post
  forward($wiki->getURL());
?>