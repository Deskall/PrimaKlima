/**
 * File: Deskall-divers.EditForm.js
 */

(function($){
	$.entwine('ss', function($){

		$('.cms-edit-form input[name=Title]').entwine({
			

			/**
			 * Function: updateURLSegment
			 *
			 * Update the URLSegment
			 * (String) title
			 */
			updateURLSegment: function(title) {
				console.log('ici');

				var urlSegmentField = urlSegmentInput.closest('.field.urlsegment');
				if (!urlSegmentField.hasClass("no-edit")){
					this._super();
				}
				else{
					return false;
				}
				
			},
		});
	});
})(jQuery);