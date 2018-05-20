<% if Effect == "fixed" || Effect == "parallax" %>
<div class="uk-background-cover uk-background-norepeat uk-padding-small $Height uk-width-1-1 <% if Background %>$Background dk-overlay <% end_if %><% if Effect == "fixed" %>uk-background-fixed<% end_if %> <% if Height == "viewport" %>uk-height-viewport<% end_if %>" style="background-image: url($Image.URL);" <% if Effect == "parallax" %>uk-parallax="$EffectOptions"<% end_if %> >

    <div class="uk-container uk-position-relative <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %> $Height">
	    <div class="$Layout uk-padding-small">
	    	<% if $Title && $ShowTitle %>
		        <h2 class="$TitleAlign">$Title</h2>
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
<% else %>
	<div class="uk-cover-container uk-width-1-1 $Height <% if Height == "viewport" %>uk-height-viewport<% end_if %> <% if Background %>$Background dk-overlay <% end_if %>">
		<% if Effect == "kenburns" %><div class="uk-position-cover uk-animation-kenburns $EffectOptions"><% end_if %>
			<% if $Image.getExtension == "svg" %><img src="$Image.URL" alt="$Image.AltTag($Title)" title="$Image.TitleTag($Title)" width="$Image.Width" height="$ImageHeight" data-uk-cover /><% else %>$Image.Banners(600,450,$ImageHeight)<% end_if %>
		<% if Effect == "kenburns" %></div><% end_if %>
		<div class="uk-container uk-position-relative <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %> $Height">
		    <div class="$Layout uk-padding-small">
		    	<% if $Title && $ShowTitle %>
			        <h2 class="$TitleAlign">$Title</h2>
			    <% end_if %>

			    <div class="uk-text-lead $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
				    $Content
				</div>

			 	
			 	<% if LinkableLinkID > 0 %>
			 		<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
			 	<% end_if %>
		    </div>
		</div>
	</div>
<% end_if %>