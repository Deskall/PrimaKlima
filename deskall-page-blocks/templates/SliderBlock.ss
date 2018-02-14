<div uk-slideshow="<% if Autoplay %>autoplay: true;<% end_if %>animation: {$Animation};min-height: 300; max-height: 500" class="uk-position-relative uk-visible-toggle">
    <ul class="uk-slideshow-items">
        <% loop ActiveSlides %>
        <li>
           <% if Effect == "kenburns" %><div class="uk-position-cover uk-animation-kenburns $EffectOptions"><% end_if %>
                <img src="$Image.URL" alt="" uk-cover>
            <% if Effect == "kenburns" %></div><% end_if %>
            <div class="uk-position-center dk-text-white uk-light uk-text-center">
                <% if Effect == "parallax" %> <div uk-slideshow-parallax="$EffectOptions"><% end_if %>
                <h2 class="dk-text-white">$Title</h2>
                <div class="uk-text-lead dk-text-white">$Content</div>
                <% if Effect == "parallax" %></div><% end_if %>

            </div>
            <% if RelatedPage %><a class="uk-position-bottom-center uk-button uk-button-secondary uk-align-center" href="$RelatedPage.URL">Hier klicken</a><% end_if %>
        </li>
        <% end_loop %>
    </ul>
    <% if Nav == "dots" %>
    <div class="uk-position-bottom-center uk-position-small">
        <ul class="uk-slideshow-nav uk-dotnav"></ul>
    </div>
    <% else_if Nav == "controls" %>
        <a class="uk-slidenav-large uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
        <a class="uk-slidenav-large uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
    <% end_if %>
</div>