
<div uk-slideshow="<% if Height != "viewport" %><% if MinHeight > 0 %>min-height:$MinHeight;<% end_if %> <% if MaxHeight > 0 %>max-height:$MaxHeight;<% end_if %><% end_if %> <% if Autoplay %>autoplay: true;<% end_if %>animation: {$Animation};" class="dk-slider uk-visible-toggle <% if Height != "viewport" %>$Height<% end_if %>">
    <ul class="uk-slideshow-items" <% if Height == "viewport" %>uk-height-viewport="<% if MinHeight > 0 %>min-height:$MinHeight;<% end_if %> <% if MaxHeight > 0 %>max-height:$MaxHeight;<% end_if %>"<% end_if %>>
        <% loop ActiveSlides %>
        <li>
           <% if Effect == "kenburns" %><div class="uk-position-cover uk-animation-kenburns $EffectOptions"><% end_if %>
                <img src="$Image.URL" alt="" uk-cover>
            <% if Effect == "kenburns" %></div><% end_if %>
            <div class="dk-slide-text-container uk-position-relative">
                <div class="uk-position-center">
                    <div class="uk-container">
                        <div class="dk-text-white uk-light uk-text-center">
                            <% if Effect == "parallax" %> <div uk-slideshow-parallax="$EffectOptions"><% end_if %>
                            <h2 class="uk-heading-primary">$Title</h2>
                            <div class="uk-text-lead uk-padding">$Content</div>
                            <% if Effect == "parallax" %></div><% end_if %>
                            <% if $CallToActionLink.Page.Link %>
                                <% with $CallToActionLink %>
                                <div class="uk-align-center">
                                    <a href="{$Page.Link}" class="uk-button uk-button-secondary"
                                        <% if $TargetBlank %>target="_blank"<% end_if %>
                                        <% if $Description %>title="{$Description.ATT}"<% end_if %>>
                                        {$Text.XML}
                                        <% include DefaultLinkIcon c=w %>
                                    </a>
                                </div>
                                <% end_with %>
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
        <a class="uk-slidenav-large uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
        <a class="uk-slidenav-large uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
    <% end_if %>
</div>