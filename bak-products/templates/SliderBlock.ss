<% if getPage.HeaderSlide %>
  <% with getPage.HeaderSlide.Image %>
<div class="dk-header-slide uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="$FocusFill(350,200).URL" data-srcset="$FocusFill(350,200).URL 320w, $FocusFill(650,250).URL 650w, $FocusFill(1200,300).URL 1200w, $FocusFillMax(2000,400).URL 1500w" alt="" data-sizes="100vw" data-uk-img><% end_with %>
<section class="uk-section uk-width-1-1 uk-position-relative">
    <div class="uk-container">
        <div class="uk-position-relative uk-height-1-1">
            <div class="dk-slide-text uk-text-left">
                <div class="title">$Product.Name</div>
                <div class="slide-text">$Product.HeaderText</div>
            </div>
        </div>
        <% if $Product.HeaderImage %>
        <div class="uk-position-center-right">
          <img src="$Product.HeaderImage.ScaleHeight(400).URL" />
        </div>
        <% end_if %>
    </div>
  </div>
</section>
<% end_if %>