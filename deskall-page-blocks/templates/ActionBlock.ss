<div class="calltoaction-container uk-flex <% if not noMargin %>dk-margin-responsive<% end_if %> uk-flex-{$TextAlignment}">
		<% if $Trigger %>
		    <button class="uk-button $Background" data-uk-toggle="target: #content-container" type="button" data-uk-icon="icon: $Icone">$Trigger</button>
		<% end_if %>
</div>