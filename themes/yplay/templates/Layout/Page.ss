
	$ElementalArea
	
	<% if $ID < 0 %> 
		<% if Form || Content %>
		<section class="uk-section">
			<div class="uk-container">
				<h1>$Title</h1>
				$Content
				$Form
			</div>
		</section>
		<% end_if %>
	<% end_if %>
	
	<% if $LateralSections.exists %>
	<div class="uk-position-fixed uk-position-center-right uk-position-z-index sidebar">
		<% loop LateralSections %>
	  	<button class="uk-button $ButtonFarbe" type="button" data-uk-toggle="target: #offcanvas-usage-{$ID}">$ButtonTitle</button>
		 <div id="offcanvas-usage-{$ID}" data-uk-offcanvas="flip:true;">
		    <div class="uk-offcanvas-bar dk-middle-offcanvas">
		        <button class="uk-offcanvas-close" type="button" data-uk-close></button>
		        <h3>$Title</h3>
		        $Text
		        <ul class="uk-nav uk-padding-remove">
		        	<% loop Links %>
		        	<li>
		        		<div class="uk-grid-small" data-uk-grid>
		        			<% if Label %><div class="uk-width-1-5"><span class="uk-label $Background uk-margin-small-right uk-border-rounded">$Label</span></div><% end_if %>
		        			<div class="<% if Label %>uk-width-4-5<% else %>uk-width-1-1<% end_if %>">
		        			    <a href="$LinkableLink.LinkURL" {$LinkableLink.TargetAttr} <% if $LinkableLink.hasIcone %>data-uk-icon="icon: $LinkableLink.Icone"<% end_if %>>
		        			    	$LinkableLink.Title
		        			    </a>
		        			</div>
		        	</li>
		        	<% end_loop %>
		        </ul>
		    </div>
		</div>
		<% end_loop %>
	</div>
	<% end_if %>