


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




