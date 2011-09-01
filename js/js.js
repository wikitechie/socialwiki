$(window).ready(function() {
	$("a[href='#toggleDiff']").click(function() {
		var riverItem = $(this).parent().parent().parent().parent();
		var container = riverItem.find("div.sliding-extender");
		all_links = riverItem.find("a[href='#toggleDiff']"); // to get all links not this only
		$nextname = all_links.html(); 
		all_links.html($(this).attr('data-nextname'));
		all_links.attr('data-nextname',$nextname);
		container.slideToggle('slow');
		
	});
	
	$("a[href='#socialBrowser']").click(function(){
		var dialog = $(".jq-dialog");
		var src = $(dialog).attr("src");
		$(dialog).html(" ");
		$("<iframe/>",{
			src		: src,
			title	: "Social Browser",
			width	: "100%",
			height	: "98%"
		}).appendTo(".jq-dialog");
		$(".jq-dialog").dialog("destroy");
		$(".jq-dialog").dialog({
			height	: 600,
			width	: "75%",
			modal	: true,
		});
		
	});	
});