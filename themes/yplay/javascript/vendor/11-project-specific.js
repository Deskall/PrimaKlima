$(document).ready(function(){
	resizeMain();
});
$( window ).resize(function() {
	resizeMain();
});

function resizeMain(){
	var screen = $( window ).height();
	var h = $('header').outerHeight() + $('footer').outerHeight();
	$('main').css({ minHeight: `${screen - h}px` });
}

UIkit.utility.on("show",$("#modal-search"),function(){
	$("input[name='Search']").focusIn();
});