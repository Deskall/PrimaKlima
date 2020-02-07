             <div class="dk-text-content $TextAlign  $TextColumns  uk-overflow-auto <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
              <% if getLessons %>
              <table class="kurse-table uk-table uk-table-small uk-table-middle">
               <thead>
                 <tr>
                   <th class="uk-text-nowrap">Kurs-Nr.</th>
                   <th>Datum</th>
                   <th class="uk-visible@m">Dauer</th>
                   <th class="uk-visible@m">Kosten</th>
                   <th class="uk-visible@m">Kursleitung</th>
                   <th class="uk-text-nowrap uk-text-center">Details</th>
                 </tr>
               </thead>
               <tbody>
                 <% loop $getLessons %>
                 <tr>
                   <td class="uk-text-nowrap">$KursID</td>
                   <td>$DatumVonDatumBis<br>
                   $Wochentag - $ZeitVonZeitBis</td>
                   <td class="uk-visible@m"><% if $AnzahlLektionen > 0 %>$AnzahlLektionen * <% end_if %>$DauerMinuten min</td>
                   <td class="uk-visible@m">Fr. $PreisPerson<br><% if istPaartanz %>(pro Person)<% else %>(pro Lektion)<% end_if %></td>
                   <td class="uk-visible@m">$LehrerVorname</td>
                   <td class="uk-table-link uk-text-center"><a href="{$Top.getPage.Link}kurs-details/$KursID.URLATT"><span class="uk-visible@m">Hier Clicken</span><span class="uk-hidden@m"><i class="icon icon-chevron-right"></i></span></a></td>
                 </tr>
                 <% end_loop %>
               </tbody>
             </table>
             <% else %>
             <p>Zur Zeit kein Kurs.</p>
             <% end_if %>
           </div>