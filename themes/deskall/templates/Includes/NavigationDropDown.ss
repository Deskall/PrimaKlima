      <div class="container nav">
          <div class="w-12 nav-container">
            <nav class="main">
              <% loop $Menu(1) %>
               <% if $Children %>

                  <div class="nav-item">
                    <a data-sub-nav-id="$Link" title="$Title.XML" <% if LinkOrSection  = section %> class="active"<% end_if %>>$MenuTitle.XML</a>

                  <nav class="secondary" data-sub-nav-id="$Link">
                    <% loop $Children %>
                      <a href="$Link" title="$Title.XML" >$MenuTitle.XML</a>
                    <% end_loop %>
                  </nav>
                </div>
              <% else %>
                <div class="nav-item">
                  <a href="$Link" title="$Title.XML" <% if LinkOrCurrent = current %> class="active"<% end_if %>>$MenuTitle.XML</a>
                </div>
                <% end_if %>
              <% end_loop %>
            </nav>
          </div>
      </div>

      <a id="show-mobile-nav" class="nav-mobile-btn-show"><i class="icon icon-drag"></i></a>
      <div class="nav-mobile-holder hidden" id="nav-mobile">
        <a id="hide-mobile-nav"class="nav-mobile-btn-hide"><i class="icon icon-close2"></i></a>
        <nav class="mobile">
        <% loop $Menu(1) %>
          <% if $Children %>
            <span>$MenuTitle.XML</span>
            <% loop $Children %>
              <a href="$Link" class="secondary">$MenuTitle.XML</a>
            <% end_loop %>
          <% else %>
            <a href="$Link" class="main<% if LinkOrSection = section %> active<% end_if %>" >$MenuTitle.XML</a>
          <% end_if %>
        <% end_loop %>
        </nav>
      </div>