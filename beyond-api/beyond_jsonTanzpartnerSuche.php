<?php 

include 'beyondSW_jsonKey.php';

//
// Copyright (c) beyond software
//
// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.
//
// Erstellungsdatum: 2.3.2017
//

class beyond_jsonTanzpartnerSuche
{

        function KursgruppenDelete($SucheRowguid = null,$AdressenRowguid = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonTanzpartnerSuche.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($SucheRowguid != null)
		    {
			    $soap_params["SucheRowguid"] = $SucheRowguid;
		    }
		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }

		    $soap_client->KursgruppenDelete(array('para' => json_encode($soap_params)));

        }

        function KursgruppenAdd($AdressenRowguid = null,$KursGruppenID = null,$ErstellungsDatum = null,$ErstellungVon = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonTanzpartnerSuche.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }
		    if($KursGruppenID != null)
		    {
			    $soap_params["KursGruppenID"] = $KursGruppenID;
		    }
		    if($ErstellungsDatum != null)
		    {
			    $soap_params["ErstellungsDatum"] = $ErstellungsDatum;
		    }
		    if($ErstellungVon != null)
		    {
			    $soap_params["ErstellungVon"] = $ErstellungVon;
		    }

		    $soap_client->KursgruppenAdd(array('para' => json_encode($soap_params)));

        }

        function KurseDelete($SucheRowguid = null,$AdressenRowguid = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonTanzpartnerSuche.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($SucheRowguid != null)
		    {
			    $soap_params["SucheRowguid"] = $SucheRowguid;
		    }
		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }

		    $soap_client->KurseDelete(array('para' => json_encode($soap_params)));

        }

        function KurseAdd($AdressenRowguid = null,$KursID = null,$ErstellungsDatum = null,$ErstellungVon = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonTanzpartnerSuche.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }
		    if($KursID != null)
		    {
			    $soap_params["KursID"] = $KursID;
		    }
		    if($ErstellungsDatum != null)
		    {
			    $soap_params["ErstellungsDatum"] = $ErstellungsDatum;
		    }
		    if($ErstellungVon != null)
		    {
			    $soap_params["ErstellungVon"] = $ErstellungVon;
		    }

		    $soap_client->KurseAdd(array('para' => json_encode($soap_params)));

        }

        function getTanzpartnerSuche($Geschlecht = null,$AdressenID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) AdressenID
            //3.) Vorname
            //4.) Nachname
            //5.) StrasseP
            //6.) PLZP
            //7.) OrtP
            //8.) TelefonP
            //9.) TelefonG
            //10.) TelefonN
            //11.) Email1
            //12.) Email2
            //13.) Email3
            //14.) Grösse
            //15.) GrösseAnzeigen
            //16.) BerGrösse
            //17.) Geburtsdatum
            //18.) GeburtsdatumAnzeigen
            //19.) BerAlter
            //20.) Bezeichnung
            //21.) Hierarchie
            //22.) KursgruppenID
            //23.) KursID
            //24.) ErstellungsDatum
            //25.) ErstellungsDatumISO8601
            //26.) ErstellungsDatumISO8601+
            //27.) ErstellungsDatumRFC5545
            //28.) ErstellungsDatumUTCISO8601
            //29.) ErstellungsDatumUTCISO8601+
            //30.) ErstellungsDatumUTCRFC5545
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonTanzpartnerSuche.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($Geschlecht != null)
		    {
			    $soap_params["Geschlecht"] = $Geschlecht;
		    }
		    if($AdressenID != null)
		    {
			    $soap_params["AdressenID"] = $AdressenID;
		    }
		    $soap_result = $soap_client->getTanzpartnerSuche(array('para' => json_encode($soap_params)))->getTanzpartnerSucheResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function sendMailPartnerBoerse($AdressenRowguid = null,$VonAdressenRowguid = null,$Nachricht = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonTanzpartnerSuche.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }
		    if($VonAdressenRowguid != null)
		    {
			    $soap_params["VonAdressenRowguid"] = $VonAdressenRowguid;
		    }
		    if($Nachricht != null)
		    {
			    $soap_params["Nachricht"] = $Nachricht;
		    }

		    $soap_client->sendMailPartnerBoerse(array('para' => json_encode($soap_params)));

        }

	function getDBUrl()
	{
		global $beyondSW_jsonKey;

        //
        // Outputs:
        // -------
        // 1.) DBUrl
        // -------
	
		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonTanzpartnerSuche.asmx?WSDL');
		
		$soap_params = array('key' => $beyondSW_jsonKey);
		
		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;
		
		$DBUrl=  json_decode($soap_result);
				
		return $DBUrl;
	}
}

?>