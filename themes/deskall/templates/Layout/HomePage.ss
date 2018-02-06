<section class="content-home-holder">
  <div class="container">
      <div class="col w-12">
      <h1>$Title</h1>
      
      <% include LeadBlock %>

    </div>
  </div>
</section>

<section class="box-holder">
  <div class="container">
      <% loop $userFriendlyDataObject("Boxes").sort(SortOrder) %>
        <div class="col w-4">
          <div class="box clearfix">
            <% if $Title %><h3>$Title</h3><% end_if %>
            <% if $BoxImage %>
              <% if $RelatedPage.LinkURL %><a href="$RelatedPage.LinkURL" $RelatedPage.TargetAttr><% end_if %>
                <img src="$BoxImage.CroppedFocusedImage(350,250).URL" alt="$Title"/>
              <% if $RelatedPage.LinkURL %></a><% end_if %>
            <% end_if %>
            <% if $Content %>
            <p>$Content</p>
            <% end_if %>
            <% if $RelatedPage.LinkURL %><a class="link-more" href="$RelatedPage.LinkURL" $RelatedPage.TargetAttr>$RelatedPage.Title<% include DefaultIcon %></a><% end_if %>
          </div>
        </div>
      <% end_loop %>
  </div>
</section>