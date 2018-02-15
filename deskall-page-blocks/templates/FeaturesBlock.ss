
<div class="uk-flex" uk-grid uk-lightbox>
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
	<ul class="uk-list uk-list-large uk-text-large dk-list dk-text-white">
	<% loop activeFeatures %> 
	    <li><span uk-icon="icon: $Icon; ratio:2" class="uk-position-top-center"></span>$Text</li>
	<% end_loop %>
	</ul>
<% end_if %>
<% if $CallToActionLink.Page.Link %>
		<% with $CallToActionLink %>
		<a href="{$Page.Link}" class="uk-button uk-button-secondary uk-align-right"
		<% if $TargetBlank %>target="_blank"<% end_if %>
		<% if $Description %>title="{$Description.ATT}"<% end_if %>>
		{$Text.XML}
		</a>
		<% end_with %>
	<% end_if %>
