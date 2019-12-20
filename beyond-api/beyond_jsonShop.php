<?php 

include 'beyondSW_jsonKey.php';

//
// Copyright (c) beyond software
//
// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.
//
// Erstellungsdatum: 2.3.2017
//

class beyond_jsonShop
{

        function addZahlung($OffenePostenID = null,$SIXPamentMethodsID = null,$Betrag = null,$ErstellungVon = null,$ErstellungsDatum = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonShop.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($OffenePostenID != null)
		    {
			    $soap_params["OffenePostenID"] = $OffenePostenID;
		    }
		    if($SIXPamentMethodsID != null)
		    {
			    $soap_params["SIXPamentMethodsID"] = $SIXPamentMethodsID;
		    }
		    if($Betrag != null)
		    {
			    $soap_params["Betrag"] = $Betrag;
		    }
		    if($ErstellungVon != null)
		    {
			    $soap_params["ErstellungVon"] = $ErstellungVon;
		    }
		    if($ErstellungsDatum != null)
		    {
			    $soap_params["ErstellungsDatum"] = $ErstellungsDatum;
		    }

		    $soap_client->addZahlung(array('para' => json_encode($soap_params)));

        }

        function getGutscheine($GutscheinRowguid = null,$AdressenID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) Vorname
            //3.) Nachname
            //4.) Geschlecht
            //5.) AblaufsDatum
            //6.) GutscheinTypID
            //7.) Text
            //8.) Wert
            //9.) WertAnzeigen
            //10.) AdressenID
            //11.) VornameKäufer
            //12.) NachnameKäufer
            //13.) VerlängerungsDatum
            //14.) ZahlungsDatum
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonShop.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($GutscheinRowguid != null)
		    {
			    $soap_params["GutscheinRowguid"] = $GutscheinRowguid;
		    }
		    if($AdressenID != null)
		    {
			    $soap_params["AdressenID"] = $AdressenID;
		    }
		    $soap_result = $soap_client->getGutscheine(array('para' => json_encode($soap_params)))->getGutscheineResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function getZahlungsarten($SixPaymentMethodsID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) ID
            //3.) Bezeichnung
            //4.) Kommission
            //5.) ImageUrl
            //6.) SixPaymentMethodsID
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonShop.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($SixPaymentMethodsID != null)
		    {
			    $soap_params["SixPaymentMethodsID"] = $SixPaymentMethodsID;
		    }
		    $soap_result = $soap_client->getZahlungsarten(array('para' => json_encode($soap_params)))->getZahlungsartenResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function addGutschein($GutscheinRowguid = null,$Vorname = null,$Nachname = null,$Geschlecht = null,$Text = null,$Wert = null,$WertAnzeigen = null,$AblaufsDatum = null,$VerlängerungsDatum = null,$GutscheinTypID = null,$AdressenID = null,$ErstellungVon = null,$Erstellungsdatum = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Parameters:
            // -------
            //1.) GutscheinRowguid
           // -------

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonShop.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($GutscheinRowguid != null)
		    {
			    $soap_params["GutscheinRowguid"] = $GutscheinRowguid;
		    }
		    if($Vorname != null)
		    {
			    $soap_params["Vorname"] = $Vorname;
		    }
		    if($Nachname != null)
		    {
			    $soap_params["Nachname"] = $Nachname;
		    }
		    if($Geschlecht != null)
		    {
			    $soap_params["Geschlecht"] = $Geschlecht;
		    }
		    if($Text != null)
		    {
			    $soap_params["Text"] = $Text;
		    }
		    if($Wert != null)
		    {
			    $soap_params["Wert"] = $Wert;
		    }
		    if($WertAnzeigen != null)
		    {
			    $soap_params["WertAnzeigen"] = $WertAnzeigen;
		    }
		    if($AblaufsDatum != null)
		    {
			    $soap_params["AblaufsDatum"] = $AblaufsDatum;
		    }
		    if($VerlängerungsDatum != null)
		    {
			    $soap_params["VerlängerungsDatum"] = $VerlängerungsDatum;
		    }
		    if($GutscheinTypID != null)
		    {
			    $soap_params["GutscheinTypID"] = $GutscheinTypID;
		    }
		    if($AdressenID != null)
		    {
			    $soap_params["AdressenID"] = $AdressenID;
		    }
		    if($ErstellungVon != null)
		    {
			    $soap_params["ErstellungVon"] = $ErstellungVon;
		    }
		    if($Erstellungsdatum != null)
		    {
			    $soap_params["Erstellungsdatum"] = $Erstellungsdatum;
		    }
		    $soap_result = $soap_client->addGutschein(array('para' => json_encode($soap_params)))->addGutscheinResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function getGutscheineTexte($GutscheineTexteRowguid = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) TextDropDown
            //3.) TextGutschein
            //4.) Wert
            //5.) WertAnzeigen
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonShop.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($GutscheineTexteRowguid != null)
		    {
			    $soap_params["GutscheineTexteRowguid"] = $GutscheineTexteRowguid;
		    }
		    $soap_result = $soap_client->getGutscheineTexte(array('para' => json_encode($soap_params)))->getGutscheineTexteResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

	function getDBUrl()
	{
		global $beyondSW_jsonKey;

        //
        // Outputs:
        // -------
        // 1.) DBUrl
        // -------
	
		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonShop.asmx?WSDL');
		
		$soap_params = array('key' => $beyondSW_jsonKey);
		
		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;
		
		$DBUrl=  json_decode($soap_result);
				
		return $DBUrl;
	}
}

?>