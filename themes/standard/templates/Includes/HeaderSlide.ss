  <% if HeaderSlide %>
  <% with HeaderSlide.Image %>
<div class="dk-header-slide uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="$FocusFill(350,200).URL" data-srcset="$FocusFill(350,200).URL 320w, $FocusFill(650,250).URL 650w, $FocusFill(1200,350).URL 1200w, $FocusFillMax(2000,500).URL 1500w" alt="" data-sizes="100vw" data-uk-img>
	<div class="dk-slide-title"> $Top.MenuTitle</div>
  </div>
  <% end_with %>
  <% end_if %>