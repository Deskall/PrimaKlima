$(document).ready(function(){
	console.log('ici');
	if ($(".sidebar-menu").length > 0){
		var sidebarWidth = $(".sidebar-menu").width();
		$(".sidebar-menu").css({transform-origin: '~"calc(50% + '+sidebarWidth+'px)" 0'});
		$(".sidebar-menu").show();
	}
});


