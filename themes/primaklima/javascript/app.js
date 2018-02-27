$(document).ready(function(){
	$(".flatpickr").flatpickr({
		dateFormat: "d.m.Y"
	});
});

//Recaptcha validation
$(document).ready(function(){
	if ($(".g-recaptcha").length > 0){
		$('<script src="https://www.google.com/recaptcha/api.js" async defer></script>').appendTo($("head"));
	}
	$(".g-recaptcha").on("click",function(event){
		event.preventDefault();
		grecaptcha.execute();
	});

	function onSubmit(token) {
	    alert('thanks ');
	}
});