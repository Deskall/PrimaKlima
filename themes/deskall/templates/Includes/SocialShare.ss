<% if $SiteConfig.showFacebook %>
	<div class="fb-share-button" data-href="$Link" data-layout="button_count" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={$Link}%2F&amp;src=sdkpreparse"><%t SocialPlugin.SHARE 'Teilen' %></a></div>
<% end_if %>
<% if $SiteConfig.showTwitter %>
	<a href="https://twitter.com/share" class="twitter-share-button"></a>
<% end_if %>
<% if $SiteConfig.showPinterest %>
	<a href="https://www.pinterest.com/pin/create/button/">
		<img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_gray_20.png" />
	</a>
<% end_if %>