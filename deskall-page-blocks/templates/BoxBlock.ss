<section class="uk-section $Background">
	<div class="uk-container <% if FullWidth %>uk-container-expand<% else %>uk-container-medium<% end_if %>">
		<h2>$Title</h2>
		$HTML
		<div class="uk-child-width-1-3@s uk-grid-match uk-grid-small" uk-grid uk-lightbox uk-height-match="target:h3;row:false;">
		<% loop ActiveBoxes %>
		<div class="uk-transition-toggle" tabindex="0">
			<% if Top.Layout == "inversed" %>
			<h3 class="uk-margin-small">$Title</h3>
			<div class="uk-margin-top dk-box-content uk-height-small">
		    	$Content
		    	<% if $CallToActionLink.Page.Link %>
		                      <% with $CallToActionLink %>
		                          <a href="{$Page.Link}" class="uk-button uk-button-secondary uk-align-center"
		                              <% if $TargetBlank %>target="_blank"<% end_if %>
		                              <% if $Description %>title="{$Description.ATT}"<% end_if %>>
		                              {$Text.XML}
		                          </a>
		                      <% end_with %>
		                  <% end_if %>
		    </div>
		    <a href="$Image.URL"><img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill(350,250).URL" alt=""></a>
		    <% else_if Top.Layout == "mixed" %>
		    <a href="$Image.URL"><img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill(350,250).URL" $Image.ImageTags($Title) ></a>
		    <h3 class="uk-margin-small">$Title</h3>
		    <div class="uk-margin-top dk-box-content uk-height-small">
		    	$Content
		    	<% if $CallToActionLink.Page.Link %>
		                      <% with $CallToActionLink %>
		                          <a href="{$Page.Link}" class="uk-button uk-button-secondary uk-align-center"
		                              <% if $TargetBlank %>target="_blank"<% end_if %>
		                              <% if $Description %>title="{$Description.ATT}"<% end_if %>>
		                              {$Text.XML}
		                          </a>
		                      <% end_with %>
		                  <% end_if %>
		    </div>
		    <% else %>
		    <h3 class="uk-margin-small">$Title</h3>
		    <a href="$Image.URL"><img class="uk-width-1-1 uk-height-1-1 <% if Top.Effect == "scale" %>uk-transition-scale-up uk-transition-opaque<% end_if %>" src="$Image.FocusFill(350,250).URL" $Image.ImageTags($Title) ></a>
		    <div class="uk-margin-top dk-box-content uk-height-small">
		    	$Content
		    	<% if $CallToActionLink.Page.Link %>
		                      <% with $CallToActionLink %>
		                          <a href="{$Page.Link}" class="uk-button uk-button-secondary uk-align-center"
		                              <% if $TargetBlank %>target="_blank"<% end_if %>
		                              <% if $Description %>title="{$Description.ATT}"<% end_if %>>
		                              {$Text.XML}
		                          </a>
		                      <% end_with %>
		                  <% end_if %>
		    </div>
		    <% end_if %>
		</div>
		<% end_loop %>
	</div>
</section>