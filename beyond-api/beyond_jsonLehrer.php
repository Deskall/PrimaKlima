<?php 

include 'beyondSW_jsonKey.php';

//
// Copyright (c) beyond software
//
// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.
//
// Erstellungsdatum: 2.3.2017
//

class beyond_jsonLehrer
{

        function getLehrer($SortColumn = null,$SortOrder = null,$FilialenID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) LehrerRowguid
            //2.) AdressenRowguid
            //3.) Nachname
            //4.) Vorname
            //5.) Hierarchie
            //6.) EMail
            //7.) Text
            //8.) FotoURL
            //9.) FilialenList
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonLehrer.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($SortColumn != null)
		    {
			    $soap_params["SortColumn"] = $SortColumn;
		    }
		    if($SortOrder != null)
		    {
			    $soap_params["SortOrder"] = $SortOrder;
		    }
		    if($FilialenID != null)
		    {
			    $soap_params["FilialenID"] = $FilialenID;
		    }
		    $soap_result = $soap_client->getLehrer(array('para' => json_encode($soap_params)))->getLehrerResult;

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
	
		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonLehrer.asmx?WSDL');
		
		$soap_params = array('key' => $beyondSW_jsonKey);
		
		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;
		
		$DBUrl=  json_decode($soap_result);
				
		return $DBUrl;
	}
}

?>