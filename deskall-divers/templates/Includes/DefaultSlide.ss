

       	<% if $ID < 0 || $showSlide %>
        	
				<% if firstBlockSlide && ParentID > 0 && ParentSlide.Slides.First.ID %>
				<div data-uk-slideshow="min-height:150;max-height:300;" class="dk-slider dk-slide-default uk-visible-toggle uk-position-relative">
				    <ul class="uk-slideshow-items">
				        <li>
				        	<picture>
								<% with $ParentSlide.Slides.First.Image %>
								<source media="(min-width: 2000px)" srcset="$FocusFill(2500,300).URL">
								<source media="(min-width: 1400px)" srcset="$FocusFill(2000,300).URL">
								<source media="(min-width: 1000px)" srcset="$FocusFill(1400,300).URL">
								<source media="(min-width: 600px)" srcset="$FocusFill(1000,300).URL">
								<source media="(min-width: 400px)" srcset="$FocusFill(600,300).URL">
								<img src="$FocusFill(400,300).URL" <% if $ExtraClasses %> class="$ExtraClasses"<% end_if %>  alt="$altTag" title="$titleTag">
								<% end_with %>
							</picture> 
					    </li>
					 </ul>
				</div>
				<% else_if $SiteConfig.DefaultSlide %>
				<div data-uk-slideshow="min-height:150;max-height:300;" class="dk-slider dk-slide-default uk-visible-toggle uk-position-relative">
				    <ul class="uk-slideshow-items">
				        <li>
				        	<picture>
								<% with $SiteConfig.DefaultSlide %>
								<source media="(min-width: 2000px)" srcset="$FocusFill(2500,300).URL">
								<source media="(min-width: 1400px)" srcset="$FocusFill(2000,300).URL">
								<source media="(min-width: 1000px)" srcset="$FocusFill(1400,300).URL">
								<source media="(min-width: 600px)" srcset="$FocusFill(1000,300).URL">
								<source media="(min-width: 400px)" srcset="$FocusFill(600,300).URL">
								<img src="$FocusFill(400,300).URL" <% if $ExtraClasses %> class="$ExtraClasses"<% end_if %>  alt="$altTag" title="$titleTag">
								<% end_with %>
							</picture>
						</li>
				    </ul>
				</div>
				<% end_if %>              
      <% end_if %>  