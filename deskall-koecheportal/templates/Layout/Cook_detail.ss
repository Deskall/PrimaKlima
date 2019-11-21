<section class="cook block-holder">
	<div class="container">


		<% if $Cook.isMe %>
		<div class="col w-12 rental">
			<div class="edit-profil-holder clearfix">
				<a href="javascript:history.back()" class="go-back">Zurück</a>
				<a href="/mein-koecheportal/#personal" class="edit-profile">Bearbeiten</a>
			</div>
		</div>
		<% end_if %>



		<% if $template == 'rental' %>

		<div class="col w-12 rental">


		<% with $Cook %>

			<div class="col w-12">
				<h1>Mietkoch-Profil</h1>
			</div>

			<div class="col w-4 image-holder" >
				<img src="$Picture.setWidth(350).URL" alt="$FirstName $Surname" title="$FirstName $Surname" />
			</div>

			<div class="col w-8 header" >
				<h2>Mietkoch, ID-Nummer: $ID</h2>
			</div>	


			<div class="col w-8 skills list ">
				<h3>Kenntnisse & Erfahrungen</h3>

					<% if $Languages %>
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
					<% end_if %>

					<% if $Skills %>
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
					<% end_if %>

					<% if $LeadershipExperience %>
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
					<% end_if %>

					<% if $LeadershipEvents %>
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
					<% end_if %>

					<% if $Reports %>
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
					<% end_if %>

			</div>

			<div class="col w-4 cv list">
				<h3>Lebenslauf</h3>
				<% loop $CVItmes.Sort("StartDate Desc") %>
					<div class="item">
						<span class="title">$StartDate.format("Y/m")<% if $EndDate %> – $EndDate.format("Y/m")<% end_if %></span>
						<span class="description">$Description</span>
					</div>
				<% end_loop %>

				<% if $CVFile %>
				<div class="certificates">
					<a href="$CVFile.URL" target="_blank" class="certificate">PDF Download</a>
				</div>
				<% end_if %>
				
			</div>				
			<div class="col w-8 employment list">
				<% if $Employments %>
				<h3>Mietkoch-Einsätze</h3>
				<% loop $Employments.Sort("StartDate Desc") %>
					<div class="item">
						<span class="title">$StartDate.format("d.m.Y")<% if $EndDate %> – $EndDate.format("d.m.Y")<% end_if %></span>
						<span class="description">$Description</span>
					</div>
				<% end_loop %>
				<% end_if %>
			</div>

		<% end_with %>







		</div>


		<% else_if $template == 'candidate' %>
		<% with $Cook %>
			<div class="col w-12">
				<h1>Bewerber-Profil</h1>
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

					<% if $Languages %>
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
					<% end_if %>

					<% if $Skills %>
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
					<% end_if %>
					
					<% if $LeadershipExperience %>
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
					<% end_if %>
					
					<% if $LeadershipEvents %>
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
					<% end_if %>
					
					<% if $Reports %>
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
					<% end_if %>

			</div>

			<div class="col w-4 cv list">
				<h3>Lebenslauf</h3>
				<% loop $CVItmes.Sort("StartDate Desc") %>
					<div class="item">
						<span class="title">$StartDate.format("Y/m")<% if $EndDate %> – $EndDate.format("Y/m")<% end_if %></span>
						<span class="description">$Description</span>
					</div>
				<% end_loop %>

				<% if $CVFile %>
				<div class="certificates">
					<a href="$CVFile.URL" target="_blank" class="certificate">PDF Download</a>
				</div>
				<% end_if %>


			</div>
			<div class="col w-4 certificates">
				<% if $Certificates %>
				<h3>Zeugnisse</h3>
				<% loop $Certificates %>
					<a href="$Link" target="_blank" class="certificate">$Title</a>
				<% end_loop %>
				<% end_if %>
			</div>


		<% end_with %>


		<% else_if $template == 'login' %>

		<div class="col w-12 login-page-holder ">
			<h1>$Title</h1>
			<p>Dieser Bereich steht nur eingeloggten Arbeitgebern zur Verfügung</p>

			$LoginForm

		</div>

		<% end_if %>
	</div>
</section>