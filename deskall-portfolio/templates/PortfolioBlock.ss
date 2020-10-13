<% include TextBlock %>
<div id="category-filter" data-uk-filter="target: .js-filter">
	<div class="BlackBackground uk-padding-small uk-margin-bottom">
		<ul data-uk-accordion>
		    <li>
		        <a class="uk-accordion-title">Filter nach Kategorien - <span id="category-displayed"></span></a>
		        <div class="uk-accordion-content">
		        	<ul class="uk-subnav uk-subnav-pill">
		        		<li data-uk-filter-control><a>Alle Referenzen anzeigen</a></li>
						<% loop Categories %>
						<li data-uk-filter-control="[data-tags*='{$URLSegment}']"><a>$Title</a></li>
						<% end_loop %>
					</ul>
		        </div>
		    </li>
		</ul>
	</div>
	
	<div class="js-filter uk-child-width-1-3 uk-child-width-1-6@m uk-grid-small" data-uk-grid="masonry:true;">
		<% loop activeReferences %>
		<div  data-tags="<% loop PortfolioCategories %>{$URLSegment} <% end_loop %>">
			<div data-id="$ID" class="reference-box uk-flex uk-flex-center uk-flex-middle">
				$Logo.FitMax(150,150)
			</div>
		</div>
		<% end_loop %>
		<div class="uk-width-1-1 uk-text-center inactive"><a class="uk-button button-PrimaryBackground" data-uk-toggle=".inactive" data-uk-icon="arrow-down">Mehr Referenzen</a></div>
		<% loop inactiveReferences %>
		<div class="inactive" data-tags="<% loop PortfolioCategories %>{$URLSegment} <% end_loop %>" hidden>
			<div data-id="$ID" class="reference-box uk-flex uk-flex-center uk-flex-middle">
				$Logo.FitMax(150,150)
			</div>
		</div>
		<% end_loop %>
	</div>
</div>