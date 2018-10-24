<% require css('silverstripe/blog: client/dist/styles/main.css') %>
<section class="uk-container uk-container-large uk-padding">


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
				<div class="uk-grid-small uk-child-width-1-1@s uk-child-width-1-2@l" data-uk-grid>
					
					<% with $PaginatedList.first %>
					<div class="main">
						<div class="uk-height-1-1 uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light uk-border-rounded" data-src="$FeaturedImage.ScaleWidth(795).URL" data-uk-img>
						  <div class=" uk-margin-large-top">
								
									
										
											<div class="uk-background-primary dk-background-main-blog-content uk-padding-small uk-border-rounded">
												<h2>$Title</h2>
												<% if $Summary %>
													$Summary.LimitWordCount(25)
												<% else %>
													<p>$Excerpt.LimitWordCount(25)</p>
												<% end_if %>
												<a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">Lire l'article <i class="icon icon-arrow-right-b"></i></a>
											</div>
										
							</div>
						</div>
						<%-- <div class="uk-cover-container uk-border-rounded">
							<img src="$FeaturedImage.ScaleWidth(795).URL" alt="$FeaturedImage.AltTag($Title)" data-uk-cover />
							
							<div class="uk-position-large uk-position-center-left uk-margin-large-top">
								
										<div class="uk-width-1-3">	
											<div class="dk-background-main-blog-title uk-border-rounded uk-padding-small"><h2>Titre<br/>court</h2></div>
										</div> 
										
											<div class="uk-background-primary dk-background-main-blog-content uk-padding-small uk-border-rounded">
												<h2>$Title</h2>
												<% if $Summary %>
													$Summary.LimitWordCount(25)
												<% else %>
													<p>$Excerpt.LimitWordCount(25)</p>
												<% end_if %>
												<a href="$Link" title="<%t SilverStripe\\Blog\\Model\\Blog.ReadMoreAbout "Read more about '{title}'..." title=$Title %>">Lire l'article <i class="icon icon-arrow-right-b"></i></a>
											</div>
										
							</div>
						</div>--%>
					</div>
					<% end_with %>
					<div>
						<div class="uk-child-width-1-2@s uk-grid-small" data-uk-grid="masonry: true;" >
							<% loop $PaginatedList %>
							<% if not first %>
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
						    <% end_if %>
						    <% end_loop %>
						</div>
					</div>
				</div>
			</div>
		<% else %>
			<p><%t SilverStripe\\Blog\\Model\\Blog.NoPosts 'There are no posts' %></p>
		<% end_if %>


	<% if $Categories.Exists %>
	<h2 class="uk-text-center with-underline"><%t SilverStripe\\Blog\\Model\\Blog.Thema 'Thématiques' %></h2>
		<div class="uk-flex uk-flex-middle uk-flex-center">
		<% loop $Categories %>
		<div class="uk-card uk-card-secondary uk-card-hover uk-card-body uk-border-rounded <% if not first %>uk-margin-left<% end_if %>">
			<a href="$Link" title="$Title">
				
					$Image.ScaleWidth(350)
					$Title
			</a>
		</div>
		<% end_loop %>
		</div>
	<% end_if %>
</section>