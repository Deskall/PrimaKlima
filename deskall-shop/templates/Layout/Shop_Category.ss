<% with Category %>
<section class="uk-section uk-background-muted uk-padding-small">
	<div class="uk-container">
		<div class="breadcrumbs">
			<ul class="uk-breadcrumb uk-margin-remove">
			    <li><a href="$SiteConfig.ShopPage.Link">Bewusstsein Leben Shop</a></li>
			</ul>
		</div>
	</div>
</section>
<section class="uk-section">
	<div class="uk-container">
		<h1>$Title</h1>
		<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
			<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
				$Lead
			</div>
		</div>
		<div class="uk-child-width-1-2@s uk-child-width-1-3@m" data-uk-grid>
			<% loop activeProducts %>
			<div>
				<div class="uk-card uk-card-body uk-text-center">
					<h3 class="uk-card-title">$Title</h3>
					<div class="uk-margin-small">
						<img src="$MainBild.FocusFill(250,250).URL" data-uk-img class="uk-border-circle" alt="$MainBild.Alt" />
					</div>
					<div class="uk-margin-small uk-text-small">
					<% if Lead %>$Lead.limitWordCount(15)<% else %>$Description.limitWordCount(15)<% end_if %>
					</div>
					<div class="uk-margin-small">
						<strong>$Price.Nice</strong>
					</div>
					<a href="$Link" class="uk-button button-blau"><%t Webshop.ToProduct 'Zum Produkt' %></a>
				</div>
			</div>
			<% end_loop %>
		</div>
	</div>
</section>
<% end_with %>