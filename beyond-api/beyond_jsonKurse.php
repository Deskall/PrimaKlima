<?php 
//

// Copyright (c) beyond software

//

// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.

//

// Erstellungsdatum: 2.3.2017

//

class beyond_jsonKurse

{
		protected $key;

		public function __construct() {
		    $this->key = '03FE4C469614658D0B1224D523595B05155A5526E80E7304E10BDF3C8FCF559B';
		}

		public function getKey() {
		    return $this->key;
		}

        function getKursStruktur($GruppenID = null,$Rekursiv = null,$FilialenID = null,$AnzeigenFlag = null)

	    {

		    

            //

            // Output Records:

            //----------

            //1.) HauptGruppenID

            //2.) GruppenID

            //3.) GruppenGuid

            //4.) Bezeichnung

            //5.) Hierarchie

            //6.) Text

            //----------

            //

            // No Output Parameters

            //

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonKurse.asmx?WSDL',array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

		

		    $soap_params = array('key' => $this->getKey());

		    if($GruppenID != null)

		    {

			    $soap_params["GruppenID"] = $GruppenID;

		    }

		    if($Rekursiv != null)

		    {

			    $soap_params["Rekursiv"] = $Rekursiv;

		    }

		    if($FilialenID != null)

		    {

			    $soap_params["FilialenID"] = $FilialenID;

		    }

		    if($AnzeigenFlag != null)

		    {

			    $soap_params["AnzeigenFlag"] = $AnzeigenFlag;

		    }

		    $soap_result = $soap_client->getKursStruktur(array('para' => json_encode($soap_params)))->getKursStrukturResult;

		    $json_objects =  json_decode($soap_result);

				

		    return $json_objects;

        }

        function getKursGruppen($GruppenID = null,$PartnerSuche = null,$VolltextSuche = null)

	    {

		    

            //

            // Output Records:

            //----------

            //1.) GruppenID

            //2.) GruppenGuid

            //3.) istPaarTanz

            //4.) PartnerSuche

            //5.) Bezeichnung

            //6.) Hierarchie

            //7.) Text

            //----------

            //

            // No Output Parameters

            //

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonKurse.asmx?WSDL',array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

		

		    $soap_params = array('key' => $this->getKey());

		    if($GruppenID != null)

		    {

			    $soap_params["GruppenID"] = $GruppenID;

		    }

		    if($PartnerSuche != null)

		    {

			    $soap_params["PartnerSuche"] = $PartnerSuche;

		    }

		    if($VolltextSuche != null)

		    {

			    $soap_params["VolltextSuche"] = $VolltextSuche;

		    }

		    $soap_result = $soap_client->getKursGruppen(array('para' => json_encode($soap_params)))->getKursGruppenResult;

		    $json_objects =  json_decode($soap_result);

				

		    return $json_objects;

        }

        function getKurseICS($KursID = null)

	    {

		    

            //

            // Output Records:

            //----------

            //1.) rowguid

            //2.) IDBezeichnung

            //3.) ICSDatumVon

            //4.) ICSDatumBis

            //5.) Anzahl

            //6.) AnzahlWochentage

            //7.) ICSAenderungsDatum

            //8.) ICSErstellungsDatum

            //----------

            //

            // No Output Parameters

            //

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonKurse.asmx?WSDL',array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

		

		    $soap_params = array('key' => $this->getKey());

		    if($KursID != null)

		    {

			    $soap_params["KursID"] = $KursID;

		    }

		    $soap_result = $soap_client->getKurseICS(array('para' => json_encode($soap_params)))->getKurseICSResult;

		    $json_objects =  json_decode($soap_result);

				

		    return $json_objects;

        }

        function getKurse($Sprache = null,$KursID = null,$Vorgänger = null,$GruppenID = null,$GruppenIDList = null,$Rekursiv = null,$AusgleichFlag = null,$Wochentag = null,$DatumFormat = null,$DatumTrennung = null,$ZeitFormat = null,$ZeitTrennung = null,$AnzeigenFlag = null,$DruckenFlag = null,$AnmeldenFlag = null,$Anzahl = null)

	    {

		    

            //

            // Output Records:

            //----------

            //1.) KursID

            //2.) Wochentag

            //3.) WochentagLang

            //4.) GruppenText

            //5.) LehrerID

            //6.) LehrerVorname

            //7.) LehrerNachname

            //8.) LehrerURL

            //9.) HauptGruppenID

            //10.) GruppenID

            //11.) GruppenTitel

            //12.) KursIDTitelDatumVonDatumBis

            //13.) KursTitelWochentag

            //14.) KursTitelWochentagDatumVonZeitVon

            //15.) KursStatus

            //16.) istAbgesagt

            //17.) istAusgebucht

            //18.) istProvisorisch

            //19.) istDefinitiv

            //20.) PreisPaar

            //21.) PreisPerson

            //22.) PreisPaarPerson

            //23.) KursText

            //24.) Text

            //25.) AnzahlLektionen

            //26.) AnzahlWochentage

            //27.) AnzahlKursDaten

            //28.) DatumVon

            //29.) DatumBis

            //30.) DatumVonDatumBis

            //31.) ZeitVon

            //32.) ZeitBis

            //33.) Zeit2Von

            //34.) Zeit2Bis

            //35.) ZeitVonZeitBis

            //36.) ZeitVonZeitBis

            //37.) DauerMinuten

            //38.) DauerStunden

            //39.) PartnerSucheText

            //40.) istFortlaufend

            //41.) istPaarTanz

            //42.) istAnmeldungMöglich

            //43.) SaalID

            //44.) SaalBezeichnung

            //45.) SaalOrt

            //46.) ErstellungsDatum

            //47.) ErstellungsDatumISO8601

            //48.) ErstellungsDatumISO8601+

            //49.) ErstellungsDatumRFC5545

            //50.) ErstellungsDatumUTCISO8601

            //51.) ErstellungsDatumUTCISO8601+

            //52.) ErstellungsDatumUTCRFC5545

            //----------

            //

            // Output Parameters:

            // -------

            //1.) Anzahl

           // -------

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonKurse.asmx?WSDL',array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

		

		    $soap_params = array('key' => $this->getKey());

		    if($Sprache != null)

		    {

			    $soap_params["Sprache"] = $Sprache;

		    }

		    if($KursID != null)

		    {

			    $soap_params["KursID"] = $KursID;

		    }

		    if($Vorgänger != null)

		    {

			    $soap_params["Vorgänger"] = $Vorgänger;

		    }

		    if($GruppenID != null)

		    {

			    $soap_params["GruppenID"] = $GruppenID;

		    }

		    if($GruppenIDList != null)

		    {

			    $soap_params["GruppenIDList"] = $GruppenIDList;

		    }

		    if($Rekursiv != null)

		    {

			    $soap_params["Rekursiv"] = $Rekursiv;

		    }

		    if($AusgleichFlag != null)

		    {

			    $soap_params["AusgleichFlag"] = $AusgleichFlag;

		    }

		    if($Wochentag != null)

		    {

			    $soap_params["Wochentag"] = $Wochentag;

		    }

		    if($DatumFormat != null)

		    {

			    $soap_params["DatumFormat"] = $DatumFormat;

		    }

		    if($DatumTrennung != null)

		    {

			    $soap_params["DatumTrennung"] = $DatumTrennung;

		    }

		    if($ZeitFormat != null)

		    {

			    $soap_params["ZeitFormat"] = $ZeitFormat;

		    }

		    if($ZeitTrennung != null)

		    {

			    $soap_params["ZeitTrennung"] = $ZeitTrennung;

		    }

		    if($AnzeigenFlag != null)

		    {

			    $soap_params["AnzeigenFlag"] = $AnzeigenFlag;

		    }

		    if($DruckenFlag != null)

		    {

			    $soap_params["DruckenFlag"] = $DruckenFlag;

		    }

		    if($AnmeldenFlag != null)

		    {

			    $soap_params["AnmeldenFlag"] = $AnmeldenFlag;

		    }

		    if($Anzahl != null)

		    {

			    $soap_params["Anzahl"] = $Anzahl;

		    }

		    $soap_result = $soap_client->getKurse(array('para' => json_encode($soap_params)))->getKurseResult;

		    $json_objects =  json_decode($soap_result);

				

		    return $json_objects;

        }

        function getKursDatenICS($KursID = null)

	    {

		    

            //

            // Output Records:

            //----------

            //1.) ICSDatum

            //----------

            //

            // No Output Parameters

            //

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonKurse.asmx?WSDL',array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

		

		    $soap_params = array('key' => $this->getKey());

		    if($KursID != null)

		    {

			    $soap_params["KursID"] = $KursID;

		    }

		    $soap_result = $soap_client->getKursDatenICS(array('para' => json_encode($soap_params)))->getKursDatenICSResult;

		    $json_objects =  json_decode($soap_result);

				

		    return $json_objects;

        }

        function getKursDatenAusnahmen($Sprache = null,$KursID = null,$ZusammenFlag = null)

	    {

		    

            //

            // Output Records:

            //----------

            //1.) Datum

            //2.) WochentagKurz

            //3.) WochentagLang

            //4.) Bezeichnung

            //5.) istVergangenheit

            //6.) DatumVon

            //7.) DatumBis

            //----------

            //

            // No Output Parameters

            //

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonKurse.asmx?WSDL',array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

		

		    $soap_params = array('key' => $this->getKey());

		    if($Sprache != null)

		    {

			    $soap_params["Sprache"] = $Sprache;

		    }

		    if($KursID != null)

		    {

			    $soap_params["KursID"] = $KursID;

		    }

		    if($ZusammenFlag != null)

		    {

			    $soap_params["ZusammenFlag"] = $ZusammenFlag;

		    }

		    $soap_result = $soap_client->getKursDatenAusnahmen(array('para' => json_encode($soap_params)))->getKursDatenAusnahmenResult;

		    $json_objects =  json_decode($soap_result);

				

		    return $json_objects;

        }

        function getKursDaten($Sprache = null,$ZeigeKursausfall = null,$KursID = null,$ZeitFormat = null,$ZeitTrennung = null)

	    {

            //

            // Output Records:

            //----------

            //1.) KursID

            //2.) Datum

            //3.) LehrerID

            //4.) LehrerVorname

            //5.) LehrerNachname

            //6.) SaalID

            //7.) SaalBezeichnung

            //8.) SaalOrt

            //9.) Wochentag

            //10.) WochentagLang

            //11.) ZeitVon

            //12.) Zeit2Von

            //13.) ZeitBis

            //14.) Zeit2Bis

            //15.) ZeitVonZeitBis

            //16.) KursausfallBezeichnung

            //17.) istVergangenheit

            //18.) istKursausfall

            //----------

            //

            // No Output Parameters

            //

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonKurse.asmx?WSDL',array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

		

		    $soap_params = array('key' => $this->getKey());

		    if($Sprache != null)

		    {

			    $soap_params["Sprache"] = $Sprache;

		    }

		    if($ZeigeKursausfall != null)

		    {

			    $soap_params["ZeigeKursausfall"] = $ZeigeKursausfall;

		    }

		    if($KursID != null)

		    {

			    $soap_params["KursID"] = $KursID;

		    }

		    if($ZeitFormat != null)

		    {

			    $soap_params["ZeitFormat"] = $ZeitFormat;

		    }

		    if($ZeitTrennung != null)

		    {

			    $soap_params["ZeitTrennung"] = $ZeitTrennung;

		    }

		    $soap_result = $soap_client->getKursDaten(array('para' => json_encode($soap_params)))->getKursDatenResult;

		    $json_objects =  json_decode($soap_result);

		    return $json_objects;

        }

	function getDBUrl()

	{

		

        //

        // Outputs:

        // -------

        // 1.) DBUrl

        // -------

	

		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonKurse.asmx?WSDL',array('compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP));

		

		$soap_params = array('key' => $this->getKey());

		

		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;

		

		$DBUrl=  json_decode($soap_result);

				

		return $DBUrl;

	}

}

?>