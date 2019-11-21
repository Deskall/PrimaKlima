

			<div class="col w-12 text">
				<h2>Bewerbung für $EmployerAdvertisement.ContentTitle</h2>
				$Content



				<% if $Attachements	%>
				<div class="certificates ">
					<h3>Anhänge</h3>
					<% loop $Attachements %>
						<a href="$URL" target="_blank" title="$Title" class="attachement">$Title</a>
					<% end_loop %>
				</div>
				<% end_if %>

			</div>


<% if $isEmployer %>
			<div class="col w-12">
				<a class="btn-reply-application large" href="mailto:$Cook.Email">Jetzt antworten</a>
			</div>
<% end_if %>




		<% with $Cook %>





			<div class="col w-12">
				<h3>Bewerber-Profil</h3>
			</div>

			<div class="col w-4 image-holder" >
				<img src="$Picture.setWidth(350).URL" alt="$FirstName $Surname" title="$FirstName $Surname" />
			</div>

			<div class="col w-8 header" >
				<h2>$FirstName $Surname</h2>
				<p class="item">ID-Nummer: $ID </p>
				<a href="mailto:$Email" class="item contact btn-email">$Email</a>
				<a href="tel:$Mobile" class="item contact btn-phone">$Mobile</a>
			</div>	

			<div class="col w-4 address">
				<p>$Address <br/>$PostalCode $Place<br/>$Country</p>
				<p>Zivilstand: $MaritalStatus</p>
			</div>

			<div class="col w-4 positions list">



				<div class="item">
				<% if $DesiredPosition.Count > 1  %>
				<span class="title">Wunschpositionen: </span><span class="description"><ul><% loop $DesiredPosition %><li>$Title__de_DE</li><% end_loop %></ul></span>
				<% else %>
				<span class="title">Wunschposition: </span><span class="description"><% loop $DesiredPosition %>$Title__de_DE<% end_loop %></span></p>
				<% end_if %>
				</div>

				<div class="item">
					<span class="title">Aktuelle Position</span>
					<span class="description">
						$CurrentJob.Title__de_DE
					</span>
				</div>


			</div>

			<div class="col w-4 skills list">
				<h3>Kenntnisse & Erfahrungen</h3>

					<div class="item">
						<span class="title">Sprachen</span>
						<span class="description">
							<ul>
								<% loop $Languages %>
									<li>$Title__de_DE</li>
								<% end_loop %>
							</ul>
						</span>
					</div>

					<div class="item">
						<span class="title">Spezialkenntnise</span>
						<span class="description">
							<ul>
								<% loop $Skills %>
									<li>$Title__de_DE</li>
								<% end_loop %>
							</ul>
						</span>
					</div>

					<div class="item">
						<span class="title">Führungserfahrung </span>
						<span class="description">
							<ul>
								<% loop $LeadershipExperience %>
									<li>$Title__de_DE</li>
								<% end_loop %>
							</ul>
						</span>
					</div>

					<div class="item">
						<span class="title">Leitung von Events </span>
						<span class="description">
							<ul>
								<% loop $LeadershipEvents %>
									<li>$Title__de_DE</li>
								<% end_loop %>
							</ul>
						</span>
					</div>

					<div class="item">
						<span class="title">Raportsysteme</span>
						<span class="description">
							<ul>
								<% loop $Reports %>
									<li>$Title__de_DE</li>
								<% end_loop %>
							</ul>
						</span>
					</div>


			</div>

			<div class="col w-4 cv list">
				<h3>Lebenslauf</h3>
				<% loop $CVItmes.Sort("StartDate Desc") %>
					<div class="item">
						<span class="title">$StartDate.format("Y/m")<% if $EndDate %> – $EndDate.format("Y/m")<% end_if %></span>
						<span class="description">$Description</span>
					</div>
				<% end_loop %>
			</div>
			<div class="col w-4 certificates">
				<h3>Zeugnisse</h3>
				<% loop $Certificates %>
					<a href="$Link" target="_blank" class="certificate">$Title</a>
				<% end_loop %>
			</div>



		<% end_with %>



<% if $isEmployer %>
			<div class="col w-12">
				<a class="btn-reply-application large" href="mailto:$Email">Jetzt antworten</a>
			</div>
<% end_if %>