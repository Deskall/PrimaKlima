
<table>
	<tbody>
		<% if Items.exists %>
			<% loop Items %>
			<tr><td>$Title</td></tr>
			<% end_loop %>
		<% end_if %>
	</tbody>

</table>
