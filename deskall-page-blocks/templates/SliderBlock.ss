
<div data-uk-slideshow="<% if Height != "viewport" %><% if MinHeight > 0 %>min-height:$MinHeight;<% end_if %> <% if MaxHeight > 0 %>max-height:$MaxHeight;<% end_if %><% end_if %> <% if Autoplay %>autoplay: true;<% end_if %>animation: {$Animation};" class="dk-slider uk-visible-toggle uk-position-relative">
    <ul class="uk-slideshow-items" <% if Height == "viewport" %>data-uk-height-viewport="<% if MinHeight > 0 %>min-height:$MinHeight;<% end_if %> <% if MaxHeight > 0 %>max-height:$MaxHeight;<% end_if %>"<% end_if %>>
        <% loop ActiveSlides %>
        <li>
            <% if SlideType == "Video" %>
                <video src="$File.URL"  autoplay loop muted playslinline data-uk-cover></video>
            <% else %>
           <% if Effect == "kenburns" %><div class="uk-position-cover uk-animation-kenburns $EffectOptions"><% end_if %>
                
                <img src="$Image.URL" alt="$Top.AltTag($Image.Description, $Image.Name,$Title)" title="$Top.TitleTag($Image.Name,$Title)" data-uk-cover />
               
            <% if Effect == "kenburns" %></div><% end_if %>
            <% end_if %>
                <div class="dk-slide-text-container dk-overlay $Background uk-height-1-1 ">
                    <div class="uk-container uk-height-1-1 <% if $Top.FullWidth %>uk-container-expand<% end_if %>">
                        <div class="uk-position-relative uk-height-1-1">
                            <div class="dk-slide-text $TextPosition $TextBackground $TextWidth $TextOffset <% if TextOpacity %>uk-overlay<% end_if %> <% if TextBackground != "no-bg" %>uk-padding-small<% end_if %>">
                                <% if Effect == "parallax" %> <div data-uk-slideshow-parallax="$EffectOptions"><% end_if %>
                                <% if Up.isPrimary && isMainSlide %>
                                    <h1 class="$TitleAlign">$getPage.Title</h1>
                                <% else %>
                                    <% if Title %><h2 class="$TitleAlign uk-h1">$Title</h2><% end_if %>
                                <% end_if %>
                                <div class="uk-text-lead $TextAlign  $TextColumns">$Content</div>
                                <% if Effect == "parallax" %></div><% end_if %>
                                <% if LinkableLinkID > 0 %>
                                    <% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
                                <% end_if %>
                            </div>
                        </div>
                    </div>
                </div>
            
        </li>
        <% end_loop %>
    </ul>
    <% if Nav == "dots" || Nav == "both" %>
    <div class="uk-position-bottom-center uk-position-large uk-visible@m">
        <ul class="uk-slideshow-nav uk-dotnav"></ul>
    </div>
    <% end_if %>
    <% if Nav == "controls" || Nav == "both" %>
            <div class="uk-light uk-visible@m">
                <a class="uk-slidenav-large uk-position-center-left uk-position-large uk-hidden-hover" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
                <a class="uk-slidenav-large uk-position-center-right uk-position-large uk-hidden-hover" data-uk-slidenav-next data-uk-slideshow-item="next"></a>
            </div>

    <% end_if %>
</div>