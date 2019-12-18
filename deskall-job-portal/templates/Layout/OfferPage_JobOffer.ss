<section class="uk-section uk-section-small">
	<div class="uk-container">

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
								<div class="uk-flex uk-flex-left uk-text-small">
									<div class="place">$City</div>
									<% with Parameters.filter('Title','Anstellung').first %><div class="type">$Value</div><% end_with %>
									<div class="start">$Start.Nice</div>
								</div>
							</div>
						</div>
						<div class="uk-flex uk-flex-middle" data-uk-grid>
							<div class="uk-width-2-3">
								<div class="uk-flex uk-flex-left uk-flex-middle">
									<a class="uk-button WhiteBackground">Unternehmensprofil</a>
									<a class="uk-button WhiteBackground" data-save><i class="icon icon-heart uk-margin-small-right"></i>Merken</a>
									<a class="uk-button WhiteBackground" data-print><i class="icon icon-printer"></i></a>
									<a class="uk-button uk-button-primary">Bewerben</a>
								</div>
							</div>
							<div class="uk-width-1-3">
								<div class="shariff" data-lang="de" data-url="$AbsoluteLink" data-button-style="icon" data-mail-url="mailto:" data-services="[&quot;facebook&quot;,&quot;twitter&quot;,&quot;linkedin&quot;,&quot;xing&quot;,&quot;whatsapp&quot;,mail&quot;]"></div>
							</div>
						</div>
						
					</div>
				</div>
				
				<div class="uk-margin main-body-offer">
					<div class="uk-card uk-card-default uk-card-body">
						$Description
						<h4>Wir bieten Ihnen</h4>
						$Customer.ReasonWhy
					</div>
				</div>
				
				<div class="uk-margin uk-text-center">
					<a class="uk-button uk-button-large uk-button-primary">Bewerben</a>
				</div>

				<div class="uk-margin company-footer">
					<div class="uk-card uk-card-default uk-card-body">
						<div class="uk-flex uk-flex-middle" data-uk-grid>
							<% if Customer.Logo %>
							<div class="uk-width-auto company-logo">
								<div><img src="$Customer.Logo.URL" alt="Logo von $Customer.Company" width="250"></div>
								<div><a href="$Customer.Link">Unternehmensprofil</a></div>
								<div><a href"$Customer.JobsLink">Jobs $Customer.Missions.count</a></div>
							</div>
							<% end_if %>
							<div class="uk-width-expand company-address">
								<h4>$Customer.Company</h4>
								$Customer.Description
							</div>
						</div>
				</div>
				<% end_with %>
	</div>
</section>