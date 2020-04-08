  <% with HeaderSlide %>
  <div class="dk-header-slide uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="$ScaleWidth(350).URL" data-srcset="$ScaleWidth(320).URL 320w, $ScaleWidth(650).URL 650w, $ScaleWidth(1200).URL 1200w, $ScaleWidth(2500).URL 2500w" alt="" data-sizes="100vw" data-uk-img>
  </div>
  <% end_with %>

  $ElementalArea
  
  <% if $ID < 0 %> 
    <% if Form || Content %>
    <section class="uk-section">
      <div class="uk-container">
        <h1>$Title</h1>
        $Content
        $Form
      </div>
    </section>
    <% end_if %>
  <% end_if %>
  