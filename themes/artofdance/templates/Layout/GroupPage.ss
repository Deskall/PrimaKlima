<section class="uk-section uk-section-small">
    <div class="uk-container">
      <div class="uk-grid-small uk-grid-match" data-uk-grid>
        <div class="uk-width-1-4@m uk-width-1-5@l uk-visible@m">
          <aside class="uk-padding-small uk-background-muted">
            <% include SideBar %>
          </aside>
        </div>
        <div class="uk-width-3-4@m uk-width-4-5@l">
          $ElementalArea
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
      </div>
    </div>
</section>

  