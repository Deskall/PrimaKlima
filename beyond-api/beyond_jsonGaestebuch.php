<?php 

include 'beyondSW_jsonKey.php';

//
// Copyright (c) beyond software
//
// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.
//
// Erstellungsdatum: 2.3.2017
//

class beyond_jsonGaestebuch
{

        function getGaestebuch($GästebuchID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) Name
            //3.) EMail
            //4.) Text
            //5.) AenderungVon
            //6.) AenderungsDatum
            //7.) ErstellungVon
            //8.) ErstellungsDatum
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonGaestebuch.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($GästebuchID != null)
		    {
			    $soap_params["GästebuchID"] = $GästebuchID;
		    }
		    $soap_result = $soap_client->getGaestebuch(array('para' => json_encode($soap_params)))->getGaestebuchResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function addGaestebuch($Name = null,$EMail = null,$Text = null,$ErstellungVon = null,$ErstellungsDatum = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonGaestebuch.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($Name != null)
		    {
			    $soap_params["Name"] = $Name;
		    }
		    if($EMail != null)
		    {
			    $soap_params["EMail"] = $EMail;
		    }
		    if($Text != null)
		    {
			    $soap_params["Text"] = $Text;
		    }
		    if($ErstellungVon != null)
		    {
			    $soap_params["ErstellungVon"] = $ErstellungVon;
		    }
		    if($ErstellungsDatum != null)
		    {
			    $soap_params["ErstellungsDatum"] = $ErstellungsDatum;
		    }

		    $soap_client->addGaestebuch(array('para' => json_encode($soap_params)));

        }

	function getDBUrl()
	{
		global $beyondSW_jsonKey;

        //
        // Outputs:
        // -------
        // 1.) DBUrl
        // -------
	
		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonGaestebuch.asmx?WSDL');
		
		$soap_params = array('key' => $beyondSW_jsonKey);
		
		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;
		
		$DBUrl=  json_decode($soap_result);
				
		return $DBUrl;
	}
}

?>