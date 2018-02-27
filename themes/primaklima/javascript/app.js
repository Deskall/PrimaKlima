$('.uk-icon').each(function(){
	var size = $(this).css("font-size"); 
	console.log(size);
	var svg = $(this).find('svg')[0];
	svg.setAttribute('height',size).setAttribute('width',size);
});
