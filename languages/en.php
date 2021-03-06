<?php
/**
 * Blog English language file.
 *
 */

$english = array(
	'wiki' => 'Wikis',
	'wiki:wikis' => 'Wikis',
	'blog:revisions' => 'Revisions',
	'blog:archives' => 'Archives',
	'blog:blog' => 'Blog',
	'item:object:wiki' => 'Wikis',
	'item:object:wikiactivity' => 'Wiki Activities',
	'item:object:wikiuser' => 'Wiki Users',

	'blog:title:user_blogs' => '%s\'s blogs',
	'blog:title:all_blogs' => 'All site blogs',
	'blog:title:friends' => 'Friends\' blogs',

	'blog:group' => 'Group blog',
	'blog:enableblog' => 'Enable group blog',
	'blog:write' => 'Write a blog post',
	'wikiactivity:show:diff' => 'Show difference',
	'wikiactivity:hide:diff' => 'Hide difference',

	// Editing
	'blog:add' => 'Add blog post',
	'blog:edit' => 'Edit blog post',
	'blog:excerpt' => 'Excerpt',
	'blog:body' => 'Body',
	'blog:save_status' => 'Last saved: ',
	'blog:never' => 'Never',
	'wiki:icon' => 'Wiki Icon',

	// Statuses
	'blog:status' => 'Status',
	'blog:status:draft' => 'Draft',
	'blog:status:published' => 'Published',
	'blog:status:unsaved_draft' => 'Unsaved Draft',

	'blog:revision' => 'Revision',
	'blog:auto_saved_revision' => 'Auto Saved Revision',

	// messages
	'blog:message:saved' => 'Blog post saved.',
	'blog:error:cannot_save' => 'Cannot save blog post.',
	'blog:error:cannot_write_to_container' => 'Insufficient access to save blog to group.',
	'blog:error:post_not_found' => 'This post has been removed, is invalid, or you do not have permission to view it.',
	'blog:messages:warning:draft' => 'There is an unsaved draft of this post!',
	'blog:edit_revision_notice' => '(Old version)',
	'blog:message:deleted_post' => 'Blog post deleted.',
	'blog:error:cannot_delete_post' => 'Cannot delete blog post.',
	'blog:none' => 'No blog posts',
	'blog:error:missing:title' => 'Please enter a blog title!',
	'blog:error:missing:description' => 'Please enter the body of your blog!',
	'blog:error:cannot_edit_post' => 'This post may not exist or you may not have permissions to edit it.',
	'blog:error:revision_not_found' => 'Cannot find this revision.',

	// river
	'river:create:object:wikiactivity' => '%s wikied the page %s in the %s wiki',
	'river:onwikiwall'=> 'on the %s wiki wall',
	'river:comment:object:wikiactivity' => '%s commented on the edit %s',
	'river:comment:object:wiki' => '%s commented on the wiki %s',
	'river:create:object:thewire' => "%s made a post",


	// notifications
	'blog:newpost' => 'A new blog post',

	// widget
	'blog:widget:description' => 'Display your latest blog posts',
	'blog:moreblogs' => 'More blog posts',
	'blog:numbertodisplay' => 'Number of blog posts to display',
	'blog:noblogs' => 'No blog posts',
	
	'socialwiki:wikis' => 'Wikis',
	'socialwiki:addwiki' => 'Add a new wiki',
	'socialwiki:recentchanges' => 'Recent changes',

	'wiki:add'=>'Add a wiki',
	'wiki:all'=>'All wikis',

	'wikiuser'=>'Wikiusers',
	'wikiuser:add'=>'Add a wikiuser',
	'wikiuser:my'=>'My wikiusers',	
	'wikiuser:duplication'=>'You already registered %s!'
);

add_translation('en', $english);
