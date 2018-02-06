
<div class="header-fixed">
  <div class="container">
    <div class="col w-4 logo-container">
      <a href="/"><img class="header-logo" src="$ThemeDir/img/logo.svg" alt="$SiteConfig.AddressTitle, $SiteConfig.AddressCity"/></a>
    </div>
    <div class="col w-8 nav-container">
      <% include NavSearchBar %>

      <% include LanguageSwitcher %>

      <% include NavigationSimple %>
    </div>
    <div class="social-container">
      <% if $SiteConfig.FacebookLink %><a href="$SiteConfig.FacebookLink" title="Facebook" target="_blank"><i class="icon-social-facebook"></i></a><% end_if %>
      <% if $SiteConfig.InstagramLink %><a href="$SiteConfig.InstagramLink" title="Instagram" target="_blank"><i class="icon-social-instagram-outline"></i></a><% end_if %>
      <% if $SiteConfig.TwitterLink %><a href="$SiteConfig.TwitterLink" title="Twitter" target="_blank"><i class="icon-social-twitter"></i></a><% end_if %>
      <% if $SiteConfig.GooglePlusLink %><a href="$SiteConfig.GooglePlusLink" title="Googl+" target="_blank"><i class="icon-social-google"></i></a><% end_if %>

    </div>

    <div class="mobile-container">
      <a id="show-mobile-nav" class="nav-mobile-btn-show"><i class="icon-android-menu"></i></a>
    </div>
  </div>
</div>


<% include NavigationMobile %>


<header>
  <div class="slider-container  <% if ClassName != HomePage %>page<% end_if %>">
    <% if ClassName = HomePage %>
        <% include Sliders %>
    <% else %>
        <% if $Slides %>
          <% include SlidersPage %>
        <% else %>
          <% with Page(home) %>
            <% include SlidersPage %>
          <% end_with %>
        <% end_if %>
    <% end_if %>
  </div> 
</header>










