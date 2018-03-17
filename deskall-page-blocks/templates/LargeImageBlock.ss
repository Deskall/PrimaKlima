<%-- <div class="uk-background-cover uk-background-norepeat uk-padding-small $Height uk-width-1-1 <% if Effect == "fixed" %>uk-background-fixed<% end_if %> <% if Height == "viewport" %>uk-height-viewport<% end_if %>" style="background-image: url($Image.URL);" <% if Effect == "parallax" %>uk-parallax="$EffectOptions"<% end_if %> >

    <div class="uk-container uk-position-relative <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %> $Height">
	    <div class="$Layout">
	    	<% if $Title && $ShowTitle %>
		        <h2>$Title</h2>
		    <% end_if %>

		    <div class="uk-text-lead $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
			    $Content
			</div>

		 	<% if $CallToActionLink.Page.Link %>
				<% include CallToActionLink c=w,b=secondary,pos=right %>
			<% end_if %>
	    </div>
	</div>
</div>
<hr> --%>
	<div class="uk-cover-container uk-width-1-1 $Height <% if Height == "viewport" %>uk-height-viewport<% end_if %> ">
		<% if Effect == "fixed" %><div class="background-fixed"><% end_if %>
		<% if $Image.getExtension == "svg" %><img src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Image.Width" height="$ImageHeight" data-uk-cover /><% else %>$Image.Banners(600,450,$ImageHeight)<% end_if %>
		<div class="uk-container uk-position-relative <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %> $Height">
		    <div class="$Layout">
		    	<% if $Title && $ShowTitle %>
			        <h2>$Title</h2>
			    <% end_if %>

			    <div class="uk-text-lead $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
				    $Content
				</div>

			 	<% if $CallToActionLink.Page.Link %>
					<% include CallToActionLink c=w,b=secondary,pos=$LinkPosition %>
				<% end_if %>
		    </div>
		</div>
		<% if Effect == "fixed" %></div><% end_if %>
	</div>
