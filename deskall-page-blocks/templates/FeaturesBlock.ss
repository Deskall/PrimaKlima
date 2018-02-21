
<div class="uk-flex" data-uk-grid data-uk-lightbox>
	<% if ContentImage %>
	<div class="<% if Layout == right || Layout == left %>uk-width-1-3@m<% else %>uk-width-1-1<% end_if%>">
		<a href="$ContentImage.URL">
			<img class="<% if Layout == right || Layout == left %>uk-align-left<% else %>uk-align-center<% end_if %>" src="$ContentImage.URL" alt="">
		</a>
	</div>
	<div class="<% if Layout == right || Layout == left %>uk-width-2-3@m<% else %>uk-width-1-1<% end_if%> <% if Layout == "right" || Layout == "hover" %>uk-flex-first<% end_if %>">$HTML
	</div>
	<% else %>
	$HTML
	<% end_if %>
</div>
<% if activeFeatures %>
	<% if $FeaturesTitle %>
		<h3>$FeaturesTitle</h3>
	<% end_if %>
	<ul class="uk-list uk-list-large uk-text-large dk-list">
	<% loop activeFeatures %> 
	    <li data-uk-icon="icon: $Top.IconItem; ratio:1.5" class="dk-large-icon">$Text</li>
	<% end_loop %>
	</ul>
<% end_if %>
<% if $CallToActionLink.Page.Link %>
	<% include CallToActionLink c=w,b=secondary %>
<% end_if %>
