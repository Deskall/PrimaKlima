<div class="calltoaction-container">
	<% with $CallToActionLink %>
		<a href="{$Page.Link}" class="uk-button uk-button-secondary uk-align-right"
		<% if $TargetBlank %>target="_blank"<% end_if %>
		<% if $Description %>title="{$Description.ATT}"<% end_if %>>
		{$Text.XML}
		<% include DefaultLinkIcon %>
		</a>
	<% end_with %>
</div>