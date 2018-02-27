$('.uk-icon').each(function(){
	var size = $(this).css("font-size"); 
	console.log(size);
	UIkit.icon('.uk-icon',{
		height: size,
		width: size
	});
});
