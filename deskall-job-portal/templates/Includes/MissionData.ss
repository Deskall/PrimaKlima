
				
				<table width="100%">
					<tr>
						<td width="100">
							<% if Customer.Logo %>
								<img <% if $Customer.Logo.getExtension == "svg" %>src="$Customer.Logo.URL"<% else %>src="$Customer.Logo.FitMax(100,100)"<% end_if %> alt="Logo von $Customer.Company" width="100">
							<% end_if %>
						</td>
						<td>
							<table>
								<tr>
									<td><strong>$Customer.Company</strong></td>
								</tr>
								<tr>
									<td><h1>$Title</h1></td>
								</tr>
								<tr>
									<td>$City</td>
									<td>
									<% with Parameters.filter('Title','Anstellung').first %>$Value<% end_with %>
									</td>
									<td>$PublishedDate.Nice</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
						
				
