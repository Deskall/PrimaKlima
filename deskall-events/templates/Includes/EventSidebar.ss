<div data-uk-sticky="bottom:true;bottom-offset:50;offset:100">
					<ul class="uk-nav-default uk-nav-parent-icon" uk-nav>
						<li <% if ClassName == "EventPage" && URLSegment == $MainEventPage.URLSegment%>class="uk-active"<% end_if %>><a href="$MainEventPage.Link" class="uk-h3 ">$MainEventPage.MenuTitle</a></li>
					       <%--  <li class="uk-parent">
					            <a href="#"><%t Event.OpenEvents 'Offene Seminare' %></a>
					            <ul class="uk-nav-sub"> --%>
					            	<li <% if ClassName == "EventPage" && URLSegment == $SubEventPage.URLSegment%>class="uk-active"<% end_if %>><a href="$SubEventPage.Link" ><%t Event.OpenEventsPreview 'Kurse Termine {year}' year=$Now.Year %></a></li>
					            	<% loop activeEvents %>
					            	<li <% if URLSegment == $Top.Event.URLSegment %>class="uk-active"<% end_if %>><a href="$Link" >$MenuTitle</a></li>
					            	<% end_loop %>
					        <%--     </ul>
					    </li> --%>
					</ul>
				</div>