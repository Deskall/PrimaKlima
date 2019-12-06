
<div data-uk-grid>
	<div class="uk-width-1-2">
		<% with Fields.FieldByName('Logo') %>
		$FieldHolder
		<% end_with %>
	</div>
	<div class="uk-width-1-2">
		<% with Fields.FieldByName('CompanyAddress') %>
		$FieldHolder
		<% end_with %>
	</div>
</div>