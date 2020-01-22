<div id="offcanvas-flip" data-uk-offcanvas="mode: reveal; overlay: true">
        <div class="uk-offcanvas-bar uk-width-1-1 dk-nav-mobile-container">
           <button class="uk-offcanvas-close" type="button" data-uk-close></button>
           <% if $ID > 0 %>
           <div class="uk-margin">
           	<ul class="uk-navbar-nav sub">
           		<li><a id="toggle-modal-postal-code" data-uk-tooltip="<%t PLZ.CHANGE 'Region ändern' %>" data-active="<% if activePLZ %>true<% else %>false<% end_if %>" data-trigger="<% if showModalPLZ %>true<% else %>false<% end_if %>" title="Ihrer PLZ auswählen / Ändern" data-uk-toggle="#modal-postal-code"><% if activePLZ %>Ihre Region: $activePLZ.CodeCity ($activeOffer)<% else %> Region unbekannt<% end_if %></a>
           		</li>
           		<% if activePLZ %>
           		<li>
           			<a href="{$Link}plz-loeschen" class="uk-padding-remove" title="Region löschen" data-uk-tooltip="<%t PLZ.CLEAR 'Region löschen' %>"><i class="icon icon-close-circled"></i></a>
           		</li>
           		<% end_if %>
           	</ul>
           </div>
           <% end_if %>
           <div class="uk-margin-top">
           <% loop SiteConfig.activeMobileMenuBlocks %>
				<% if Type == 'form' %>
					<div class="$Layout $Width uk-visible@m">$Top.SearchForm</div>
				<% else_if Type == "Languages" %>
					<% include MenuBlock_Languages Locales=Top.Locales %>
				<% else %>
					$forTemplate
				<% end_if %>
			<% end_loop %>
			</div>
        </div>

    </div>