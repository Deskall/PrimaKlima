$(document).ready(function(){
	if ($(".sidebar-menu").length > 0){
		var sidebarWidth = Math.ceil($(".sidebar-menu").width()) / 4;
		console.log(sidebarWidth);
		$(".sidebar-menu").css("transform-origin", 'calc(50% + '+sidebarWidth+'px + 4px) 0');
		$(".sidebar-menu").show();
	}

	//PLZ Modal
	UIkit.modal($("#modal-postal-code")).show();
	UIkit.util.on("#modal-postal-code","shown",function(){
		$(this).find('input').focus();
	});
});


