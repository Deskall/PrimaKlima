<?php 

include 'beyondSW_jsonKey.php';

//
// Copyright (c) beyond software
//
// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.
//
// Erstellungsdatum: 2.3.2017
//

class beyond_jsonAktuelles
{

        function getAktuelles($RowCount = null,$SortColumn = null,$SortOrder = null,$AktuellesRowguid = null,$Typ = null,$FilialenID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) AktuellesID
            //2.) Titel
            //3.) Beschreibung
            //4.) Hervorheben
            //5.) FilialenID
            //6.) URL
            //7.) URLTarget
            //8.) ErstellungsDatum
            //9.) ErstellungsDatumISO8601
            //10.) ErstellungsDatumISO8601+
            //11.) ErstellungsDatumRFC5545
            //12.) ErstellungsDatumUTCISO8601
            //13.) ErstellungsDatumUTCISO8601+
            //14.) ErstellungsDatumUTCRFC5545
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAktuelles.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($RowCount != null)
		    {
			    $soap_params["RowCount"] = $RowCount;
		    }
		    if($SortColumn != null)
		    {
			    $soap_params["SortColumn"] = $SortColumn;
		    }
		    if($SortOrder != null)
		    {
			    $soap_params["SortOrder"] = $SortOrder;
		    }
		    if($AktuellesRowguid != null)
		    {
			    $soap_params["AktuellesRowguid"] = $AktuellesRowguid;
		    }
		    if($Typ != null)
		    {
			    $soap_params["Typ"] = $Typ;
		    }
		    if($FilialenID != null)
		    {
			    $soap_params["FilialenID"] = $FilialenID;
		    }
		    $soap_result = $soap_client->getAktuelles(array('para' => json_encode($soap_params)))->getAktuellesResult;

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
	
		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAktuelles.asmx?WSDL');
		
		$soap_params = array('key' => $beyondSW_jsonKey);
		
		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;
		
		$DBUrl=  json_decode($soap_result);
				
		return $DBUrl;
	}
}

?>