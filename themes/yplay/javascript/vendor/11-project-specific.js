$(document).ready(function(){
	var screen = $( window ).height();
	var h = $('header').height() + $('footer').height();
	$('main').css({ minHeight: `calc(${screen}px - ${h}px)` });
});