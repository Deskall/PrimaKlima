<div class="image-block">
	<% if $Content %>
	<div class="image-block-text">
		$Content
	</div>
	<% end_if %>

	<% if $Images %>
	<div class="image-block-gallery">
	  <div class="owl-gallery owl-carousel owl-theme">
	    <% loop $Images.Sort('SortOrder') %>
	      <div class="item">
	        <a href="$URL" title="$Description" data-imagelightbox="{$Top.ID}f">
	        	<% if $Pos > 4 %>
	        	<img class="lazyOwl" data-src="$CroppedFocusedImage(350,250).URL" data-src-retina="$CroppedFocusedImage(350,250).URL" alt="$Description" />
	        	<% else %>
	        	<img src="$CroppedFocusedImage(350,250).URL" alt="$Description"/>
	        	<% end_if %>
	        </a>
	      </div>
	    <% end_loop %>
	  </div>
	</div>
	<% end_if %>
</div>