
<div class="$Layout <% if isMobile  %> uk-hidden@m <% else %>uk-visible@m<% end_if %> $Class">
	
			        <ul class="uk-navbar-nav $CurrentMember.ClassName">
			        	<% if CurrentMember %>
			            <li>
			            	<a href="$CurrentMember.MemberPageLink"><i data-uk-icon="lock" class="uk-margin-small-right"></i><%t MenuProfile.Portal 'Portal' %></a>
			            	<div class="uk-padding-small PrimaryBackground" data-uk-dropdown="animation: uk-animation-slide-bottom-small; duration: 500">
			            	    <ul class="uk-nav uk-dropdown-nav">
			            	    	<li><a class="uk-padding-small uk-text-small" href="$CurrentMember.MemberPageLink"><%t Member.MyAccount 'Meine Konto' %></a></li>
			            	    	<li><a class="uk-padding-small uk-text-small" href="{$LogoutURL}?BackURL=$CurrentMember.MemberPageLink"><%t Member.Logout 'Abmelden' %></a></li>
			            	    </ul>
			            	</div>
			            </li>
			            <% else %>
				            <% loop ProfilPages.filter('ShowInMenus',1) %>
				            <li>
				            	<a href="$Link"><i <% if ClassName == "MemberProfilePage" %>data-uk-icon="lock"<% else %>data-uk-icon="sign-in"<% end_if %> class="uk-margin-small-right"></i>$MenuTitle.XML</a>
				            </li>
				           <% end_loop %>

			            <% end_if %>
			        </ul>
		
</div>
