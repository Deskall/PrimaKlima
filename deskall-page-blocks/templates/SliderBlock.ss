
<div data-uk-slideshow="<% if Height != "viewport" %><% if MinHeight > 0 %>min-height:$MinHeight;<% end_if %> <% if MaxHeight > 0 %>max-height:$MaxHeight;<% end_if %><% end_if %> <% if Autoplay %>autoplay: true;<% end_if %>animation: {$Animation};" class="dk-slider uk-visible-toggle">
    <ul class="uk-slideshow-items" <% if Height == "viewport" %>data-uk-height-viewport="<% if MinHeight > 0 %>min-height:$MinHeight;<% end_if %> <% if MaxHeight > 0 %>max-height:$MaxHeight;<% end_if %>"<% end_if %>>
        <% loop ActiveSlides %>
        <li>
           <% if Effect == "kenburns" %><div class="uk-position-cover uk-animation-kenburns $EffectOptions"><% end_if %>
                $Image.Slides(2500,$Title)
            <% if Effect == "kenburns" %></div><% end_if %>
            <div class="dk-slide-text-container uk-position-relative">
                <div class="uk-position-center">
                    <div class="uk-container">
                        <div class="dk-text-white uk-light uk-text-center">
                            <% if Effect == "parallax" %> <div data-uk-slideshow-parallax="$EffectOptions"><% end_if %>
                            <% if Title %><h2>$Title</h2><% end_if %>
                            <div class="uk-text-lead">$Content</div>
                            <% if Effect == "parallax" %></div><% end_if %>
                           <% if $CallToActionLink.Page.Link %>
                                <% include CallToActionLink c=w,pos=center,b=secondary,noMargin=true %>
                            <% end_if %>
                        </div>
                    </div>
                </div>
               
            </div>
        </li>
        <% end_loop %>
    </ul>
    <% if Nav == "dots" %>
    <div class="uk-position-bottom-center uk-position-small">
        <ul class="uk-slideshow-nav uk-dotnav"></ul>
    </div>
    <% else_if Nav == "controls" %>
        <a class="uk-slidenav-large uk-position-center-left uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
        <a class="uk-slidenav-large uk-position-center-right uk-position-small uk-hidden-hover" href="#" data-uk-slidenav-next data-uk-slideshow-item="next"></a>
    <% end_if %>


    
</div>