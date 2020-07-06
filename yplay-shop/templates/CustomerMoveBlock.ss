<% include TextBlock %>

<div class="uk-margin">
	<div class="uk-panel uk-background-muted uk-padding-small">
		<% if $Message %>
		<p>$Message</p>
		<% end_if %>
		<% if not activePLZ %>
			<form method="POST" class="form-std plz-form customer-move-form">
				<div class="uk-flex uk-flex-left uk-flex-top">
				   <div>
				        <input class="uk-input uk-text-center" type="text" name="plz-choice" required="required" placeholder="Ihrer PLZ">
				   </div>
				   <button class="uk-button uk-button-primary" type="submit">Region prüfen</button>
				</div>
			</form>
		<% else %>
			<p class="uk-text-muted">Ihre Region: $activePLZ.Code - $activePLZ.City <a href="{$getPage.Link}plz-loeschen" class="uk-padding-remove" title="Region löschen" data-uk-tooltip="<%t PLZ.CLEAR 'Region löschen' %>"><i class="icon icon-close-circled uk-text-muted"></i></a></p>
		<% end_if %>
	</div>
	<div id="partner-results" class="shop-list link-block clearfix uk-margin-top">
	</div>
</div>