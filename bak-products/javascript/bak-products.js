var products,
    categories;

$(document).ready(function(){  
    if( window.location.pathname.split("/")[1] == 'produkte' || window.location.pathname.split("/")[1] == 'products'){
        jQuery.ajax({
            type: "GET",
            url: window.location.pathname.split("/")[1]+"/all",
            success: function (data) {
                results = jQuery.parseJSON(data);
                products = results.products;
                categories = results.categories;
                $('[data-product-list]').find('.holder').html(filterProducts());
            }
        });
    }
    $("[data-search-products]").on("keyup", function(){

        $('.head').removeClass('active');
        $('.filter-list').removeClass('active');
        $(this).parents('.head').addClass('active');
        $('.product-list').addClass('active');

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

    })

    $('[data-show-filter]').click(function(){
        $('[data-show-filter],[data-filter-list], .head').removeClass('active');
        $('[data-search-products]').val("")
        $(this).addClass('active');
        $('[data-filter-list=' + $(this).attr('data-show-filter') + ']').addClass('active');
        $('[data-product-list]').removeClass('active');
        $('[data-show-filter]').each( function(){
            $(this).text( $(this).attr('data-filter-name'));
        });
        history.pushState({'filterList': $(this).attr('data-show-filter') }, $(this).attr('data-filter-name'), $(this).attr('href'));
        ga('set', 'page', $(this).attr('href'));
        ga('send', 'pageview');

        $('h1').text($('h1').attr('data-title-orig'));
        $('title').text($('h1').attr('data-title-orig'));
        return false;
    });

    $('[data-filter-list] a').on("click", function(){
        var filter = $(this).parents('[data-filter-list]').attr('data-filter-list');
        var filterValue = $(this).attr('href');
        var name = $(this).attr('data-filter-name');

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
             $("#description").empty();
        }
        else{
            for (i = 0; i < categories.length; i++) {
                if( categories[i]['title'] && ( categories[i]['title'].toLowerCase().indexOf( name.toLowerCase() ) > -1 ) ) {
                    description = categories[i]['description'];
                    metadescription = categories[i]['metadescription'];
                } 
            }
            $("#description").empty().html(description);
           
            $("meta[name='description']").attr('content',metadescription);
            
        }
       

        ga('set', 'page', $(this).attr('href'));
        ga('send', 'pageview');
        
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
    var results = {};
    results.products = [];
    var itemOK = false;
    console.log(products[i]);
    for (var i = 0; i < products.length; i++) {
        if( filter == "all" || ( products[i][filter] && ( products[i][filter].toLowerCase().indexOf( filterValue.toLowerCase() ) > -1 ) ) ){
            results.products.push(products[i]);
        }

    }
    var source   = document.getElementById("products-template").innerHTML;
    var template = Handlebars.compile(source);

    window.scrollTo(0, $('.uk-switcher').offset().top);
    var HTML     = template(results);

    return HTML;
}
