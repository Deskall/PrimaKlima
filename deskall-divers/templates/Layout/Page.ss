
	<div class="<% if not useMasonry %>$BlockAlignment<% end_if %> $BlocksPerLine uk-grid-collapse uk-grid-match" data-uk-grid="<% if useMasonry %>masonry:true;<% end_if %><% if Parallax %>parallax:$Parallax;<% end_if %>">
	$ElementalArea
	</div>
	<% if $ID < 0 %> 
		<% if Form || Content %>
		<section class="uk-section">
			<div class="uk-container">
				<h1>$Title</h1>
				$Content
				$Form
			</div>
		</section>
		<% end_if %>
	<% end_if %>
	