<div id="overlay-$ID" class="overlay-modal" data-uk-modal>
    <div class="uk-modal-dialog">
    	<div class="<% if BackgroundImage.exists %>uk-cover-container<% end_if %>" <% if BackgroundImage.exists %>style="background-image: url($BackgroundImage.URL);"<% end_if %>>
	        <button class="uk-modal-close-default" type="button" data-uk-close></button>
	        <% if Title %>
	        <div class="uk-modal-header">
	            <h2 class="uk-modal-title">$Title</h2>
	        </div>
	        <% end_if %>
	        <div class="uk-modal-body">
	        	<% if Subtitle %><h3>$Subtitle</h3><% end_if %>
	        	<% if Content %>
	        	<div class="dk-text-content">
	        		$Content
	        	</div>
	        	<% end_if %>
	        </div>
	        <div class="uk-modal-footer uk-text-right">
	        	<button class="uk-button uk-button-default uk-modal-close" type="button">Zurück</button>
	        	<button class="uk-button uk-button-primary" type="button">OK</button>
	        </div>
	    </div>
    </div>
</div>