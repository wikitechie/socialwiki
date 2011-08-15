<?php
  // get the form input
  $title = get_input('title');
  $body = get_input('body');
  $tags = string_to_tag_array(get_input('tags'));
 
  // create a new blog object
  $blogpost = new ElggObject();
  $blogpost->subtype = "myblog";
  $blogpost->title = $title;
  $blogpost->description = $body;
 
  // for now make all blog posts public
  $blogpost->access_id = ACCESS_PUBLIC;
 
  // owner is logged in user
  $blogpost->owner_guid = elgg_get_logged_in_user_guid();
 
  // save tags as metadata
  $blogpost->tags = $tags;
 
  // save to database
  $blogpost->save();
 
  // forward user to a page that displays the post
  forward($blogpost->getURL());
?>