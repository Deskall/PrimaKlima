//  $(document).ready(function(){
// 		$(".js-upload.with-preview").each(function(){
// 			var bar = $('<progress id="js-progressbar" class="uk-progress" value="0" max hidden></progress>');
// 			var	container = $($(this).attr('data-container'));
// 			var	filetype = "image";
// 			var	name = $(this).attr('data-field-name');
// 			var url = (window.location.pathname.substr(window.location.pathname.length-1,1) == "/") ? window.location.pathname+"upload" : window.location.pathname+"/upload";
// 			var id = $(this).attr('id');
// 			var itemid = $(this).attr('data-id');
// 			UIkit.upload('#'+id, {

// 			    url: url,
// 			    multiple: false,

// 			    beforeSend: function () {
// 			    	container.append(bar);
// 			    },
// 			    beforeAll: function () {
// 			   		container.empty();
// 			    },
// 			    load: function () {
// 			    },
// 			    error: function () {
// 			    },
// 			    complete: function () {
			   
// 			        var data = $.parseJSON(arguments[0].response);
// 			        var image = data[0];
// 			        $('input[name="'+name+'"]').val(image.id);
			       
// 			        container.append('<img src="'+image.url+'" alt="'+image.name+'" class="photo" />');
// 			        container.parents('.team-member').find('.uk-dark').removeClass('uk-dark').addClass('uk-light');
// 			    },

			  
// 			    loadStart: function (e) {

// 			        bar.attr('hidden',false);
// 			        bar.attr('max', e.total);
// 			        bar.attr('value',e.loaded);
// 			    },

// 			    progress: function (e) {

// 			        bar.attr('max', e.total);
// 			        bar.attr('value',e.loaded);
// 			    },

// 			    loadEnd: function (e) {
// 					bar.attr('max', e.total);
// 			        bar.attr('value',e.loaded);
// 			    },

// 			    completeAll: function () {

// 			        setTimeout(function () {
// 			            bar.attr('hidden', 'hidden');
// 			        }, 1000);
// 			    }
// 			});

// 			$(".dk-cancel-picture").on("click",function(){
// 				$(".js-upload").find('img.photo').remove();
// 				$(".js-upload").find('.form-field').show();
// 			});
// 		});

// 		$(".js-upload.multiple").each(function(){
// 			var container = $($(this).attr('data-container'));
// 			var url = (window.location.pathname.substr(window.location.pathname.length-1,1) == "/") ? window.location.pathname+"upload" : window.location.pathname+"/upload";
// 			var bar = $('<progress id="js-progressbar" class="uk-progress" value="0" max hidden></progress>');
// 			var form = $(this).parents('form');
// 			var name = $(this).attr('data-field-name');
// 			var type = $(this).attr('data-type');
// 			var id = $(this).attr('id');
// 			UIkit.upload('#'+id, {

// 			    url: url,
// 			    multiple: true,

// 			    beforeSend: function () {
			    	
// 			    	var tr = $('<tr></tr>');
// 			    	var td = $('<td colspan="5"></td>');
// 			    	td.append(bar);
// 			    	tr.append(td);
// 			    	container.append(tr);
// 			    },
// 			    beforeAll: function () {
// 			    },
// 			    load: function () {
// 			    },
// 			    error: function () {
// 			    },
// 			    complete: function () {
			    	
// 			       var data = $.parseJSON(arguments[0].response);
// 			       var image = data[0];
// 			       if (type == "image"){
// 			       	container.find('tr:last').empty().append('<td><span class="fa fa-ellipsis-v"></span></td><td><img src="'+image.smallThumbnail+'" alt="'+image.name+'" class="thumbnail" width="80" height="80" /></td><td>'+image.name+'</td><td><a data-delete-row><span class="fa fa-trash"></span></a></td><td><input type="hidden" name="'+name+'" value="'+image.id+'" /></td>');
// 			       }
// 			       else{
// 			       	container.find('tr:last').empty().append('<td><span class="fa fa-ellipsis-v"></span></td><td><i class="fa fa-file uk-text-large"></i></td><td>'+image.name+'</td><td><a data-delete-row><span class="fa fa-trash"></span></a></td><td><input type="hidden" name="'+name+'" value="'+image.id+'" /></td>');
// 			       }
// 			    },

// 			    loadStart: function (e) {

// 			        bar.attr('hidden',false);
// 			        bar.attr('max', e.total);
// 			        bar.attr('value',e.loaded);
// 			    },

// 			    progress: function (e) {

// 			        bar.attr('max', e.total);
// 			        bar.attr('value',e.loaded);
// 			    },

// 			    loadEnd: function (e) {
// 					bar.attr('max', e.total);
// 			        bar.attr('value',e.loaded);
			        
// 			    },

// 			    completeAll: function () {

// 			        setTimeout(function () {
// 			            bar.attr('hidden', 'hidden');
// 			        }, 1000);
// 			    }

// 			});
// 		});
// 		$(document).on("click",'[data-delete]',function(){
// 			var img = $(this).parent().parent().find('img');
// 			UIkit.toggle(img).toggle();
// 		});
// 		$(document).on("click","[data-delete-row]",function(e){
// 		$(this).parents('tr').remove();
// 	});
// });

var MTIProjectId='4b41bbd9-4c07-40bd-b496-1ecb39ec46d6';
 (function() {
        var mtiTracking = document.createElement('script');
        mtiTracking.type='text/javascript';
        mtiTracking.async='true';
         mtiTracking.src='themes/standard/mtiFontTrackingCode.js';
        (document.getElementsByTagName('head')[0]||document.getElementsByTagName('body')[0]).appendChild( mtiTracking );
   })();
// if (!$('body').hasClass('ShopPage')){
// 		var url = window.location.pathname;
// 		$.ajax({
// 			url: '/shop/getActiveCart',
// 			dataType: 'html'
// 		}).done(function(response){
// 			$('body').append(response);
// 		});
// 	}
 