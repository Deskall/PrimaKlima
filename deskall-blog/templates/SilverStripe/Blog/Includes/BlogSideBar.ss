<div class="uk-section-small" data-uk-sticky="media:960;bottom:true;offset:-80;">
	<div class="uk-padding-small sidebar-container">
		<% if Categories.Exists %>
		<div class="uk-margin-small">
			<strong><%t SilverStripe\\Blog\\Model\\Blog.Thema 'Thema' %></strong>
			<ul class="uk-nav">
			<% loop Categories %>
			    <li><a href="$Link" title="$Title" class="uk-text-break">$Title<i class="fa fa-caret-right uk-margin-small-left"></i></a></li>
			<% end_loop %>
			</ul>
		</div>
		<% end_if %>
		<% if Tags.Exists %>
		<div class="uk-margin-small">
			<strong><%t SilverStripe\\Blog\\Model\\Blog.Tag 'Tags' %></strong>
			<ul class="uk-nav">
			<% loop Tags %>
			    <li><a href="$Link" title="$Title" class="uk-text-break">$Title<i class="fa fa-caret-right uk-margin-small-left"></i></a></li>
			<% end_loop %>
			</ul>
		</div>
		<% end_if %>
		<% if Tags.Exists || Categories.Exists %><hr><% end_if %>
		<% if $Categories.first.BlogPosts.exclude('ID',$ID).exists %> 
		<p class="uk-text-center"><%t SilverStripe\\Blog\\Model\\Blog.SimilarThema 'mehr über dieses Thema' %></p>
		<% loop $Categories.first.BlogPosts.exclude('ID',$ID).limit(2) %>
		<div class="uk-background-muted uk-border-rounded uk-padding-small uk-text-small uk-margin-small">
			<a href="$Link" title="$Title">$MenuTitle<i class="fa fa-caret-right uk-margin-small-left"></i></a>
		</div>
		<% end_loop %>
		<hr/>
		<% end_if %>
		<% if $Parent.displayShareButtons %>
		<p class="uk-text-center"><%t SilverStripe\\Blog\\Model\\Blog.ShareThis 'diese Artikel teilen' %></p>
		 <div class="uk-margin-top uk-text-center">
			<div class="shariff" data-lang="de" data-url="$AbsoluteLink" data-button-style="icon" data-mail-url="mailto:" data-services="[&quot;facebook&quot;,&quot;twitter&quot;,&quot;linkedin&quot;,&quot;xing&quot;,&quot;whatsapp&quot;,mail&quot;]"></div>
		</div>
		<% end_if %>
		<% if $CommentsEnabled %>
		<div class="uk-margin-top uk-text-center">
		<a class="uk-button uk-button-primary" href="{$Link}#comments-holder" data-uk-scroll><%t SilverStripe\\Blog\\Model\\Blog.Comment 'Kommentieren' %></a>
		</div>
		<% end_if %>
	</div>
</div>