	<progress class="uk-progress" value="$CurrentCandidat.ProfilCompletion" max="100"></progress>
	
	<ul data-uk-tab="connect: #component-tab; animation: uk-animation-fade">
								<li <% if not $activeTab || $activeTab == "account" %>class="uk-active"<% end_if %>><a><%t JobSucher.Account '1. Adressangaben erfassen' %></a></li>
								<li <% if $activeTab == "profil" %>class="uk-active"<% end_if %>><a><%t JobSucher.Profil '2. Porträt erstellen' %></a></li>
								<li <% if $activeTab == "competences" %>class="uk-active"<% end_if %>><a><%t JobSucher.Competences '3. Fähigkeiten' %></a></li>
								<li <% if $activeTab == "ads" %>class="uk-active"<% end_if %>><a><%t JobSucher.Ads '4. Bewerbungen verwalten' %></a></li>
							</ul>
						
							<ul id="component-tab" class="uk-switcher">
								<li class="account-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobSucher.AccountTitle 'Ihr Konto' %></h2>
										<div class="member-section-container">
											<div class="uk-margin">
												<a href="{$CurrentUser.ResetPassword}?BackURL=$Link"><%t Member.ChangePassword 'Passwort ändern' %></a>
											</div>
											$CandidatAccountForm
										</div>
									</div>
								</li>
								<li class="account-tab personal-data-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobSucher.ProfilTitle 'Ihr Profil' %></h2>
										<div class="member-section-container">
											$CandidatProfilForm
										</div>
									</div>
								</li>
								<li class="account-tab personal-data-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobSucher.CompetencesTitle 'Ihre Fähigkeiten' %></h2>
										<div class="member-section-container">
											$CompetencesForm
										</div>
									</div>
								</li>
								<li class="account-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobSucher.AdsTitle 'Ihre Bewerbungen' %></h2>
										<div class="member-section-container">
											<% if $CurrentCandidat.Candidatures.exists %>
											<table class="uk-table uk-table-small uk-table-divider">
												<% loop $CurrentCandidat.Candidatures %>
												<tr><td>$Mission.Title</td><td>$Mission.Company</td><td>$Mission.City</td><td>$Created.Ago</td><td>$NiceStatus</td><td>$CV</td><td><a href="$Mission.previewLink" title="zur Stellenangebote" data-uk-tooltip><i class="icon icon-eye"></i></a></td></tr>
												<% end_loop %>
											</table>
											<% else %>
												<p><i><%t JobSucher.noCandidatures 'Sie haben momentan keine Bewerbung' %></i></p>
											<% end_if %>
											<div class="uk-margin">
												<a href="$OfferPage.Link" class="uk-button button-PrimaryBackground"><%t JobSucher.toSearch 'Zur Jobsuche' %></a>
											</div>
										</div>
									</div>
								</li>
								
							</ul>