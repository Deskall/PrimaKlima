
<div data-uk-grid>
	<div class="uk-width-1-2@m">
		<div class="uk-card uk-card-default uk-card-body ">
		<% with Fields.FieldByName('Logo') %>
		$FieldHolder
		<% end_with %>
		</div>
	</div>
	<div class="uk-width-1-1">
		<div class="uk-card uk-card-default uk-card-body ">
		<% with Fields.FieldByName('OnlineFields') %>
		$FieldHolder
		<% end_with %>
		</div>
	</div>
</div>