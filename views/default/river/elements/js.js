$(window).ready(function() {
	$("a[href='#toggleDiff']").click(function() {
		var container = $(this).parent().parent().parent().find("div.sliding-extender");
		all_links = $("a[href='#toggleDiff']"); // to get all links not this only
		$nextname = all_links.html(); 
		all_links.html($(this).attr('data-nextname'));
		all_links.attr('data-nextname',$nextname);
		container.slideToggle('slow');
		
	});
});