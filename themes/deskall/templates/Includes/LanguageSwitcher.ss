<div id="tdLangNav">
      <ul>
        <% if $Product %>
          <li><a href="$Product.Link('de_DE')" <% if ContentLocale == 'de-DE' %>class="current"<% end_if %>  title="Deutsch">DE</a></li>
          <li><a href="$Product.Link('fr_FR')" <% if ContentLocale == 'fr-FR' %>class="current"<% end_if %> title="Franzosich">FR</a></li>
        <% else_if $News %>
          <li><a href="$News.Link('de_DE')" <% if ContentLocale == 'de-DE' %>class="current"<% end_if %> title="Deutsch">DE</a></li>
          <li><a href="$News.Link('fr_FR')" <% if ContentLocale == 'fr-FR' %>class="current"<% end_if %> title="Franzosich">FR</a></li>
        <% else %>
        <% loop Languages %>
        <li><a href="$Link" class="$LinkingMode" title="$Title.ATT">$Language</a></li>
        <% end_loop %>
        <% end_if %>
      </ul>
  </div>