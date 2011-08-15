<div>
    <label>Wiki name</label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'title')); ?>
</div>

<div>
    <label>Wiki homepage URL</label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'url')); ?>
</div> 

<div>
    <label>MediaWiki API URL</label><br />
    <?php echo elgg_view('input/text',array('internalname' => 'api')); ?>
</div>
 
<div>
    <label><?php echo elgg_echo("body"); ?></label><br />
    <?php echo elgg_view('input/longtext',array('internalname' => 'body')); ?>
</div>

<div>
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('save'))); ?>
</div>