<div class="map-block">
	<div class="map" id="googlemap_{$ID}" data-google-map="$ID" data-google-map-address="<% if $Address %> $Address<% else %>$SiteConfig.AddressStreet,+$SiteConfig.AddressCity<% end_if %>">
		<% if $Label %>
			$Label
		<% else %>
			<p><strong>$SiteConfig.AddressTitle</strong><br />
			$SiteConfig.AddressStreet<br />
			$SiteConfig.AddressCity</p>
		<% end_if %>
	</div>
</div>
