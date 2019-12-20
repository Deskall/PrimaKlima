<?php 

include 'beyondSW_jsonKey.php';

//
// Copyright (c) beyond software
//
// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.
//
// Erstellungsdatum: 2.3.2017
//

class beyond_jsonBlogs
{

        function getBlogs($BlogID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) Titel
            //3.) Text
            //4.) BildURL
            //5.) AenderungVon
            //6.) AenderungsDatum
            //7.) ErstellungVon
            //8.) ErstellungsDatum
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonBlogs.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($BlogID != null)
		    {
			    $soap_params["BlogID"] = $BlogID;
		    }
		    $soap_result = $soap_client->getBlogs(array('para' => json_encode($soap_params)))->getBlogsResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function getBlogKommentare($BlogID = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) BlogID
            //3.) Name
            //4.) EMail
            //5.) Text
            //6.) AenderungVon
            //7.) AenderungsDatum
            //8.) ErstellungVon
            //9.) ErstellungsDatum
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonBlogs.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($BlogID != null)
		    {
			    $soap_params["BlogID"] = $BlogID;
		    }
		    $soap_result = $soap_client->getBlogKommentare(array('para' => json_encode($soap_params)))->getBlogKommentareResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function addBlogKommentare($BlogID = null,$Name = null,$EMail = null,$Text = null,$ErstellungVon = null,$ErstellungsDatum = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonBlogs.asmx?WSDL');
		
		    $soap_params = array('key' => $beyondSW_jsonKey);

		    if($BlogID != null)
		    {
			    $soap_params["BlogID"] = $BlogID;
		    }
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

		    $soap_client->addBlogKommentare(array('para' => json_encode($soap_params)));

        }

	function getDBUrl()
	{
		global $beyondSW_jsonKey;

        //
        // Outputs:
        // -------
        // 1.) DBUrl
        // -------
	
		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonBlogs.asmx?WSDL');
		
		$soap_params = array('key' => $beyondSW_jsonKey);
		
		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;
		
		$DBUrl=  json_decode($soap_result);
				
		return $DBUrl;
	}
}

?>