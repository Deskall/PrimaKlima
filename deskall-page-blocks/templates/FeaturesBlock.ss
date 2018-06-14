<% include TextBlock %>
<% if activeFeatures %>
	<% if $FeaturesTitle %>
		<h3>$FeaturesTitle</h3>
	<% end_if %>
	<ul class="dk-list $FeaturesColumns $FeaturesTextAlign" data-uk-grid>
	<% loop activeFeatures %> 
	    <li><span class="dk-large-icon uk-text-large" data-uk-icon="icon: $Top.IconItem;">$Text</span></li>
	<% end_loop %>
	</ul>
<% end_if %>