<div id="modal-search" class="uk-modal-full dk-nav-mobile-container" data-uk-modal>
	    <div class="uk-modal-dialog" data-uk-height-viewport>
	        <button class="uk-modal-close-full uk-close-large" type="button" uk-close></button>
	       	<div class="uk-grid-collapse uk-child-width-1-2@s uk-flex-middle" data-uk-grid>
        		
	        	<div class="uk-padding-large">
		        	<h2>Suche</h2>
			        <form class="search-form uk-flex uk-flex-between" method="GET" action="{$Link}SearchForm">
			        	<input type="text" class="uk-input" minlength="4" required name="Search" placeholder="<%t Search.PLACEHOLDER 'Suche auf dieser Website...' %>" />
			        	<button type="submit"><i data-uk-icon="search"></i></button>
			        </form>
			    </div>
			    <div class="uk-background-cover uk-visible@m" style="background-image:url('$ThemeDir/img/paul-green-mln2ExJIkfc-unsplash.jpg');" data-uk-height-viewport></div>
		    </div>
	    </div>
	</div>