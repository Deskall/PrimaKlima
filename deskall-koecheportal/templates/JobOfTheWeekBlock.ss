


	<div class="job-of-the-week-block-gallery">
	  <div class="owl-job-of-the-week owl-carousel owl-theme">
	    <% loop $Jobs %>
			<div class="box-large clearfix">
				<div class="col-left">
					<% if $Employer.Picture %>

					<div class="img-content">
					<a href="/ad/detail/$ID" $RelatedPage.TargetAttr>
					<img src="$Employer.Picture.setWidth(300).URL" alt="$ContentTitle"/>
					</a>
				</div>
					<% end_if %>
				</div>

				<div class="col-right">
					

					<p>$ContentIntro</p>
					<h3>$ContentTitle</h3>
					<div class="content">
					$ContentMain.FirstParagraph
					</div>
					<p>$Employer.Company, $Employer.AddressPostalCode $Employer.AddressPlace</p>
					<a class="link-more" href="/ad/detail/$ID" >Zum Inserat <% include DefaultIcon %></a>


				</div>


			</div>

		<% end_loop %>
	  </div>
	</div>



