<div class="uk-section-small" data-uk-sticky="media:960;bottom:true;offset:-80;">
	<% if Categories.Exists %>
		<h4><%t SilverStripe\\Blog\\Model\\Blog.Thema 'Thema' %></h4>
		<ul class="uk-nav">
		<% loop Categories %>
		    <li> <a href="$Link" title="$Title" data-uk-icon="chevron-right" class="uk-padding-remove">$Title</a></li>
		<% end_loop %>
		</ul>
		<% end_if %>
		<% if Tags.Exists %>
		<h5><%t SilverStripe\\Blog\\Model\\Blog.Thema 'Thema' %></h5>
		<ul class="uk-nav">
		<% loop Tags %>
		    <li> <a href="$Link" title="$Title" data-uk-icon="chevron-right">$Title</a></li>
		<% end_loop %>
		</ul>
		<% end_if %>
		<hr>
		<% if $Categories.first.BlogPosts.exists %> 
		<p class="uk-text-center"><%t SilverStripe\\Blog\\Model\\Blog.SimilarThema 'mehr über dieses Thema' %></p>
		<% loop $Categories.first.BlogPosts.exclude('ID',$ID).limit(2) %>
		<div class="uk-background-muted uk-border-rounded uk-padding-small uk-text-small uk-margin-small">
			<a href="$Link" title="$Title" data-uk-icon="triangle-right">$Title</a>
		</div>
		<% end_loop %>
		<hr/>
		<% end_if %>
		<p class="uk-text-center"><%t SilverStripe\\Blog\\Model\\Blog.ShareThis 'diese Artikel teilen' %></p>
		    <div class="uk-flex uk-flex-around">
		   <a rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u={$AbsoluteLink.URLATT}" title='<%t SilverStripe\\Blog\\Model\\Blog.ShareOn "teilen" %> Facebook' target="_blank"><i data-uk-icon="icon: facebook;ratio:2;"></i></a>
            <a rel="nofollow" href="https://twitter.com/intent/tweet/?text={$Title.URLATT}&url={$AbsoluteLink.URLATT}&via=fitnessstriver" title='<%t SilverStripe\\Blog\\Model\\Blog.ShareOn "teilen" %> Twitter' target="_blank"><i data-uk-icon="icon: twitter;ratio:2;"></i></a>
		</div>
		<div class="uk-margin-top uk-text-center">
		<a class="uk-button uk-button-secondary" href="{$Link}#comments-holder" data-uk-scroll><%t SilverStripe\\Blog\\Model\\Blog.Comment 'Kommentar hinzufügen' %></a>
	</div>
</div>