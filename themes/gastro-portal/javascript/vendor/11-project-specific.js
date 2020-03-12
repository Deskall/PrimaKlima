 $(document).ready(function(){
		$(".js-upload.with-preview").each(function(){
			var bar = $('<progress id="js-progressbar" class="uk-progress" value="0" max hidden></progress>');
			var	container = $($(this).attr('data-container'));
			var	filetype = "image";
			var	name = $(this).attr('data-field-name');
			var allowed = $(this).attr('data-allowed');
			var url = $(this).attr('data-upload-url');
			url = (typeof url != "undefined") ? url : ((window.location.pathname.substr(window.location.pathname.length-1,1) == "/") ? window.location.pathname+"upload" : window.location.pathname+"/upload");
			var id = $(this).attr('id');
			var itemid = $(this).attr('data-id');
			UIkit.upload('#'+id, {

			    url: url,
			    multiple: false,
			    allow: allowed,
				msgInvalidMime: "Bitte laden Sie ein Bild (Format: .png, .jpg, .jpeg, .gif, .svg)",

			    beforeSend: function () {
			    	container.append(bar);
			    },
			    beforeAll: function () {
			   		container.empty();
			    },
			    load: function () {
			    },
			    error: function () {
			    },
			    complete: function () {
			   
			        var data = $.parseJSON(arguments[0].response);
			        var image = data[0];
			        $('input[name="'+name+'"]').val(image.id);
			       
			        container.append('<img src="'+image.url+'" alt="'+image.name+'" class="photo" />');
			    },

			  
			    loadStart: function (e) {

			        bar.attr('hidden',false);
			        bar.attr('max', e.total);
			        bar.attr('value',e.loaded);
			    },

			    progress: function (e) {

			        bar.attr('max', e.total);
			        bar.attr('value',e.loaded);
			    },

			    fail: function () {
					alert('Die Datei hat nicht das richtige Format.\nFormate zulässig: '+allowed);
				},

			    loadEnd: function (e) {
					bar.attr('max', e.total);
			        bar.attr('value',e.loaded);
			    },

			    completeAll: function () {

			        setTimeout(function () {
			            bar.attr('hidden', 'hidden');
			        }, 1000);
			    }

			});

			$(".dk-cancel-picture").on("click",function(){
				$(".js-upload").find('img.photo').remove();
				$(".js-upload").find('.form-field').show();
			});
		});
		$(".js-upload.simple").each(function(){
			var bar = $('<progress id="js-progressbar" class="uk-progress" value="0" max hidden></progress>');
			var	container = $($(this).attr('data-container'));
			var	filetype = "file";
			var	name = $(this).attr('data-field-name');
			var url = ($(this).attr('data-url')) ? $(this).attr('data-url') : ( (window.location.pathname.substr(window.location.pathname.length-1,1) == "/") ? window.location.pathname+"upload" : window.location.pathname+"/upload");
			var id = $(this).attr('id');
			var itemid = $(this).attr('data-id');
			UIkit.upload('#'+id, {

			    url: url,
			    multiple: false,

			    beforeSend: function () {
			    	container.append(bar);
			    },
			    beforeAll: function () {
			   		container.empty();
			    },
			    load: function () {
			    },
			    error: function () {
			    },
			    complete: function () {
			   
			        var data = $.parseJSON(arguments[0].response);
			        var file = data[0];
			        $('input[name="'+name+'"]').val(file.id);
			       
			        container.append('<i class="icon icon-file uk-text-large uk-margin-small-right"></i>'+file.name);
			    },

			  
			    loadStart: function (e) {

			        bar.attr('hidden',false);
			        bar.attr('max', e.total);
			        bar.attr('value',e.loaded);
			    },

			    progress: function (e) {

			        bar.attr('max', e.total);
			        bar.attr('value',e.loaded);
			    },

			    loadEnd: function (e) {
					bar.attr('max', e.total);
			        bar.attr('value',e.loaded);
			    },

			    completeAll: function () {

			        setTimeout(function () {
			            bar.attr('hidden', 'hidden');
			        }, 1000);
			    }

			});
		});
	
		$(".js-upload.multiple").each(function(){
			var container = $($(this).attr('data-container'));
			var url = $(this).attr('data-upload-url');
			url = (typeof url != "undefined") ? url : ((window.location.pathname.substr(window.location.pathname.length-1,1) == "/") ? window.location.pathname+"upload" : window.location.pathname+"/upload");
			var bar = $('<progress id="js-progressbar" class="uk-progress" value="0" max hidden></progress>');
			var form = $(this).parents('form');
			var name = $(this).attr('data-field-name');
			var type = $(this).attr('data-type');
			var id = $(this).attr('id');
			UIkit.upload('#'+id, {

			    url: url,
			    multiple: true,

			    beforeSend: function () {
			    	
			    	var tr = $('<tr></tr>');
			    	var td = $('<td colspan="5"></td>');
			    	td.append(bar);
			    	tr.append(td);
			    	container.append(tr);
			    },
			    beforeAll: function () {
			    },
			    load: function () {
			    },
			    error: function () {
			    },
			    complete: function () {
			    	
			       var data = $.parseJSON(arguments[0].response);
			       var image = data[0];
			       if (type == "image"){
			       	container.find('tr:last').empty().append('<td><span class="icon icon-android-more-vertical"></span></td><td><img src="'+image.smallThumbnail+'" alt="'+image.name+'" class="thumbnail" width="80" height="80" /></td><td>'+image.name+'</td><td><a data-delete-row><span class="icon icon-trash-a"></span></a></td><td><input type="hidden" name="'+name+'" value="'+image.id+'" /></td>');
			       }
			       else{
			       	container.find('tr:last').empty().append('<td><span class="icon icon-android-more-vertical"></span></td><td><i class="icon icon-file uk-text-large"></i></td><td>'+image.name+'</td><td><a data-delete-row><span class="icon icon-trash-a"></span></a></td><td><input type="hidden" name="'+name+'" value="'+image.id+'" /></td>');
			       }
			    },

			    loadStart: function (e) {

			        bar.attr('hidden',false);
			        bar.attr('max', e.total);
			        bar.attr('value',e.loaded);
			    },

			    progress: function (e) {

			        bar.attr('max', e.total);
			        bar.attr('value',e.loaded);
			    },

			    loadEnd: function (e) {
					bar.attr('max', e.total);
			        bar.attr('value',e.loaded);
			        
			    },

			    completeAll: function () {

			        setTimeout(function () {
			            bar.attr('hidden', 'hidden');
			        }, 1000);
			    }

			});
		});
		$(document).on("click",'[data-delete]',function(){
			var img = $(this).parent().parent().find('img');
			UIkit.toggle(img).toggle();
		});
		$(document).on("click","[data-delete-row]",function(e){
			$(this).parents('tr').remove();
		});
});