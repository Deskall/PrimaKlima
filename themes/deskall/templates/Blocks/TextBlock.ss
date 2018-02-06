<div class="text-block clearfix $countChars">
	<% if $ContentImage %>
		<% if $BildFormat == "big" %>
			<div class="content-image-large">
				<% if $RelatedPage %>
				<a href="$RelatedPage.LinkURL" $RelatedPage.TargetAttr <% if $ContentImage.getExtension == "gif" %>class="gif-player"<% end_if %>>
					<% if $ContentImage.getExtension == "svg" %>
					<img src="$ContentImage.URL" alt="$ContentImage.Description"/>
					<% else %>
					<img src="$ContentImage.CroppedFocusedImage(730,250).URL" alt="$ContentImage.Description"/>
					<% end_if %>
				</a>
		   		<% else %>
		   		
		   			<% if $ContentImage.getExtension == "svg" %>
					<img src="$ContentImage.URL" alt="$ContentImage.Description"/>
					<% else %>
					<a href="$ContentImage.URL" title="$ContentImage.Description" data-imagelightbox="{$Top.ID}f">
						<img src="$ContentImage.CroppedFocusedImage(730,250).URL" alt="$ContentImage.Description"/>
					</a>
					<% end_if %>

		   		<% end_if %>
		   		$Content
				<% if $RelatedPage.LinkURL %><a href="$RelatedPage.LinkURL" $RelatedPage.TargetAttr class="link-more">$RelatedPage.Title<% include DefaultIcon %></a><% end_if %>
		   	</div>
	   	<% else %>

			<% if $RelatedPage %>

				<a href="$RelatedPage.LinkURL" $RelatedPage.TargetAttr <% if $ContentImage.getExtension == "gif" %>class="gif-player"<% end_if %>>
					<% if $ContentImage.getExtension == "svg" %>
					<img src="$ContentImage.URL" alt="$ContentImage.Description" class="img-left <% if $BildFormat == "padded" %> img-padded<% end_if %>"/>
					<% else %>
						<% if $BildFormat == "padded" %>
						<img src="$ContentImage.setWidth(338).URL" alt="$ContentImage.Description" class="img-left img-padded"/>
						<% else_if $BildFormat == "links" %>
            			<img src="$ContentImage.setWidth(350).URL" alt="$ContentImage.Description" class="img-left img-links"/>
						<% else %>
						<img src="$ContentImage.CroppedFocusedImage(350, 250).URL" alt="$ContentImage.Description" class="img-left"/>
						<% end_if %>
					<% end_if %>
				</a>
		   	<% else %>
		   		
	   			<% if $ContentImage.getExtension == "svg" %>
					<img src="$ContentImage.URL" alt="$ContentImage.Description" class="img-left  <% if $BildFormat == "padded" %> img-padded<% end_if %>"/>
					<% else %>
					<a href="$ContentImage.URL" title="$ContentImage.Description" data-imagelightbox="{$Top.ID}f" class="img-link <% if $ContentImage.getExtension == "gif" %>gif-player<% end_if %>">
						<% if $BildFormat == "padded" %>
						<img src="$ContentImage.setWidth(338).URL" alt="$ContentImage.Description" class="img-left img-padded"/>
						<% else_if $BildFormat == "links" %>
            			<img src="$ContentImage.setWidth(350).URL" alt="$ContentImage.Description" class="img-left img-links"/>
						<% else %>
						<img src="$ContentImage.CroppedFocusedImage(350, 250).URL" alt="$ContentImage.Description" class="img-left"/>
						<% end_if %>
					</a>
				<% end_if %>

		   	<% end_if %>
	   		 <% if $countChars < 300 %>
				<div class="short-text">$Content</div>
	   		 <% else %>
				<div class="short-text">$Content.customFirstParagraph</div>
				<div class="long-text">$Content.RemainingTextAfter</div>
			<% end_if %>
			<% if $RelatedPage.LinkURL %><a href="$RelatedPage.LinkURL" $RelatedPage.TargetAttr class="link-more">$RelatedPage.Title<% include DefaultIcon %></a><% end_if %>
		<% end_if %>
	<% else %>
	$Content
	<% if $RelatedPage.LinkURL %><a href="$RelatedPage.LinkURL" $RelatedPage.TargetAttr class="link-more">$RelatedPage.Title<% include DefaultIcon %></a><% end_if %>

	<% end_if %>
</div>
