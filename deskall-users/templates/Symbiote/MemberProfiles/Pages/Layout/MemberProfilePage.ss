

<% include DefaultSlide %>

$ElementalArea

ici

<div class="element" id="member-section">
	<section class="uk-section">

		<div class="uk-container">
			<% if $Type == 'Register' %>
			<% include Symbiote/MemberProfiles/Pages/MemberProfilePage_register %>
			<% else_if $Type == 'Add' %>
			<% include Symbiote/MemberProfiles/Pages/MemberProfilePage_addmember %>
			<% else %>
			log in
			<% end_if %>
			
		</div>
	</section>
</div>
