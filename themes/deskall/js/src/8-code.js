/*
	usage code for the site
	authors: D. Wirz und M. Flueckiger,  Deskall Kommunikation 2015
*/

var screensize = $(window).width();

    function loadmap() {
      $('[data-google-map]').each(function(){
            initGmaps('googlemap_'+$(this).attr('data-google-map'), $(this).attr('data-google-map-address'), $(this).html());
            $(this).show();
        }); 
    }

    function initGmaps(id, address, label){

        var geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(0,0);

        var myOptions = {
            zoom:15,
            center: latlng
        };

        var map = new google.maps.Map(
            document.getElementById(id),
            myOptions
        );

        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
              var marker = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location
              });
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }

            var infowindow = new google.maps.InfoWindow({
              content: label
            });

            infowindow.open(map,marker);

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });
        });
    }

if (screensize < 768){
    var mobilescreen = true;
}

    var isMobile = {
        Android: function() {
            return (navigator.userAgent.match(/Android/i) && mobilescreen);
        },
        BlackBerry: function() {
            return (navigator.userAgent.match(/BlackBerry/i) && mobilescreen);
        },
        iOS: function() {
            return (navigator.userAgent.match(/iPhone|iPad|iPod/i) && mobilescreen);
        },
        Opera: function() {
            return (navigator.userAgent.match(/Opera Mini/i) && mobilescreen);
        },
        Windows: function() {
            return ((navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/WPDesktop/i)) && mobilescreen);
        },
        any: function() {
            return ((isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows()) && mobilescreen);
        }
    };




    function initGmaps(id, address, label){

        var geocoder = new google.maps.Geocoder();
        var latlng = new google.maps.LatLng(0,0);

        var myOptions = {
            zoom:15,
            center: latlng
        };

        var map = new google.maps.Map(
            document.getElementById(id),
            myOptions
        );

        geocoder.geocode( { 'address': address}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
              map.setCenter(results[0].geometry.location);
              var marker = new google.maps.Marker({
                  map: map,
                  position: results[0].geometry.location
              });
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }

            var infowindow = new google.maps.InfoWindow({
              content: label
            });

            infowindow.open(map,marker);

            google.maps.event.addListener(marker, 'click', function() {
                infowindow.open(map,marker);
            });
        });
    }




    $(window).load(function() {

        $("#owl-slider").owlCarousel({
            navigation : false,
            avigationText: ["<i class='icon icon-chevron-left'></i>", "<i class='icon icon-chevron-right'></i>"],
            autoPlay: true,
            singleItem : true,
            transitionStyle : "fade"
        });

        $(".owl-gallery").owlCarousel({
            itemsCustom : [
                [0, 1],
                [751, 2],
            ],
            navigationText: ["<i class='icon icon-chevron-left'></i>", "<i class='icon icon-chevron-right'></i>"],
            lazyLoad: true,
            navigation: true,
            pagination: false
        });

        if( $('[data-google-map]').length > 0 ){
            $('body').append('<script defer src="//maps.google.com/maps/api/js?key=AIzaSyCbrDquBmMxiRMZz6itPir8xKX7HLa7xZE&callback=loadmap"></script>');
        }

        var scrollNaviDesktop = true; // turn desktop navi scroll on/off
        var scrollNaviMobile = true; // turn mobile navi scroll on/off
        var primaryNav = $('header');
        primaryNavTopPosition = primaryNav.height();

        $(window).scroll(function () {

           
        if(! isMobile.any() && $(".sidebar").innerHeight() < $('.col.w-8').innerHeight() && $(".sidebar").height() < $( window ).height() - $('.header-fixed').height()  ){
            if (scrollNaviDesktop){
                if($(window).scrollTop() > primaryNavTopPosition ) {
                    $(".sidebar").addClass('fixed');
                } else {
                    $(".sidebar").removeClass('fixed');
                }
    
                // handle footer overflow
                var marginbeforefooter = 200; // stops 40 px before footer
                footertotop = ($('footer').position().top);
                var contentheight =  ($('.sidebar').height()) + ($('.nav-holder').height());
                scrolltop = $(document).scrollTop() + contentheight + marginbeforefooter;
    
                difference = scrolltop-footertotop;
                if (scrolltop > footertotop) {
                    var margin = -difference;
                    $('.sidebar.fixed').css('margin-top', margin + 'px' );
                }
                else{
                    $('.sidebar.fixed').css('margin-top', 0 + 'px' );
                }
            }
        }
    });


        $('#show-mobile-nav').click(function(){
            $("#nav-mobile, #hide-mobile-nav").removeClass("hidden");
            $("section, footer, aside").addClass("hidden");
        });

        $('#hide-mobile-nav').click(function(){
            $("#nav-mobile, #hide-mobile-nav").addClass("hidden");
            $("section, footer, aside").removeClass("hidden");
        });

        $('[data-show-search-form]').click(function(){
            $('[data-show-search-form]').addClass('hidden');
            $('[data-search-form]').removeClass('hidden');
            $('#SearchForm_SearchForm_Search').focus();
        });

        $('[data-hide-search-form]').click(function(){
            $('[data-show-search-form]').removeClass('hidden');
            $('[data-search-form]').addClass('hidden');
        });

        $('[data-action="print"]').click(function(){
            window.print();
        });


        $("a[data-sub-nav-id]").click( function() {
            if( $("nav[data-sub-nav-id=" + $(this).attr("data-sub-nav-id") + "]").hasClass("active") ){
                $("nav[data-sub-nav-id=" + $(this).attr("data-sub-nav-id") + "]").removeClass("active");
            } else {
                $("nav[data-sub-nav-id]").removeClass("active");
                $("nav[data-sub-nav-id=" + $(this).attr("data-sub-nav-id") + "]").addClass("active");
            }
        });

    });

//Required for SAFARI
    if(navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1){
        $("form").submit(function(e) {

            var ref = $(this).find("[required]");

            $(ref).each(function(){
                if ( $(this).val() == '' )
                {
                    alert("Bitte füllen Sie alle Pflichtfelder (*) aus.");

                    $(this).focus();

                    e.preventDefault();
                    return false;
                }
            });
            return true;
        });
    }



