<div id="overlay-$ID" class="overlay-modal" data-triggered="false" data-uk-modal data-trigger-type="$TriggerType" <% if TriggerType == "Time" %>data-trigger-time="$TriggerTime"<% end_if %>>
    <div class="uk-modal-dialog">
    	<div class="<% if BackgroundImage.exists %>uk-cover-container<% end_if %> <% if BackgroundColor %>$BackgroundColor dk-overlay<% end_if %>" <% if BackgroundImage.exists %>style="background-image: url($BackgroundImage.FocusFill(600,800).URL);"<% end_if %>>
    		<div class="modal-container">
		        <button class="uk-modal-close-default" type="button" data-uk-close></button>
		        <% if Title %>
		        <div class="uk-modal-header">
		            <h2 class="uk-modal-title">$Title</h2>
		        </div>
		        <% end_if %>
		        <div class="uk-modal-body">
		        	<% if FormBlock.exists %>
			        	<% with FormBlock.Controller %>
			        		$Me
			        	<% end_with %>
		        	<% else %>
			        	<% if Subtitle %><h3>$Subtitle</h3><% end_if %>
			        	<% if Content %>
			        	<div class="dk-text-content">
			        		$Content
			        	</div>
			        	<% end_if %>
		        	<% end_if %>
		        </div>
		        <div class="uk-modal-footer uk-text-right">
		        	<button class="uk-button button-$CloseButtonBackground uk-modal-close" type="button">$CloseButtonText</button>
		        	<% if LinkableLink.exists %>
		        	<% with LinkableLink %>
		        	<a href="$LinkURL" {$TargetAttr} <% if Rel %>rel="$Rel"<% end_if %> class="<% if Background %>uk-button button-{$Background}<% end_if %>" <% if hasIcone %>data-uk-icon="icon: $Icone"<% end_if %> <% if Embedded %>data-type="iframe"<% end_if %>>$Title</a>
		        	<% end_with %>
		        	<% end_if %>
		        	<%-- <button class="uk-button button-$ValidButtonBackground" type="button">$ValidButtonText</button> --%>
		        </div>
		    </div>
	    </div>
    </div>
</div>