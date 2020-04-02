
<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
		$Lead
	</div>
</div>

<div class="uk-child-width-1-1" data-uk-grid>
	<% loop activeCategories %>
	<div>
		<div class="uk-card uk-card-default uk-card-body">
			<div class="uk-grid-small" data-uk-grid>
				<div class="uk-width-1-3@m">
					<img src="$Image.FocusFill(250,250).URL" data-uk-img class="uk-border-circle" alt="$Image.Alt" />
				</div>
				<div class="uk-width-2-3@m">
				    <h3 class="uk-card-title">$Title</h3>
				    $Description
				    <div class="uk-text-right@m">
				    	<a href="$Link" class="uk-button button-blau"><%t Webshop.ToProducts 'Zum Produkte' %></a>
				    </div>
				</div>
			</div>
		</div>
	</div>
	<% end_loop %>
</div>


<% if LinkableLinkID > 0 %>
	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
<% end_if %>
