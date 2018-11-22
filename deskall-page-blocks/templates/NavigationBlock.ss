
<ul class="uk-subnav" data-uk-margin data-uk-sticky="media: 960">
	<% loop Items.filter('ItemType','block') %>
    	<li class="uk-width-1-1 uk-width-auto@m">
    		<a href="#{$TargetLink}" class="uk-button uk-button-small ActiveColor" data-uk-scroll="offset:50"><% if Title %>$Title<% else %>$Target.Title<% end_if %></a>
    	</li>
   <% end_loop %>
</ul>

<div class="uk-position-fixed uk-position-large uk-position-bottom-right uk-position-z-index">
	<ul class="uk-subnav" data-uk-margin>
		<% loop Items.filter('ItemType','target') %>
	    	<li class="uk-width-1-1 uk-width-auto@m">
	    		<a data-uk-toggle="target: {$TargetLink}" class="uk-button uk-button-small uk-button-secondary"><% if Title %>$Title<% else %>$Target.Title<% end_if %></a>
	    	</li>
	   <% end_loop %>
	</ul>
</div>