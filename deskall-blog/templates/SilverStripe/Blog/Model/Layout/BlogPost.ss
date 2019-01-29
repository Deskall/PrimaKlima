<% require css('silverstripe/blog: client/dist/styles/main.css') %>
<div class="heading-article">
	<% if $FeaturedImage %>
	<div class="uk-cover-container uk-height-large">
	    <img src="$FeaturedImage.ScaleWidth(2500).URL" alt="" data-uk-cover>
	    <div class="uk-position-bottom uk-overlay uk-overlay-default uk-padding-small">
	    	<div class="uk-container uk-container-large uk-padding-small">
		    	<h1 class="uk-article-title">$Title</h1>
		    	<% include SilverStripe\\Blog\\EntryMeta %>
		    </div>
	    </div>
	</div>
	<% end_if %>
	
</div>
<section class="uk-container">
	<div data-uk-grid>
		<div class="uk-width-1-4@m uk.width-1-5@l uk-flex-last uk-flex-first@m">
			<% include SilverStripe\\Blog\\BlogSideBar %>
		</div>
		<div class="uk-width-expand">
			<div class="blog-entry content-container">
				<article class="uk-article uk-margin-medium-top uk-margin-large-bottom">
					

					$ElementalArea

					<% include SilverStripe\\Blog\\BlogPostFooter %>
					
				</article>
				<hr/>
				<div class="uk-padding-small">
					$Form
					$CommentsForm
				</div>
			</div>
		</div>
	</div>
</section>