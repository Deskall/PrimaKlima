$.cachedScript = function( url, options ) {
 
  // Allow user to set any option except for dataType, cache, and url
  options = $.extend( options || {}, {
    dataType: "script",
    cache: true,
    url: url
  });
 
  // Use $.ajax() since it is more flexible than $.getScript
  // Return the jqXHR object so we can chain callbacks
  return $.ajax( options );
};


//Flatpickr plugin (only if needed)
$(document).ready(function(){
  if ($(".flatpickr").length > 0){
    //Include script
    $.cachedScript( 'thirdparty/04-flatpicker.min.js' ).done(function( script, textStatus ) {
      $(".flatpickr").each(function(){
        var input = $(this);
        input.flatpickr({
            defaultDate: input.attr('value'),
            minDate: input.attr('minDate'),
            maxDate: input.attr('maxDate'),
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
      });
      
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
         $.cachedScript( 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCbrDquBmMxiRMZz6itPir8xKX7HLa7xZE&callback=loadmap' ).done(function( script, textStatus ) {
        });
    }
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

//Anonymize IP
// var gaProperty = 'UA-XXXXXXXX-X';
// var disableStr = 'ga-disable-' + gaProperty;
// if (document.cookie.indexOf(disableStr + '=true') > -1) {
//   window[disableStr] = true;
// }

// $('a[href$="#ga-optout"]').click(function(){
//     document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/';
//     window[disableStr] = true;
//     alert('Google Analytics wurde deaktiviert');
//     return false;
// });

//ensure minimum height for main content
$(document).ready(function(){
  resizeMain();

  UIkit.util.on("#modal-search","shown",function(){
    $("input[name='Search']").focus();
  });

});
$( window ).resize(function() {
  resizeMain();
});

function resizeMain(){
  var screen = $( window ).height();
  var h = $('header').outerHeight() + $('footer').outerHeight();
  console.log(screen);
  console.log($('header').outerHeight());
  console.log($('footer').outerHeight());
  $('main').css({ minHeight: `${screen - h}px` });
}