<% include DefaultSlide %>

$ElementalArea

<section class="uk-section">
	<div class="uk-container">
		<h2>
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
			<% end_if %>
		</h2>

		<div class="content">$Content</div>

		<% if $PaginatedList.Exists %>
			<div class="blog-overview">
				<div class="uk-grid-small uk-child-width-1-1" data-uk-grid>
					
							<% loop $PaginatedList %>
							
							<div>
							
								<a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "mehr über '{title}' lesen..." title=$Title %>">
								<div class="uk-card uk-card-default uk-card-hover uk-border-rounded uk-grid-collapse uk-child-width-1-2@s uk-margin" data-uk-grid>
						            <div class="uk-card-media-left uk-cover-container">
						                <img src="$FeaturedImage.ScaleWidth(390).URL" alt="$FeaturedImage.AltTag($Title)" data-uk-cover>
						                <canvas with="390" height="300"></canvas> 
						            </div>
						            <div class="uk-card-body uk-padding-small">
						                <h3 class="uk-card-title">$Title</h3>
						                <div>
						                	<% if $Summary %>
						                		$Summary.LimitWordCount(30)
						                	<% else %>
						                		$SummaryFromBlocks.LimitWordCount(30)
						                	<% end_if %>
										</div>
						                <div class="uk-position-bottom-right uk-position-medium"><%t SilverStripe\\Blog\\Model\\Blog.ReadPost "Lesen" %><i class="fa fa-chevron-right uk-margin-small-left"></i></div>
						            </div>
						        </div>
						    	</a>
						    </div>
						    
						    <% end_loop %>
					
				</div>
			</div>
		<% else %>
			<p><%t SilverStripe\\Blog\\Model\\Blog.NoPosts 'Es gibt keine Artikel' %></p>
		<% end_if %>

	</div>
</section>