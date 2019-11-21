<hr>
<br/>
<table>
	<tr><td><%t Mission.Position 'Position' %></td><td>$NiceJobTitle</td></tr>
	<tr><td><%t Mission.Place 'Ort' %></td><td>$Place</td></tr>
	<tr><td><%t Mission.Period 'Zeitraum' %></td><td>$Period</td></tr>
	<tr><td><%t Mission.TransportCost 'Fahrtkosten' %></td><td>$CookConfig.TransportCost</td></tr>
	<tr><td><%t Mission.CostAndHousing 'Kost & Logis' %></td><td>$CookConfig.CostAndHousing</td></tr>
	<tr><td><%t Mission.AgentCost 'Agentur-Gebühr' %></td><td>$CookConfig.AgentCost</td></tr>
	<% if Others %><tr><td><%t Mission.Others 'Bemerkungen / Sondernwünsche' %></td><td>$Others</td></tr><% end_if %>
</table>
<br/>
<hr>