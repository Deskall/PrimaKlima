<section class="uk-container uk-padding">


		<h1>
 			<% if $ArchiveYear %>
				<%t SilverStripe\\Blog\\Model\\Blog.Archive 'Archive' %>:
				<% if $ArchiveDay %>
					$ArchiveDate.Nice
				<% else_if $ArchiveMonth %>
					$ArchiveDate.format('F, Y')
				<% else %>
					$ArchiveDate.format('Y')
				<% end_if %>
			<% else_if $CurrentTag %>
				<%t SilverStripe\\Blog\\Model\\Blog.Tag 'Tag' %>: $CurrentTag.Title
			<% else_if $CurrentCategory %>
				<%t SilverStripe\\Blog\\Model\\Blog.Category 'Category' %>: $CurrentCategory.Title
			<% else %>
				$Title
			<% end_if %>
		</h1>

		<div class="content">$Content</div>

		<% if $PaginatedList.Exists %>
			<div class="blog-overview">
				<div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
					
							<% loop $PaginatedList %>
							
							<div>
								<div class="uk-card uk-background-primary uk-card-hover uk-border-rounded">
						            <div class="uk-card-media-top">
						            	<div class="uk-cover-container">
						                	<img src="$FeaturedImage.ScaleWidth(390).URL" alt="$FeaturedImage.AltTag($Title)" data-uk-cover>
						                </div>
						            </div>
						            <div class="uk-card-body uk-padding-small">
						                <h3 class="uk-card-title">$Title</h3>
						                <div class="uk-text-small">
						                	<% if $Summary %>
						                		$Summary.LimitWordCount(15)
						                	<% else %>
						                		<p>$Excerpt.LimitWordCount(15)</p>
						                	<% end_if %>
										</div>
						                <div class="uk-position-bottom-right"><a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>"><%t SilverStripe\\Blog\\Model\\Blog.ReadMore "Lire" %><i class="icon icon-arrow-right-b"></i></a></div>
						            </div>
						        </div>
						    </div>
						    
						    <% end_loop %>
					
				</div>
			</div>
		<% else %>
			<p><%t SilverStripe\\Blog\\Model\\Blog.NoPosts 'There are no posts' %></p>
		<% end_if %>


	
</section>