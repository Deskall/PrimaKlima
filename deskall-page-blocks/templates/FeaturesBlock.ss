
<div class="uk-flex" data-uk-grid data-uk-lightbox>
	<% if ContentImage %>
	<div class="<% if Layout == right || Layout == left %>uk-width-1-3@m<% else %>uk-width-1-1<% end_if%>">
		<a href="$ContentImage.URL">
			<img src="$ContentImage.URL" alt="">
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
	<ul class="uk-list uk-list-large dk-list">
	<% loop activeFeatures %> 
	    <li data-uk-icon="icon: $Top.IconItem; ratio:1.2" class="dk-large-icon"><span class="uk-text-large">$Text</span></li>
	<% end_loop %>
	</ul>
<% end_if %>
<% if $CallToActionLink.Page.Link %>
	<% include CallToActionLink c=w,b=secondary,pos=right %>
<% end_if %>
