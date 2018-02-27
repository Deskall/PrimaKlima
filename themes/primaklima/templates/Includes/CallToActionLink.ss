<div class="calltoaction-container uk-flex dk-margin-responsive uk-flex-{$pos}">
	<% with $CallToActionLink %>
		<a href="{$Page.Link}" class="uk-button uk-button-{$Top.b}"
		<% if $TargetBlank %>target="_blank"<% end_if %>
		<% if $Description %>title="{$Description.ATT}"<% end_if %>>
		{$Text.XML}
		<% include DefaultLinkIcon c=$Top.c %>
		</a>
	<% end_with %>
</div>