
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
		    </div>
		</div>
		<% end_loop %>
	</div>
	<% end_if %>