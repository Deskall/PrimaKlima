	
	<section class="uk-section uk-section-small">
		<div class="uk-container">
			<div class="uk-grid-small uk-grid-match" data-uk-grid>
				<div class="uk-width-1-4@m uk-width-1-5@l uk-visible@m">
					<aside class="uk-padding-small uk-background-muted">
						<% include SideBar %>
					</aside>
				</div>
				<div class="uk-width-3-4@m uk-width-4-5@l">
					    $MainGroup.Bezeichnung / <a href="$Link">$kursData.GruppenTitel</a> / $kursData.KursIDTitelDatumVonDatumBis
					      <h1>$Title</h1>
					      <div class="main-data">
					        <% if $kursData.DatumVonDatumBis %>
					      	<div class="item">
					      		<i class="icon icon-calendar"></i> 
					      		$kursData.DatumVonDatumBis (<% if $kursData.AnzahlLektionen > 0 %>$kursData.AnzahlLektionen * <% end_if %>$kursData.DauerMinuten min)
					      	</div>
					        <% end_if %>
					        <% if $kursData.ZeitVonZeitBis %>
					        <div class="item">
					          <i class="icon icon-clock"></i> 
					          $kursData.WochentagLang - $kursData.ZeitVonZeitBis
					        </div>
					        <% end_if %>
					        <% if $kursData.PreisPaarPerson %>
					        <div class="item">
					          <i class="icon icon-cash"></i> 
					          Kosten: $kursData.PreisPaarPerson
					        </div>
					        <% end_if %>
					        <% if $kursData.LehrerID %>
					      	<div class="item">
					      		<i class="icon icon-ios-people"></i> 
					      		Kursleitung: $kursData.LehrerVorname $kursData.LehrerNachname
					      	</div>
					        <% end_if %>
					        <% if $kursData.SaalID %>
					      	<div class="item">
					      		<i class="icon icon-location"></i> 
					      		Saal: $kursData.SaalBezeichnung
					      	</div>
					        <% end_if %>
					      	<div class="lead-block">
					      		<p>$kursData.GruppenText</p>
					      	</div>
					      	<div>
					      		<p>$kursData.KursText</p>
					      	</div>
					    </div>
					    <% if $kursData.Text %>
					    <div class="text-block">
					      $kursData.Text
					    </div>
					    <% end_if %>
					    <% if ${kursData.istAnmeldungMöglich} %>
							  <div class="form-block">
					        <form action="{$Link}SendKurseForm" method="post" class="form-std">
					          <div class="col w-12">
					            <h2>Kursanmeldung</h2>
					            <div><p>Die Online-Anmeldung ist verbindlich.</p></div>
					            <div><p><small>* = Pflichtfeld.</small></p></div>
					          </div>
					          <% if $kursData.istPaarTanz %>
					            <div class="col w-12">
					              <h3>Ihre Angaben</h3>
					              <div class="form-field"><label><%t FormBlock.ANREDE 'Anrede *' %></label><select name="anrede" required><option>Bitte wählen</option><option value="Frau">Frau</option><option value="Herr">Herr</option></select></div>
					              <div class="form-field"><label><%t FormBlock.NAME 'Name *' %></label><input type="text" name="name" required/></div>
					              <div class="form-field"><label><%t FormBlock.VORNAME 'Vorname *' %></label><input type="text" name="vorname" required/></div>
					              <div class="form-field"><label><%t FormBlock.EMAIL 'E-Mail *' %></label><input type="email" name="email" required/></div>
					              <div class="form-field"><label><%t FormBlock.BIRTHDAY 'Geburstdatum *' %></label><input type="date" name="birthday" required/></div>
					              <div class="form-field"><label><%t FormBlock.STREET 'Strasse' %></label><input type="text" name="strasse" /></div>
					              <div class="form-field"><label><%t FormBlock.PLZ 'PLZ' %></label><input type="text" name="plz"/></div>
					              <div class="form-field"><label><%t FormBlock.Place 'Ort' %></label><input type="text" name="ort" /></div>
					              <div class="form-field"><label><%t FormBlock.PHONE 'Telefon' %></label><input type="text" name="telephone" /></div>
					            </div>
					            <div class="col w-12 partner">
					              <h3>Angaben Partner</h3>
					              <div class="form-field"><label><%t FormBlock.ANREDE 'Anrede *' %></label><select name="anrede2" required><option>Bitte wählen</option><option value="Frau">Frau</option><option value="Herr">Herr</option></select></div>
					              <div class="form-field"><label><%t FormBlock.NAME 'Name *' %></label><input type="text" name="name2" required/></div>
					               <div class="form-field"><label><%t FormBlock.VORNAME 'Vorname *' %></label><input type="text" name="vorname2" required/></div>
					              <div class="form-field"><label><%t FormBlock.EMAIL 'E-Mail *' %></label><input type="email" name="email2" required/></div>
					              <div class="form-field"><label><%t FormBlock.BIRTHDAY 'Geburstdatum *' %></label><input type="date" name="birthday2" required/></div>
					              <div class="form-field"><label><%t FormBlock.STREET 'Strasse' %></label><input type="text" name="strasse2" /></div>
					              <div class="form-field"><label><%t FormBlock.PLZ 'PLZ' %></label><input type="text" name="plz2"/></div>
					              <div class="form-field"><label><%t FormBlock.Place 'Ort' %></label><input type="text" name="ort2" /></div>
					              <div class="form-field"><label><%t FormBlock.PHONE 'Telefon' %></label><input type="text" name="telephone2" /></div>
					            </div>
					           
					          <% else %>
					          <div class="col w-12">
					              <div class="form-field"><label><%t FormBlock.ANREDE 'Anrede *' %></label><select name="anrede" required><option>Bitte wählen</option><option value="Frau">Frau</option><option value="Herr">Herr</option></select></div>
					              <div class="form-field"><label><%t FormBlock.NAME 'Name *' %></label><input type="text" name="name" required/></div>
					              <div class="form-field"><label><%t FormBlock.VORNAME 'Vorname *' %></label><input type="text" name="vorname" required/></div>
					              <div class="form-field"><label><%t FormBlock.EMAIL 'E-Mail *' %></label><input type="email" name="email" required/></div>
					              <div class="form-field"><label><%t FormBlock.BIRTHDAY 'Geburstdatum *' %></label><input type="date" name="birthday" required/></div>
					              <div class="form-field"><label><%t FormBlock.STREET 'Strasse' %></label><input type="text" name="strasse" /></div>
					              <div class="form-field"><label><%t FormBlock.PLZ 'PLZ' %></label><input type="text" name="plz"/></div>
					              <div class="form-field"><label><%t FormBlock.Place 'Ort' %></label><input type="text" name="ort" /></div>
					              <div class="form-field"><label><%t FormBlock.PHONE 'Telefon' %></label><input type="text" name="telephone" /></div>
					          </div>
					          <% end_if %>
					          <input type="hidden" name="course" value="$kursData.KursID" />
					          
					          <div class="col w-12">
					            <div class="form-field checkbox">
					             <label><input type="checkbox" name="agb" required /><a href="ueber-uns/agb" target="_blank">AGB</a>'s gelesen</label>
					            </div>
					          </div>
					           <div class="col w-12">
					             <div class="form-field checkbox">
					              <label><input type="checkbox" name="acceptance" required />Sie erklären sich damit einverstanden, dass Ihre Daten zur Bearbeitung Ihres Anliegens verwendet werden. Weitere Informationen und Widerrufshinweise finden Sie in der Datenschutzerklärung. Eine Kopie Ihrer Nachricht wird an Ihre E-Mail-Adresse geschickt.</label>
					            </div>
					          </div>
					          <div class="col w-12">
					            <div class="g-recaptcha" data-sitekey="6LdIp6gUAAAAANwnrU-l3IF5ukVbEIDH7L5UpKKu" data-size="invisible"></div>
					    			  <button><% if TextButton %>$TextButton<% else %><%t FormKursBlock.SEND 'Jetzt anmelden' %><% end_if %><% include DefaultIcon %></button>
					          </div>
								</form>
							</div>
					    <% end_if %>
				</div>
			</div>
		</div>
	</section>
	
	