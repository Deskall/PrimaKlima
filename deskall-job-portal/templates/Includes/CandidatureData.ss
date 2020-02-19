<table cellpaddind="10" width="100%" bgcolor="#EEEEEE">
	<tr>
		<td width="100"><%t Candidature.MissionNumber 'Stellenangebot-Nr.:' %> $Mission.Nummer</td>
		<td width="445">$Mission.Title</td>
	</tr>
</table>
<table>
	<tr height="50">
		<td>&nbsp;</td>
	</tr>
</table>
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
<table>
	<tr height="50">
		<td>&nbsp;</td>
	</tr>
</table>
<% if $Content %>
<table width="100%">
	<tr>
		<td><h2><%t Candidature.Text 'Bewerbungstext' %></h2></td>
	</tr>
	<tr height="30">
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>$Content</td>
	</tr>
</table>
<table>
	<tr height="50">
		<td>&nbsp;</td>
	</tr>
</table>
<% end_if %>
<table width="100%">
	<tr>
		<td><h2><%t Candidature.ExperienceTitle 'Berüfliche Erfahrungen' %></h2></td>
	</tr>
	<tr height="30">
		<td>&nbsp;</td>
	</tr>
	<% if Candidat.CVItems.exists %>
		<% loop Candidat.CVItems %> 
		<tr>
			<td width="100">
				$StartDate.Nice - <% if $EndDate %>$EndDate.Nice<% else %><%t Candidature.Today 'Heute' %><% end_if %><br>
				$Company
			</td>
			<td>
				<div><strong>$Position</strong></div>
				$Description
			</td>
		</tr>
		<tr height="20">
			<td>&nbsp;</td>
		</tr>
		<% end_loop %>
	<% else %>
	<tr><td><%t Candidature.NoExperience 'Keine berüfliche Erfahrungen' %></td></tr>
	<% end_if %>
</table>
<table>
	<tr height="50">
		<td>&nbsp;</td>
	</tr>
</table>
<table width="100%">
	<tr>
		<td><h2><%t Candidature.FormationTitle 'Ausbildungen' %></h2></td>
	</tr>
	<tr height="30">
		<td>&nbsp;</td>
	</tr>
	<% if Candidat.CursusItems.exists %>
		<% loop Candidat.CursusItems %> 
		<tr>
			<td width="100">
				$StartDate.Nice - <% if $EndDate %>$EndDate.Nice<% else %><%t Candidature.Today 'Heute' %><% end_if %><br>
				$School
			</td>
			<td>
				<div><strong>$Diplom</strong></div>
			</td>
		</tr>
		<tr height="20">
			<td>&nbsp;</td>
		</tr>
		<% end_loop %>
	<% else %>
	<tr><td><%t Candidature.NoFormation 'Keine Ausbildungen' %></td></tr>
	<% end_if %>
</table>