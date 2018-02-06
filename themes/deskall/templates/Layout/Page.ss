<section class="content-holder">
  <div class="container">
    <div class="col l-1 w-8">
      <h1>$Title</h1>

      <% include LeadBlock %>
      $Form

      <% loop $userFriendlyDataObject("Blocks") %>
        <div class="blocks clearfix <% if $hasBorder %>bottom-border<% end_if %>" id="$PrintURLSegment">
          <% if $Title %><h2>$Title</h2><% end_if %>
            $HTML
        </div>
      <% end_loop %>

    </div>


      <% include NavigationSidebar %>
  </div>
</section>




