<div class="uk-container">
	<div data-uk-grid>
		<div class="uk-width-1-3@m uk-width-1-4@l uk-visible@m">
			<% if PageLevel > 1 %>
			<% with Level(1) %>
				<div class="uk-visible@m uk-width-1-3@m uk-width-1-4@l sidebar-products">
			        <h3>$Title</h3>
			        <ul class="uk-nav">
			          <% loop $Children %>
			          <li class="$LinkingMode <% if LinkingMode == "current" || LinkingMode == "section" %>uk-active<% end_if %>"><a href="$Link" title="$MenuLink.XML" class="uk-position-relative"><span class="uk-margin-small-right uk-position-left" data-uk-icon="chevron-right"></span>$MenuTitle-XML</a></li>
			          <% end_loop %>
			        </ul>
			     </div>
			<% end_with %>
			<% end_if %>
		</div>
		<div class="uk-width-1-1 uk-width-2-3@m uk-width-3-4@l">
			$ElementalArea
			
			<% if $ID < 0 %> 
				<% if Form || Content %>
				<section class="uk-section">
					<div class="uk-container">
						<h1>$Title</h1>
						$Content
						$Form
					</div>
				</section>
				<% end_if %>
			<% end_if %>
		</div>
	</div>
</div>