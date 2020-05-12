var products,
    categories,
    usages;

$(document).ready(function(){  

    $(".dk-header-slide .title").each( function(){
        $(this).html( $(this).html().replace(new RegExp("On", 'g'), "<span>On</span>") ) ;
    });

    $(".product-block.table table").each(function(){
        $(this).addClass("uk-table uk-table-small uk-table-striped");
    });

    $("[data-open-dropdown]").click( function() {
        if( $(this).hasClass("active") ){
            $(this).parents("[data-dropdown]").find(".dropdown-content").addClass("hidden");
            if( $(this).parents("[data-dropdown]").find("input[type='checkbox']:checked").length > 1 ){
                $(this).parents("[data-dropdown]").find('[data-dropdown-checked-options]').removeClass("hidden");
                $(this).parents("[data-dropdown]").find('.product-name-holder').addClass("hidden");
            }else{
                $(this).parents("[data-dropdown]").find('[data-dropdown-checked-options]').addClass("hidden");
                $(this).parents("[data-dropdown]").find('.product-name-holder').removeClass("hidden");
                $(this).parents("[data-dropdown]").find('.product-name-holder').text( $(this).parents("[data-dropdown]").find("input[type='checkbox']:checked").val() );
            }
            $(this).removeClass("active");
        }else{
            $(this).parents("[data-dropdown]").find(".dropdown-content").removeClass("hidden");
            $(this).parents("[data-dropdown]").find('[data-dropdown-checked-options]').addClass("hidden");
            $(this).addClass("active");
        }
    });

    $("[data-dropdown] input[type='checkbox']").on("change", function(){
        var listHTML = '';
        $(this).parents("[data-dropdown]").find("input[type='checkbox']:checked").each(function(){
            listHTML += '<li>' + $(this).val() + '</li>';
        });
        $(this).parents("[data-dropdown]").find(".checked-options").html(listHTML);
    });

    if( window.location.pathname.split("/")[1] == 'produkte' || window.location.pathname.split("/")[1] == 'products'){
        jQuery.ajax({
            type: "GET",
            url: window.location.pathname.split("/")[1]+"/all",
            success: function (data) {
                results = jQuery.parseJSON(data);
                products = results.products;
                categories = results.categories;
                usages = results.usages;
            }
        });
    }
    $("[data-search-products]").on("keyup", function(){

            $('.head').removeClass('active');
            $('.filter-list').removeClass('active');
            $(this).parents('.head').addClass('active');
            $('.product-list').addClass('active');
            $("[data-close-products]").show();
            if( $(this).val().length > 0 ){
                var search = $(this).val();
                $('[data-product-list]').find('.holder').html( filterProducts( "name", search ) );
            }else{
                var search = $(this).val();
                $('[data-product-list]').find('.holder').html( filterProducts( "all" ) );
            }


            $('[data-show-filter]').each( function(){
                $(this).text( $(this).attr('data-filter-name'));
            });

        });

        $("[data-close-products]").on("click",function(e){
            e.preventDefault();
            $(this).hide();
            $('.head').removeClass('active');
            $('[data-show-filter]').each(function(){
                $(this).text( $(this).attr('data-filter-name'));
            });
            $("[data-search-products]").parents('.head').addClass('active');
            $("[data-search-products]").val("");
            var search = $(this).val();
            $('[data-product-list]').find('.holder').html( filterProducts( "all" ) );
        });

        $('[data-show-filter]').click(function(e){
            e.preventDefault();
            $("[data-close-products]").show();
            $('[data-show-filter],[data-filter-list], .head').removeClass('active');
            $('[data-search-products]').val("")
            $(this).addClass('active');
            $('[data-filter-list=' + $(this).attr('data-show-filter') + ']').addClass('active');
            $('[data-product-list]').removeClass('active');
            $('[data-show-filter]').each( function(){
                $(this).text( $(this).attr('data-filter-name'));
            });
            history.pushState({'filterList': $(this).attr('data-show-filter') }, $(this).attr('data-filter-name'), $(this).attr('href'));
            // ga('set', 'page', $(this).attr('href'));
            // ga('send', 'pageview');

            $('h1').text($('h1').attr('data-title-orig'));
            $('title').text($('h1').attr('data-title-orig'));
            return false;
        });

        $('[data-filter-list] a').on("click", function(e){
             e.preventDefault();
            var filter = $(this).parents('[data-filter-list]').attr('data-filter-list');
            var filterValue = $(this).attr('href');
            var name = $(this).attr('data-filter-name');
            $("[data-close-products]").show();
            $('.head').removeClass('active');
            $('.filter-list').removeClass('active');
            $('[data-show-filter="' + $(this).parents('[data-filter-list]').attr('data-filter-list') + '"]').addClass('active');

            $('[data-show-filter="' + $(this).parents('[data-filter-list]').attr('data-filter-list') + '"]').text( $(this).attr('data-filter-name') );

            $('.product-list').addClass('active');

            $('[data-product-list]').find('.holder').html( filterProducts(filter, filterValue) );


            history.pushState({'filter': filter, 'filterValue' : filterValue}, $(this).attr('data-filter-name'), $(this).attr('href'));

            $('h1').text($('h1').attr('data-title-orig') + ": " +$(this).attr('data-filter-name'));
            $('title').text($('h1').attr('data-title-orig') + ": " +$(this).attr('data-filter-name'));

            //Change description
            var description = '';
            var metadescription = '';
            if( filter == "all"){
                 $("#description .dk-text-content").empty();
            }
            else{
                if ($(this).attr('data-type') == "category"){
                    for (i = 0; i < categories.length; i++) {
                        if( categories[i]['title'] && ( categories[i]['title'].toLowerCase().indexOf( name.toLowerCase() ) > -1 ) ) {
                            description = categories[i]['description'];
                            metadescription = categories[i]['metadescription'];
                        } 
                    }
                }
                if ($(this).attr('data-type') == "usage"){
                    for (i = 0; i < usages.length; i++) {
                        if( usages[i]['title'] && ( usages[i]['title'].toLowerCase().indexOf( name.toLowerCase() ) > -1 ) ) {
                            description = usages[i]['description'];
                            metadescription = usages[i]['metadescription'];
                        }
                    }
                }
                $("#description .dk-text-content").empty().html(description);
               
                $("meta[name='description']").attr('content',metadescription);
                
            }
           

            // ga('set', 'page', $(this).attr('href'));
            // ga('send', 'pageview');
            
            return false;
        });


        window.onpopstate = function (e) {
            if ( e.state && 'filter' in e.state){
                var filter = e.state.filter;
                var filterValue = e.state.filterValue;

                $('.head').removeClass('active');
                $('.filter-list').removeClass('active');
                $('[data-show-filter="' +filter + '"]').addClass('active');

                $('[data-show-filter="' + filter + '"]').text( $(this).attr('data-filter-name') );

                $('.product-list').addClass('active');

                $('[data-product-list]').find('.holder').html( filterProducts(filter, filterValue) );
            }else{
                if( e.state &&  'filterList' in e.state ){
                    var filterList = e.state.filterList;
                }else{
                    var filterList = 'categories';
                }

                $('[data-show-filter],[data-filter-list], .head').removeClass('active');
                $('[data-search-products]').val("")
                $('[data-show-filter=' + filterList + ']').addClass('active');
                $('[data-filter-list=' + filterList + ']').addClass('active');
                $('[data-product-list]').removeClass('active');
                $('[data-show-filter]').each( function(){
                    $(this).text( $(this).attr('data-filter-name'));
                });


            }
        }
});

function filterProducts( filter, filterValue ){
    var HTML = '';
    for (i = 0; i < products.length; i++) {
        if( filter == "all" || ( products[i][filter] && ( products[i][filter].toLowerCase().indexOf( filterValue.toLowerCase() ) > -1 ) ) ){

            HTML += '<div class="product" data-uk-grid>';
            if( 'image' in products[i] ){

                HTML += '<div class="uk-width-1-1 uk-width-1-2@s uk-width-1-4@m uk-width-1-5@l uk-width-1-6@xl"><a href="' + products[i].link + '"><img src="' + products[i].image + '" alt="' +  products[i].name + '" /></a></div>';
            }

            HTML += '<div class="uk-width-1-1 uk-width-1-2@s uk-width-3-4@m uk-width-4-5@l uk-width-5-6@xl"><h3>' + products[i].name + '</h3>';
            if( products[i].lead ){
                HTML += '<p class="description">' + products[i].lead + '</p>';
            }
            else if( products[i].description ){
                HTML += '<p class="description">' + products[i].description + '</p>';
            }else{

                if( products[i].features ){
                    HTML += '<p class="description">' + products[i].features + '</p>';
                }
                if( products[i].number ){
                    HTML += '<p class="description">' + products[i].numberText  + ': ' +  products[i].number + '</p>';
                }
            }

            HTML += '<div class="link-more"><a href="' + products[i].link + '">' + products[i].linkText  + '  <span class="icon ion-ios-arrow-right"></span></a></div></div></div><div><hr></div>';
        }

    }
    if( !HTML ){
        HTML = '<div class="product"><div class="uk-width-1-1"><h3>' + $('[data-product-list]').attr("data-no-products-found") + '</h3></div></div>';
    }

    window.scrollTo(0, $('.product-filter-holder').offset().top);


    return HTML;
}
