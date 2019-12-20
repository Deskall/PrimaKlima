             <div class="dk-text-content $TextAlign  $TextColumns  <% if TextColumnsDivider %>uk-column-divider<% end_if %>">
              <% if getLessons %>
              <table class="kurse-table">
               <thead>
                 <tr>
                   <th>Kurs-Nr.</th>
                   <th>Datum</th>
                   <th>Tag</th>
                   <th>Zeit</th>
                   <th>Dauer</th>
                   <th>Kosten</th>
                   <th>Kursleitung</th>
                   <th>Info & Anmeldung</th>
                 </tr>
               </thead>
               <tbody>
                 <% loop $getLessons %>
                 <tr>
                   <td>$KursID</td>
                   <td>$DatumVonDatumBis</td>
                   <td>$Wochentag</td>
                   <td>$ZeitVonZeitBis</td>
                   <td><% if $AnzahlLektionen > 0 %>$AnzahlLektionen * <% end_if %>$DauerMinuten min</td>
                   <td>Fr. $PreisPerson</td>
                   <td>$LehrerVorname $LehrerNachname</td>
                   <td><a href="{$Top.Level(1).Link}kurs-details/$KursID.URLATT">Hier Clicken</a></td>
                 </tr>
                 <% end_loop %>
               </tbody>
             </table>
             <% else %>
             <p>Zur Zeit kein Kurs.</p>
             <% end_if %>
           </div>