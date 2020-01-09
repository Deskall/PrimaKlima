<div class="sidebar">
	<h1 class="uk-h3">$Title</h1>
	<div class="filters uk-margin">
		<% loop filters %>
		<button class="uk-button uk-margin-small" data-filter-title="$Title">$Value<span class="uk-margin-small-left" data-uk-close></span></button>
		<% end_loop %>
	</div>
	<% loop $CookConfig.Parameters %>
	<div class="parameter uk-margin">
		<strong class="parameter-title">$Title</strong>
		<% loop $Values %>
		<% if $activeOffers.exists %>
		<div><a class="uk-flex uk-flex-between" data-filter="$Up.Title" data-filter-value="$Title"><span class="uk-text-truncate">$Title</span><span>$activeOffers.count</span></a></div>
		<% end_if %>
		<% end_loop %>
	</div>
	<% end_loop %>
	<div class="parameter uk-margin">
		<strong class="parameter-title"><%t JobSearch.Places 'Ort' %></strong>
		<% loop $CookConfig.activeCountries.GroupedBy(CountryTitle) %>
		<div class="uk-flex uk-flex-between"><span class="uk-text-truncate">$CountryTitle</span><span>$Children.count</span></div>
		<% end_loop %>
	</div>
</div>