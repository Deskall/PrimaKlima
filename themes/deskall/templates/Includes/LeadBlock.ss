<div class="lead-block text-block clearfix">
  <% if $ContentImage %>

    <% if $BildFormat == "big" %>
      <% if $ContentImage.getExtension == "svg" %>
        <img src="$ContentImage.URL" alt="$ContentImage.Description"/>
        <% else %>
        <a href="$ContentImage.URL" title="$ContentImage.Description" data-imagelightbox="{$Top.ID}f">
          <img src="$ContentImage.CroppedFocusedImage(730,250).URL" alt="$ContentImage.Description"/>
        </a>
      <% end_if %>

    <% else %>

      <div class="content-image">
        <% if $ContentImage.getExtension == "svg" %>
          <img src="$ContentImage.URL" alt="$ContentImage.Description" class="img-left <% if $BildFormat == "padded" %> img-padded<% end_if %>"/>
        <% else %>
          <a href="$ContentImage.URL" title="$ContentImage.Description" data-imagelightbox="{$Top.ID}f">
            <% if $BildFormat == "padded" %>
            <img src="$ContentImage.setWidth(338).URL" alt="$ContentImage.Description" class="img-left img-padded"/>
            <% else_if $BildFormat == "links" %>
            <img src="$ContentImage.setWidth(350).URL" alt="$ContentImage.Description" class="img-left img-links"/>
            <% else %>
            <img src="$ContentImage.CroppedFocusedImage(350, 250).URL" alt="$ContentImage.Description" class="img-left"/>
            <% end_if %>
          </a> 

        <% end_if %>
      </div>


    <% end_if %>
  
    $Content
  <% else %>
    <div class="lead">
      $Content
    </div>
  <% end_if %>
</div>
