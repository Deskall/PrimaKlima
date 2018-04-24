<div class="calltoaction-container uk-flex <% if not noMargin %>dk-margin-responsive<% end_if %> uk-flex-{$TextAlignment}">
		<% if InteractionType == "dropdown" %>
		<div class="uk-inline uk-width-1-1">
			<% if $Trigger %>
			    <button class="uk-button $ButtonBackground $ButtonPosition" data-uk-toggle="target: #content-container-{$ID}" type="button" data-uk-icon="icon: $Icone">$Trigger</button>
			<% end_if %>
			<div data-uk-dropdown="pos: $DropdownPosition;mode:$DropdownTrigger;">
				 <% include TextBlock %>
			</div>
		</div>
		<% else_if InteractionType == "offcanvas" %>
		    <button class="uk-button $ButtonBackground $ButtonPositiont" type="button" data-uk-toggle="target: #offcanvas-container-{$ID}">$Trigger</button>
		<% else_if InteractionType == "scroll" %>
		 <a class="uk-button $ButtonBackground $ButtonPosition" href="#e{$Target}" data-uk-scroll type="button" data-uk-icon="icon: $Icone">$Trigger</a>
		<% else_if InteractionType == "toggle" %>
		 <a class="uk-button $ButtonBackground $ButtonPosition" data-uk-toggle="target: #toggle-container-{$ID};<% if ToggleClass %>cls: $ToggleClass;<% end_if %>"  type="button" data-uk-icon="icon: $Icone">$Trigger</a>
		<% else %>
			<% if $Trigger %>
			    <button class="uk-button $ButtonBackground $ButtonPosition" data-uk-toggle="target: #content-container-{$ID}" type="button" data-uk-icon="icon: $Icone">$Trigger</button>
			<% end_if %>
		<% end_if %>
</div>

<% if InteractionType == "modal" %>
<div id="content-container-{$ID}" class="$ModalSize" data-uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-padding-remove">
    	<button class="uk-modal-close-default" type="button" data-uk-close></button>
    	<% if ModalSize == "uk-modal-full" %>
    		<% if $ContentImage %>
	       	<div class="uk-grid-collapse uk-child-width-1-2@s uk-flex-middle" data-uk-grid>
	            <div class="uk-background-cover uk-first-column" style="background-image: url($ContentImage.URL); box-sizing: border-box; min-height: 100vh; height: 100vh;" data-uk-height-viewport></div>
	            <div class="uk-padding-large" data-uk-overflow-auto data-uk-height-viewport>
	               <h3 class="uk-modal-title">$Title</h3>
					<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>"> 
						$HTML
					</div>
					<button class="uk-button uk-modal-close $ButtonBackground $ButtonPosition dk-margin-responsive" type="button">$CloseText</button>
	            </div>
	        </div>
	        <% else %>
	          	<div class="uk-padding-large" data-uk-overflow-auto data-uk-height-viewport>
	          		<h3 class="uk-modal-title">$Title</h3>
	               	<div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>"> 
						
						$HTML
					</div>
					<button class="uk-button uk-modal-close $ButtonBackground $ButtonPosition dk-margin-responsive" type="button">$CloseText</button>
	            </div>
	        <% end_if %>
        <% else %>
      		<div class="uk-padding-large" <% if ModalScroll %>data-uk-overflow-auto<% end_if %>>
      			<% if Title and ShowTitle %><h3 class="uk-modal-title">$Title</h3><% end_if %>
                <% include TextBlock %>
				<button class="uk-button uk-modal-close $ButtonBackground $ButtonPosition dk-margin-responsive" type="button">$CloseText</button>
           	</div>
        <% end_if %>
    </div>
</div>
<% end_if %>

<% if InteractionType == "offcanvas" %>
<div id="offcanvas-container-{$ID}" data-uk-offcanvas="mode: $Effect;<% if OffcanvasPosition == "right" %>flip: true;<% end_if %><% if OffcanvasOverlay %>overlay: true;<% end_if %>">
        <div class="uk-offcanvas-bar">
            <button class="uk-offcanvas-close" type="button" data-uk-close></button>
	         	<% if Title and ShowTitle %><h3 class="uk-modal-title">$Title</h3><% end_if %>
	          	<% include TextBlock %>
            <button class="uk-button dk-margin-responsive" type="button" data-uk-toggle="target: #offcanvas-container-{$ID}">$CloseText</button>
        </div>
    </div>
<% end_if %>

<% if InteractionType == "toggle" %>
<div id="toggle-container-{$ID}">
	<% if Title and ShowTitle %><h3>$Title</h3><% end_if %>
	<% include TextBlock %>      
</div>
<% end_if %>