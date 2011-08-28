$(window).ready(function() {
	$("a[href='#showdiff']").click(function() {
		var container = $(this).parent().parent().parent().find("div.attachments");
		if (! $(container).is(":hidden"))
			$(this).html('View difference');
		else
			$(this).html('Hide difference');
		container.slideToggle('slow');
		
	});
});