<% if HeaderSlide %>
  <% with HeaderSlide.Image %>
<div class="dk-header-slide uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="$FocusFill(350,200).URL" data-srcset="$FocusFill(350,200).URL 320w, $FocusFill(650,250).URL 650w, $FocusFill(1200,300).URL 1200w, $FocusFillMax(2000,400).URL 1500w" alt="" data-sizes="100vw" data-uk-img><% end_with %>
<section class="uk-section uk-width-1-1 uk-position-relative">
    <div data-uk-slideshow="<% if Height != "viewport" %><% if MinHeight > 0 %>min-height:$MinHeight;<% end_if %> <% if MaxHeight > 0 %>max-height:$MaxHeight;<% end_if %><% end_if %> <% if Autoplay %>autoplay: true;<% end_if %>animation: {$Animation};" class="dk-slider uk-visible-toggle uk-position-relative">
        <ul class="uk-slideshow-items" <% if Height == "viewport" %>data-uk-height-viewport="<% if MinHeight > 0 %>min-height:$MinHeight;<% end_if %> <% if MaxHeight > 0 %>max-height:$MaxHeight;<% end_if %>"<% end_if %>>
            <% loop ActiveSlides %>
            <li>

                <div class="uk-container">
                    <div class="uk-position-relative uk-height-1-1">
                        <div class="dk-slide-text uk-text-left">
                            <div class="title">$Title</div>
                            <div class="slide-text">$Content</div>
                        </div>
                    </div>
                    <% if $Image %>
                    <div class="uk-position-center-right">
                      <img src="$Product.HeaderImage.ScaleHeight(400).URL" />
                    </div>
                    <% end_if %>
                </div>
            </li>
            <% end_loop %>
        </ul>
        <% if Nav == "dots" || Nav == "both" %>
        <div class="uk-position-bottom-center uk-position-large uk-visible@m">
            <ul class="uk-slideshow-nav uk-dotnav"></ul>
        </div>
        <% end_if %>
        <% if Nav == "controls" || Nav == "both" %>
                <div class="uk-light uk-visible@m">
                    <a class="uk-slidenav-large uk-position-center-left uk-position-large uk-hidden-hover" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
                    <a class="uk-slidenav-large uk-position-center-right uk-position-large uk-hidden-hover" data-uk-slidenav-next data-uk-slideshow-item="next"></a>
                </div>

        <% end_if %>
    </div>
  </div>
</section>
<% end_if %>
