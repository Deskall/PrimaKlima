$(document).ready(function(){  
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
});