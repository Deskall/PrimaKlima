<table>
	<tr>
		<td><% if Candidat.Picture.exists %>$Candidat.Picture.Thumbnail(80,80)<% end_if %></td>
		<td>
			<strong>$Candidat.Gender $Candidat.Member.FirstName $Candidat.Member.Surname</strong><br/>
			<% if $Candidat.Birthdate %><span>$Candidat.Age</span><% end_if %>
			$Description
		</td>
		<td align="right">$Candidat.NiceAddress</td>
	</tr>
	<tr>
		<td><% if Candidat.Picture.exists %>$Candidat.Picture.Thumbnail(80,80)<% end_if %></td>
		<td align="right">$Candidat.NiceAddress</td>
	</tr>
</table>