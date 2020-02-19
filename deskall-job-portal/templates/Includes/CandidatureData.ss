<table width="100%">
	<tr>
		<td width="100"><% if Candidat.Picture.exists %>$Candidat.Picture.Thumbnail(80,80)<% end_if %></td>
		<td width="320">
			<strong>$Candidat.Gender $Candidat.Member.FirstName $Candidat.Member.Surname</strong><br/>
			<% if $Candidat.Birthdate %><span>$Candidat.Age</span><% end_if %>
			$Description
		</td>
		<td width="125" align="right">$Candidat.NiceAddress</td>
	</tr>
</table>
<% if $Content %>
<table style="margin-top:40px;" width="100%">
	<tr>
		<td><h2><%t Candidature.Text 'Bewerbungstext' %></h2></td>
	</tr>
	<tr>
		<td>$Content</td>
	</tr>
</table>
<% end_if %>
<table style="margin-top:40px;" width="100%">
	<tr>
		<td><h2><%t Candidature.ExperienceTitle 'Berüfliche Erfahrungen' %></h2></td>
	</tr>
	<% if CVItems.exists %>
		<% loop CVItems %> 
		<tr>
			<td>$Content</td>
		</tr>
		<% end_loop %>
	<% else %>
	<tr><td><%t Candidature.NoExperience 'Keine berüfliche Erfahrungen' %></td></tr>
	<% end_if %>
</table>