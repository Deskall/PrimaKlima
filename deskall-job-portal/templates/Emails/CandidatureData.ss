
<br/>
<strong><%t Mission.Mission 'Angebot:' %></strong>
<table>
	<tr><td><%t Mission.Number 'Angebot-Nr.' %></td><td>$Mission.Nummer</td></tr>
	<tr><td><%t Mission.Title 'Title' %></td><td>$Mission.Title</td></tr>
	<tr><td><%t Mission.Place 'Ort' %></td><td>$Mission.Place $Mission.City</td></tr>
</table>
<br/>

<strong><%t Mission.Candidature 'Bewerbung:' %></strong>
<p><%t Candidat.Title 'Bewerber' %>: $Candidat.Member.FirstName $Candidat.Member.Surname</p>
	
<strong><%t Mission.CandidatureText 'Bewerbungstext:' %></strong>
<p>«<i>$Content</i>»</p>