<% if HeaderSlide %>
  <% with HeaderSlide.Image %>
<div class="dk-header-slide uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light" data-src="$FocusFill(350,200).URL" data-srcset="$FocusFill(350,200).URL 320w, $FocusFill(650,250).URL 650w, $FocusFill(1200,300).URL 1200w, $FocusFillMax(2000,400).URL 1500w" alt="" data-sizes="100vw" data-uk-img><% end_with %>
<section class="uk-section uk-width-1-1 uk-position-relative">
    <div class="uk-container">
        <div class="uk-position-relative uk-height-1-1">
            <div class="dk-slide-text uk-text-left">
                <div class="title">$Product.Name</div>
                <div class="slide-text">$Product.HeaderText</div>
            </div>
        </div>
        <% if $Product.HeaderImage %>
        <div class="uk-position-center-right">
          <img src="$Product.HeaderImage.ScaleHeight(400).URL" />
        </div>
        <% end_if %>
    </div>
  </div>
</section>
<% end_if %>

<section class="uk-section">
  <div class="uk-container">
    <div data-uk-grid>
      <div class="uk-visible@m uk-width-1-3@m uk-width-1-4@l sidebar-products">
        <h2><%t ProductPage.PRODUKTE "Produkte" %></h2>
        <ul class="uk-nav">
          <% loop $getCategories %>
          <% if $Title %>
          <li class="<% if $Top.Product.hasCategory($ID) %>uk-active<% end_if %>"><a href="$Link" class="uk-position-relative"><span class="uk-margin-small-right uk-position-left" data-uk-icon="chevron-right"></span>$Title</a></li>
          <% end_if %>
          <% end_loop %>
        </ul>
      </div>
      <div class="uk-width-2-3@m uk-width-3-4@l">
        <h1>$Product.Lead</h1>


        <% if $Product.MainImage %>
        <div data-uk-grid>
          <div class="uk-width-1-2@m product-image">
            <a class="clearfix" href="$Product.MainImage.URL" title="$Product.Description" data-imagelightbox="{$Top.ID}f"><img src="$Product.MainImage.Pad(350,250, FFFFFF).URL" alt="$Product.Description" /></a>
          </div>
          <div class="uk-width-1-2@m dk-text-content">
            <div class="uk-text-lead">$Product.Description</div>
          </div>
        </div>
        <% else %>
          <div class="uk-text-lead">$Product.Description</div>
        <% end_if %>

        <% if $Product.Features %>
        <div class="product-block dk-text-content uk-margin-large-bottom">
          $Product.Features
        </div>
        <% end_if %>

        <% if $Product.Number %>
        <div class="product-block uk-margin-large-bottom">
          <%t ProductPage.NUMMER "Best.-Nr." %>: $Product.Number
        </div>
        <% end_if %>




        <% if $Product.Usages %>
        <div class="product-block uk-margin-large-bottom">
          <h2><%t ProductPage.ANWENDUNG "Einfache Anwendung" %></h2>
          <div class="image-block">
            <div class="owl-gallery owl-carousel owl-theme">
              <% loop $Product.Usages %>
              <% if $Image %>
              <div class="item">
                <a href="$Image.Link" title="$Description" data-imagelightbox="{$Top.ID}f"><img src="$Image.FocusFillMax(350,250).URL" alt="$Title"/></a>
              </div>
              <% end_if %>
              <% end_loop %>
            </div>
          </div>
        </div>
        <% end_if %>






        <% if $Product.Images %>
        <div class="product-block uk-margin-large-bottom">
          <div class="image-block">
            <div class="owl-gallery owl-carousel owl-theme">
              <% loop $Product.Images.Sort('SortOrder') %>
              <div class="item">
                <a href="$URL" title="$Description" data-imagelightbox="{$Top.ID}f"><img src="$FocusFillMax(350,250).URL" alt="$Description"/></a>
              </div>
              <% end_loop %>
            </div>
          </div>
        </div>
        <% end_if %> 


        <% if $Product.Table %>
        <div class="product-block table uk-margin-large-bottom">
          <h2><%t ProductPage.TECHNISCHEDATEN "Technische Daten" %></h2>
          $Product.Table
        </div>
        <% end_if %>


        <% if $ContentLocale = "de-DE"%>
          <% if $Product.Downloads %>
          <div class="product-block uk-margin-large-bottom">
            <h2><%t ProductPage.DOWNLOADS "Downloads" %></h2>
            <div class="download-block">
              <% loop $Product.Downloads.Sort('SortOrder') %>
              <a href="$URL" target="_blank">$Title</a>
              <% end_loop %>
            </div>
          </div>
          <% end_if %>
        <% else %>
          <% if $Product.Downloads__en_US %>
          <div class="product-block uk-margin-large-bottom">
            <h2><%t ProductPage.DOWNLOADS "Downloads" %></h2>
            <div class="download-block">
              <% loop $Product.Downloads__en_US.Sort('SortOrder') %>
              <a href="$URL" target="_blank">$Title</a>
              <% end_loop %>
            </div>
          </div>
        <% end_if %>
        <% end_if %>


        <% if $Product.Videos %>
        <div class="product-block uk-margin-large-bottom">
          <h2><%t ProductPage.VIDEOS "Videos" %></h2>
          <div class="video-block">
            $Product.VideosHTML
           <%-- <div class="uk-flex-left uk-child-width-1-2@s uk-grid-small" data-uk-grid data-uk-lightbox>
              <% loop Product.Videos %>
                <div>
                  <% if Type == "Datei" %>
                        
                          <video data-uk-video width="480" height="360" controls>
                            <source src="$File.URL" type="video/{$File.getExtension}">
                            </video>
                         
                          <% else %>
                          <div data-uk-lightbox>
                            <a class="uk-inline uk-panel uk-link-muted uk-text-center uk-width-1-1" href="$URL" caption="$Title">
                              <figure>
                                <img src="$ThumbnailURL" width="400" alt="" class="uk-width-1-1">
                                <div class="uk-position-center">
                                    <div class="dk-video-play"><span class="icon ion-ios-play"></span></div>
                                </div>
                              </figure>
                            </a>
                          </div>
                    <% end_if %>
                </div>
                <% end_loop %>
            </div> --%>
          </div>
        </div>
        <% end_if %>
        <div class="product-block uk-margin-large-bottom">
          <h2><%t ProductPage.FORMTITLE "Jetzt Kontakt aufnehmen" %></h2>
          <div class="form-block">
           <div class="form-block">
            <form action="{$Link}SendProductForm" method="post" class="form-std">
              <span data-icon="&#xf213;"><input type="text" name="name" placeholder="<%t ProductPage.Name 'Name *' %>" required/></span>
              <span data-icon="&#xf26c;"><input type="text" name="firma" placeholder='<%t ProductPage.FIRMA "Firma" %>' /></span>
                 <!-- <span data-icon="&#xf3a3;"><input type="text" name="address" placeholder='<%t ProductPage.ADRESSE "Adresse *"%>' required/></span>
                  <span data-icon="&#xf3a3;"><input type="text" name="ort" placeholder='<%t ProductPage.ORT "PLZ / Ort *"%>' required/></span> -->
                  <% if $ContentLocale = "de-DE"%>
                  <select name="land" required><option value="">Land *</option><option value="Schweiz">Schweiz</option><option value="Deutschland">Deutschland</option><option value="Vereinigte Staaten von Amerika">Vereinigte Staaten von Amerika</option><option value="Afghanistan">Afghanistan</option><option value="Ägypten">Ägypten</option><option value="Aland">Aland</option><option value="Albanien">Albanien</option><option value="Algerien">Algerien</option><option value="Amerikanisch-Samoa">Amerikanisch-Samoa</option><option value="Amerikanische Jungferninseln">Amerikanische Jungferninseln</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarktis">Antarktis</option><option value="Antigua und Barbuda">Antigua und Barbuda</option><option value="Äquatorialguinea">Äquatorialguinea</option><option value="Argentinien">Argentinien</option><option value="Armenien">Armenien</option><option value="Aruba">Aruba</option><option value="Ascension">Ascension</option><option value="Aserbaidschan">Aserbaidschan</option><option value="Äthiopien">Äthiopien</option><option value="Australien">Australien</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesch">Bangladesch</option><option value="Barbados">Barbados</option><option value="Belgien">Belgien</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivien">Bolivien</option><option value="Bosnien und Herzegowina">Bosnien und Herzegowina</option><option value="Botswana">Botswana</option><option value="Bouvetinsel">Bouvetinsel</option><option value="Brasilien">Brasilien</option><option value="Brunei">Brunei</option><option value="Bulgarien">Bulgarien</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Chile">Chile</option><option value="China">China</option><option value="Cookinseln">Cookinseln</option><option value="Costa Rica">Costa Rica</option><option value="Cote d'Ivoire">Cote d'Ivoire</option><option value="Dänemark">Dänemark</option><option value="Diego Garcia">Diego Garcia</option><option value="Dominica">Dominica</option><option value="Dominikanische Republik">Dominikanische Republik</option><option value="Dschibuti">Dschibuti</option><option value="Ecuador">Ecuador</option><option value="El Salvador">El Salvador</option><option value="Eritrea">Eritrea</option><option value="Estland">Estland</option><option value="Europäische Union">Europäische Union</option><option value="Falklandinseln">Falklandinseln</option><option value="Färöer">Färöer</option><option value="Fidschi">Fidschi</option><option value="Finnland">Finnland</option><option value="Frankreich">Frankreich</option><option value="Französisch-Guayana">Französisch-Guayana</option><option value="Französisch-Polynesien">Französisch-Polynesien</option><option value="Gabun">Gabun</option><option value="Gambia">Gambia</option><option value="Georgien">Georgien</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Grenada">Grenada</option><option value="Griechenland">Griechenland</option><option value="Grönland">Grönland</option><option value="Großbritannien">Großbritannien</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guernsey">Guernsey</option><option value="Guinea">Guinea</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Heard und McDonaldinseln">Heard und McDonaldinseln</option><option value="Honduras">Honduras</option><option value="Hongkong">Hongkong</option><option value="Indien">Indien</option><option value="Indonesien">Indonesien</option><option value="Irak">Irak</option><option value="Iran">Iran</option><option value="Irland">Irland</option><option value="Island">Island</option><option value="Israel">Israel</option><option value="Italien">Italien</option><option value="Jamaika">Jamaika</option><option value="Japan">Japan</option><option value="Jemen">Jemen</option><option value="Jersey">Jersey</option><option value="Jordanien">Jordanien</option><option value="Kaimaninseln">Kaimaninseln</option><option value="Kambodscha">Kambodscha</option><option value="Kamerun">Kamerun</option><option value="Kanada">Kanada</option><option value="Kanarische Inseln">Kanarische Inseln</option><option value="Kap Verde">Kap Verde</option><option value="Kasachstan">Kasachstan</option><option value="Katar">Katar</option><option value="Kenia">Kenia</option><option value="Kirgisistan">Kirgisistan</option><option value="Kiribati">Kiribati</option><option value="Kokosinseln">Kokosinseln</option><option value="Kolumbien">Kolumbien</option><option value="Komoren">Komoren</option><option value="Kongo">Kongo</option><option value="Kroatien">Kroatien</option><option value="Kuba">Kuba</option><option value="Kuwait">Kuwait</option><option value="Laos">Laos</option><option value="Lesotho">Lesotho</option><option value="Lettland">Lettland</option><option value="Libanon">Libanon</option><option value="Liberia">Liberia</option><option value="Libyen">Libyen</option><option value="Liechtenstein">Liechtenstein</option><option value="Litauen">Litauen</option><option value="Luxemburg">Luxemburg</option><option value="Macao">Macao</option><option value="Madagaskar">Madagaskar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Malediven">Malediven</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marokko">Marokko</option><option value="Marshallinseln">Marshallinseln</option><option value="Martinique">Martinique</option><option value="Mauretanien">Mauretanien</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Mazedonien">Mazedonien</option><option value="Mexiko">Mexiko</option><option value="Mikronesien">Mikronesien</option><option value="Moldawien">Moldawien</option><option value="Monaco">Monaco</option><option value="Mongolei">Mongolei</option><option value="Montserrat">Montserrat</option><option value="Mosambik">Mosambik</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Neukaledonien">Neukaledonien</option><option value="Neuseeland">Neuseeland</option><option value="Neutrale Zone">Neutrale Zone</option><option value="Nicaragua">Nicaragua</option><option value="Niederlande">Niederlande</option><option value="Niederländische Antillen">Niederländische Antillen</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Nordkorea">Nordkorea</option><option value="Nördliche Marianen">Nördliche Marianen</option><option value="Norfolkinsel">Norfolkinsel</option><option value="Norwegen">Norwegen</option><option value="Oman">Oman</option><option value="Österreich">Österreich</option><option value="Pakistan">Pakistan</option><option value="Palästina">Palästina</option><option value="Palau">Palau</option><option value="Panama">Panama</option><option value="Papua-Neuguinea">Papua-Neuguinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippinen">Philippinen</option><option value="Pitcairninseln">Pitcairninseln</option><option value="Polen">Polen</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="Réunion">Réunion</option><option value="Ruanda">Ruanda</option><option value="Rumänien">Rumänien</option><option value="Russische Föderation">Russische Föderation</option><option value="Salomonen">Salomonen</option><option value="Sambia">Sambia</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="São Tomé und Príncipe">São Tomé und Príncipe</option><option value="Saudi-Arabien">Saudi-Arabien</option><option value="Schweden">Schweden</option><option value="Senegal">Senegal</option><option value="Serbien und Montenegro">Serbien und Montenegro</option><option value="Seychellen">Seychellen</option><option value="Sierra Leone">Sierra Leone</option><option value="Simbabwe">Simbabwe</option><option value="Singapur">Singapur</option><option value="Slowakei">Slowakei</option><option value="Slowenien">Slowenien</option><option value="Somalia">Somalia</option><option value="Spanien">Spanien</option><option value="Sri Lanka">Sri Lanka</option><option value="St. Helena">St. Helena</option><option value="St. Kitts und Nevis">St. Kitts und Nevis</option><option value="St. Lucia">St. Lucia</option><option value="St. Pierre und Miquelon">St. Pierre und Miquelon</option><option value="St. Vincent/Grenadinen (GB)">St. Vincent/Grenadinen (GB)</option><option value="Südafrika, Republik">Südafrika, Republik</option><option value="Sudan">Sudan</option><option value="Südkorea">Südkorea</option><option value="Suriname">Suriname</option><option value="Svalbard und Jan Mayen">Svalbard und Jan Mayen</option><option value="Swasiland">Swasiland</option><option value="Syrien">Syrien</option><option value="Tadschikistan">Tadschikistan</option><option value="Taiwan">Taiwan</option><option value="Tansania">Tansania</option><option value="Thailand">Thailand</option><option value="Timor-Leste">Timor-Leste</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad und Tobago">Trinidad und Tobago</option><option value="Tristan da Cunha">Tristan da Cunha</option><option value="Tschad">Tschad</option><option value="Tschechische Republik">Tschechische Republik</option><option value="Tunesien">Tunesien</option><option value="Türkei">Türkei</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks- und Caicosinseln">Turks- und Caicosinseln</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="Ungarn">Ungarn</option><option value="Uruguay">Uruguay</option><option value="Usbekistan">Usbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Vatikanstadt">Vatikanstadt</option><option value="Venezuela">Venezuela</option><option value="Vereinigte Arabische Emirate">Vereinigte Arabische Emirate</option><option value="Vietnam">Vietnam</option><option value="Wallis und Futuna">Wallis und Futuna</option><option value="Weihnachtsinsel">Weihnachtsinsel</option><option value="Weißrussland">Weißrussland</option><option value="Westsahara">Westsahara</option><option value="Zentralafrikanische Republik">Zentralafrikanische Republik</option><option value="Zypern">Zypern</option></select>
                  <% else_if $ContentLocale == "es-ES" %>
                  <select name="land" required><option value="">País *</option><option value="Suiza">Suiza</option><option value="Alemania">Alemania</option><option value="Afganistán">Afganistán</option><option value="Albania">Albania</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antártida">Antártida</option><option value="Antigua y barbuda">Antigua y Barbuda</option><option value="Antillas holandesas">Antillas Holandesas</option><option value="Arabia saudi">Arabia Saudi</option><option value="Argelia">Argelia</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Australia">Australia</option><option value="Austria">Austria</option><option value="Azerbaiyán">Azerbaiyán</option><option value="Bahamas">Bahamas</option><option value="Bahrein">Bahrein</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Bélgica">Bélgica</option><option value="Belice">Belice</option><option value="Benin">Benin</option><option value="Bermudas">Bermudas</option><option value="Bielorrusia">Bielorrusia</option><option value="Birmania">Birmania</option><option value="Bolivia">Bolivia</option><option value="Bosnia y herzegovina">Bosnia y Herzegovina</option><option value="Botswana">Botswana</option><option value="Brasil">Brasil</option><option value="Brunei">Brunei</option><option value="Bulgaria">Bulgaria</option><option value="Burkina faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Bután">Bután</option><option value="Cabo verde">Cabo Verde</option><option value="Camboya">Camboya</option><option value="Camerún">Camerún</option><option value="Canadá">Canadá</option><option value="Chad">Chad</option><option value="Chile">Chile</option><option value="China">China</option><option value="Chipre">Chipre</option><option value="Ciudad del vaticano (santa sede)">Ciudad del Vaticano (Santa Sede)</option><option value="Colombia">Colombia</option><option value="Comores">Comores</option><option value="Congo">Congo</option><option value="Congo, república democrática del">Congo, República Democrática del</option><option value="Corea">Corea</option><option value="Corea del norte">Corea del Norte</option><option value="Costa de marfil">Costa de Marfil</option><option value="Costa rica">Costa Rica</option><option value="Croacia (hrvatska)">Croacia (Hrvatska)</option><option value="Cuba">Cuba</option><option value="Dinamarca">Dinamarca</option><option value="Djibouti">Djibouti</option><option value="Dominica">Dominica</option><option value="Ecuador">Ecuador</option><option value="Egipto">Egipto</option><option value="El salvador">El Salvador</option><option value="Emiratos Árabes unidos">Emiratos Árabes Unidos</option><option value="Eritrea">Eritrea</option><option value="Eslovenia">Eslovenia</option><option value="España">España</option><option value="Estados unidos">Estados Unidos</option><option value="Estonia">Estonia</option><option value="Etiopia">Etiopia</option><option value="Fiji">Fiji</option><option value="Filipinas">Filipinas</option><option value="Finlandia">Finlandia</option><option value="Francia">Francia</option><option value="Gabón">Gabón</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Granada">Granada</option><option value="Grecia">Grecia</option><option value="Groenlandia">Groenlandia</option><option value="Guadalupe">Guadalupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guayana">Guayana</option><option value="Guayana francesa">Guayana Francesa</option><option value="Guinea">Guinea</option><option value="Guinea ecuatorial">Guinea Ecuatorial</option><option value="Guinea-Bissau">Guinea-Bissau</option><option value="Haiti">Haiti</option><option value="Honduras">Honduras</option><option value="Hungria">Hungria</option><option value="India">India</option><option value="Indonesia">Indonesia</option><option value="Irak">Irak</option><option value="Irán">Irán</option><option value="Irlanda">Irlanda</option><option value="Isla bouvet">Isla Bouvet</option><option value="Isla de christmas">Isla de Christmas</option><option value="Islandia">Islandia</option><option value="Islas caimán">Islas Caimán</option><option value="Islas cook">Islas Cook</option><option value="Islas de cocos o keeling">Islas de Cocos o Keeling</option><option value="Islas faroe">Islas Faroe</option><option value="Islas heard y mcdonald">Islas Heard y McDonald</option><option value="Islas malvinas">Islas Malvinas</option><option value="Islas marianas del norte">Islas Marianas del Norte</option><option value="Islas marshall">Islas Marshall</option><option value="Islas menores de estados unidos">Islas menores de Estados Unidos</option><option value="Islas palau">Islas Palau</option><option value="Islas salomón">Islas Salomón</option><option value="Islas svalbard y jan mayen">Islas Svalbard y Jan Mayen</option><option value="Islas tokelau">Islas Tokelau</option><option value="Islas turks y caicos">Islas Turks y Caicos</option><option value="Islas virgenes (ee.uu.)">Islas Virgenes (EE.UU.)</option><option value="Islas virgenes (reino unido)">Islas Virgenes (Reino Unido)</option><option value="Islaswallis y futuna">Islas Wallis y Futuna</option><option value="Israel">Israel</option><option value="Italia">Italia</option><option value="Jamaica">Jamaica</option><option value="Japón">Japón</option><option value="Jordania">Jordania</option><option value="Kazajistán">Kazajistán</option><option value="Kenia">Kenia</option><option value="Kirguizistán">Kirguizistán</option><option value="Kiribati">Kiribati</option><option value="Kuwait">Kuwait</option><option value="Laos">Laos</option><option value="Lesotho">Lesotho</option><option value="Letonia">Letonia</option><option value="Libano">Libano</option><option value="Liberia">Liberia</option><option value="Libia">Libia</option><option value="Liechtenstein">Liechtenstein</option><option value="Lituania">Lituania</option><option value="Luxemburgo">Luxemburgo</option><option value="Macedonia, ex-república yugoslava de">Macedonia, Ex-República Yugoslava de</option><option value="Madagascar">Madagascar</option><option value="Malasia">Malasia</option><option value="Malawi">Malawi</option><option value="Maldivas">Maldivas</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Marruecos">Marruecos</option><option value="Martinica">Martinica</option><option value="Mauricio">Mauricio</option><option value="Mauritania">Mauritania</option><option value="Mayotte">Mayotte</option><option value="México">México</option><option value="Micronesia">Micronesia</option><option value="Moldavia">Moldavia</option><option value="Mónaco">Mónaco</option><option value="Mongolia">Mongolia</option><option value="Montserrat">Montserrat</option><option value="Mozambique">Mozambique</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="Nicaragua">Nicaragua</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="Norfolk">Norfolk</option><option value="Noruega">Noruega</option><option value="Nueva caledonia">Nueva Caledonia</option><option value="Nueva zelanda">Nueva Zelanda</option><option value="Omán">Omán</option><option value="Paises bajos">Paises Bajos</option><option value="Panamá">Panamá</option><option value="Papúa nueva guinea">Papúa Nueva Guinea</option><option value="Paquistán">Paquistán</option><option value="Paraguay">Paraguay</option><option value="Perú">Perú</option><option value="Pitcairn">Pitcairn</option><option value="Polinesia francesa">Polinesia Francesa</option><option value="Polonia">Polonia</option><option value="Portugal">Portugal</option><option value="Puerto rico">Puerto Rico</option><option value="Qatar">Qatar</option><option value="Reino unido">Reino Unido</option><option value="República centroafricana">República Centroafricana</option><option value="República checa">República Checa</option><option value="República de sudáfrica">República de Sudáfrica</option><option value="República dominicana">República Dominicana</option><option value="República eslovaca">República Eslovaca</option><option value="Reunión">Reunión</option><option value="Ruanda">Ruanda</option><option value="Rumania">Rumania</option><option value="Rusia">Rusia</option><option value="Sahara occidental">Sahara Occidental</option><option value="Saint kitts y nevis">Saint Kitts y Nevis</option><option value="Samoa">Samoa</option><option value="Samoa americana">Samoa Americana</option><option value="San marino">San Marino</option><option value="San vicente y granadinas">San Vicente y Granadinas</option><option value="Santa helena">Santa Helena</option><option value="Santa lucia">Santa Lucia</option><option value="Santo tomé y principe">Santo Tomé y Principe</option><option value="Senegal">Senegal</option><option value="Seychelles">Seychelles</option><option value="Sierra leona">Sierra Leona</option><option value="Singapur">Singapur</option><option value="Siria">Siria</option><option value="Somalia">Somalia</option><option value="Sri lanka">Sri Lanka</option><option value="St. pierre y miquelon">St. Pierre y Miquelon</option><option value="Suazilandia">Suazilandia</option><option value="Sudán">Sudán</option><option value="Suecia">Suecia</option><option value="Surinam">Surinam</option><option value="Tailandia">Tailandia</option><option value="Taiwán">Taiwán</option><option value="Tanzania">Tanzania</option><option value="Tayikistán">Tayikistán</option><option value="Territorios franceses del sur">Territorios Franceses del Sur</option><option value="Timor oriental">Timor Oriental</option><option value="Togo">Togo</option><option value="Tonga">Tonga</option><option value="Trinidad y tobago">Trinidad y Tobago</option><option value="Túnez">Túnez</option><option value="Turkmenistán">Turkmenistán</option><option value="Turquia">Turquia</option><option value="Tuvalu">Tuvalu</option><option value="Ucrania">Ucrania</option><option value="Uganda">Uganda</option><option value="Uruguay">Uruguay</option><option value="Uzbekistán">Uzbekistán</option><option value="Vanuatu">Vanuatu</option><option value="Venezuela">Venezuela</option><option value="Vietnam">Vietnam</option><option value="Yemen">Yemen</option><option value="Yugoslavia">Yugoslavia</option><option value="Zambia">Zambia</option><option value="Zimbawe">Zimbawe</option>
                  </select>
                  <% else %>
                  <select name="land" required><option value="">Country *</option><option value="Switzerland">Switzerland</option><option value="Germany">Germany</option><option value="United States">United States</option><option value="Afghanistan">Afghanistan</option><option value="Egypt">Egypt</option><option value="Åland Islands">Åland Islands</option><option value="Albania">Albania</option><option value="Algeria">Algeria</option><option value="American Samoa">American Samoa</option><option value="Virgin Islands, U.s.">Virgin Islands, U.s.</option><option value="Andorra">Andorra</option><option value="Angola">Angola</option><option value="Anguilla">Anguilla</option><option value="Antarctica">Antarctica</option><option value="Antigua And Barbuda">Antigua And Barbuda</option><option value="Equatorial Guinea">Equatorial Guinea</option><option value="Argentina">Argentina</option><option value="Armenia">Armenia</option><option value="Aruba">Aruba</option><option value="Ascension">Ascension</option><option value="Azerbaijan">Azerbaijan</option><option value="Ethiopia">Ethiopia</option><option value="Australia">Australia</option><option value="Bahamas">Bahamas</option><option value="Bahrain">Bahrain</option><option value="Bangladesh">Bangladesh</option><option value="Barbados">Barbados</option><option value="Belgium">Belgium</option><option value="Belize">Belize</option><option value="Benin">Benin</option><option value="Bermuda">Bermuda</option><option value="Bhutan">Bhutan</option><option value="Bolivia">Bolivia</option><option value="Bosnia And Herzegovina">Bosnia And Herzegovina</option><option value="Botswana">Botswana</option><option value="Bouvet Island">Bouvet Island</option><option value="Brazil">Brazil</option><option value="Brunei Darussalam">Brunei Darussalam</option><option value="Bulgaria">Bulgaria</option><option value="Burkina Faso">Burkina Faso</option><option value="Burundi">Burundi</option><option value="Chile">Chile</option><option value="China">China</option><option value="Cook Islands">Cook Islands</option><option value="Costa Rica">Costa Rica</option><option value="CÔte D'ivoire">CÔte D'ivoire</option><option value="Denmark">Denmark</option><option value="Diego Garcia">Diego Garcia</option><option value="Dominica">Dominica</option><option value="Dominican Republic">Dominican Republic</option><option value="Djibouti">Djibouti</option><option value="Ecuador">Ecuador</option><option value="El Salvador">El Salvador</option><option value="Eritrea">Eritrea</option><option value="Estonia">Estonia</option><option value="Europäische Union">Europäische Union</option><option value="Falkland Islands (malvinas)">Falkland Islands (malvinas)</option><option value="Faroe Islands">Faroe Islands</option><option value="Fiji">Fiji</option><option value="Finland">Finland</option><option value="France">France</option><option value="French Guiana">French Guiana</option><option value="French Polynesia">French Polynesia</option><option value="Gabon">Gabon</option><option value="Gambia">Gambia</option><option value="Georgia">Georgia</option><option value="Ghana">Ghana</option><option value="Gibraltar">Gibraltar</option><option value="Grenada">Grenada</option><option value="Greece">Greece</option><option value="Greenland">Greenland</option><option value="Create Britain">Create Britain</option><option value="Guadeloupe">Guadeloupe</option><option value="Guam">Guam</option><option value="Guatemala">Guatemala</option><option value="Guernsey">Guernsey</option><option value="Guinea">Guinea</option><option value="Guinea-bissau">Guinea-bissau</option><option value="Guyana">Guyana</option><option value="Haiti">Haiti</option><option value="Heard Island And Mcdonald Islands">Heard Island And Mcdonald Islands</option><option value="Honduras">Honduras</option><option value="Hong Kong">Hong Kong</option><option value="India">India</option><option value="Indonesia">Indonesia</option><option value="Iraq">Iraq</option><option value="Iran, Islamic Republic Of">Iran, Islamic Republic Of</option><option value="Ireland">Ireland</option><option value="Iceland">Iceland</option><option value="Israel">Israel</option><option value="Italy">Italy</option><option value="Jamaica">Jamaica</option><option value="Japan">Japan</option><option value="Yemen">Yemen</option><option value="Jersey">Jersey</option><option value="Jordan">Jordan</option><option value="Cayman Islands">Cayman Islands</option><option value="Cambodia">Cambodia</option><option value="Cameroon">Cameroon</option><option value="Canada">Canada</option><option value="Kanarische Inseln">Kanarische Inseln</option><option value="Cape Verde">Cape Verde</option><option value="Kazakhstan">Kazakhstan</option><option value="Qatar">Qatar</option><option value="Kenya">Kenya</option><option value="Kyrgyzstan">Kyrgyzstan</option><option value="Kiribati">Kiribati</option><option value="Cocos (keeling) Islands">Cocos (keeling) Islands</option><option value="Colombia">Colombia</option><option value="Comoros">Comoros</option><option value="Congo">Congo</option><option value="Croatia">Croatia</option><option value="Cuba">Cuba</option><option value="Kuwait">Kuwait</option><option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option><option value="Lesotho">Lesotho</option><option value="Latvia">Latvia</option><option value="Lebanon">Lebanon</option><option value="Liberia">Liberia</option><option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option><option value="Liechtenstein">Liechtenstein</option><option value="Lithuania">Lithuania</option><option value="Luxembourg">Luxembourg</option><option value="Macao">Macao</option><option value="Madagascar">Madagascar</option><option value="Malawi">Malawi</option><option value="Malaysia">Malaysia</option><option value="Maldives">Maldives</option><option value="Mali">Mali</option><option value="Malta">Malta</option><option value="Morocco">Morocco</option><option value="Marshall Islands">Marshall Islands</option><option value="Martinique">Martinique</option><option value="Mauritania">Mauritania</option><option value="Mauritius">Mauritius</option><option value="Mayotte">Mayotte</option><option value="Macedonia, The Former Yugoslav Republic Of">Macedonia, The Former Yugoslav Republic Of</option><option value="Mexico">Mexico</option><option value="Micronesia">Micronesia</option><option value="Moldova">Moldova</option><option value="Monaco">Monaco</option><option value="Mongolia">Mongolia</option><option value="Montserrat">Montserrat</option><option value="Mozambique">Mozambique</option><option value="Myanmar">Myanmar</option><option value="Namibia">Namibia</option><option value="Nauru">Nauru</option><option value="Nepal">Nepal</option><option value="New Caledonia">New Caledonia</option><option value="New Zealand">New Zealand</option><option value="Neutrale Zone">Neutrale Zone</option><option value="Nicaragua">Nicaragua</option><option value="Netherlands">Netherlands</option><option value="Netherlands Antilles">Netherlands Antilles</option><option value="Niger">Niger</option><option value="Nigeria">Nigeria</option><option value="Niue">Niue</option><option value="North Korea">North Korea</option><option value="Northern Mariana Islands">Northern Mariana Islands</option><option value="Norfolk Island">Norfolk Island</option><option value="Norway">Norway</option><option value="Oman">Oman</option><option value="Austria">Austria</option><option value="Pakistan">Pakistan</option><option value="Palestinian Territory">Palestinian Territory</option><option value="Palau">Palau</option><option value="Panama">Panama</option><option value="Papua New Guinea">Papua New Guinea</option><option value="Paraguay">Paraguay</option><option value="Peru">Peru</option><option value="Philippines">Philippines</option><option value="Pitcairn">Pitcairn</option><option value="Poland">Poland</option><option value="Portugal">Portugal</option><option value="Puerto Rico">Puerto Rico</option><option value="RÉunion">RÉunion</option><option value="Rwanda">Rwanda</option><option value="Romania">Romania</option><option value="Russian Federation">Russian Federation</option><option value="Solomon Islands">Solomon Islands</option><option value="Zambia">Zambia</option><option value="Samoa">Samoa</option><option value="San Marino">San Marino</option><option value="Sao Tome And Principe">Sao Tome And Principe</option><option value="Saudi Arabia">Saudi Arabia</option><option value="Sweden">Sweden</option><option value="Senegal">Senegal</option><option value="Serbien und Montenegro">Serbien und Montenegro</option><option value="Seychelles">Seychelles</option><option value="Sierra Leone">Sierra Leone</option><option value="Zimbabwe">Zimbabwe</option><option value="Singapore">Singapore</option><option value="Slovakia">Slovakia</option><option value="Slovenia">Slovenia</option><option value="Somalia">Somalia</option><option value="Spain">Spain</option><option value="Sri Lanka">Sri Lanka</option><option value="Saint Helena">Saint Helena</option><option value="Saint Kitts And Nevis">Saint Kitts And Nevis</option><option value="Saint Lucia">Saint Lucia</option><option value="Saint Pierre And Miquelon">Saint Pierre And Miquelon</option><option value="Saint Vincent/Grenadines">Saint Vincent/Grenadines</option><option value="South Africa">South Africa</option><option value="Sudan">Sudan</option><option value="South Korea">South Korea</option><option value="Suriname">Suriname</option><option value="Svalbard And Jan Mayen">Svalbard And Jan Mayen</option><option value="Swaziland">Swaziland</option><option value="Syrian Arab Republic">Syrian Arab Republic</option><option value="Tajikistan">Tajikistan</option><option value="Taiwan, Province Of China">Taiwan, Province Of China</option><option value="Tanzania">Tanzania</option><option value="Thailand">Thailand</option><option value="Timor-leste">Timor-leste</option><option value="Togo">Togo</option><option value="Tokelau">Tokelau</option><option value="Tonga">Tonga</option><option value="Trinidad And Tobago">Trinidad And Tobago</option><option value="Tristan da Cunha">Tristan da Cunha</option><option value="Chad">Chad</option><option value="Czech Republic">Czech Republic</option><option value="Tunisia">Tunisia</option><option value="Turkey">Turkey</option><option value="Turkmenistan">Turkmenistan</option><option value="Turks And Caicos Islands">Turks And Caicos Islands</option><option value="Tuvalu">Tuvalu</option><option value="Uganda">Uganda</option><option value="Ukraine">Ukraine</option><option value="Hungary">Hungary</option><option value="Uruguay">Uruguay</option><option value="Uzbekistan">Uzbekistan</option><option value="Vanuatu">Vanuatu</option><option value="Holy See (vatican City State)">Holy See (vatican City State)</option><option value="Venezuela">Venezuela</option><option value="United Arab Emirates">United Arab Emirates</option><option value="Viet Nam">Viet Nam</option><option value="Wallis And Futuna">Wallis And Futuna</option><option value="Christmas Island">Christmas Island</option><option value="Belarus">Belarus</option><option value="Western Sahara">Western Sahara</option><option value="Central African Republic">Central African Republic</option><option value="Cyprus">Cyprus</option></select>
                  <% end_if %>
                  <span data-icon="&#xf2eb;"><input type="email" name="email" placeholder="E-Mail *" required/></span>
                  <span data-icon="&#xf2d2;"><input type="text" name="telephone" placeholder='<%t ProductPage.TELEFON "Telefon"%>' /></span>

                  <div class="dropdown" data-dropdown>
                    <div class="dropdown-title" data-open-dropdown><%t ProductPage.INTERESSE "Ich interessiere mich für" %> <span class="product-name-holder">$Product.Name</span></div>
                    <ul class="checked-options hidden" data-dropdown-checked-options>

                    </ul>
                    <div class="dropdown-content hidden">
                      $Product.getAllProducts($ContentLocale)
                    </div>
                  </div>

                <!--  <div class="dropdown" data-dropdown>
                    <div class="dropdown-title" data-open-dropdown><%t ProductPage.ANFRAGE "Bitte schicken Sie mir" %> <span class="product-name-holder">...</span></div>
                    <ul class="checked-options hidden" data-dropdown-checked-options>

                    </ul>
                      <div class="dropdown-content hidden">
                      <label><input name="send[]" type="checkbox" value="<%t ProductPage.UNTERLAGEN 'Unterlagen' %>"/><%t ProductPage.UNTERLAGEN 'Unterlagen' %></label>
                      <label><input name="send[]" type="checkbox" value="<%t ProductPage.OFFERTEN 'Offerten' %>"/><%t ProductPage.OFFERTEN 'Offerten' %></label>
                    </div>
                  </div> -->
                  <input type="hidden" name="locale" value="$ContentLocale"/>



                  <span data-icon="&#xf2bf;"><textarea name="message" placeholder='<%t ProductPage.NACHRICHT "Ihre Nachricht" %>'></textarea></span>

                  <label class="acceptance"><input type="checkbox" name="acceptance" required /><%t Main.ACCEPTANCE 'Sie erklären sich damit einverstanden, dass ihre Daten zur Bearbeitung Ihres Anliegens verwendet werden. Weitere Informationen und Widerrufshinweise finden Sie in der <a href="/datenschutz">Datenschutzerklärung</a>. Eine Kopie Ihrer Nachricht wird an Ihre E-Mail-Adresse geschickt.' %></label>
                  <div>
                  <p class="acceptance"><%t NocaptchaField.GoogleTerms 'Diese Seite ist durch reCAPTCHA geschützt und unterliegt <a href="https://policies.google.com/privacy" target="_blank" rel="nofollow">der Datenschutzerklärung</a> und <a href="https://policies.google.com/terms" target="_blank" rel="nofollow">den Nutzungsbedingungen</a> von Google.' %>
                  </p>
                </div>


                  <%-- <div id="captcha-{$ID}" class="g-recaptcha" data-sitekey="6LcBbrwUAAAAABu3UKDgco4rSFK_QspP7C0LokUA" data-size="invisible"></div> --%>
                  <div id="captcha-{$ID}" class="g-recaptcha" data-sitekey="6LchV0kUAAAAAO933jAsFfyjanFlxT2nbRd1s5Tc" data-size="invisible"></div>
                  <div class="uk-clearfix uk-text-right">
                    <button><%t ProductPage.SENDENACHRICHT "Anfrage senden" %><i class="icon ion-chevron-right"></i></button>
                  </div>
                  <input type="hidden" name="ID" value="$Product.ID" />
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  
  </section>