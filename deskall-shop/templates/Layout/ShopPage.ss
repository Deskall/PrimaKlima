<% if CurrentCustomer && Content %>
	<section class="uk-section uk-section-small no-bg">
		<div class="uk-container">
			<h1>$Title</h1>
			<div class="dk-text-content">$Content</div>
		</div>
	</section>
<% else %>
$ElementalArea

<section class="uk-section no-bg uk-padding-remove-top">
	<% if CurrentCustomer %>
			<% if CurrentCustomer.activeOrder %>
				<div class="uk-container">
					<p><%t Checkout.AlreadyActive 'Sie haben bereits ein aktives Paket.' %></p>
					<a href="$CurrentUser.MemberPageLink"><%t Checkout.PortalLink 'zu Ihrem Portal' %><i class="icon icon-chevron-right uk-margin-small-left"></i></a>
				</div>
			<% else %>
				$CheckoutForm
			<% end_if %>
	<% else %>
		<% include LoginOrRegister %>
	<% end_if %>
</section>
<% end_if %>
