<% if $LinkList %>
<div class="link-block clearfix">
<% loop $LinkList.Sort('SortOrder') %>
	<% if $RelatedPage %>

		<div class="link-item clearfix">
			<a href="$RelatedPage.LinkURL" $RelatedPage.TargetAttr>
			<% if $LinkImage %>
				<img src="$LinkImage.SetWidth(100).URL" alt="$Top.Description"/>
			<% end_if %>
			<strong>$RelatedPage.Title</strong>
			<span>$Description</span>
			</a>
		</div>

	<% end_if %>
<% end_loop %>
</div>
<% end_if %>


