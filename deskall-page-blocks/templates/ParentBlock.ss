<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>
<% if Slide %>
	<div data-uk-slider="center: true;<% if not infiniteLoop %>finite:true;<% end_if %><% if Autoplay %>autoplay: true;autoplay-interval:3000;<% end_if %>">
	    <div class="uk-position-relative uk-visible-toggle" tabindex="-1">
	        <ul class="uk-slider-items list-element__container $BlocksPerLine uk-grid">
	        	 <% loop $Elements.ElementControllers %>
				  <li>$Me</li>
			    <% end_loop %>
	        </ul>
        	<% if ShowNav %>
        	<div class="uk-hidden@l uk-light">
        		<a class="uk-position-center-left uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
        		<a class="uk-position-center-right uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
        	</div>

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
<ul data-uk-accordion>
    <% loop $Elements.ElementControllers %>
    <li>
        <a class="uk-accordion-title" href="#panel-{$Element.ID}">$Element.Title</a>
        <div id="panel-{$Element.ID}" class="uk-accordion-content">$Element</div>
    </li>
    <% end_loop %>
</ul>
<% else %>
<div class="list-element__container $BlocksPerLine  $BlockAlignment uk-grid-small <% if $Border %>uk-grid-divider<% end_if %> <% if $matchHeight %>uk-grid-match<% end_if %>" <% if CollapsableChildren %>data-uk-accordion="content:.uk-panel;toggle:h3;<% if not Collapsable %>collapsible:false;<% end_if %><% if CollapseMultipe %>multiple:true;<% end_if %>"<% end_if %> data-uk-grid data-listelement-count="$Elements.Elements.Count" data-element-expanded="$ExpandedBlocks" >
    <% loop $Elements.ElementControllers %>
    $Me
    <% end_loop %>
</div>
<% end_if %>