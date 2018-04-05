(function($) {
    $.entwine(function($) {
		$('.jscolor').entwine({
			onmatch: function(){
				jscolor.installByClassName("jscolor");
			}
		});
		$('[data-class="Color"]').entwine({
			onmatch: function(){
				var preview = this.find('.col-Title input');
				preview.css({"background-color":"#"+this.find('.col-Color input').val(), "color":"#"+this.find('.col-FontColor input').val()});
			}
		});
	});
      
})(jQuery);