function display(){
	document.getElementById('social_browser').innerHTML='Hello!';
}
$(document).ready(function(){
	$(".elgg-module-popup").draggable();
	$("a[href='#socialBrowser']").click(function(){
		
		$(".modal-dialog").dialog("destroy");
		$(".modal-dialog").dialog({
			height: 140,
			modal: true
		});
		iframe = $("<iframe/>",{
			src : "http://wikilogia.net",
		});
		$(iframe).attr("width",'100%');
		$(iframe).attr("height",'100%');
		$(".modal-dialog").html($(iframe).html());
	});	
});
