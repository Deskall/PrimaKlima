<dl class="uk-description-list uk-description-list-divider">
    <dt>Description term</dt>
    <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</dd>
    <dt>Description term</dt>
    <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</dd>
    <dt>Description term</dt>
    <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</dd>
    <% loop Items %>
    <dt>$Title</dt>
    <dd>$Content<br/>
    	<% if LinkableLinkID > 0 %>
    		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
    	<% end_if %>
    </dd>
    <% end_loop %>
</dl>