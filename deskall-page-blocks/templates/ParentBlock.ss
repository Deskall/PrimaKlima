<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
	$HTML
</div>
<% if Slide %>
	<div data-uk-slider="center: true">
	    <div class="uk-position-relative uk-visible-toggle" tabindex="-1">
	        <ul class="uk-slider-items list-element__container $BlocksPerLine uk-grid">
	        	 <% loop $Elements.ElementControllers %>
				  <li>$Me</li>
			    <% end_loop %>
	        </ul>
	    </div>
	</div>
<% else %>
<div class="list-element__container $BlocksPerLine  uk-flex uk-grid-small <% if $Border %>uk-grid-divider<% end_if %> <% if $matchHeight %>uk-grid-match<% end_if %>" <% if CollapsableChildren %>data-uk-accordion="content:.uk-panel;toggle:h3;<% if not Collapsable %>collapsible:false;<% end_if %><% if CollapseMultipe %>multiple:true;<% end_if %>"<% end_if %> data-uk-grid data-listelement-count="$Elements.Elements.Count" data-element-expanded="$ExpandedBlocks" >
    $Elements
</div>
<% end_if %>