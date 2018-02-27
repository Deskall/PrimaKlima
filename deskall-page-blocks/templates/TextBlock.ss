
<div class="uk-panel" data-uk-lightbox>
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
<% if $CallToActionLink.Page.Link %>
	<% include CallToActionLink c=w,b=secondary,pos=right %>
<% end_if %>
