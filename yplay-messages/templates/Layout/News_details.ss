<div class="container background">
  <div class="col w-12 main-content">
    <div class="content">
      <a href="" onclick="window.history.back();"><i class="fa fa-angle-left"></i> Zurück</a>
      <h1>$Title</h1>
      <% with $News %>
     <div class="text-block news clearfix">
        <% if $Image %>
               <a href="$Image.URL" title="$Title" class="fancybox"><img src="$Image.CroppedFocusedImage(350,250).URL" alt="$Image.Description" class="img-left"/></a>
        <% end_if %>
        <div class="lead">$Lead</div>
      </div>
      <div class="content-text">
         $Content
      </div>
      <% end_with %>

       <% loop $Blocks %>
        <div class="blocks clearfix">
          <% if $Title %><a name="$PrintURLSegment"></a><h2>$Title</h2><% end_if %>
            $HTML
        </div>
      <% end_loop %> 
    </div>
  </div>

</div>