$(document).ready(function(){
	if ($(".sidebar-menu").length > 0){
		var sidebarWidth = $(".sidebar-menu").width();
		console.log(sidebarWidth);
		$(".sidebar-menu").css("transform-origin", 'calc(50% + '+sidebarWidth+'px) 0');
		$(".sidebar-menu").show();
	}
});


