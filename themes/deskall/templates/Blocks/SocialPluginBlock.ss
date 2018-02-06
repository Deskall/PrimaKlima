<div class="social-plugin-block">
<ul class="sharing-buttons">
	<% if $showFacebook %>
  <li>
    <a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={$Parent.AbsoluteLink.URLATT}" target="_blank"><%t SocialPlugin.SHARE 'Teilen' %></a>
  </li>
  <% end_if %>
	<% if $showTwitter %>
  <li>
    <a class="twitter" href="https://twitter.com/intent/tweet?url={$Parent.AbsoluteLink.URLATT}" target="_blank"><%t SocialPlugin.TWEET 'Tweet' %></a>
  </li>
  	<% end_if %>
	<% if $showGoogle %>
  <li>
    <a class="google-plus" href="https://plus.google.com/share?url={$Parent.AbsoluteLink.URLATT}" target="_blank"><%t SocialPlugin.SHARE 'Teilen' %></a>
  </li>
  	<% end_if %>
  	<% if $showPinterest %>
  <li>
	  <a href="http://pinterest.com/pin/create/button/?url={$Parent.AbsoluteLink.URLATT}&media={$BaseHref}{}&description={$Parent.Title}" class="pin-it-button pinterest" count-layout="horizontal" target="_blank">
	    <%t SocialPlugin.Pin 'Pin it' %>
	</a>
  </li>
  <% end_if %>
</ul>
</div>