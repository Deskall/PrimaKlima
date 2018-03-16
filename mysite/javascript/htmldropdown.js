(function($) {
    $.entwine(function($) {
		$('.html-dropdown').entwine({
			onmatch: function() {
				this.writeValue();
      		},
      		showOptions: function(){
      			this.find('.chosen-drop').toggleClass('active').focus();
      		},
      		writeValue: function(){
      			var option = this.find('.html-dropdown-option.selected');
      			var html = (option.length) ? option.html() : 'Neu Block hinzufügen';
      			var value = (option.length) ? option.attr('data-value') : '';
      			this.find('.chosen-single').html(html+'<div><b></b></div>');
      			//this.find('select option[value="'+value+'"]').attr('selected','selected');
                        this.find('select').val(value).trigger('change');

      		}
      	});
      	$('.html-dropdown a.chosen-single').entwine({
			onclick: function() {
				this.parents('.html-dropdown').showOptions();		
      		}
      	});
      	$('.html-dropdown .chosen-drop.active').entwine({
      		onmatch: function(){
      			$this = this;
      			var htmldropdown = this.parents('.html-dropdown');
				$(window).on('click',function(event){
					if ( 
			            htmldropdown.has(event.target).length == 0 //checks if descendants of $box was clicked
			            &&
			            !htmldropdown.is(event.target) //checks if the $box itself was clicked
			        ){
						$this.removeClass('active');
					} 
				});
      		}
		});
		$('.html-dropdown-option').entwine({
			onclick: function() {
				$('.html-dropdown-option').removeClass('selected');
				this.addClass('selected');
				this.parents('.html-dropdown').writeValue();
				this.parents('.chosen-drop').removeClass('active');
      		}
      	});

            // $(".htmldropdown select").entwine({
            //       onadd: function() {
            //             this.update();
            //       },
            //       onchange: function() {
            //             this.update();
            //       },
            //       update: function() {
            //             var btn = this.parents(".ss-gridfield-add-new-multi-class").find('[data-add-multiclass]');
            //             if(this.val() && this.val().length) {
            //                   btn.removeClass('disabled');
            //             } else {
            //                   btn.addClass('disabled');
            //             }
            //       }
            // });
		
    });
})(jQuery);