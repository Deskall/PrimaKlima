<% if ID < 0 || $firstBlockSlide %>
<% include DefaultSlide %>
<% end_if %>


<div class="element uk-background-cover" id="member-section">
	<section class="uk-section uk-section-xsmall">

		<div class="uk-container">
			<h1>$Title</h1>
			<div data-uk-grid>
				<div class="uk-width-auto@m">
					<ul class="uk-tab-left uk-margin-large-bottom" data-uk-tab="connect: #component-tab-left; animation: uk-animation-fade">
						<% if CurrentMember.Cook.isApproved %>
						<li><a><%t CustomUser.ActiveMission 'Ihre Aufträge' %></a></li>
						<li <% if activeTab == "missions" %>class="uk-active"<% end_if %>><a><%t CustomUser.NewMission 'Neue Aufträge' %></a></li><% end_if %>
						<li <% if activeTab == "profile" %>class="uk-active"<% end_if %>><a><%t CustomUser.Profil 'Ihre Profil' %></a></li>
					</ul>
				</div>
				<div class="uk-width-expand@m">

					<ul id="component-tab-left" class="uk-switcher" data-uk-height-match="target: .account-tab;row: false;">
						<% if CurrentMember.Cook.isApproved %>
						<li class="account-tab">
							<div class="uk-panel">
								
								<h2 class="uk-heading-divider"><%t CustomUser.ActiveMission 'Ihre Aufträge' %></h2>
								<div class="member-section-container">
									<div class="uk-margin uk-background-muted">$HoursReporLabel</div>
									<% if CurrentMember.Cook.ActiveMissions.exists %>
									<ul data-uk-accordion>
										<% loop CurrentMember.Cook.ActiveMissions %>
									    <li class="uk-box-shadow-medium">
									       
										        <a class="uk-accordion-title uk-padding-small" href="#"><strong>$Job.Title</strong><br/>
										        <small>$Period - $Place<br/>
										        <% if $Start.InPast && $End.InFuture %><div class="uk-label uk-label-success">Aktive</div><% else_if $isClosed %><div class="uk-label uk-background-muted">Geschlossen</div><% else %><%t Mission.StartIn 'Anfang {days}' days=Start.Ago %><% end_if %></small></a>
										        <div class="uk-accordion-content">
										            <div class="uk-margin uk-overflow-auto">
										            	<table id="timesheet-{$ID}" class="uk-table uk-table-small uk-table-striped uk-table-middle">
										            		<thead>
										            			<th><%t Mission.WeekNumber 'Wochen-Nr.' %></th>
										            			<th><%t Mission.WeekDate 'Datum' %></th>
										            			<th><%t Mission.WeekReport 'Arbeitsstunden Datei (Excel)' %></th>
										            			<th><%t Mission.WeekStatus 'Status' %></th>
										            		</thead>
										            		<tbody>
										            			<% loop Weeks %>
										            			<tr id="row-week-{$ID}">
										            				<td>$Number</td>
										            				<td>von $Start.Format('dd.MM') bis $End.Format('dd.MM.Y')</td>
										            				<td id="week-file-{$ID}">
										            					<% if End.InPast %>
											            					<% if File.exists %><span class="uk-text-truncate">$File <a data-delete-timesheet="$File.ID" class="uk-float-right"><span class="fa fa-trash"></span></a></span><% end_if %>
											            					<div id="upload-file-week-{$ID}" class="js-upload timesheet uk-placeholder uk-text-center" data-container="#week-file-{$ID}" data-field-name="week-report-{$ID}" data-file-type="file" data-week-id="$ID" data-allowed="*.csv" <% if File.exists %>hidden<% end_if %>>
											            							<div class="form-field">
											            						    <span data-uk-icon="icon: cloud-upload"></span>
											            						    <span class="uk-text-middle"><%t Member.AddFile 'Legen Sie Datei ab oder' %></span>
											            						    <div data-uk-form-custom>
											            						       <input type="file" name="files" />
											            						        <span class="uk-link"><%t Member.SelectPicture 'Klicken Sie hier an' %></span>
											            						    </div>
											            							</div>
											            							<input type="hidden" name="week-report-{$ID}" />
											            					</div>
										            					<% else %>
										            					keine Datei
										            					<% end_if %>
										            				</td>
										            				<td><% if End.InPast && not $File.exists %><span class="uk-label uk-label-danger"><%t Week.NoFile 'Fällig' %></span><% end_if %></td>
										            			</tr>
										            			<% end_loop %>
										            		</tbody>

										            	</table>
										            </div>
										        </div>
										    
									    </li>
									   <% end_loop %>
									</ul>
									<% else %>
										<div><p><%t Missions.NoActiveMissions 'Momentan haben Sie keine aktive Aufträge.' %></p></div>
									<% end_if %>
								</div>
								
							</div>
						</li>
						<li class="account-tab">
							<div class="uk-panel">
								
								<h2 class="uk-heading-divider"><%t CustomUser.NewMission 'Neue Aufträge' %></h2>
								<div class="member-section-container">
									<div class="uk-child-with-1-1 uk-child-width-1-2@s uk-grid-small uk-grid-match" data-uk-grid>
										<% if Missions.exists %>
										<% loop Missions %>
										<div>
											<div class="uk-card uk-card-default uk-card-body uk-position-relative">
											    <h3 class="uk-card-title">$Title.LimitWordCount(100)</h3>
											    <%-- <div class="uk-position-top-right uk-padding-small"><%t Mission.PublishedAt 'Veröffentlicht am' %> $SentDate.Nice</div> --%>
											    <div class="uk-overflow-auto uk-margin-bottom">
											    	<table class="uk-table uk-table-collapsed uk-table-justify">
											    		<tbody>
											    			<tr><td class="uk-padding-remove"><%t Mission.Position 'Position:' %></td><td class="uk-padding-remove">$NiceJobTitle</td></tr>
											    			<tr><td class="uk-padding-remove"><%t Mission.Preis 'Stundensatz:' %></td><td class="uk-padding-remove">$Price</td></tr>
											    			<tr><td class="uk-padding-remove"><%t Mission.Place 'Ort:' %></td><td class="uk-padding-remove">$Place</td></tr>
											    			<tr><td class="uk-padding-remove"><%t Mission.Period 'Zeitraum:' %></td><td class="uk-padding-remove">$Period</td></tr>
											    		</tbody>
											    	</table>
											    </div>
											   <div class="uk-flex uk-flex-center uk-margin-top">
											    		<% if canCandidate %>
												    	<button data-mission="$ID" class="uk-button PrimaryBackground"><%t Mission.Candidate 'Bewerben' %></button>
												    	<% end_if %>
												    	<% if Candidatures.filter('CookID',Top.CurrentMember.Cook.ID) %>
												    	<p><%t Mission.CandidatureDone 'Bewerbung gesendet' %></p>
												    	<% end_if %>
												</div>
												<% if Access || Others %>
											    <button data-uk-toggle=".mission-detail-{$ID}" data-uk-icon="chevron-down"><%t Mission.More 'mehr Info' %></button>
											    <div class="mission-detail-{$ID} uk-margin-small" hidden>
											    	<div class="uk-overflow-auto">
											    		<table class="uk-table uk-table-justify uk-table-small uk-text-small">
											    			<% if Access %><tr><td><%t Mission.Access 'Anreise' %></td><td>$Access</td></tr><% end_if %>
											    			<% if Others %><tr><td><%t Mission.Others 'Sonstiges' %></td><td>$Others</td></tr><% end_if %>
											    		</table>
											    	</div>
											    </div>
											    <% end_if %>
											</div>
										</div>
										<% end_loop %>

										<%-- <div class="uk-width-1-1 uk-margin">
											<ul class="uk-pagination uk-flex-center" data-uk-margin>
											    <li><a><span uk-pagination-previous></span></a></li>
											    <li><a>1</a></li>
											    <li class="uk-disabled"><span>...</span></li>
											    <li><a>4</a></li>
											    <li><a>5</a></li>
											    <li><a>6</a></li>
											    <li class="uk-active"><span>7</span></li>
											    <li><a>8</a></li>
											    <li><a>9</a></li>
											    <li><a>10</a></li>
											    <li class="uk-disabled"><span>...</span></li>
											    <li><a>20</a></li>
											    <li><a><span uk-pagination-next></span></a></li>
											</ul>
										</div> --%>
										<% else %>
										<div><p><%t Missions.NoNewMissions 'Momentan gibt es keine neuen Aufträge.' %></p></div>
										<% end_if %>
									</div>
								</div>
								
							</div>
						</li>
						<% end_if %>
						<li class="account-tab personal-data-tab">
							<div class="uk-panel">
								<h2 class="uk-heading-divider"><%t CustomUser.Profil 'Ihre Profil' %></h2>
								<div class="member-section-container">
								<% if $CurrentMember.Cook.profileCompletion < 100 %>
									<p><i><%t CustomUser.ProfilCompletionLabel 'Ihr Profil ist zu {percent}% vollständig. Um die neuen Aufträge anschauen zu können, müssen Sie zuerst Ihr Profil vervollständigen!' percent=$CurrentMember.Cook.profileCompletion %></i></p>
									<progress class="uk-progress" value="$CurrentMember.Cook.profileCompletion" max="100"></progress>
								<% end_if %>
									
								$ProfilForm
									
								</div>
							</div>
						</li>
					</ul>
				</div>

		</div>
	</section>
</div>
