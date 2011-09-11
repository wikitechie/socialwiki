<?php 


	echo elgg_view('input/hidden',array('internalname' => 'guid', 'value'=>$vars['guid']));
	
?>
<div>
    <label>Wiki name</label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'title' , 'value' =>  $vars['title'])); ?>
</div>

<div>
	<label><?php echo elgg_echo("wiki:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>

<div>
    <label>Wiki homepage URL</label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'wiki_url',  'value' =>  $vars['wiki_url'])); ?>
</div> 

<div>
    <label>MediaWiki API URL</label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'api',  'value' =>  $vars['api'])); ?>
</div>
 
<div>
    <label><?php echo elgg_echo("body"); ?></label><br />
    <?php echo elgg_view('input/longtext',array('internalname' => 'body', 'value' =>  $vars['body'])); ?>
</div>

<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>