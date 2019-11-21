<div class="price-block clearfix">
<% loop $PackageData %>
	<div class="package-item <% if First %>attr-holder<% else %>package-holder<% end_if %> package-{$PackageCode}">
		<div class="row title">$Title <br/></div>
		<div class="row">$RunTime</div>
		<div class="row">$NumOfAds</div>

		<% loop $Features.Sort('SortOrder') %>
			<% if $Title__de_DE == 'y' %>
				<div class="row"><span class="icon-checkmark-round"></span></div>
			<% else_if $Title__de_DE == 'n' %>
				<div class="row">-</div>
			<% else %>
				<div class="row">$Title__de_DE</div>
			<% end_if %>
		<% end_loop %>


		<% if $PriceOptions  %>

		<div class="row price-options">
			<% loop $PriceOptions %>
				<% if $Price > 0 %>
				<div class="item clearfix">
					<div class="key">$Title</div>
					<div class="val">$Price €</div>
				</div>
				<% end_if %>
			<% end_loop %>
		</div>

		<% else %>
		<% if $Price %>
		<div class="row price">$Price €</div>
		<% end_if %>
		<% end_if %>

		<% if  not First %>
		<div class="row cta-hoder">
			<a href="/mein-koecheportal" class="btn-buy" >Jetzt buchen</a>
		</div>
		<% end_if %>

	</div>
<% end_loop %>

</div>