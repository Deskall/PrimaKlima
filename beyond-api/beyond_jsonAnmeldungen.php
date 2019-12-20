<?php 

include 'beyondSW_jsonKey.php';

//
// Copyright (c) beyond software
//
// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.
//
// Erstellungsdatum: 2.3.2017
//

class beyond_jsonAnmeldungen
{	
		protected $key;

		public function __construct() {
		    $this->key = '03FE4C469614658D0B1224D523595B05155A5526E80E7304E10BDF3C8FCF559B';
		}

		public function getKey() {
		    return $this->key;
		}

        function getAnmeldungen($AnmeldungenPaarRowguid = null,$AdressenRowguid = null,$KursID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) KursID
            //2.) KursBezeichnung
            //3.) KursDatumVon
            //4.) KursDatumBis
            //5.) AdressenID
            //6.) Vorname
            //7.) Nachname
            //8.) LehrerVornameNachname
            //9.) PaarID
            //10.) PartnerVorname
            //11.) PartnerNachname
            //12.) PartnerID
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAnmeldungen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AnmeldungenPaarRowguid != null)
		    {
			    $soap_params["AnmeldungenPaarRowguid"] = $AnmeldungenPaarRowguid;
		    }
		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }
		    if($KursID != null)
		    {
			    $soap_params["KursID"] = $KursID;
		    }
		    $soap_result = $soap_client->getAnmeldungen(array('para' => json_encode($soap_params)))->getAnmeldungenResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function addAnmeldungenFortsetzen($AnmeldungenPaarRowguid = null,$ErstellungsDatum = null,$ErstellungVon = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAnmeldungen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AnmeldungenPaarRowguid != null)
		    {
			    $soap_params["AnmeldungenPaarRowguid"] = $AnmeldungenPaarRowguid;
		    }
		    if($ErstellungsDatum != null)
		    {
			    $soap_params["ErstellungsDatum"] = $ErstellungsDatum;
		    }
		    if($ErstellungVon != null)
		    {
			    $soap_params["ErstellungVon"] = $ErstellungVon;
		    }

		    $soap_client->addAnmeldungenFortsetzen(array('para' => json_encode($soap_params)));

        }

        function addAnmeldungen($AnmeldungsRowguid = null,$KursID = null,$Geschlecht1 = null,$Geschlecht2 = null,$AdressenRowguid1 = null,$AdressenRowguid2 = null,$AnmeldeStatusID1 = null,$AnmeldeStatusID2 = null,$Gutschein1 = null,$Gutschein2 = null,$Bemerkungen = null,$ErstellungsDatum = null,$ErstellungVon = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Parameters:
            // -------
            //1.) AnmeldungsRowguid
           // -------

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAnmeldungen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AnmeldungsRowguid != null)
		    {
			    $soap_params["AnmeldungsRowguid"] = $AnmeldungsRowguid;
		    }
		    if($KursID != null)
		    {
			    $soap_params["KursID"] = $KursID;
		    }
		    if($Geschlecht1 != null)
		    {
			    $soap_params["Geschlecht1"] = $Geschlecht1;
		    }
		    if($Geschlecht2 != null)
		    {
			    $soap_params["Geschlecht2"] = $Geschlecht2;
		    }
		    if($AdressenRowguid1 != null)
		    {
			    $soap_params["AdressenRowguid1"] = $AdressenRowguid1;
		    }
		    if($AdressenRowguid2 != null)
		    {
			    $soap_params["AdressenRowguid2"] = $AdressenRowguid2;
		    }
		    if($AnmeldeStatusID1 != null)
		    {
			    $soap_params["AnmeldeStatusID1"] = $AnmeldeStatusID1;
		    }
		    if($AnmeldeStatusID2 != null)
		    {
			    $soap_params["AnmeldeStatusID2"] = $AnmeldeStatusID2;
		    }
		    if($Gutschein1 != null)
		    {
			    $soap_params["Gutschein1"] = $Gutschein1;
		    }
		    if($Gutschein2 != null)
		    {
			    $soap_params["Gutschein2"] = $Gutschein2;
		    }
		    if($Bemerkungen != null)
		    {
			    $soap_params["Bemerkungen"] = $Bemerkungen;
		    }
		    if($ErstellungsDatum != null)
		    {
			    $soap_params["ErstellungsDatum"] = $ErstellungsDatum;
		    }
		    if($ErstellungVon != null)
		    {
			    $soap_params["ErstellungVon"] = $ErstellungVon;
		    }
		    $soap_result = $soap_client->addAnmeldungen(array('para' => json_encode($soap_params)))->addAnmeldungenResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function deleteAnmeldung($AnmPaarID = null,$AnmPersonID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAnmeldungen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AnmPaarID != null)
		    {
			    $soap_params["AnmPaarID"] = $AnmPaarID;
		    }
		    if($AnmPersonID != null)
		    {
			    $soap_params["AnmPersonID"] = $AnmPersonID;
		    }

		    $soap_client->deleteAnmeldung(array('para' => json_encode($soap_params)));

        }

	function getDBUrl()
	{
		global $beyondSW_jsonKey;

        //
        // Outputs:
        // -------
        // 1.) DBUrl
        // -------
	
		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAnmeldungen.asmx?WSDL');
		
		$soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);
		
		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;
		
		$DBUrl=  json_decode($soap_result);
				
		return $DBUrl;
	}
}

?>