<ul data-uk-tab="connect: #component-tab; animation: uk-animation-fade">
								<li <% if not $activeTab || $activeTab == "account" %>class="uk-active"<% end_if %>><a><%t JobSucher.Account '1. Adressangaben erfassen' %></a></li>
								<li <% if $activeTab == "profil" %>class="uk-active"<% end_if %>><a><%t JobSucher.Profil '2. Porträt erstellen' %></a></li>
								<li <% if $activeTab == "ads" %>class="uk-active"<% end_if %>><a><%t JobSucher.Ads '4. Bewerbungen verwalten' %></a></li>
							</ul>
						
							<ul id="component-tab" class="uk-switcher">
								<li class="account-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobSucher.AccountTitle 'Ihr Konto' %></h2>
										<div class="member-section-container">
											<div class="uk-margin">
												<a href="$CurrentUser.ResetPassword"><%t Member.ChangePassword 'Passwort ändern' %></a>
											</div>
											$CandidatAccountForm
										</div>
									</div>
								</li>
								<li class="account-tab personal-data-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobSucher.ProfilTitle 'Ihr Profil' %></h2>
										<div class="member-section-container">
											<%-- $CandidatProfilForm --%>
										</div>
									</div>
								</li>
								<li class="account-tab">
									<div class="uk-panel uk-background-muted uk-padding-small">
										<h2><%t JobSucher.AdsTitle 'Ihre Bewerbungen' %></h2>
										<div class="member-section-container">
											
										</div>
									</div>
								</li>
								
							</ul>