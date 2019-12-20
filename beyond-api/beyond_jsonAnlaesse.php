<?php 

include 'beyondSW_jsonKey.php';

//
// Copyright (c) beyond software
//
// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.
//
// Erstellungsdatum: 2.3.2017
//

class beyond_jsonAnlaesse
{

        function getAnlaesse($AnlassTypID = null,$SpezialTypID = null,$AnzeigenFlag = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) AnlassSpezialTypBezeichnung
            //2.) AnlassTypBezeichnung
            //3.) AnlassSpezialTypText
            //4.) AnlassTypText
            //5.) Bezeichnung
            //6.) Text
            //7.) Datum
            //8.) ZeitVon
            //9.) ZeitBis
            //10.) Preis
            //11.) LehrerID
            //12.) WochentagKurz
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAnlaesse.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($AnlassTypID != null)
		    {
			    $soap_params["AnlassTypID"] = $AnlassTypID;
		    }
		    if($SpezialTypID != null)
		    {
			    $soap_params["SpezialTypID"] = $SpezialTypID;
		    }
		    if($AnzeigenFlag != null)
		    {
			    $soap_params["AnzeigenFlag"] = $AnzeigenFlag;
		    }
		    $soap_result = $soap_client->getAnlaesse(array('para' => json_encode($soap_params)))->getAnlaesseResult;

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
	
		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAnlaesse.asmx?WSDL');
		
		$soap_params = array('key' => $beyondSW_jsonKey);
		
		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;
		
		$DBUrl=  json_decode($soap_result);
				
		return $DBUrl;
	}
}

?>