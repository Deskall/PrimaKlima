<section class="uk-section $Background">
	<div class="uk-container <% if not FullWidth %>uk-container-medium<% end_if %>">
		<h2>$Title</h2>
		<div class="uk-flex" uk-grid uk-lightbox>
			<div class="<% if Layout == right || Layout == left %>uk-width-1-3@m<% else %>uk-width-1-1<% end_if%>"><a href="$ContentImage.URL"><img class="<% if Layout == right || Layout == left %>uk-align-left<% else %>uk-align-center<% end_if %>" src="$ContentImage.URL" alt=""></a></div>
			<div class="<% if Layout == right || Layout == left %>uk-width-2-3@m<% else %>uk-width-1-1<% end_if%> <% if Layout == "right" || Layout == "hover" %>uk-flex-first<% end_if %>">$HTML</div>
			
		</div>
		<% if RelatedPage %>
			<a class="uk-button uk-button-secondary uk-align-right" href="$RelatedPage.URL">Hier klicken</a>
		<% end_if %>
	</div>
</section>