$(document).ready(function(){
	if ($(".sidebar").length > 0){
		var sidebarWidth = $(".sidebar").width();
		$(".sidebar").css({transform-origin: '~"calc(50% + '+sidebarWidth+'px)" 0'});
		$(".sidebar").show();
	}
});


