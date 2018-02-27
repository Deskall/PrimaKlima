$('.uk-icon').each(function(){
	var size = $(this).css("font-size"); 
	console.log(size);
	$(this).find('svg').setAttribute('height',size).setAttribute('width',size);
});
