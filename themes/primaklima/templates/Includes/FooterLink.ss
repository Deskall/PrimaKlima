		<li data-uk-icon="icon:  <% if $Icon %>$Icon;<% else %>chevron-right<% end_if %>">
		    <% if $CallToActionLink.Page.Link %>
		        <% with $CallToActionLink %>
		            <a href="{$Page.Link}"
		                <% if $TargetBlank %>target="_blank"<% end_if %>
		                <% if $Description %>title="{$Description.ATT}"<% end_if %>>
		                {$Text.XML}
		            </a>
		        <% end_with %>
		    <% end_if %>
		    $Content
		</li>