<?php

use SilverStripe\CMS\Model\SiteTree;
use g4b0\SearchableDataObjects\Searchable;

class Page extends SiteTree implements Searchable
{


     /**
      * Filter array
      * eg. array('Disabled' => 0);
      * @return array
      */
     public static function getSearchFilter() {
         return array();
     }

     /**
      * FilterAny array (optional)
      * eg. array('Disabled' => 0, 'Override' => 1);
      * @return array
      */
     public static function getSearchFilterAny() {
         return array();
     }

     /**
      * FilterByCallback function (optional)
      * eg. function($object){
      *  return ($object->StartDate > date('Y-m-d') || $object->isStillRecurring());
      * };
      * @return array
      */
     public static function getSearchFilterByCallback() {
         return function($object){ return true; };
     }

     /**
      * Fields that compose the Title
      * eg. array('Title', 'Subtitle');
      * @return array
      */
     public function getTitleFields() {
         return array('Title');
     }

     /**
      * Fields that compose the Content
      * eg. array('Teaser', 'Content');
      * @return array
      */
     public function getContentFields() {
         return array();
     }


     public function getEs(){
        $input = '<select name="country">
    <option value="AF">AfganistÃ¡n</option>
    <option value="AL">Albania</option>
    <option value="DE">Alemania</option>
    <option value="AD">Andorra</option>
    <option value="AO">Angola</option>
    <option value="AI">Anguilla</option>
    <option value="AQ">AntÃ¡rtida</option>
    <option value="AG">Antigua y Barbuda</option>
    <option value="AN">Antillas Holandesas</option>
    <option value="SA">Arabia SaudÃ­</option>
    <option value="DZ">Argelia</option>
    <option value="AR">Argentina</option>
    <option value="AM">Armenia</option>
    <option value="AW">Aruba</option>
    <option value="AU">Australia</option>
    <option value="AT">Austria</option>
    <option value="AZ">AzerbaiyÃ¡n</option>
    <option value="BS">Bahamas</option>
    <option value="BH">Bahrein</option>
    <option value="BD">Bangladesh</option>
    <option value="BB">Barbados</option>
    <option value="BE">BÃ©lgica</option>
    <option value="BZ">Belice</option>
    <option value="BJ">Benin</option>
    <option value="BM">Bermudas</option>
    <option value="BY">Bielorrusia</option>
    <option value="MM">Birmania</option>
    <option value="BO">Bolivia</option>
    <option value="BA">Bosnia y Herzegovina</option>
    <option value="BW">Botswana</option>
    <option value="BR">Brasil</option>
    <option value="BN">Brunei</option>
    <option value="BG">Bulgaria</option>
    <option value="BF">Burkina Faso</option>
    <option value="BI">Burundi</option>
    <option value="BT">ButÃ¡n</option>
    <option value="CV">Cabo Verde</option>
    <option value="KH">Camboya</option>
    <option value="CM">CamerÃºn</option>
    <option value="CA">CanadÃ¡</option>
    <option value="TD">Chad</option>
    <option value="CL">Chile</option>
    <option value="CN">China</option>
    <option value="CY">Chipre</option>
    <option value="VA">Ciudad del Vaticano (Santa Sede)</option>
    <option value="CO">Colombia</option>
    <option value="KM">Comores</option>
    <option value="CG">Congo</option>
    <option value="CD">Congo, RepÃºblica DemocrÃ¡tica del</option>
    <option value="KR">Corea</option>
    <option value="KP">Corea del Norte</option>
    <option value="CI">Costa de MarfÃ­l</option>
    <option value="CR">Costa Rica</option>
    <option value="HR">Croacia (Hrvatska)</option>
    <option value="CU">Cuba</option>
    <option value="DK">Dinamarca</option>
    <option value="DJ">Djibouti</option>
    <option value="DM">Dominica</option>
    <option value="EC">Ecuador</option>
    <option value="EG">Egipto</option>
    <option value="SV">El Salvador</option>
    <option value="AE">Emiratos Ãrabes Unidos</option>
    <option value="ER">Eritrea</option>
    <option value="SI">Eslovenia</option>
    <option value="ES" selected>EspaÃ±a</option>
    <option value="US">Estados Unidos</option>
    <option value="EE">Estonia</option>
    <option value="ET">EtiopÃ­a</option>
    <option value="FJ">Fiji</option>
    <option value="PH">Filipinas</option>
    <option value="FI">Finlandia</option>
    <option value="FR">Francia</option>
    <option value="GA">GabÃ³n</option>
    <option value="GM">Gambia</option>
    <option value="GE">Georgia</option>
    <option value="GH">Ghana</option>
    <option value="GI">Gibraltar</option>
    <option value="GD">Granada</option>
    <option value="GR">Grecia</option>
    <option value="GL">Groenlandia</option>
    <option value="GP">Guadalupe</option>
    <option value="GU">Guam</option>
    <option value="GT">Guatemala</option>
    <option value="GY">Guayana</option>
    <option value="GF">Guayana Francesa</option>
    <option value="GN">Guinea</option>
    <option value="GQ">Guinea Ecuatorial</option>
    <option value="GW">Guinea-Bissau</option>
    <option value="HT">HaitÃ­</option>
    <option value="HN">Honduras</option>
    <option value="HU">HungrÃ­a</option>
    <option value="IN">India</option>
    <option value="ID">Indonesia</option>
    <option value="IQ">Irak</option>
    <option value="IR">IrÃ¡n</option>
    <option value="IE">Irlanda</option>
    <option value="BV">Isla Bouvet</option>
    <option value="CX">Isla de Christmas</option>
    <option value="IS">Islandia</option>
    <option value="KY">Islas CaimÃ¡n</option>
    <option value="CK">Islas Cook</option>
    <option value="CC">Islas de Cocos o Keeling</option>
    <option value="FO">Islas Faroe</option>
    <option value="HM">Islas Heard y McDonald</option>
    <option value="FK">Islas Malvinas</option>
    <option value="MP">Islas Marianas del Norte</option>
    <option value="MH">Islas Marshall</option>
    <option value="UM">Islas menores de Estados Unidos</option>
    <option value="PW">Islas Palau</option>
    <option value="SB">Islas SalomÃ³n</option>
    <option value="SJ">Islas Svalbard y Jan Mayen</option>
    <option value="TK">Islas Tokelau</option>
    <option value="TC">Islas Turks y Caicos</option>
    <option value="VI">Islas VÃ­rgenes (EE.UU.)</option>
    <option value="VG">Islas VÃ­rgenes (Reino Unido)</option>
    <option value="WF">Islas Wallis y Futuna</option>
    <option value="IL">Israel</option>
    <option value="IT">Italia</option>
    <option value="JM">Jamaica</option>
    <option value="JP">JapÃ³n</option>
    <option value="JO">Jordania</option>
    <option value="KZ">KazajistÃ¡n</option>
    <option value="KE">Kenia</option>
    <option value="KG">KirguizistÃ¡n</option>
    <option value="KI">Kiribati</option>
    <option value="KW">Kuwait</option>
    <option value="LA">Laos</option>
    <option value="LS">Lesotho</option>
    <option value="LV">Letonia</option>
    <option value="LB">LÃ­bano</option>
    <option value="LR">Liberia</option>
    <option value="LY">Libia</option>
    <option value="LI">Liechtenstein</option>
    <option value="LT">Lituania</option>
    <option value="LU">Luxemburgo</option>
    <option value="MK">Macedonia, Ex-RepÃºblica Yugoslava de</option>
    <option value="MG">Madagascar</option>
    <option value="MY">Malasia</option>
    <option value="MW">Malawi</option>
    <option value="MV">Maldivas</option>
    <option value="ML">MalÃ­</option>
    <option value="MT">Malta</option>
    <option value="MA">Marruecos</option>
    <option value="MQ">Martinica</option>
    <option value="MU">Mauricio</option>
    <option value="MR">Mauritania</option>
    <option value="YT">Mayotte</option>
    <option value="MX">MÃ©xico</option>
    <option value="FM">Micronesia</option>
    <option value="MD">Moldavia</option>
    <option value="MC">MÃ³naco</option>
    <option value="MN">Mongolia</option>
    <option value="MS">Montserrat</option>
    <option value="MZ">Mozambique</option>
    <option value="NA">Namibia</option>
    <option value="NR">Nauru</option>
    <option value="NP">Nepal</option>
    <option value="NI">Nicaragua</option>
    <option value="NE">NÃ­ger</option>
    <option value="NG">Nigeria</option>
    <option value="NU">Niue</option>
    <option value="NF">Norfolk</option>
    <option value="NO">Noruega</option>
    <option value="NC">Nueva Caledonia</option>
    <option value="NZ">Nueva Zelanda</option>
    <option value="OM">OmÃ¡n</option>
    <option value="NL">PaÃ­ses Bajos</option>
    <option value="PA">PanamÃ¡</option>
    <option value="PG">PapÃºa Nueva Guinea</option>
    <option value="PK">PaquistÃ¡n</option>
    <option value="PY">Paraguay</option>
    <option value="PE">PerÃº</option>
    <option value="PN">Pitcairn</option>
    <option value="PF">Polinesia Francesa</option>
    <option value="PL">Polonia</option>
    <option value="PT">Portugal</option>
    <option value="PR">Puerto Rico</option>
    <option value="QA">Qatar</option>
    <option value="UK">Reino Unido</option>
    <option value="CF">RepÃºblica Centroafricana</option>
    <option value="CZ">RepÃºblica Checa</option>
    <option value="ZA">RepÃºblica de SudÃ¡frica</option>
    <option value="DO">RepÃºblica Dominicana</option>
    <option value="SK">RepÃºblica Eslovaca</option>
    <option value="RE">ReuniÃ³n</option>
    <option value="RW">Ruanda</option>
    <option value="RO">Rumania</option>
    <option value="RU">Rusia</option>
    <option value="EH">Sahara Occidental</option>
    <option value="KN">Saint Kitts y Nevis</option>
    <option value="WS">Samoa</option>
    <option value="AS">Samoa Americana</option>
    <option value="SM">San Marino</option>
    <option value="VC">San Vicente y Granadinas</option>
    <option value="SH">Santa Helena</option>
    <option value="LC">Santa LucÃ­a</option>
    <option value="ST">Santo TomÃ© y PrÃ­ncipe</option>
    <option value="SN">Senegal</option>
    <option value="SC">Seychelles</option>
    <option value="SL">Sierra Leona</option>
    <option value="SG">Singapur</option>
    <option value="SY">Siria</option>
    <option value="SO">Somalia</option>
    <option value="LK">Sri Lanka</option>
    <option value="PM">St. Pierre y Miquelon</option>
    <option value="SZ">Suazilandia</option>
    <option value="SD">SudÃ¡n</option>
    <option value="SE">Suecia</option>
    <option value="CH">Suiza</option>
    <option value="SR">Surinam</option>
    <option value="TH">Tailandia</option>
    <option value="TW">TaiwÃ¡n</option>
    <option value="TZ">Tanzania</option>
    <option value="TJ">TayikistÃ¡n</option>
    <option value="TF">Territorios Franceses del Sur</option>
    <option value="TP">Timor Oriental</option>
    <option value="TG">Togo</option>
    <option value="TO">Tonga</option>
    <option value="TT">Trinidad y Tobago</option>
    <option value="TN">TÃºnez</option>
    <option value="TM">TurkmenistÃ¡n</option>
    <option value="TR">TurquÃ­a</option>
    <option value="TV">Tuvalu</option>
    <option value="UA">Ucrania</option>
    <option value="UG">Uganda</option>
    <option value="UY">Uruguay</option>
    <option value="UZ">UzbekistÃ¡n</option>
    <option value="VU">Vanuatu</option>
    <option value="VE">Venezuela</option>
    <option value="VN">Vietnam</option>
    <option value="YE">Yemen</option>
    <option value="YU">Yugoslavia</option>
    <option value="ZM">Zambia</option>
    <option value="ZW">Zimbawe</option>
  </select>';
    $dom = new DOMDocument;
    $dom->loadHTML($input);
    $options = $dom->getElementsByTagName('option');
    $optionHtml = '';
    foreach($options as $option){
      $html = '';
      foreach ($option->childNodes as $node){
        if ($node->nodeType != XML_TEXT_NODE) {
            continue;
        }
         $html = $node;
        break;
      }
      $optionHtml .= '<option value='. $html.'>'. $html.'</option>';
    }
    print_r($optionHtml);
  }
}