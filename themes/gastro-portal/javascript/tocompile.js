


// numeral.language('de-ch', {
//     delimiters: {
//         thousands: ' ',
//         decimal: '.'
//     },
//     abbreviations: {
//         thousand: 'k',
//         million: 'm',
//         billion: 'b',
//         trillion: 't'
//     },
//     ordinal: function (number) {
//         return '.';
//     },
//     currency: {
//         symbol: 'Fr. '
//     }
// });

// // switch between languages
// numeral.language('de-ch');


$(document).ready(function(){
  if ($(".flatpickr").length > 0){
    $(".flatpickr").flatpickr({
        dateFormat: "d.m.Y",
        altInput: true,
        locale: {
          weekdays: {
            shorthand: ["So", "Mo", "Di", "Mi", "Do", "Fr", "Sa"],
            longhand: [
              "Sonntag",
              "Montag",
              "Dienstag",
              "Mittwoch",
              "Donnerstag",
              "Freitag",
              "Samstag",
            ],
          },
          months: {
            shorthand: [
              "Jan",
              "Feb",
              "Mär",
              "Apr",
              "Mai",
              "Jun",
              "Jul",
              "Aug",
              "Sep",
              "Okt",
              "Nov",
              "Dez",
            ],
            longhand: [
              "Januar",
              "Februar",
              "März",
              "April",
              "Mai",
              "Juni",
              "Juli",
              "August",
              "September",
              "Oktober",
              "November",
              "Dezember",
            ],
          },
          firstDayOfWeek: 1,
          weekAbbreviation: "KW",
          rangeSeparator: " bis ",
          scrollTitle: "Zum ƒndern scrollen",
          toggleTitle: "Zum Umschalten klicken",
        }
    });
  }
});

//Google Maps
	function loadmap() {
      $('[data-google-map]').each(function(){
            initGmaps('googlemap_'+$(this).attr('data-google-map'), $(this).attr('data-google-map-address'), $(this).attr('data-google-map-options'), $(this).html());
            $(this).fadeIn();
        });
    }

	function initGmaps(id, address,options, label){

        var geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(0,0);
        options = $.parseJSON(options);
        var map = new google.maps.Map(
            document.getElementById(id),
            options
        );

        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }

            var infowindow = new google.maps.InfoWindow({
              content: label,
              position: results[0].geometry.location
            });

            infowindow.open(map);
        });
    }
	$(document).ready(function(){
	    if ($(".google-map").length > 0){
	 		$('<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbrDquBmMxiRMZz6itPir8xKX7HLa7xZE&callback=loadmap"></script>').appendTo($("body"));
	 	}
	});


//Table
// $(document).ready(function(){
//   $(".dk-text-content table").each(function(){
//     $(this).wrap('<div class="uk-overflow-auto"></div>');
//       $(this).addClass("uk-table uk-table-small");
//       if ($(this).width() > $(window).width()){
//           divContainer = $("<div></div>");
//           divContainer.addClass("uk-overflow-auto");
//           $(this).detach().appendTo(divContainer);
//       }

//   });
// });

//Parent Block
$(document).ready(function(){
    $(".parentblock .uk-accordion").each(function(){
      // var options = {content: '.uk-panel', target: 'h3' }; 
      // UIkit.accordion($(this), options);
        // $(this).find("h3").each(function(){
        //     var html = $(this).html();
        //     var a = $('<a></a>');
        //     a.addClass("uk-accordion-title uk-width-1-1").html(html);
        //     $(this).html(a);
        // });
        var expandedBlocks = $(this).attr('data-element-expanded');
        if (expandedBlocks){
            expandedBlocks = $.parseJSON(expandedBlocks);
          $.each(expandedBlocks, function(index, value){
              $("#e"+value).addClass("uk-open");
          });
        }
      
    });
});

//Scroll links
$(document).ready(function(){
  $("[href *= '#']").each(function(){
    var target = $(this).attr("href");
    target = target.substr(0,target.indexOf("#"));
    if (window.location.pathname == target){
      UIkit.scroll($(this),{offset: 100});
    }
  });
});

$(document).ready(function(){
  UIkit.update(document.body, type = 'update');
});
$( window ).resize(function() {
  UIkit.update(document.body, type = 'update');
}); $(document).ready(function(){
		$(".js-upload.with-preview").each(function(){
			var bar = $('<progress id="js-progressbar" class="uk-progress" value="0" max hidden></progress>');
			var	container = $($(this).attr('data-container'));
			var	filetype = "image";
			var	name = $(this).attr('data-field-name');
			var url = (window.location.pathname.substr(window.location.pathname.length-1,1) == "/") ? window.location.pathname+"upload" : window.location.pathname+"/upload";
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
			        var image = data[0];
			        $('input[name="'+name+'"]').val(image.id);
			       
			        container.append('<img src="'+image.url+'" alt="'+image.name+'" class="photo" />');
			        container.parents('.team-member').find('.uk-dark').removeClass('uk-dark').addClass('uk-light');
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

			$(".dk-cancel-picture").on("click",function(){
				$(".js-upload").find('img.photo').remove();
				$(".js-upload").find('.form-field').show();
			});
		});

		$(".js-upload.multiple").each(function(){
			var container = $($(this).attr('data-container'));
			var url = (window.location.pathname.substr(window.location.pathname.length-1,1) == "/") ? window.location.pathname+"upload" : window.location.pathname+"/upload";
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
			       	container.find('tr:last').empty().append('<td><span class="fa fa-ellipsis-v"></span></td><td><img src="'+image.smallThumbnail+'" alt="'+image.name+'" class="thumbnail" width="80" height="80" /></td><td>'+image.name+'</td><td><a data-delete-row><span class="fa fa-trash"></span></a></td><td><input type="hidden" name="'+name+'" value="'+image.id+'" /></td>');
			       }
			       else{
			       	container.find('tr:last').empty().append('<td><span class="fa fa-ellipsis-v"></span></td><td><i class="fa fa-file uk-text-large"></i></td><td>'+image.name+'</td><td><a data-delete-row><span class="fa fa-trash"></span></a></td><td><input type="hidden" name="'+name+'" value="'+image.id+'" /></td>');
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