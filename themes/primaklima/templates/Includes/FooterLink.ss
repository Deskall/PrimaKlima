
		    <% if $CallToActionLink.Page.Link %>
		        <% with $CallToActionLink %>
		            <a href="{$Page.Link}"
		                <% if $TargetBlank %>target="_blank"<% end_if %>
		                <% if $Description %>title="{$Description.ATT}"<% end_if %>>
		                <% if $Top.Icon %>
		                	<span uk-icon="icon: $Top.Icon; ratio: 0.8"></span>
		                <% end_if %>
		                {$Text.XML}
		            </a>
		        <% end_with %>
		    <% end_if %>
		    $Content