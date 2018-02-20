
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
	<% if $FeaturesTitle %>
		<h3>$FeaturesTitle</h3>
	<% end_if %>
	<ul class="uk-list uk-list-large uk-text-large dk-list">
	<% loop activeFeatures %> 
	    <li uk-icon="icon: $Top.IconItem; ratio:2" class="dk-large-icon">$Text</li>
	<% end_loop %>
	</ul>
<% end_if %>
<% if $CallToActionLink.Page.Link %>
		<% with $CallToActionLink %>
		<a href="{$Page.Link}" class="uk-button uk-button-secondary uk-position-bottom-right"
		<% if $TargetBlank %>target="_blank"<% end_if %>
		<% if $Description %>title="{$Description.ATT}"<% end_if %>>
		{$Text.XML}
		<% include DefaultLinkIcon c=w %>
		</a>
		<% end_with %>
<% end_if %>
