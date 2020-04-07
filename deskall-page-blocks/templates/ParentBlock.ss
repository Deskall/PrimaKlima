<% if HTML %>
<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	<% if CollapseText %>
            <div class="short-text toggle-text-{$ID}">$HTML.limitWordCount($Limit)<div class="uk-position-bottom-center button-container"><button class="uk-button uk-button-primary uk-box-shadow-large" data-uk-toggle=".toggle-text-{$ID}">Mehr</button></div></div>
            <div class="long-text toggle-text-{$ID}" hidden>$HTML</div>
        <% else %>
            $HTML
        <% end_if %>
</div>
<% end_if %>
<% if Slide %>
    <div data-uk-slider="<% if not infiniteLoop %>finite:true;<% end_if %><% if Autoplay %>autoplay: true;autoplay-interval:<% if $Interval %>$Interval<% else %>7000<% end_if %>;<% end_if %>">
        <div class="uk-position-relative uk-visible-toggle" tabindex="-1">
            <div class="uk-slider-container">
                <ul class="uk-slider-items list-element__container $BlocksPerLine uk-grid">
                     <% loop $Elements.ElementControllers %>
                     <% if $isVisible %>
                      <li class="$Top.BlockAlignment uk-grid-small uk-flex $Top.BlockVerticalAlignment $ExtraClass">$Me</li>
                      <% end_if %>
                    <% end_loop %>
                </ul>
            </div>
            <% if ShowNavMobile %>
            <div class="uk-hidden@l">
                <a class="uk-position-center-left uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
            </div>
            <% end_if %>
            <% if ShowNav %>
            <div class="uk-visible@l">
                <a class="uk-position-center-left-out uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
                <a class="uk-position-center-right-out uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
            </div>
            <% end_if %>
        </div>
        <% if ShowDot %>
        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
        <% end_if %>
    </div>
<% else_if CollapsableChildren %>
<ul data-uk-accordion="<% if not CanCollapse %>collapsible:false;<% end_if %><% if CollapseMultipe %>multiple:true;<% end_if %>">
    <% loop $Elements.ElementControllers.filter('isVisible',1) %>
    <li id="$Element.Anchor" class="uk-margin <% if not Element.collapsed %>uk-open<% end_if %> $Element.ExtraClass">
       <a class="uk-accordion-title"><h3>$Element.Title</h3></a>
        <div id="panel-{$Element.ID}" class="uk-accordion-content element $Element.SimpleClassName.LowerCase uk-margin-remove-top">
        <% if $Element.BackgroundImage.exists %>
            <section class="uk-section $Element.Background uk-cover-container dk-overlay $Element.SectionPadding with-background <% if $Element.BackgroundImageEffect %>uk-background-fixed<% end_if %>" <% if $Element.BackgroundImage.getExtension == "svg" %>data-src="$Element.BackgroundImage.URL"<% else %>data-src="$Element.BackgroundImage.ScaleWidth(1200).URL" data-srcset="$Element.BackgroundImage.ScaleWidth(650).URL 650w,$Element.BackgroundImage.ScaleWidth(1200).URL 1200w, $Element.BackgroundImage.ScaleWidth(1600).URL 1600w, $Element.BackgroundImage.URL 2500w" data-sizes="100vw" data-uk-img<% end_if %>>
        <% else %>
            <section class="uk-section <% if $Element.Background != "no-bg" %>$Element.Background with-background<% end_if %> uk-padding-remove">
        <% end_if %>                
                <div class="uk-container $Element.TextAlign <% if $Element.FullWidth %>uk-container-expand<% end_if %>">
                    $Element
                </div>
            </section>
        </div>
    </li>
    <% end_loop %>
</ul>
<% else %>
<div class="list-element__container $BlocksPerLine  $BlockAlignment uk-grid-small uk-flex $BlockVerticalAlignment <% if $Border %>uk-grid-divider<% end_if %> <% if $matchHeight %>uk-grid-match<% end_if %>" data-uk-grid >
    <% loop $Elements.ElementControllers %>
    $Me
    <% end_loop %>
</div>
<% end_if %>

<% if LinkableLinkID > 0 %>
    <% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
