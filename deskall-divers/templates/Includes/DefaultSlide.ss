
<div data-uk-slideshow="min-height:150;max-height:300;" class="dk-slider dk-slide-default uk-visible-toggle uk-position-relative">
    <ul class="uk-slideshow-items">
        <li>
        	<picture>
				<%-- video tag is needed for IE9 support - see https://scottjehl.github.io/picturefill/ --%>
				<!--[if IE 9]><video style="display: none;"><![endif]-->
				<% if noSlide && ParentID > 0 && ParentSlide.Slides.First.ID %>
					<% with $ParentSlide.Slides.First.Image %>
					<source media="(min-width: 2000px)" srcset="$ScaleWidth(2500).URL">
					<source media="(min-width: 1400px)" srcset="$ScaleWidth(2000).URL">
					<source media="(min-width: 1000px)" srcset="$ScaleWidth(1400).URL">
					<source media="(min-width: 600px)" srcset="$ScaleWidth(1000).URL">
					<source media="(min-width: 400px)" srcset="$ScaleWidth(600).URL">
					<!--[if IE 9]></video><![endif]-->
					<img src="$ScaleWidth(400).URL" <% if $ExtraClasses %> class="$ExtraClasses"<% end_if %>  alt="$altTag" title="$titleTag">
					<% end_with %>
				<% else %>
					<% with $SiteConfig.DefaultSlide %>
					<source media="(min-width: 2000px)" srcset="$ScaleWidth(2500).URL">
					<source media="(min-width: 1400px)" srcset="$ScaleWidth(2000).URL">
					<source media="(min-width: 1000px)" srcset="$ScaleWidth(1400).URL">
					<source media="(min-width: 600px)" srcset="$ScaleWidth(1000).URL">
					<source media="(min-width: 400px)" srcset="$ScaleWidth(600).URL">
					<!--[if IE 9]></video><![endif]-->
					<img src="$ScaleWidth(400).URL" <% if $ExtraClasses %> class="$ExtraClasses"<% end_if %>  alt="$altTag" title="$titleTag">
					<% end_with %>
				<% end_if %>
			</picture>               
        </li>
    </ul>
</div>