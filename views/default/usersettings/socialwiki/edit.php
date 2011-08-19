You can handle your wiki users account through <?php echo elgg_view('output/url', array('text' => 'this page', 'href'=>$site->url."socialwiki/wikiusers/".(elgg_get_logged_in_user_guid()), 'encode_text'=>true)); echo "<br>"; ?>.

