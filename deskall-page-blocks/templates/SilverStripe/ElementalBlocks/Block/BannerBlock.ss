<div class="uk-cover-container $Height uk-width-1-1" <% if Height == "viewport" %>data-uk-height-viewport<% end_if %>>
    <img src="$File.URL" alt="" data-uk-cover>
    <div class="uk-position-center">
    	<% if $Title && $ShowTitle %>
	        <h2>$Title</h2>
	    <% end_if %>

	    $Content

	   <% if $CallToActionLink.Page.Link %>
			<% include CallToActionLink c=w %>
		<% end_if %>
    </div>
</div>