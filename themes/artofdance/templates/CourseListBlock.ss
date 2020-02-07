             <div class="dk-text-content $TextAlign  $TextColumns  uk-overflow-auto <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
              <% if getLessons %>
              <table class="kurse-table uk-table uk-table-small">
               <thead>
                 <tr>
                   <th>Kurs-Nr.</th>
                   <th>Datum</th>
                   <th>Tag - Zeit</th>
                   <th class="uk-visible@m">Dauer</th>
                   <th class="uk-visible@m">Kosten</th>
                   <th class="uk-visible@m">Kursleitung</th>
                   <th>Details</th>
                 </tr>
               </thead>
               <tbody>
                 <% loop $getLessons %>
                 <tr>
                   <td>$KursID</td>
                   <td>$DatumVonDatumBis</td>
                   <td>$Wochentag - $ZeitVonZeitBis</td>
                   <td class="uk-visible@m"><% if $AnzahlLektionen > 0 %>$AnzahlLektionen * <% end_if %>$DauerMinuten min</td>
                   <td class="uk-visible@m">Fr. $PreisPerson</td>
                   <td class="uk-visible@m">$LehrerVorname</td>
                   <td><a href="{$Top.getPage.Link}kurs-details/$KursID.URLATT"><span class="uk-visible@m">Hier Clicken</span><span class="uk-hidden@m"><i class="icon icon-chevron-right"></i></span></a></td>
                 </tr>
                 <% end_loop %>
               </tbody>
             </table>
             <% else %>
             <p>Zur Zeit kein Kurs.</p>
             <% end_if %>
           </div>