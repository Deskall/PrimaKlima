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
		 <div class="uk-margin-top uk-text-center">
			<div class="shariff" data-lang="de" data-url="$AbsoluteLink" data-button-style="icon" data-mail-url="mailto:" data-services="[&quot;facebook&quot;,&quot;twitter&quot;,&quot;linkedin&quot;,&quot;xing&quot;,&quot;whatsapp&quot;,mail&quot;]"></div>
		</div>
		<div class="uk-margin-top uk-text-center">
		<a class="uk-button uk-button-secondary" href="{$Link}#comments-holder" data-uk-scroll><%t SilverStripe\\Blog\\Model\\Blog.Comment 'Kommentar hinzufügen' %></a>
	</div>
</div>