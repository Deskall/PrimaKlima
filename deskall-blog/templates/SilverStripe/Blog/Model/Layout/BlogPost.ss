<div class="uk-background-muted uk-padding-small">
	<div class="uk-container $SiteConfig.ContainerSize">
		<div class="uk-margin-small">
			$BreadCrumbs
		</div>
	</div>
</div>
<section class="uk-container $SiteConfig.ContainerSize">
	
	<div data-uk-grid>
		<div class="uk-width-1-4@m uk.width-1-5@l uk-flex-last uk-flex-first@m">
			<% include SilverStripe\\Blog\\BlogSideBar %>
		</div>
		<div class="uk-width-expand">
			<div class="blog-entry content-container uk-padding-small">
				<article class="uk-article uk-margin-medium-top uk-margin-large-bottom">
					<% if $FeaturedImage %>
					    <img data-src="$FeaturedImage.FocusFillMax(850,450).URL" alt="" data-uk-img>
					<% end_if %>
					<h1 class="uk-article-title">$Title</h1>
					<% include SilverStripe\\Blog\\EntryMeta %>

					

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