<div class="$Layout $Width $Class">
	<% if Type == "Languages" %>
		<% if $Top.Locales %>
		<ul class="uk-navbar-nav">
		<% loop $Top.Locales %>
			<li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link.ATT" <% if $LinkingMode != 'invalid' %>rel="alternate" hreflang="$LocaleRFC1766"<% end_if %>>$Title.XML</a></li>
		<% end_loop %>
		</ul>
		<% end_if %>
	<% end_if %>
	<% if Type == "links" %>
	<% if UseMenu %>
	<ul class="dk-nav-mobile uk-nav" data-uk-nav>
		<% if Title %>
		<li class="uk-nav-header">$Title</li>
		<% end_if %>
		<% loop Menu(1) %>
		<li class="$LinkingMode  ">
			<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>><span class="uk-margin-small-right" data-uk-icon="icon: chevron-right;"></span>$MenuTitle.XML</a>
			<% if $Children %>
			<ul class="uk-nav-sub">
				<% loop $Children %>
				<li class="$LinkingMode <% if LinkingMode == "current" %>uk-active<% end_if %>" >
					<a href="$Link" title="$Title.XML" <% if ClassName == "SilverStripe\CMS\Model\RedirectorPage" && RedirectionType == "External" %>target="_blank"<% end_if %>><span class="uk-margin-small-right" data-uk-icon="icon: chevron-right;"></span>$MenuTitle.XML</a>
				</li>
				<% end_loop %>
			</ul>
			<% end_if %>
		</li>
		<% end_loop %>
	</ul>
	<% else %>
	<ul class="dk-nav-mobile uk-nav uk-margin-top dk-list">
		<% if Title %>
		<li class="uk-nav-header">$Title</li>
		<% end_if %>
		<% loop $activeLinks %>
		$forTemplate
		<% end_loop %>
	</ul>
	<% end_if %>		  
	<% end_if %>
	<% if Type == "logo" %>
	<a href="/" class="uk-navbar-item uk-logo">
		<% if $Logo.getExtension == "svg" %>
		<img src="$Logo.URL" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>" />
		<% else %>
		<img src="$Logo.ScaleWidth(150).URL" data-srcset="$Logo.ScaleWidth(150).URL 150w, $Logo.ScaleWidth(250).URL 250w, $Logo.ScaleWidth(350).URL 350w" data-sizes="150w, (min-width:650px) 250w, (min-width:1200px) 350w" alt="$Top.SiteConfig.Title Logo" title="<%t Global.Home 'Home' %>"  data-uk-img/>
		<% end_if %>
	</a>
	<% end_if %>
	<% if Type == "divider" %>
	<ul class="dk-nav-mobile uk-nav">
		<li class="uk-nav-divider uk-margin uk-width-1-1 uk-margin-top"></li>
	</ul>
	<% end_if %>
	<% if Type == "address" %>
	<div class="uk-width-1-1 uk-margin uk-text-muted dk-mobile-address">

		<ul class="uk-nav dk-list uk-margin-small-top">
			<% if SiteConfig.AddressTitle %>
			<li class="uk-nav-header">$SiteConfig.AddressTitle</li>
			<% end_if %>
			<li data-uk-icon="icon: location;ratio: 0.75;"><a>
				$SiteConfig.Address<br/>
				$SiteConfig.CodeCity<br/>
			$SiteConfig.Country</a>
		</li>
		<% if SiteConfig.Email %>
		<li data-uk-icon="icon: mail;ratio: 0.75;">
			<a>$SiteConfig.Email</a>
		</li>
		<% end_if %>
		<% if SiteConfig.Phone %>
		<li data-uk-icon="icon: receiver;ratio: 0.75;">
			<a>$SiteConfig.Phone</a>
		</li>
		<% end_if %>
		<% if SiteConfig.Mobile %>
		<li data-uk-icon="icon: phone;ratio: 0.75;">
			<a>$SiteConfig.Mobile</a>
		</li>
		<% end_if %>
	</ul>
</div>
<% end_if %>
<% if Type == "social" %>
<ul class="dk-nav-mobile uk-nav">
	<% if SiteConfig.Facebook %>
	<li class="uk-display-inline-block"><a href="$SiteConfig.Facebook" data-uk-icon="facebook" target="_blank"></a></li>
	<% end_if %>
	<% if SiteConfig.Twitter %>
	<li class="uk-display-inline-block"><a href="$SiteConfig.Twitter" data-uk-icon="twitter" target="_blank"></a></li>
	<% end_if %>
	<% if SiteConfig.Linkedin %>
	<li class="uk-display-inline-block"><a href="$SiteConfig.Linkedin" data-uk-icon="linkedin" target="_blank"></a></li>
	<% end_if %>
	<% if SiteConfig.Xing %>
	<li class="uk-display-inline-block"><a href="$SiteConfig.Xing" data-uk-icon="xing" target="_blank"></a></li>
	<% end_if %>
</ul>
<% end_if %>
<% if Type == "content" %>
<h5>$Title</h5>
<div class="dk-text-content">$Content</div>
<% end_if %>
</div>