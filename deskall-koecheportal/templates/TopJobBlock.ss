<section class="block-holder top-job-block <% if $hasBorder %>bottom-border<% end_if %> color-$BGColor <% if $NoPaddingTop %>no-padding-top<% end_if %> <% if $NoPaddingBottom %>no-padding-bottom<% end_if %> <% if $Alignment %>text-align-$Alignment<% end_if %>" id="$PrintURLSegment">
  <div class="container">
    <div class="col w-12">
        <% if $Title %><h2>$Title</h2><% end_if %>




	<div class="top-job-block-gallery">
	  <div class="owl-topjobs owl-carousel owl-theme">
	    <% loop $Jobs %>

				<div class="box clearfix">
					<h3>$ContentTitle</h3>
					<div class="img-content">
					<% if $Employer.Picture %>
					<a href="/ad/detail/$ID" $RelatedPage.TargetAttr>
					<img src="$Employer.Picture.setWidth(300).URL" alt="$ContentTitle"/>
					</a>
					<% end_if %>
				</div>
					<p>$Employer.Company, $Employer.AddressPostalCode $Employer.AddressPlace</p>
					<a class="link-more" href="/ad/detail/$ID" >Zum Inserat <% include DefaultIcon %></a>
				</div>

		<% end_loop %>
	  </div>
	</div>





    </div>
  </div>
</section>