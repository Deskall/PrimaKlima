<% with Event %>
<section class="uk-section uk-background-muted uk-padding-small">
	<div class="uk-container">
		<div class="breadcrumbs">
			<ul class="uk-breadcrumb uk-margin-remove">
			    <li><a href="$EventConfig.MainPage.Link">$EventConfig.MainPage.MenuTitle.XML</a></li>
			   
			    <%-- <li><span>$Title</span></li> --%>
			</ul>
		</div>
	</div>
</section>
<section class="uk-section no-bg uk-section-small">
	<div class="uk-container">
				<div class="element" id="event-{$ID}">
					<h1>$Title</h1>
					<div class="uk-panel">
						<div class="uk-text-lead">$Intro</div>
						<% if Images.exists || ActiveVideos.exists %>
						<div class="uk-margin">
							<div class="uk-position-relative" tabindex="-1" data-uk-slideshow="min-height: 300; max-height: 450; animation: fade">

								<ul class="uk-slideshow-items" data-uk-lightbox>
									<% if Images.exists %>
									<% loop Images.sort('SortOrder') %>
									<li class="uk-flex uk-flex-middle uk-flex-center">
										<a href="$getSourceURL" class="dk-lightbox" data-caption="$Description">
											<img data-src="
											<% if $getExtension == "svg" %>
											$URL
											<% else %>
											$FocusFill(600,450).URL
											<% end_if %>" alt="$Up.AltTag($Description,$Name,$up.Title)" title="$Up.TitleTag($Name,$Up.Title)"  class="uk-width-1-1" data-uk-img>
										</a>
									</li>
									<% end_loop %>
									<% end_if %>
									<% if ActiveVideos.exists %>
									<% loop ActiveVideos %>
									<li class="uk-flex uk-flex-middle uk-flex-center">

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
										</li>
										<% end_loop %>
										<% end_if %>
								</ul>

									<a class="uk-position-center-left uk-position-small uk-dark uk-text-primary" data-uk-slidenav-previous data-uk-slideshow-item="previous"></a>
									<a class="uk-position-center-right uk-position-small uk-dark uk-text-primary" data-uk-slidenav-next data-uk-slideshow-item="next"></a>

							</div>
						</div>
						<% end_if %>
						<div class="uk-margin">
							<h3><%t Event.Target 'Zielgruppe:' %></h3>
							$Target
						</div>
						<div class="uk-margin">
							<h3><%t Event.Content 'Seminarinhalte:' %></h3>
							$Content
						</div>
						<div class="uk-margin">
							<h3><%t Event.Extras 'Extras:' %></h3>
							$Extras
						</div>
						<div class="uk-margin">
							<h3><%t Event.Duration 'Dauer:' %></h3>
							$Duration
						</div>
						<div class="uk-margin">
							<h3><%t Event.Investition 'Investition:' %></h3>
							$Investition
						</div>
						<div class="uk-margin">
							<h3><%t Event.Dates 'Termine:' %></h3>
							<% if Dates.exists %>
							<% loop Dates %>
							<div>$Date <%t Event.In 'in' %> $City - <a href="$RegisterLink" data-uk-tooltip="<%t Event.RegisterNow 'jetzt anmelden' %>"><%t Event.RegisterNow 'jetzt anmelden' %></a></div>
							$EventDateStructuredData
							<% end_loop %>
							<% else %>
							<p><%t Event.NoDates 'Keine Termine am Moment' %></p>
							<% end_if %>
						</div>
						<% if Files.exists %>
						<div class="uk-margin">
							<h3><%t Event.Files 'Downloads:' %></h3>
							<% loop Files %>
							<div class="uk-flex uk-flex-middle">
								<img src="$ThumbnailURL(120,120)" />
								<div>
									<strong>$Title</strong>
									<div>$Extension - $Size</div>
									<a href="$URL" target="_blank" data-uk-tooltip="title: Herunterladen"><i class="fa fa-download uk-margin-small-right" ></i><span class="file-name">$Name.LimitCharacters(30)</span></a>
								</div>
							</div>
							<% end_loop %>
						</div>
						<% end_if %>
						<div class="uk-margin">
							$Footer
						</div>
					</div>
				</div>
	</div>
</section>
<% end_with %>