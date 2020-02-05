<div class="container background">
  <div class="col w-8 main-content">
    <div class="content">
      <h1><a href="/news">News</a> / $Title</h1>
      <% loop $Category.NewsPublished($ShowArchive) %>
      <div class="content">
        <% if $Image %>
          <div class="clearfix">
            <div class="content-image">
              <a href="$Link"><img src="$Image.CroppedFocusedImage(350,250).URL" alt="$Title" class="img-left"/></a>
            </div>
            <div class="content-small">
              $Lead
            </div>
          </div>
        <% else %>
          <div class="lead">
            $Lead
          </div>
        <% end_if %>

        <a class="link-more" href="$Link">mehr erfahren</a>
      </div>
      <% end_loop %>
    </div>
 </div>
  <div class="col w-4">

    <% include SearchBar %>

    <% include NavigationSidebar %>

    <% include ContactForm %>

  </div>
</div>
</section>


