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
<div class="calltoaction-container uk-flex <% if not noMargin %>dk-margin-responsive<% end_if %> uk-flex-{$LinkableLink.LinkPosition}"  <% if LinkableLink.Embedded %>data-uk-lightbox<% end_if %>>
	<% with $LinkableLink %>
		<% if $LinkURL %>
		    <a href="$LinkURL" {$TargetAttr} <% if Rel %>rel="$Rel"<% end_if %> class="uk-button button-{$Background}" <% if hasIcone %>data-uk-icon="icon: $Icone"<% end_if %> <% if Embedded %>data-type="iframe"<% end_if %>>$Title</a>
		<% end_if %>
	<% end_with %>
</div> 