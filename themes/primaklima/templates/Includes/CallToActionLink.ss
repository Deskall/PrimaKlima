<div class="calltoaction-container uk-flex uk-margin uk-flex-right">
	<% with $CallToActionLink %>
		<a href="{$Page.Link}" class="uk-button <% if $Top.c == w %>uk-button-secondary<% end_if %>"
		<% if $TargetBlank %>target="_blank"<% end_if %>
		<% if $Description %>title="{$Description.ATT}"<% end_if %>>
		{$Text.XML}
		<% include DefaultLinkIcon c=$Top.c %>
		</a>
	<% end_with %>
</div>