

<% include DefaultSlide %>



<div class="element" id="member-section">
	<section class="uk-section">

		<div class="uk-container uk-container-large">
			<h1>$Title</h1>
			<% if $Type == 'Register' %>
			<% include Symbiote/MemberProfiles/Pages/MemberProfilePage_register %>
			<% else_if $Type == 'Add' %>
			<% include Symbiote/MemberProfiles/Pages/MemberProfilePage_addmember %>
			<% else %>
			<% include Symbiote/MemberProfiles/Pages/MemberProfilePage_profile %>
			<% end_if %>
			
		</div>
	</section>
</div>
