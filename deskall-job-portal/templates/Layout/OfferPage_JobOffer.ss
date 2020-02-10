<section class="uk-section uk-section-small">
	<div class="uk-container">
		<div class="uk-margin">
			<div><button class="uk-button uk-button-primary" onclick="window.history.back()"><i class="icon icon-chevron-left uk-margin-small-right"></i><%t Global.Back 'Zurück' %></button></div>
				<% with Offer %>
				<div class="uk-margin company-header">
					<div class="uk-card uk-card-default uk-card-body">
						<div class="uk-flex uk-flex-middle" data-uk-grid>
							<% if Customer.Logo %>
							<div class="uk-width-auto company-logo">
								<img src="$Customer.Logo.URL" alt="Logo von $Customer.Company" width="250">
							</div>
							<% end_if %>
							<div class="uk-width-expand company-address">
								<strong>$Customer.Company</strong><br>
								<h1>$Title</h1>
								<div class="uk-flex uk-grid uk-text-small">
									<div class="place"><i class="icon icon-location uk-margin-small-right"></i>$City</div>
									<% with Parameters.filter('Title','Anstellung').first %><div class="type"><i class="icon icon-information uk-margin-small-right"></i>$Value</div><% end_with %>
									<div class="start"><i class="icon icon-calendar uk-margin-small-right"></i>$PublishedDate.Nice</div>
								</div>
							</div>
						</div>
						<div class="uk-flex uk-flex-middle" data-uk-grid>
							<div class="uk-width-2-3">
								<div class="uk-flex uk-flex-left uk-flex-middle">
									<%-- <a class="uk-button WhiteBackground uk-margin-small-right"><%t OfferPage.CompanyPage 'Unternehmensprofil' %></a> --%>
									<a class="uk-button WhiteBackground uk-margin-small-right" data-save><i class="icon icon-heart"></i></a>
									<a class="uk-button WhiteBackground uk-margin-small-right" data-print><i class="icon icon-printer"></i></a>
									<% if CurrentMember %>
										<% if canCandidate %><a class="uk-button uk-button-primary" href="{$Top.Link}bewerben/$ID"><%t OfferPage.Candidate 'Bewerben' %></a><<% end_if %>
									<% else %>
										<a class="uk-button uk-button-primary" href="$Top.MemberPage.Link"><%t OfferPage.Candidate 'Bewerben' %></a>
									<% end_if %>
								</div>
							</div>
							<div class="uk-width-1-3">
								<div class="shariff" data-lang="de" data-url="$AbsoluteLink" data-button-style="icon" data-mail-url="mailto:" data-services="[&quot;facebook&quot;,&quot;twitter&quot;,&quot;linkedin&quot;,&quot;xing&quot;,&quot;whatsapp&quot;,mail&quot;]"></div>
							</div>
							<% if hasCandidated %><div><p><i><%t Mission.hasCandidated 'Sie haben sich am {date} für diese Stelle beworben' date=$hasCandidated.Created.Nice %></i></p></i><% end_if %>
						</div>
						
					</div>
				</div>
				
				<div class="uk-margin main-body-offer">
					<div class="uk-card uk-card-default">
						<div class="uk-card-media-top uk-text-center">
						    <img src="$Image.FitMax(700,350).URL" alt="$Image.Description">
						</div>
						<div class="uk-card-body">
							$Description
							<h4><%t OfferPage.WeOffer 'Wir bieten Ihnen' %></h4>
							$Customer.ReasonWhy
							<% if Attachments.exists %>
							<h5><%t OfferPage.MoreInfos 'Weitere Informationen' %></h5>
							<% loop Attachments %>
							<div class="uk-margin">
								<div  class="uk-text-truncate">
									<a href="$URL" title="Download $Title" target="_blank"><i data-uk-icon="download" class="uk-margin-right"></i>$Title</a>
								</div>
							</div>
							<% end_loop %>
							<% end_if %>
						</div>
					</div>
				</div>
				
				<div class="uk-margin uk-text-center">
					<% if CurrentMember %>
						<% if canCandidate %><a class="uk-button uk-button-primary" href="{$Top.Link}bewerben/$ID"><%t OfferPage.Candidate 'Bewerben' %></a><% else_if hasCandidated %><p><i><%t Mission.hasCandidated 'Sie haben sich am {date} für diese Stelle beworben' date=$hasCandidated.Created.Nice %></i></p><% end_if %>
					<% else %>
					<a class="uk-button uk-button-large uk-button-primary"  href="$Top.MemberPage.Link"><%t OfferPage.Candidate 'Bewerben' %></a>
					<% end_if %>
				</div>

				<div class="uk-margin company-footer">
					<div class="uk-card uk-card-default uk-card-body">
						<div class="uk-flex uk-flex-middle" data-uk-grid>
							<% if Customer.Logo %>
							<div class="uk-width-auto company-logo">
								<div class="uk-margin-small"><img src="$Customer.Logo.URL" alt="Logo von $Customer.Company" width="250"></div>
								
								<%-- <div class="uk-margin-small"><a href="$Customer.Link"><i class="icon icon-chevron-right uk-margin-small-right uk-text-small"></i><%t OfferPage.CompanyPage 'Unternehmensprofil' %></a></div>
								<div class="uk-margin-small"><a href"$Customer.JobsLink"><i class="icon icon-chevron-right uk-margin-small-right uk-text-small"></i><%t OfferPage.Jobs 'Jobs' %> $Customer.Missions.count</a></div> --%>
							</div>
							<% end_if %>
							<div class="uk-width-expand company-address">
								<h4>$Customer.Company</h4>
								$Customer.Description
							</div>
						</div>
						<div class="uk-flex uk-flex-center" data-uk-grid>
							<% if $Customer.URL %>
							<a href="$Customer.URL" target="_blank" rel="nofollow" title="Website von $Customer.Company"><i data-uk-icon="world"></i></a>
							<% end_if %>
							<% if $Customer.SocialFacebook %>
							<a href="$Customer.SocialFacebook" target="_blank" rel="nofollow" title="Facebook von $Customer.Company"><i data-uk-icon="facebook"></i></a>
							<% end_if %>
							<% if $Customer.SocialTwitter %>
							<a href="$Customer.SocialTwitter" target="_blank" rel="nofollow" title="Twitter von $Customer.Company"><i data-uk-icon="twitter"></i></a>
							<% end_if %>
							<% if $Customer.SocialXing %>
							<a href="$Customer.SocialXing" target="_blank" rel="nofollow" title="Xing von $Customer.Company"><i data-uk-icon="xing"></i></a>
							<% end_if %>
							<% if $Customer.SocialLinkedin %>
							<a href="$Customer.SocialLinkedin" target="_blank" rel="nofollow" title="Linkedin von $Customer.Company"><i data-uk-icon="linkedin"></i></a>
							<% end_if %>
							<% if $Customer.SocialInstagram %>
							<a href="$Customer.SocialInstagram" target="_blank" rel="nofollow" title="Instagram von $Customer.Company"><i data-uk-icon="instagram"></i></a>
							<% end_if %>
							<% if $Customer.SocialPinterest %>
							<a href="$Customer.SocialPinterest" target="_blank" rel="nofollow" title="Pinterest von $Customer.Company"><i data-uk-icon="pinterest"></i></a>
							<% end_if %>
							
						</div>
					</div>
				</div>
				<% end_with %>
	</div>
</section>