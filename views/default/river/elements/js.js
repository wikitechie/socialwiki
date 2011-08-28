$(window).ready(function() {
	$("a[href='#showdiff']").click(function() {
		$(this).parent().parent().parent().find(".diff").fadeToggle();
	});
});