<% loop $userFriendlyDataObject("Slides").sort(SortOrder)  %>
	<% if $First %>
		<% if $TotalItems > 1%>
  			<div id="owl-slider" class="owl-carousel owl-theme">
		<% else %>
  			<div id="owl-slider-single-slide" class="owl-carousel owl-theme">
		<% end_if %>

	<% end_if %>
    <div class="item" <% if $SlideImage %> style="background-image: url($SlideImage.SameImage.URL); background-position: center $SlideImagePosition;" <% end_if %>  >

    </div>

<% end_loop %>
    </div>