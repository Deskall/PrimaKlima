
				
				<table width="100%">
					<tr>
						<td width="100">
							<% if Customer.Logo %>
								<% if $Customer.Logo.getExtension == "svg" %>
								<img src="$Customer.Logo.URL" width="100" />
								<% else %>
								<img src="$Customer.Logo.FitMax(100,100)" width="100" />
								<% end_if %>
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
						
				
