<div class="header-slider uk-position-relative">
	
		<div data-uk-slideshow="autoplay: true;animation: fade;autoplay-interval:5000;min-height: 300; max-height:300">
		    <ul class="uk-slideshow-items">
		    	<% loop SiteConfig.activeSlides %>
		        <li>
		        	<div class="uk-inline uk-width-1-1 uk-height-1-1">
					    <img src="$Image.FocusFill(320,250).URL" data-srcset="$Image.FocusFill(320,250).URL 320w, $Image.FocusFill(650,500).URL 650w, $Image.FocusFill(1200,800).URL 1200w, $Image.FocusFill(2500,1500).URL 2500w" alt="" data-uk-cover data-sizes="100vw" data-uk-img>
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