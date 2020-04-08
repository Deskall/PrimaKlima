<% include HeaderSlide %>

<% with Event %>
<section class="uk-section uk-background-muted uk-padding-small">
	<div class="uk-container">
		<div class="breadcrumbs">
			<ul class="uk-breadcrumb uk-margin-remove">
			    <li><a href="$EventConfig.MainPage.Link">$EventConfig.MainPage.MenuTitle.XML</a></li>
			    <li><span>$MenuTitle</span></li>
			</ul>
		</div>
	</div>
</section>
<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">
				<div class="element" id="event-{$ID}">
					<h1>$Title</h1>
					<% if Subtitle %><h2>$Subtitle</h2><% end_if %>
					<div class="uk-panel">
						<div class="uk-text-lead">$Description</div>
						
						<div class="uk-margin">
							<h3><%t Event.Target 'Zielgruppe:' %></h3>
							$Target
						</div>
						<div class="uk-margin">
							<h3><%t Event.Dates 'Termine:' %></h3>
							<% if Dates.exists %>
							<table class="uk-table uk-table-small uk-table-striped uk-table-middle">
								<tbody>
								<% loop Dates %>
								<tr><td><i class="icon icon-calendar uk-margin-small-right"></i>$Date</td><td><i class="icon icon-ios-location uk-margin-small-right"></i><%t Event.In 'in' %> $City</td><td>$Price.Nice</td><td><% if isFull %><i class="text-pink">ausgebucht</i><% else_if isOpen %><a href="$RegisterLink" class="uk-button button-gruen"><i class="icon icon-log-in uk-margin-small-right"></i><%t Event.RegisterNow 'jetzt anmelden' %></a><% end_if %></td></tr>
								<% end_loop %>
								</tbody>
							</table>
							<% else %>
							<p><%t Event.NoDates 'Keine Termine am Moment' %></p>
							<% end_if %>
						</div>
						<% if Content %>
						<div class="uk-margin">
							<h3><%t Event.Content 'Kurs-Inhalt:' %></h3>
							$Content
						</div>
						<% end_if %>
						<% if Duration %>
						<div class="uk-margin">
							<h3><%t Event.Duration 'Dauer:' %></h3>
							$Duration
						</div>
						<% end_if %>
						<div class="uk-margin">
							<h3><%t Event.Investition 'Preise:' %></h3>
							$Investition
						</div>
						<% if Images.exists %>
						<div class="uk-margin">
							<h3><%t Event.Images 'Bildergallerie' %></h3>
							<div data-uk-slider="<% if not infiniteLoop %>finite:true;<% end_if %><% if Autoplay %>autoplay: true;autoplay-interval:3000;<% end_if %>">
								<div class="uk-position-relative uk-visible-toggle">
									<div class="uk-slider-container">
										<ul class="uk-slider-items uk-child-width-1-2@s uk-child-width-1-3@m" data-uk-height-match=".uk-card-body" data-uk-grid>
											<% loop Images.sort('SortOrder') %>
												<li class="uk-flex uk-flex-middle uk-flex-center">
													<a href="$getSourceURL" class="dk-lightbox" data-caption="$Description">
														<img data-src="
														<% if $getExtension == "svg" %>
														$URL
														<% else %>
														$FocusFill(600,450).URL
														<% end_if %>" alt="$Description"  class="uk-width-1-1" data-uk-img>
													</a>
												</li>
											<% end_loop %>
										</ul>
									</div>
									
									<div class="uk-hidden@l">
										<a class="uk-position-center-left uk-dark uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
										<a class="uk-position-center-right uk-dark uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
									</div>

									<div class="uk-visible@l">
										<a class="uk-position-center-left-out uk-dark uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
										<a class="uk-position-center-right-out uk-dark uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
									</div>
									
								</div>
								<ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
							</div>
						</div>
						<% end_if %>
						<% if ActiveVideos.exists %>
						<div class="uk-margin">
							<h3><%t Event.Videos 'Videos' %></h3>
							<div data-uk-slider>
								<div class="uk-position-relative uk-visible-toggle">
									<div class="uk-slider-container">
										<ul class="uk-slider-items uk-child-width-1-1" data-uk-height-match=".uk-card-body" data-uk-grid>
									
											<% if ActiveVideos.exists %>
												<% loop ActiveVideos %>
												<li class="uk-flex uk-flex-middle uk-flex-center">
													<% if HTML %>
														<div class="uk-grid-small" data-uk-grid>
															<div class="uk-width-1-3@s">
													<% end_if %>
														<% if Type == "Datei" %>
														<video data-uk-video width="480" height="360" controls>
															<source src="$File.URL" type="video/{$File.getExtension}">
															</video>
														<% else %>
															<a class="uk-inline uk-panel uk-link-muted uk-text-center" href="$URL" caption="$Title">
																<figure>
																	<img src="$ThumbnailURL" width="400" alt="">
																</figure>
															</a>
														<% end_if %>
													<% if HTML %>
													</div>
													<div class="uk-width-2-3@s">
														<% if Title %>
														<h4>$Title</h4>
														<% end_if %>
														$HTML
													</div>
													<% end_if %>
												</li>
												<% end_loop %>
											<% end_if %>
										</ul>

										<div class="uk-hidden@l">
											<a class="uk-position-center-left uk-dark uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
											<a class="uk-position-center-right uk-dark uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
										</div>

										<div class="uk-visible@l">
											<a class="uk-position-center-left-out uk-dark uk-position-small" data-uk-slidenav-previous data-uk-slider-item="previous"></a>
											<a class="uk-position-center-right-out uk-dark uk-position-small" data-uk-slidenav-next data-uk-slider-item="next"></a>
										</div>
									</div>
								</div>
							</div>
						</div>
						<% end_if %>
						<% if Files.exists %>
						<div class="uk-margin">
							<h3><%t Event.Files 'Downloads:' %></h3>
							<table class="uk-table-small uk-table-middle">
								<tbody>
									<% loop Files %>
									<tr>
										<td><img src="$ThumbnailURL(120,120)" /></td>
										<td>
											<strong>$Title</strong>
											<div><i>$Extension - $Size</i></div>
										</td>
										<td>
											<a href="$URL" target="_blank" class="uk-button button-gruen uk-flex-middle" download><i class="icon icon-ios-download uk-margin-small-right" ></i><span>herunterladen</span></a>
										</td>
									</tr>
									<% end_loop %>
								</tbody>
							</table>
						</div>
						<% end_if %>
						<div class="uk-margin">
							$Footer
						</div>
					</div>
				</div>

				<% if Dates.exists %>
					<% loop Dates %>
					$EventDateStructuredData
					<% end_loop %>
				<% end_if %>
	</div>
</section>
<% end_with %>