    <% loop $NewsPublished($Status) %>
    <h2>$Title</h2>
    <div class="text-block new-block news clearfix">
      <% if $Image %>
             <a href="$Link" title="$Title"><img src="$Image.CroppedFocusedImage(350,250).URL" alt="$Image.Description" class="img-left"/></a>
      <% end_if %>
      <div class="lead">$Lead</div>
    </div>
  <hr>
  <% end_loop %>








