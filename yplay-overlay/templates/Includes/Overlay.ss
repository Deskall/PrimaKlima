<div id="overlay-$Overlay.ID" class="overlay-modal" data-triggered="false" data-uk-modal data-trigger-type="$Overlay.TriggerType" <% if $Overlay.TriggerType == "Time" %>data-trigger-time="$Overlay.TriggerTime"<% end_if %>>
    <div class="uk-modal-dialog">
    	<div class="<% if $Overlay.BackgroundImage.exists %>uk-cover-container<% end_if %> <% if $Overlay.BackgroundColor %>$Overlay.BackgroundColor dk-overlay<% end_if %>" <% if $Overlay.BackgroundImage.exists %>style="background-image: url($Overlay.BackgroundImage.FocusFill(600,800).URL);"<% end_if %>>
    		<div class="modal-container">
		        <button class="uk-modal-close-default" type="button" data-uk-close></button>
		        <% if $Overlay.Title || $Overlay.CountDown %>
		        <div class="uk-modal-header">
		        	<% if $Overlay.CountDown %>
		        	<div class="uk-grid-small uk-child-width-auto uk-flex uk-flex-middle" data-uk-grid data-uk-countdown="date: $Overlay.CountDownDate">
		        	    <div>
		        	        <div class="uk-countdown-number uk-countdown-days"></div>
		        	        <div class="uk-countdown-label uk-visible@s">Tage</div>
		        	    </div>
		        	    <div class="uk-countdown-separator">:</div>
		        	    <div>
		        	        <div class="uk-countdown-number uk-countdown-hours"></div>
		        	        <div class="uk-countdown-label uk-visible@s">Uhren</div>
		        	    </div>
		        	    <div class="uk-countdown-separator">:</div>
		        	    <div>
		        	        <div class="uk-countdown-number uk-countdown-minutes"></div>
		        	        <div class="uk-countdown-label uk-visible@s">Minuten</div>
		        	    </div>
		        	    <div class="uk-countdown-separator">:</div>
		        	    <div>
		        	        <div class="uk-countdown-number uk-countdown-seconds"></div>
		        	        <div class="uk-countdown-label uk-visible@s">Sekunden</div>
		        	    </div>
		        	</div>
		        	<% end_if %>
		        	<% if $Overlay.Title %>
		            <h2 class="uk-modal-title">$Overlay.Title</h2>
		            <% end_if %>
		        </div>
		        <% end_if %>
		        <div class="uk-modal-body">
		        	<% if $Overlay.Subtitle %><h3>$Overlay.Subtitle</h3><% end_if %>
			        <% if $Overlay.Content %><div class="dk-text-content">$Overlay.Content</div><% end_if %>
		        	<% if $Overlay.Type == "Form" %>
			        	<% if $Overlay.FormBlock.exists %>
				        	<% with $Overlay.FormBlock.Controller %>
				        		$Me
				        	<% end_with %>
				        <% end_if %>
				    <% else_if $Overlay.Type == "Newsletter" %>
				    	$NewsletterForm
				    <% else_if $Overlay.Type == "Bewertung" %>
				    	Bewertung
		        	<% end_if %>
		        </div>
		        <% if $Overlay.Type == "Text" %>
		        <div class="uk-modal-footer uk-text-right">
		        	<button class="uk-button button-$Overlay.CloseButtonBackground uk-modal-close" type="button">$Overlay.CloseButtonText</button>
		        	<% if $Overlay.LinkableLink.exists %>
		        	<% with $Overlay.LinkableLink %>
		        	<a href="$LinkURL" {$TargetAttr} <% if Rel %>rel="$Rel"<% end_if %> class="<% if Background %>uk-button button-{$Background}<% end_if %>" <% if hasIcone %>data-uk-icon="icon: $Icone"<% end_if %> <% if Embedded %>data-type="iframe"<% end_if %>>$Title</a>
		        	<% end_with %>
		        	<% end_if %>
		        </div>
		        <% end_if %>
		    </div>
	    </div>
    </div>
</div>