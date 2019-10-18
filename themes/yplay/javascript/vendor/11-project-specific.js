$(document).ready(function(){
	if ($(".sidebar-menu").length > 0){
		var sidebarWidth = Math.ceil($(".sidebar-menu").innerWidth()) / 4;
		console.log(sidebarWidth);
		$(".sidebar-menu").css("transform-origin", 'calc(50% + '+sidebarWidth+'px) 0');
		$(".sidebar-menu").show();
	}
});


