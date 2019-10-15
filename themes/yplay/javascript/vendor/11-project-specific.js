$(document).ready(function(){
	resizeMain();

	UIkit.util.on("#modal-search","show",function(){
		console.log('hehe');
		$("input[name='Search']").focusIn();
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

