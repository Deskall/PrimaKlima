<div class="title-container">
	<h3 class="uk-margin-small-bottom">$SiteConfig.AddressTitle</h3>
</div>

<ul class="uk-list uk-list-large dk-list uk-margin-remove-top">
	<% if $SiteConfig.Address != "" %>
	<li><a href="https://www.google.com/maps/place/{$SiteConfig.Address.URLATT},{$SiteConfig.Code.URLATT}+{$SiteConfig.City.URLATT},+{$SiteConfig.Country.URLATT}/" target="_blank" title="$SiteConfig.Title">
		<span class="uk-margin-small-right" data-uk-icon="icon: location;"></span>
		<span class="dk-link-with-icon">
			<% if $SiteConfig.Address %>
			$SiteConfig.Address<br/>
			<% end_if %>
			<% if $SiteConfig.Code %>
			$SiteConfig.Code - $SiteConfig.City<br/>
			<% end_if %>
			<% if $SiteConfig.Country %>
			$SiteConfig.Country
			<% end_if %>
		</span>
	</a>
</li>
<% end_if %>
<% if SiteConfig.Email %>
<li>
	<a href="mailTo:{$SiteConfig.Email}" title="<%t SiteConfig.EmailTitleTag 'Email zu' %> $SiteConfig.Title">
		<span class="uk-margin-small-right" data-uk-icon="icon: mail;"></span>
		<span class="dk-link-with-icon">$SiteConfig.Email</span>
	</a>
</li>
<% end_if %>
<% if SiteConfig.Phone %>
<li>

	<span class="uk-margin-small-right" data-uk-icon="icon: receiver;"></span>
	<span class="dk-link-with-icon">$SiteConfig.Phone</span>

</li>
<% end_if %>
<% if SiteConfig.Fax %>
<li>
	
	<span class="uk-margin-small-right" data-uk-icon="icon: fax;"></span>
	<span class="dk-link-with-icon">$SiteConfig.Fax</span>
	
</li>
<% end_if %>
<% if SiteConfig.Mobile %>
<li>

	<span class="uk-margin-small-right"  data-uk-icon="icon: phone;"></span>
	<span class="dk-link-with-icon">$SiteConfig.Mobile</span>

</li>
<% end_if %>
<% if SiteConfig.Facebook || SiteConfig.Twitter || SiteConfig.Linkedin || SiteConfig.Xing || SiteConfig.Instagramm %>
<li>
	<ul class="uk-iconnav uk-padding-remove uk-margin-remove">
		<% if SiteConfig.Facebook %>
		<li><a href="$SiteConfig.Facebook" target="_blank" data-uk-icon="facebook"></a></li>
		<% end_if %>
		<% if SiteConfig.Twitter %>
		<li><a href="$SiteConfig.Twitter" target="_blank" data-uk-icon="twitter"></a></li>
		<% end_if %>
		<% if SiteConfig.Linkedin %>
		<li><a href="$SiteConfig.Linkedin" target="_blank" data-uk-icon="linkedin"></a></li>
		<% end_if %>
		<% if SiteConfig.Xing %>
		<li><a href="$SiteConfig.Xing" target="_blank" data-uk-icon="xing"></a></li>
		<% end_if %>
		<% if SiteConfig.Instagram %>
		<li><a href="$SiteConfig.Instagram" target="_blank" data-uk-icon="instagram"></a></li>
		<% end_if %>
	</ul>
</li>
<% end_if %>
</ul>