<div class="uk-background-cover uk-background-norepeat uk-padding-small $Height uk-width-1-1 <% if Effect == "fixed" %>uk-background-fixed<% end_if %> <% if Height == "viewport" %>uk-height-viewport<% end_if %>" style="background-image: url($File.URL);" <% if Effect == "parallax" %>uk-parallax="$EffectOptions"<% end_if %> >

    <div class="uk-container uk-position-relative <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %> $Height">
	    <div class="$Layout">
	    	<% if $Title && $ShowTitle %>
		        <h2>$Title</h2>
		    <% end_if %>

		    $Content

		 	<% if $CallToActionLink.Page.Link %>
				<% include CallToActionLink c=w %>
			<% end_if %>
	    </div>
	</div>
</div>