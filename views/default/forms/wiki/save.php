<div>
    <label><?php echo elgg_echo("title"); ?></label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'title')); ?>
</div>
 
<div>
    <label><?php echo elgg_echo("body"); ?></label><br />
    <?php echo elgg_view('input/longtext',array('internalname' => 'body')); ?>
</div>
 
<div>
    <label><?php echo elgg_echo("tags"); ?></label><br />
    <?php echo elgg_view('input/tags',array('internalname' => 'tags')); ?>
</div>
 
<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>