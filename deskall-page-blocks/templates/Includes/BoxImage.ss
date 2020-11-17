<% if $Image.getExtension == "svg" %>
<div class="uk-flex uk-flex-center uk-flex-middle">
	<figure>
		<img class="uk-preserve dk-icon uk-width-auto  <% if Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.URL" alt="$Alt"  width="$Width" height="$Width" />
		<% if Image.Description %><figcaption>$Image.Description</figcaption><% end_if %>
	</figure>
</div>
<% else %>
	<% if not FullLink %><a href="$Image.getSourceURL" class="dk-lightbox" data-caption="$Image.Description"><% end_if %>
		<figure>
			<img class="uk-preserve dk-icon uk-width-auto <% if Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.Square($Width).URL" alt="$Alt"  width="$Width" height="$Width" />
			<% if Image.Description %><figcaption>$Image.Description</figcaption><% end_if %>
		</figure>
	<% if not FullLink %></a><% end_if %>
<% end_if %>