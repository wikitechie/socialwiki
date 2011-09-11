$(window).ready(function() {
	$("a[href='#toggleDiff']").click(function() {
		var riverItem = $(this).parent().parent().parent().parent();
		var container = riverItem.find("div.sliding-extender");
		if ( $(container).html() == ""){
			var riverItemId = $(riverItem).attr("id").match(/(.*)-(.d+)/)[2];
			$(container).addClass("elgg-ajax-loader");
			elgg.view('wikiactivity/get_diff',{
				data:{id:riverItemId},
				target: $(container),
				success:function() {
					$(container).removeClass("elgg-ajax-loader");
				}
			});
		}
		all_links = riverItem.find("a[href='#toggleDiff']"); // to get all links not this only
		$nextname = all_links.html(); 
		all_links.html($(this).attr('data-nextname'));
		all_links.attr('data-nextname',$nextname);
		container.slideToggle('slow');
		
	});
/*	
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
	*/
	$("a[href='#socialBrowser']").click(function(){
		var dialog = $(".jq-dialog");
		var src = $(dialog).attr("src");
		newWindow = window.open(src,'SocialBrowser',"width=900,height=600");
		if (window.focus) {newwindow.focus();}
		return false;
	});
});