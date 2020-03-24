<% with Product %>
<section class="uk-section">
	<div class="uk-container">
		<div class="breadcrumbs">
			<ul class="uk-breadcrumb">
			    <li><a href="/webshop">Bewusstsein Leben Shop</a></li>
			    <li><a href="$Category.Link">$Category.Title</a></li>
			    <li><span>$Title</span></li>
			</ul>
		</div>
		<h1>$Title</h1>
		<div <% if ContentImage %>class="uk-flex" data-uk-grid data-uk-lightbox="toggle: a.dk-lightbox;"<% end_if %>>
			<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
				$Lead
			</div>
		</div>
	</div>
</section>
<% end_with %>