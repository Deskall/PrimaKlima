<div class="sitemap-block clearfix ">


  <% loop $SitemapItems %>
    <ul>
      <% if $Children %>
        <li>
          <a href="$Link" title="$Title.XML"><strong>$MenuTitle.XML</strong></a>
            <% with $Level(1) %>
              <ul >
                <% include SitemapSub %>
              </ul>
            <% end_with %>
        </li>
       <% else %>
        <li><a href="$Link" title="$Title.XML"><strong>$MenuTitle.XML</strong></a></li>
      <% end_if %>
    </ul>
  <% end_loop %>




</div>
