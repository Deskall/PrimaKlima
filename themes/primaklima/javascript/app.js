$('.uk-icon').each(function(){
	var size = $(this).css("font-size"); 
	console.log(size);
	UIkit.icon('.uk-icon').svg.then(function(svg) { svg.setAttribute('height',size).setAttribute('width',size); })
});
