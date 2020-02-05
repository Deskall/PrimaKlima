<div id="modal-notifications" class="uk-modal-full dk-nav-mobile-container uk-dark" data-uk-modal>
	    <div class="uk-modal-dialog" data-uk-height-viewport>
	        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
        	<div class="uk-grid-collapse uk-child-width-1-2@s uk-flex-middle" data-uk-grid>
        		<div class="uk-background-cover uk-visible@m" style="background-image:url('$ThemeDir/img/thomas-q-_fQ6zg_McEU-unsplash.jpg');" data-uk-height-viewport></div>
	        	<div class="uk-padding-large">
	        		<h2>Meldungen</h2>
			        <ul data-uk-accordion>
			        	<% loop activeMessages %>
			            <li>
			                <a class="uk-accordion-title" href="#">$Title</a>
			                <div class="uk-accordion-content">
			                  $Lead
			                </div>
			            </li>
			            <% end_loop %>
			        </ul>
			    </div>
	    	</div>
	    </div>
	</div>