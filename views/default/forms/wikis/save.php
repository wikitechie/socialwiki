<?php 

$vars['entity'] = get_entity($vars['guid']);
if ($vars['entity'])
	echo elgg_view('input/hidden',array('internalname' => 'guid', 'value'=>$vars['entity']->guid));
	
?>
<div>
    <label>Wiki name</label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'title', 'value'=>$vars['entity']->title)); ?>
</div>

<div>
	<label><?php echo elgg_echo("wiki:icon"); ?></label><br />
	<?php echo elgg_view("input/file", array('name' => 'icon')); ?>
</div>

<div>
    <label>Wiki homepage URL</label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'url', 'value'=>$vars['entity']->url)); ?>
</div> 

<div>
    <label>MediaWiki API URL</label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'api', 'value'=>$vars['entity']->api)); ?>
</div>
 
<div>
    <label><?php echo elgg_echo("body"); ?></label><br />
    <?php echo elgg_view('input/longtext',array('internalname' => 'body', 'value'=>$vars['entity']->description)); ?>
</div>

<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>