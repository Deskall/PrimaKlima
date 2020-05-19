<% if HeaderSlide %>
  <% with HeaderSlide.Image %>
    <div class="dk-header-slide-home uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="$FocusFill(350,350).URL" data-srcset="$FocusFill(350,350).URL 320w, $FocusFill(650,450).URL 650w, $FocusFill(1200,600).URL 1200w, $FocusFillMax(2000,750).URL 1500w" alt="" data-sizes="100vw" data-uk-img><% end_with %>
           
               <%--  <div class="uk-height-1-1 uk-width-1-1" data-uk-slideshow="autoplay:true;min-height: 300;animation: fade;">
                    <div class="uk-position-relative uk-height-1-1 uk-width-1-1" tab="-1">
                        <ul class="uk-slideshow-items">
                            <% loop ActiveSlides %>
                            <li >
                                
                                    <div>
                                        <div class="uk-container uk-height-1-1 uk-position-relative">
                                            <div class="uk-position-top-left">
                                                <div class="dk-slide-text uk-text-left uk-padding uk-padding-remove-horizontal">
                                                    <div class="title">$Top.styledTitle($Title)</div>
                                                    <div class="slide-text">$Content</div>
                                                </div>
                                            </div>
                                            <% if LinkableLinkID > 0 %>
                                            <div class="uk-position-bottom-left uk-padding-large uk-padding-remove-horizontal">
                                                <% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
                                            </div>
                                            <% end_if %>
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
                        
                        <div class="uk-position-bottom-center uk-padding-small">
                            <ul class="uk-slider-nav uk-dotnav"></ul>
                        </div>
                    </div>
                </div>
             --%>
             <div class="uk-position-relative uk-visible-toggle" tabindex="-1" uk-slideshow="animation: push;min-height:350">

                 <ul class="uk-slideshow-items">
                     <li>
                         <img src="images/photo.jpg" alt="" uk-cover>
                         <div class="uk-position-center uk-position-small uk-text-center uk-light">
                             <h2 class="uk-margin-remove">Center</h2>
                             <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                         </div>
                     </li>
                     <li>
                         <img src="images/dark.jpg" alt="" uk-cover>
                         <div class="uk-position-bottom uk-position-medium uk-text-center uk-light">
                             <h3 class="uk-margin-remove">Bottom</h3>
                             <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                         </div>
                     </li>
                     <li>
                         <img src="images/light.jpg" alt="" uk-cover>
                         <div class="uk-overlay uk-overlay-primary uk-position-bottom uk-text-center">
                             <h3 class="uk-margin-remove">Overlay Bottom</h3>
                             <p class="uk-margin-remove">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                         </div>
                     </li>
                     <li>
                         <img src="images/dark.jpg" alt="" uk-cover>
                         <div class="uk-overlay uk-overlay-default uk-position-bottom-right uk-position-small">
                             <h3 class="uk-margin-remove">Overlay Bottom Right</h3>
                             <p class="uk-margin-remove">Lorem ipsum dolor sit amet.</p>
                         </div>
                     </li>
                 </ul>

                 <div class="uk-light">
                     <a class="uk-position-center-left uk-position-small uk-hidden-hover" href="#" uk-slidenav-previous uk-slideshow-item="previous"></a>
                     <a class="uk-position-center-right uk-position-small uk-hidden-hover" href="#" uk-slidenav-next uk-slideshow-item="next"></a>
                 </div>

             </div>
    </div>
<% end_if %>
