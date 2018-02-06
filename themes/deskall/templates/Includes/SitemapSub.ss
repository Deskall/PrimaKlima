<% if $Children %>
  <% loop $Children %>
    <li>
      <a href="$Link">$MenuTitle.XML</a>
      <% if $Children %>
        <ul>
          <% include SitemapSub %>
        </ul>
      <% end_if %>
    </li>
  <% end_loop %>
<% end_if %>