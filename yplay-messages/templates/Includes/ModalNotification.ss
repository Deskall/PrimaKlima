<div id="modal-notifications" class="uk-modal-full dk-nav-mobile-container uk-dark" data-uk-modal>
	    <div class="uk-modal-dialog" data-uk-height-viewport>
	        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
        	<div class="uk-grid-collapse uk-flex-middle" data-uk-grid>
        		<div class="uk-background-cover uk-visible@m uk-width-1-3@m uk-width-1-4@l" style="background-image:url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');" data-uk-height-viewport></div>
	        	<div class="uk-padding uk-width-2-3@m uk-width-3-4@l" data-uk-height-viewport>
	        		<h2>Meldungen</h2>
			        <div class="uk-margin-large" data-uk-overflow-auto >
			        	<% loop activeMessages %>
			            <div class="uk-margin">
			                <div><strong>$Title</strong></div>
			                <div><small class="uk-text-muted">Betroffene Ort(e): <% if PostalCodes.exists %><% loop $PostalCodes %>$Code - $City<% if not Last %>,<% end_if %><% end_loop %><% else %>Alle<% end_if %></small></div>
			                <div class="dk-text-content">
			                  $Lead
			                </div>
			                <% if LinkableLinkID > 0 %>
			                	<% include CallToActionLink c=w,b=primary,pos=$LinkPosition %>
			                <% end_if %>
			            </div>
			            <% end_loop %>
			        </div>
			        <div class="uk-text-center">
			        	<button class="uk-modal-close uk-button dk-button-black uk-button-large" type="button">Schliessen</button>
			        </div>
			    </div>
	    	</div>
	    </div>
	</div>