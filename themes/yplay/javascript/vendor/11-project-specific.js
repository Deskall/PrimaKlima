$(document).ready(function(){
	resizeMain();

	UIkit.util.on("#modal-search","show",function(){
		$("input[name='Search']").focus();
	});

});
$( window ).resize(function() {
	resizeMain();
});

function resizeMain(){
	var screen = $( window ).height();
	var h = $('header').outerHeight() + $('footer').outerHeight();
	$('main').css({ minHeight: `${screen - h}px` });
}

