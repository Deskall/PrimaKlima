
<a id="hide-mobile-nav" class="nav-mobile-btn-hide hidden"><i class="icon-android-close"></i></a>



<div class="nav-mobile-holder hidden" id="nav-mobile">

    <div class="nav-mobile-social clearfix">
      <% if $SiteConfig.FacebookLink %><a href="$SiteConfig.FaceBookLink" title="Facebook"><i class="icon-social-facebook"></i></a><% end_if %>
      <% if $SiteConfig.InstagramLink %><a href="$SiteConfig.InstagramLink" title="Instagram"><i class="icon-social-instagram-outline"></i></a><% end_if %>
      <% if $SiteConfig.TwitterLink %><a href="$SiteConfig.TwitterLink" title="Twitter"><i class="icon-social-twitter"></i></a><% end_if %>
      <% if $SiteConfig.GooglePlusLink %><a href="$SiteConfig.GooglePlusLink" title="Googl+"><i class="icon-social-google"></i></a><% end_if %>
    </div>





  <nav class="mobile">
  <% loop $Menu(1) %>
    <% if $Children %>
      <a href="$Link" class="main<% if LinkOrSection = section %> active<% end_if %>">$MenuTitle.XML</a>
      <% loop $Children %>
        <a href="$Link" class="lvl-2">$MenuTitle.XML</a>
           <% if $Children %>
             <% include SubMenuMobile %>
          <% end_if %>
      <% end_loop %>
    <% else %>
      <a href="$Link" class="main<% if LinkOrSection = section %> active<% end_if %>" >$MenuTitle.XML</a>
    <% end_if %>
  <% end_loop %>
  </nav>

  <div class="mobile-nav-actions">
    <a target="_blank" href="https://www.google.com/maps/place/+$SiteConfig.AddressStreet.URLATT,+$SiteConfig.AddressCity.URLATT,+Switzerland/"><i class="icon icon-location"></i>
        $SiteConfig.AddressStreet<br/>
        $SiteConfig.AddressCity
    </a>
    <a href="tel:$SiteConfig.AddressPhoneCall.URLATT"><i class="icon icon-android-call"></i>$SiteConfig.AddressPhoneDisplay</a>
    <a href="mailto:$SiteConfig.AddressEmail"><i class="icon icon-ios-email-outline"></i>$SiteConfig.AddressEmail</a>
  </div>
</div>