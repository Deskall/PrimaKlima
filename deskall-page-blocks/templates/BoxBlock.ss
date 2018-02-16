
		$HTML
		<div class="$BoxPerLine uk-grid-match" uk-grid uk-lightbox uk-height-match="target:h3;row:false;">
		<% loop ActiveBoxes %>
		<div class="uk-transition-toggle" tabindex="0">
			<% if Top.Layout == "inversed" %>
			<h3 class="uk-margin-small">$Title</h3>
			<div class="uk-margin-top dk-box-content">
		    	$Content
		    	<% if $CallToActionLink.Page.Link %>
		                      <% with $CallToActionLink %>
		                          <a href="{$Page.Link}" class="uk-button uk-align-center"
		                              <% if $TargetBlank %>target="_blank"<% end_if %>
		                              <% if $Description %>title="{$Description.ATT}"<% end_if %>>
		                              {$Text.XML}
		                              <% include DefaultLinkIcon c=r %>
		                          </a>
		                      <% end_with %>
		                  <% end_if %>
		    </div>
		    <% if Image %>
		    	<% if $Top.ImageType == "icon" %>
		    		<img class="dk-icon <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.PaddedImage(350,250).URL" $Image.ImageTags($Title) />
		    	<% else %>
		    	<a href="$Image.URL"><img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill(350,250).URL" $Image.ImageTags($Title)></a>
		    	<% end_if %>
		    <% end_if %>
		    <% else_if Top.Layout == "mixed" %>
		    <% if Image %>
		    	<% if $Top.ImageType == "icon" %>
		    		<img class="dk-icon <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.PaddedImage(350,250).URL" $Image.ImageTags($Title) />
		    	<% else %>
		    <a href="$Image.URL"><img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill(350,250).URL" $Image.ImageTags($Title) ></a>
		    	<% end_if %>
		    <% end_if %>
		    <h3 class="uk-margin-small">$Title</h3>
		    <div class="uk-margin-top dk-box-content">
		    	$Content
		    	<% if $CallToActionLink.Page.Link %>
		                      <% with $CallToActionLink %>
		                          <a href="{$Page.Link}" class="uk-button uk-align-center"
		                              <% if $TargetBlank %>target="_blank"<% end_if %>
		                              <% if $Description %>title="{$Description.ATT}"<% end_if %>>
		                              {$Text.XML}
		                              <% include DefaultLinkIcon c=r %>
		                          </a>
		                      <% end_with %>
		                  <% end_if %>
		    </div>
		    <% else %>
		    <h3 class="uk-margin-small">$Title</h3>
		    <% if Image %>
		    	<% if $Top.ImageType == "icon" %>
		    		<img class="dk-icon <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.PaddedImage(350,250).URL" $Image.ImageTags($Title) />
		    	<% else %>
		    <a href="$Image.URL"><img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill(350,250).URL" $Image.ImageTags($Title) ></a>
		    	<% end_if %>
		    <% end_if %>
		    <div class="uk-margin-top dk-box-content">
		    	$Content
		    	<% if $CallToActionLink.Page.Link %>
		                      <% with $CallToActionLink %>
		                          <a href="{$Page.Link}" class="uk-button uk-align-center"
		                              <% if $TargetBlank %>target="_blank"<% end_if %>
		                              <% if $Description %>title="{$Description.ATT}"<% end_if %>>
		                              {$Text.XML}
		                              <% include DefaultLinkIcon c=r %>
		                          </a>
		                      <% end_with %>
		                  <% end_if %>
		    </div>
		    <% end_if %>
		</div>
		<% end_loop %>
