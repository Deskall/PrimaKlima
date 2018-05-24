<dl class="uk-description-list uk-description-list-divider">
    <dt>Description term</dt>
    <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</dd>
    <dt>Description term</dt>
    <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</dd>
    <dt>Description term</dt>
    <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</dd>
    <% loop Items %>
    <div data-uk-grid>
    	<div class="uk-width-1-2 uk-width-1-3@s uk-width-1-4@m uk-width-1-5@l">
    	</div>
    	<div class="uk-width-1-2 uk-width-2-3@s uk-width-3-4@m uk-width-4-5@l">
		    <dt>$Title</dt>
		    <dd>$Content<br/>
		    	<% if LinkableLinkID > 0 %>
		    		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
		    	<% end_if %>
		    </dd>
		</div>
	 </div>
    <% end_loop %>
</dl>