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
							<a class="uk-button WhiteBackground uk-margin-small-right"><%t OfferPage.CompanyPage 'Unternehmensprofil' %></a>
							<a class="uk-button WhiteBackground uk-margin-small-right" data-save><i class="icon icon-heart"></i></a>
							<a class="uk-button WhiteBackground uk-margin-small-right" data-print><i class="icon icon-printer"></i></a>
							<% if canCandidate %><a class="uk-button uk-button-primary" href="{$Top.Link}bewerben/$ID"><%t OfferPage.Candidate 'Bewerben' %></a><% end_if %>
						</div>
					</div>
					<div class="uk-width-1-3">
						<div class="shariff" data-lang="de" data-url="$AbsoluteLink" data-button-style="icon" data-mail-url="mailto:" data-services="[&quot;facebook&quot;,&quot;twitter&quot;,&quot;linkedin&quot;,&quot;xing&quot;,&quot;whatsapp&quot;,mail&quot;]"></div>
					</div>
				</div>
				
			</div>
		</div>
		<% end_with %>
		<div class="uk-margin">
			<div><button class="uk-button uk-button-primary" onclick="window.history.back()"><i class="icon icon-chevron-left uk-margin-small-right"></i><%t Global.Back 'Zurück' %></button></div>
			<div class="uk-margin">
				$ApplicationForm
			</div>
		</div>
	</div>
</section>

