<div class="header-slider uk-position-relative">
	
		<div data-uk-slideshow="autoplay: true;animation: fade;autoplay-interval:5000;min-height: 300; max-height:300">
		    <ul class="uk-slideshow-items">
		    	<% loop SiteConfig.activeSlides %>
		        <li>
		        	<div class="uk-inline uk-width-1-1 uk-height-1-1">
					    <img data-src="$Image.FocusFillMax(1500,300).Link" sizes="100vw"
                         data-srcset="$Image.FocusFillMax(400,300).Link 400w,
                         $Image.FocusFillMax(600,300).Link 600w,
                         $Image.FocusFillMax(800,300).Link 800w,
                         $Image.FocusFillMax(1200,300).Link 1200w,
                         $Image.FocusFillMax(1500,300).Link 1500w,
                         $Image.FocusFillMax(2500,300).Link 2500w"  alt="$Image.AtlTag($Title)" data-uk-cover data-uk-img="target:<% if First %>!ul > :last-child, !* +*"<% else_if Last %>!* -*, !ul > :first-child<% else %>!.uk-slideshow-items<% end_if %>">
					    <div class="uk-overlay uk-position-bottom-right uk-text-right">
					    	<div class="header-slide-title">$Title</div>
		            		<div class="header-slide-subtitle">$Content</div>
		            	</div>
					</div>
		        </li>
		        <% end_loop %>
		    </ul>
		</div>
</div>