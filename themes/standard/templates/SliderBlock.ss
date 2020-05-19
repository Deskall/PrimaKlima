<% if HeaderSlide %>
  <% with HeaderSlide.Image %>
    <div class="dk-header-slide-home uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="$FocusFill(350,350).URL" data-srcset="$FocusFill(350,350).URL 320w, $FocusFill(650,450).URL 650w, $FocusFill(1200,600).URL 1200w, $FocusFillMax(2000,750).URL 1500w" alt="" data-sizes="100vw" data-uk-img><% end_with %>
        <section class="uk-section uk-width-1-1 uk-height-1-1 uk-padding-remove uk-position-relative">
           
                <div data-uk-slider class="uk-height-1-1">
                    
                        <ul class="uk-slider-items uk-height-1-1">
                            <% loop ActiveSlides %>
                            <li class="uk-width-1-1">
                                
                                    <div class=" uk-height-1-1">
                                        <div class="uk-container uk-height-1-1 uk-position-relative">
                                            <div class="uk-position-center-left">
                                                <div class="dk-slide-text uk-text-left">
                                                    <div class="title">$Top.styledTitle($Title)</div>
                                                    <div class="slide-text">$Content</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <% if $Image %>
                                <div class="uk-position-bottom-right">
                                  <img src="$Image.ScaleHeight(400).URL" />
                                </div>
                                <% end_if %>
                            </li>
                            <% end_loop %>
                        </ul>
                    
                </div>
            
        </section>
    </div>
<% end_if %>
