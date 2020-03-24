<section class="uk-section">
	<div class="uk-container">
		<div class="breadcrumbs">
			<ul class="uk-breadcrumb">
			    <li><a href="/webshop"></a>Bewusstsein Leben Shop</li>
			    <li><span>$Title</span></li>
			</ul>
		</div>
		<% with Category %>
		<h1>$Title</h1>
		<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
			<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
				$Lead
			</div>
		</div>
		<div class="uk-child-width-1-1" data-uk-grid>
			<% loop activeProducts %>
			<div>
				<div class="uk-card uk-card-default uk-card-body">
					<div class="uk-grid-small uk-flex-middle uk-grid-match" data-uk-grid>
						<div class="uk-width-1-3">
							<img src="$MainBild.FocusFill(250,250).URL" data-uk-img class="uk-border-circle" alt="$MainBild.Alt" />
						</div>
						<div class="uk-width-2-3 uk-position-relative">
						    <h3 class="uk-card-title">$Title</h3>
						    $Description
						    <div class="uk-position-bottom-right">
						    	<a href="$Link" class="uk-button button-PrimaryBackground"><%t Webshop.ToProducts 'Zum Produkte' %><i class="uk-margin-small-left" data-uk-icon="chevron-right"></i></a>
						    </div>
						</div>
					</div>
				</div>
			</div>
			<% end_loop %>
		</div>
		<% end_with %>
	</div>
</section>