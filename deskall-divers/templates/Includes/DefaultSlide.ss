

       	<% if $ID < 0 || $showSlide %>
        	
				<% if firstBlockSlide && ParentID > 0 && ParentSlide.Slides.First.ID %>
				<div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="$ParentSlide.Slides.First.ScaleWidth(350).URL" data-srcset="$ParentSlide.Slides.First.ScaleWidth(320).URL 320w, $ParentSlide.Slides.First.ScaleWidth(650).URL 650w, $ParentSlide.Slides.First.ScaleWidth(1200).URL 1200w, $ParentSlide.Slides.First.ScaleWidth(2500).URL 2500w" alt="" data-sizes="100vw" data-uk-img>
				</div>
				<% else_if $SiteConfig.DefaultSlideID > 0 %>
				<div class="uk-height-medium uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="$SiteConfig.DefaultSlide.ScaleWidth(350).URL" data-srcset="$SiteConfig.DefaultSlide.ScaleWidth(320).URL 320w, $SiteConfig.DefaultSlide.ScaleWidth(650).URL 650w, $SiteConfig.DefaultSlide.ScaleWidth(1200).URL 1200w, $SiteConfig.DefaultSlide.ScaleWidth(2500).URL 2500w" alt="" data-sizes="100vw" data-uk-img>
				</div>
				<% end_if %>              
      <% end_if %>  