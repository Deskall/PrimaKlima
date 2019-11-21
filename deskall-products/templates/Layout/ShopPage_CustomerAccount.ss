<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">
		<div data-uk-grid>
			<div class="uk-width-1-4@m uk-visible@m">
				<% include ProductSidebar %>
			</div>
			<div class="uk-width-3-4@m">
				<ul data-uk-tab>
				    <li><a>Ihre Angaben</a></li>
				    <li><a>Ihre Bestellungen</a></li>
				</ul>

				<ul class="uk-switcher uk-margin">
				    <li>$CustomerForm</li>
				    <li>
				    	<% if Orders.exists %>
				    	<table class="uk-table uk-table-small uk-table-striped uk-table-responsive">
				    		<thead>
				    			<th><%t Shop.Number 'Nr.' %></th>
				    			<th><%t Shop.Product 'Produkt' %></th>
				    			<th><%t Shop.Price 'Preis (EUR)' %></th>
				    			<th><%t Shop.Date 'Datum' %></th>
				    			<%-- <th><%t Shop.Status 'Status' %></th> --%>
				    			<th>&nbsp;</th>
				    			<th>&nbsp;</th>
				    		</thead>
				    		<tbody>
				    			<% loop Orders %>
				    			<tr><td>$Nummer</td><td>$Product.Title</td><td>$Price</td><td>$Created.Date</td><%-- <td>$OrderStatus</td> --%><td><% if isPaid %>$ReceiptFile<% else %>$BillFile<% end_if %></td><td><% if Product.Online %><a href="$OnlineDeliveryLink" class="uk-button uk-button-secondary uk-button-small" title="<%t Shop.SeeProduct 'Produkt ansehen' %>"><%t Shop.ToProduct 'Zum Produkt' %></a><% end_if %></td></tr>
				    			<% end_loop %>
				    		</tbody>
				    	</table>
				    	<% else %>
				    	<p>Sie haben noch keine Bestellung.</p>
				    	<% end_if %>
				    </li>
				</ul>
			</div>
		</div>
	</div>
</section>