$(document).ready(function(){
	$(".flatpickr").flatpickr({
		dateFormat: "d.m.Y"
	});
});

//Recaptcha validation
// $(document).ready(function(){
// 	if ($(".g-recaptcha").length > 0){
// 		$('<script src="https://www.google.com/recaptcha/api.js" async defer></script>').appendTo($("head"));
// 	}
// 	$(".g-recaptcha").on("click",function(event){
// 		event.preventDefault();
// 		grecaptcha.execute();
// 	});

// 	function onSubmit(token) {
// 	    alert('thanks ');
// 	}
// });

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
        console.log(options);
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