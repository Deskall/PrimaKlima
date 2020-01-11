<div class="uk-background-muted uk-padding-small uk-hidden@m">
	<div class="uk-container">
		<div class="uk-margin-small">
			$BreadCrumbs
		</div>
	</div>
</div>


<section class="uk-section uk-padding-remove">
	<div class="uk-container">
		<div class="uk-grid-small uk-grid-match" data-uk-grid>
			<div class="uk-width-1-4@m uk-width-1-5@l uk-visible@m">
				<aside class="uk-padding-small uk-background-muted">
					<% include SilverStripe\\Blog\\BlogSideBar %>
				</aside>
			</div>
			<div class="uk-width-3-4@m uk-width-4-5@l">
				<div class="blog-entry content-container uk-padding-small">
					<article class="uk-article uk-margin-medium-top uk-margin-large-bottom">
						<% if $FeaturedImage %>
						<img data-src="$FeaturedImage.FocusFillMax(850,450).URL" alt="" data-uk-img>
						<% end_if %>
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
	</div>
</section>