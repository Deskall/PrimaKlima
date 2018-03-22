<%-- <div class="calltoaction-container uk-flex <% if not noMargin %>dk-margin-responsive<% end_if %> uk-flex-{$pos}">
	<% with $CallToActionLink %>
		<a href="{$Page.Link}" class="uk-button uk-button-{$Top.b}"
		<% if $TargetBlank %>target="_blank"<% end_if %>
		<% if $Description %>title="{$Description.ATT}"<% end_if %>>
		{$Text.XML}
		<% include DefaultLinkIcon c=$Top.c %>
		</a>
	<% end_with %>
</div> --%>
<div class="calltoaction-container uk-flex <% if not noMargin %>dk-margin-responsive<% end_if %> uk-flex-{$LinkableLink.LinkPosition}">
	<% with $LinkableLink %>
		<% if $LinkURL %>
		    <a href="$LinkURL" {$TargetAttr} class="uk-button $Background" data-uk-icon="icon: $Icone">$Title</a>
		<% end_if %>
	<% end_with %>
</div>