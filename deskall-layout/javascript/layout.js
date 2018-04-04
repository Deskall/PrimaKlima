(function($) {
    $.entwine(function($) {
		$('.jscolor').entwine({
			onmatch: function(){
				jscolor.installByClassName("jscolor");
			}
		});
	});
      
})(jQuery);