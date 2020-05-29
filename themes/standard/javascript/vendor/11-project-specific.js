$(document).ready(function(){
	$(document).on("change",".search-form input",function(){
		var input = $(this).val();
		if (input.length >= 3){
			$.ajax({
				url: window.location.pathname+'SearchSuggestions',
				method: 'POST',
				data: {input: input}
			}).done(function(response){
				$("#search-suggestions").replaceWith(response);
			});
		}
	});
});

var MTIProjectId='4b41bbd9-4c07-40bd-b496-1ecb39ec46d6';
 (function() {
        var mtiTracking = document.createElement('script');
        mtiTracking.type='text/javascript';
        mtiTracking.async='true';
         mtiTracking.src='themes/standard/mtiFontTrackingCode.js';
        (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild( mtiTracking );
   })();
   

 