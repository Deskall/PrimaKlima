<table width="100%">
	<tr>
		<td width="100"><% if Candidat.Picture.exists %>$Candidat.Picture.Thumbnail(80,80)<% end_if %></td>
		<td width="300">
			<strong>$Candidat.Gender $Candidat.Member.FirstName $Candidat.Member.Surname</strong><br/>
			<% if $Candidat.Birthdate %><span>$Candidat.Age</span><% end_if %>
			$Description
		</td>
		<td width="100" align="right">$Candidat.NiceAddress</td>
	</tr>
</table>
<% if $Content %>
<table width="100%">
	<tr>
		<td><h2><%t Candidature.Text 'Bewerbungstext' %></h2></td>
	</tr>
	<tr>
		<td><i>$Content</i></td>
	</tr>
</table>
<% end_if %>
