<div class="uk-cover-container $Height uk-width-1-1" <% if Height == "viewport" %>uk-height-viewport<% end_if %>>
    <img src="$File.URL" alt="" uk-cover>
    <div class="uk-position-center">
    	<% if $Title && $ShowTitle %>
	        <h2>$Title</h2>
	    <% end_if %>

	    $Content

	    <%-- Add a CallToActionLink if available --%>
	    <% if $CallToActionLink.Page.Link %>
	       
	        <% with $CallToActionLink %>
	            <a href="{$Page.Link}" 
	                <% if $TargetBlank %>target="_blank"<% end_if %>
	                <% if $Description %>title="{$Description.ATT}"<% end_if %>>
	                {$Text.XML}
	            </a>
	        <% end_with %>
	        
	    <% end_if %>
    </div>
</div>