
				<table cellpadding="10" width="100%" bgcolor="#EEEEEE">
					<tr>
						<td width="100"><%t Candidature.MissionNumber 'Stellenangebot-Nr.:' %> $Nummer</td>
						<td width="445">$Title</td>
					</tr>
				</table>
				<table>
					<tr height="80">
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td width="120">
							<% if Customer.Logo %>
								<% if $Customer.Logo.getExtension == "svg" %>
								<img src="$Customer.Logo.URL" width="100" />
								<% else %>
								<img src="$Customer.Logo.FitMax(100,100).URL" width="100" />
								<% end_if %>
							<% end_if %>
						</td>
						<td>
							<table>
								<tr>
									<td colspan="3"><strong>$Customer.Company</strong></td>
								</tr>
								<tr height="30">
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td colspan="3"><h1>$Title</h1></td>
								</tr>
								<tr height="30">
									<td>&nbsp;</td>
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
						
				
				<table width="100%">
					<tr height="80">
						<td>&nbsp;</td>
					</tr>
				</table>

				
				<table width="100%">
					<tr>
						<td><h2><%t OfferPage.JobDescription 'Job Beschreibung' %></h2></td>
					</tr>
					<tr height="30">
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>$Description</td>
					</tr>
				</table>

				<table width="100%">
					<tr height="80">
						<td>&nbsp;</td>
					</tr>
				</table>
				<% if $Attachments.exists %>
				<table width="100%">
					<tr>
						<td><h3><%t OfferPage.MoreInfos 'Weitere Informationen' %></h3></td>
					</tr>
					<tr height="30">
						<td>&nbsp;</td>
					</tr>
					<% loop $Attachments %>
					<tr>
						<td><a href="$URL" target="_blank">$Title</a></td>
					</tr>
					<% end_loop %>
				</table>
				<% end_if %>
				<table width="100%">
					<tr height="80">
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="100%">
					<tr>
						<td><h2><%t OfferPage.WeOffer 'Wir bieten Ihnen' %></h2></td>
					</tr>
					<tr>
						<td>$Customer.ReasonWhy</td>
					</tr>
				</table>
				
				
<table width="100%">
					<tr height="80">
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="100%">
					
						
								<tr>
									<td><h2><%t Mission.About 'Über' %> $Customer.Company</h2></td>
								</tr>
								<tr height="30">
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td>$Customer.Description</td>
								</tr>
					
				</table>
				<table width="100%">
					<tr height="80">
						<td>&nbsp;</td>
					</tr>
				</table>
				<table width="100%">
					
						
								<tr>
									<td><a href="$AbsoluteLink" target="_blank"><%t Mission.GoOnline 'Klicken Sie hier, um dieses und viele andere Angebote auf unserer Website www.schneider-hotel-gastrojobs.com zu finden' %></a></td>
								</tr>
								
					
				</table>