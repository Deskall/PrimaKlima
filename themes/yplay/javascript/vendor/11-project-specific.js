$(document).ready(function(){
	var h = $('header').height() + $('footer').height();
	$('main').css({ minHeight: `calc(100% - ${h}px)` });
});