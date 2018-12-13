
$(document).ready(function(){
  if ($(".flatpickr").length > 0){
    $(".flatpickr").flatpickr({
        dateFormat: "d.m.Y",
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
$(document).ready(function(){
  $(".element table").each(function(){
    $(this).wrap('<div class="uk-overflow-auto"></div>');
      $(this).addClass("uk-table uk-table-striped uk-table-small");
      if ($(this).width() > $(window).width()){
          divContainer = $("<div></div>");
          divContainer.addClass("uk-overflow-auto");
          $(this).detach().appendTo(divContainer);
      }

  });
});

//Parent Block
$(document).ready(function(){
    $(".parentblock .uk-accordion").each(function(){
        $(this).find("h3").each(function(){
            var html = $(this).html();
            var a = $('<a></a>');
            a.addClass("uk-accordion-title uk-width-1-1").html(html);
            $(this).html(a);
        });
        var expandedBlocks = $(this).attr('data-element-expanded');
        expandedBlocks = $.parseJSON(expandedBlocks);
        $.each(expandedBlocks, function(index, value){
            $("#e"+value).addClass("uk-open");
        });
    });
});


 // Coookie consent
