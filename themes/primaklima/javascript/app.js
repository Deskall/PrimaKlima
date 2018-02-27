$('.dk-responsive-icon').each(function(){
	var size = $(this).css("font-size"); 
	console.log(size);
	var svg = $(this).find('svg')[0];
	console.log(svg);
	if (svg){
		svg.setAttribute('height',size);
		svg.setAttribute('width',size);
	}
	
});
