<% if $Image.getExtension == "svg" %>
<div class="uk-flex uk-flex-center uk-flex-middle">
	<figure>
		<img class="uk-preserve dk-icon uk-width-auto <% if Top.RoundedImage %>uk-border-circle<% end_if %> <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.Square($Up.PictureWidth).URL" alt="$Top.AltTag($Image.Description, $Image.Name, $Title)"  width="$Up.PictureWidth" height="$Up.PictureWidth" />
		<% if Image.Description %><figcaption>$Image.Description</figcaption><% end_if %>
	</figure>
</div>
<% else %>
	<% if not Top.FullLink %><a href="$Image.getSourceURL" class="dk-lightbox" data-caption="$Image.Description"><% end_if %>
		<figure>
			<img class="uk-preserve dk-icon uk-width-auto <% if Top.RoundedImage %>uk-border-circle<% end_if %> <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.Square($Up.PictureWidth).URL" alt="$Top.AltTag($Image.Description, $Image.Name, $Title)"  width="$Up.PictureWidth" height="$Up.PictureWidth" />
			<% if Image.Description %><figcaption>$Image.Description</figcaption><% end_if %>
		</figure>
	<% if not Top.FullLink %></a><% end_if %>
<% end_if %>