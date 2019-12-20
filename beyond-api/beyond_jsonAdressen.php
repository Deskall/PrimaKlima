<?php 

include 'beyondSW_jsonKey.php';

//
// Copyright (c) beyond software
//
// Verwendung nur gestattet mit Verwaltungsoftware von beyond software.
//
// Erstellungsdatum: 2.3.2017
//

class beyond_jsonAdressen
{
		protected $key;

		public function __construct() {
		    $this->key = '03FE4C469614658D0B1224D523595B05155A5526E80E7304E10BDF3C8FCF559B';
		}

		public function getKey() {
		    return $this->key;
		}

        function setMailingAnmelden($AdressenEMailRowguid = null,$NewsletterTypenID = null,$ErstellungVon = null,$ErstellungsDatum = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AdressenEMailRowguid != null)
		    {
			    $soap_params["AdressenEMailRowguid"] = $AdressenEMailRowguid;
		    }
		    if($NewsletterTypenID != null)
		    {
			    $soap_params["NewsletterTypenID"] = $NewsletterTypenID;
		    }
		    if($ErstellungVon != null)
		    {
			    $soap_params["ErstellungVon"] = $ErstellungVon;
		    }
		    if($ErstellungsDatum != null)
		    {
			    $soap_params["ErstellungsDatum"] = $ErstellungsDatum;
		    }

		    $soap_client->setMailingAnmelden(array('para' => json_encode($soap_params)));

        }

        function setMailingAbmelden($AdressenEMailNewsletterRowguid = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Parameters:
            // -------
            //1.) AdressenEMailNewsletterRowguid
           // -------

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AdressenEMailNewsletterRowguid != null)
		    {
			    $soap_params["AdressenEMailNewsletterRowguid"] = $AdressenEMailNewsletterRowguid;
		    }
		    $soap_result = $soap_client->setMailingAbmelden(array('para' => json_encode($soap_params)))->setMailingAbmeldenResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function setLogin($AdressenRowguid = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }

		    $soap_client->setLogin(array('para' => json_encode($soap_params)));

        }

        function sendmailPasswort($EMail = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($EMail != null)
		    {
			    $soap_params["EMail"] = $EMail;
		    }

		    $soap_client->sendmailPasswort(array('para' => json_encode($soap_params)));

        }

        function getNewsletterTypen()
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) ID
            //3.) Bezeichnung
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    $soap_result = $soap_client->getNewsletterTypen(array('para' => json_encode($soap_params)))->getNewsletterTypenResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function getLaender()
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) CurrencyEnglishName
            //3.) CurrencyNativeName
            //4.) CurrencySymbol
            //5.) DisplayName
            //6.) EnglishName
            //7.) GeoId
            //8.) IsMetric
            //9.) ISOCurrencySymbol
            //10.) Name
            //11.) NativeName
            //12.) ThreeLetterISORegionName
            //13.) ThreeLetterWindowsRegionName
            //14.) TwoLetterISORegionName
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    $soap_result = $soap_client->getLaender(array('para' => json_encode($soap_params)))->getLaenderResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function getAdressenEMailNewsletter($AdressenEMailNewsletterRowguid = null,$NewsletterTypenID = null,$AdressenEMailID = null,$AdressenEMailRowguid = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) Vorname
            //2.) Nachname
            //3.) AdressenEMailRowguid
            //4.) NewsletterTypenID
            //5.) AdressenEMailNewsletterRowguid
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AdressenEMailNewsletterRowguid != null)
		    {
			    $soap_params["AdressenEMailNewsletterRowguid"] = $AdressenEMailNewsletterRowguid;
		    }
		    if($NewsletterTypenID != null)
		    {
			    $soap_params["NewsletterTypenID"] = $NewsletterTypenID;
		    }
		    if($AdressenEMailID != null)
		    {
			    $soap_params["AdressenEMailID"] = $AdressenEMailID;
		    }
		    if($AdressenEMailRowguid != null)
		    {
			    $soap_params["AdressenEMailRowguid"] = $AdressenEMailRowguid;
		    }
		    $soap_result = $soap_client->getAdressenEMailNewsletter(array('para' => json_encode($soap_params)))->getAdressenEMailNewsletterResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function getAdressen($SortColumn = null,$SortOrder = null,$AdressenRowguid = null,$Vorname = null,$Nachname = null,$PLZP = null,$EMail = null,$Passwort = null,$Telefon = null,$TanzpartnerFlag = null,$FirmaNichtAnzeigenFlag = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) rowguid
            //2.) Nachname
            //3.) Vorname
            //4.) Geschlecht
            //5.) Titel
            //6.) StrasseP
            //7.) PLZP
            //8.) OrtP
            //9.) KantonP
            //10.) LandP
            //11.) TelefonP
            //12.) TelefonG
            //13.) TelefonN
            //14.) EMail1
            //15.) EMail2
            //16.) EMail3
            //17.) EMailRowguid1
            //18.) EMailRowguid2
            //19.) EMailRowguid3
            //20.) EMail1Werbung
            //21.) EMail2Werbung
            //22.) EMail3Werbung
            //23.) NachnameVorname
            //24.) VornameNachname
            //25.) Geburtsdatum
            //26.) GeburtsdatumAnzeigen
            //27.) Grösse
            //28.) GrösseAnzeigen
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($SortColumn != null)
		    {
			    $soap_params["SortColumn"] = $SortColumn;
		    }
		    if($SortOrder != null)
		    {
			    $soap_params["SortOrder"] = $SortOrder;
		    }
		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }
		    if($Vorname != null)
		    {
			    $soap_params["Vorname"] = $Vorname;
		    }
		    if($Nachname != null)
		    {
			    $soap_params["Nachname"] = $Nachname;
		    }
		    if($PLZP != null)
		    {
			    $soap_params["PLZP"] = $PLZP;
		    }
		    if($EMail != null)
		    {
			    $soap_params["EMail"] = $EMail;
		    }
		    if($Passwort != null)
		    {
			    $soap_params["Passwort"] = $Passwort;
		    }
		    if($Telefon != null)
		    {
			    $soap_params["Telefon"] = $Telefon;
		    }
		    if($TanzpartnerFlag != null)
		    {
			    $soap_params["TanzpartnerFlag"] = $TanzpartnerFlag;
		    }
		    if($FirmaNichtAnzeigenFlag != null)
		    {
			    $soap_params["FirmaNichtAnzeigenFlag"] = $FirmaNichtAnzeigenFlag;
		    }
		    $soap_result = $soap_client->getAdressen(array('para' => json_encode($soap_params)))->getAdressenResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function addAdresse($AdressenRowguid = null,$PostRowguid = null,$VaterRowguid = null,$MutterRowguid = null,$Geschlecht = null,$Titel = null,$AnredeForm = null,$RechnungsArt = null,$Vorname = null,$Nachname = null,$TelefaxP = null,$TelefonP = null,$TelefonP2 = null,$TelefonG = null,$TelefaxG = null,$TelefonG2 = null,$TelefonN = null,$EMail1 = null,$EMail1Werbung = null,$EMail2 = null,$EMail2Werbung = null,$EMail3 = null,$EMail3Werbung = null,$OrtP = null,$KantonP = null,$LandP = null,$PLZP = null,$StrasseP = null,$Grösse = null,$GrösseAnzeigen = null,$Geburtsdatum = null,$GeburtsdatumAnzeigen = null,$AufmerksamDurch = null,$ErstellungVon = null,$ErstellungsDatum = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Parameters:
            // -------
            //1.) AdressenRowguid
           // -------

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }
		    if($PostRowguid != null)
		    {
			    $soap_params["PostRowguid"] = $PostRowguid;
		    }
		    if($VaterRowguid != null)
		    {
			    $soap_params["VaterRowguid"] = $VaterRowguid;
		    }
		    if($MutterRowguid != null)
		    {
			    $soap_params["MutterRowguid"] = $MutterRowguid;
		    }
		    if($Geschlecht != null)
		    {
			    $soap_params["Geschlecht"] = $Geschlecht;
		    }
		    if($Titel != null)
		    {
			    $soap_params["Titel"] = $Titel;
		    }
		    if($AnredeForm != null)
		    {
			    $soap_params["AnredeForm"] = $AnredeForm;
		    }
		    if($RechnungsArt != null)
		    {
			    $soap_params["RechnungsArt"] = $RechnungsArt;
		    }
		    if($Vorname != null)
		    {
			    $soap_params["Vorname"] = $Vorname;
		    }
		    if($Nachname != null)
		    {
			    $soap_params["Nachname"] = $Nachname;
		    }
		    if($TelefaxP != null)
		    {
			    $soap_params["TelefaxP"] = $TelefaxP;
		    }
		    if($TelefonP != null)
		    {
			    $soap_params["TelefonP"] = $TelefonP;
		    }
		    if($TelefonP2 != null)
		    {
			    $soap_params["TelefonP2"] = $TelefonP2;
		    }
		    if($TelefonG != null)
		    {
			    $soap_params["TelefonG"] = $TelefonG;
		    }
		    if($TelefaxG != null)
		    {
			    $soap_params["TelefaxG"] = $TelefaxG;
		    }
		    if($TelefonG2 != null)
		    {
			    $soap_params["TelefonG2"] = $TelefonG2;
		    }
		    if($TelefonN != null)
		    {
			    $soap_params["TelefonN"] = $TelefonN;
		    }
		    if($EMail1 != null)
		    {
			    $soap_params["EMail1"] = $EMail1;
		    }
		    if($EMail1Werbung != null)
		    {
			    $soap_params["EMail1Werbung"] = $EMail1Werbung;
		    }
		    if($EMail2 != null)
		    {
			    $soap_params["EMail2"] = $EMail2;
		    }
		    if($EMail2Werbung != null)
		    {
			    $soap_params["EMail2Werbung"] = $EMail2Werbung;
		    }
		    if($EMail3 != null)
		    {
			    $soap_params["EMail3"] = $EMail3;
		    }
		    if($EMail3Werbung != null)
		    {
			    $soap_params["EMail3Werbung"] = $EMail3Werbung;
		    }
		    if($OrtP != null)
		    {
			    $soap_params["OrtP"] = $OrtP;
		    }
		    if($KantonP != null)
		    {
			    $soap_params["KantonP"] = $KantonP;
		    }
		    if($LandP != null)
		    {
			    $soap_params["LandP"] = $LandP;
		    }
		    if($PLZP != null)
		    {
			    $soap_params["PLZP"] = $PLZP;
		    }
		    if($StrasseP != null)
		    {
			    $soap_params["StrasseP"] = $StrasseP;
		    }
		    if($Grösse != null)
		    {
			    $soap_params["Grösse"] = $Grösse;
		    }
		    if($GrösseAnzeigen != null)
		    {
			    $soap_params["GrösseAnzeigen"] = $GrösseAnzeigen;
		    }
		    if($Geburtsdatum != null)
		    {
			    $soap_params["Geburtsdatum"] = $Geburtsdatum;
		    }
		    if($GeburtsdatumAnzeigen != null)
		    {
			    $soap_params["GeburtsdatumAnzeigen"] = $GeburtsdatumAnzeigen;
		    }
		    if($AufmerksamDurch != null)
		    {
			    $soap_params["AufmerksamDurch"] = $AufmerksamDurch;
		    }
		    if($ErstellungVon != null)
		    {
			    $soap_params["ErstellungVon"] = $ErstellungVon;
		    }
		    if($ErstellungsDatum != null)
		    {
			    $soap_params["ErstellungsDatum"] = $ErstellungsDatum;
		    }
		    $soap_result = $soap_client->addAdresse(array('para' => json_encode($soap_params)))->addAdresseResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function editAdresse($AdressenRowguid = null,$PostRowguid = null,$Geschlecht = null,$Titel = null,$AnredeForm = null,$RechnungsArt = null,$Vorname = null,$Nachname = null,$TelefaxP = null,$TelefonP = null,$TelefonP2 = null,$TelefonG = null,$TelefaxG = null,$TelefonG2 = null,$TelefonN = null,$EMail1 = null,$EMail1Werbung = null,$EMail2 = null,$EMail2Werbung = null,$EMail3 = null,$EMail3Werbung = null,$OrtP = null,$KantonP = null,$LandP = null,$PLZP = null,$StrasseP = null,$Grösse = null,$GrösseAnzeigen = null,$Geburtsdatum = null,$SetGeburtstdatum = null,$GeburtsdatumAnzeigen = null,$Passwort = null,$AenderungVon = null,$AenderungsDatum = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Parameters:
            // -------
            //1.) PostRowguid
           // -------

		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }
		    if($PostRowguid != null)
		    {
			    $soap_params["PostRowguid"] = $PostRowguid;
		    }
		    if($Geschlecht != null)
		    {
			    $soap_params["Geschlecht"] = $Geschlecht;
		    }
		    if($Titel != null)
		    {
			    $soap_params["Titel"] = $Titel;
		    }
		    if($AnredeForm != null)
		    {
			    $soap_params["AnredeForm"] = $AnredeForm;
		    }
		    if($RechnungsArt != null)
		    {
			    $soap_params["RechnungsArt"] = $RechnungsArt;
		    }
		    if($Vorname != null)
		    {
			    $soap_params["Vorname"] = $Vorname;
		    }
		    if($Nachname != null)
		    {
			    $soap_params["Nachname"] = $Nachname;
		    }
		    if($TelefaxP != null)
		    {
			    $soap_params["TelefaxP"] = $TelefaxP;
		    }
		    if($TelefonP != null)
		    {
			    $soap_params["TelefonP"] = $TelefonP;
		    }
		    if($TelefonP2 != null)
		    {
			    $soap_params["TelefonP2"] = $TelefonP2;
		    }
		    if($TelefonG != null)
		    {
			    $soap_params["TelefonG"] = $TelefonG;
		    }
		    if($TelefaxG != null)
		    {
			    $soap_params["TelefaxG"] = $TelefaxG;
		    }
		    if($TelefonG2 != null)
		    {
			    $soap_params["TelefonG2"] = $TelefonG2;
		    }
		    if($TelefonN != null)
		    {
			    $soap_params["TelefonN"] = $TelefonN;
		    }
		    if($EMail1 != null)
		    {
			    $soap_params["EMail1"] = $EMail1;
		    }
		    if($EMail1Werbung != null)
		    {
			    $soap_params["EMail1Werbung"] = $EMail1Werbung;
		    }
		    if($EMail2 != null)
		    {
			    $soap_params["EMail2"] = $EMail2;
		    }
		    if($EMail2Werbung != null)
		    {
			    $soap_params["EMail2Werbung"] = $EMail2Werbung;
		    }
		    if($EMail3 != null)
		    {
			    $soap_params["EMail3"] = $EMail3;
		    }
		    if($EMail3Werbung != null)
		    {
			    $soap_params["EMail3Werbung"] = $EMail3Werbung;
		    }
		    if($OrtP != null)
		    {
			    $soap_params["OrtP"] = $OrtP;
		    }
		    if($KantonP != null)
		    {
			    $soap_params["KantonP"] = $KantonP;
		    }
		    if($LandP != null)
		    {
			    $soap_params["LandP"] = $LandP;
		    }
		    if($PLZP != null)
		    {
			    $soap_params["PLZP"] = $PLZP;
		    }
		    if($StrasseP != null)
		    {
			    $soap_params["StrasseP"] = $StrasseP;
		    }
		    if($Grösse != null)
		    {
			    $soap_params["Grösse"] = $Grösse;
		    }
		    if($GrösseAnzeigen != null)
		    {
			    $soap_params["GrösseAnzeigen"] = $GrösseAnzeigen;
		    }
		    if($Geburtsdatum != null)
		    {
			    $soap_params["Geburtsdatum"] = $Geburtsdatum;
		    }
		    if($SetGeburtstdatum != null)
		    {
			    $soap_params["SetGeburtstdatum"] = $SetGeburtstdatum;
		    }
		    if($GeburtsdatumAnzeigen != null)
		    {
			    $soap_params["GeburtsdatumAnzeigen"] = $GeburtsdatumAnzeigen;
		    }
		    if($Passwort != null)
		    {
			    $soap_params["Passwort"] = $Passwort;
		    }
		    if($AenderungVon != null)
		    {
			    $soap_params["AenderungVon"] = $AenderungVon;
		    }
		    if($AenderungsDatum != null)
		    {
			    $soap_params["AenderungsDatum"] = $AenderungsDatum;
		    }
		    $soap_result = $soap_client->editAdresse(array('para' => json_encode($soap_params)))->editAdresseResult;

		    $json_objects =  json_decode($soap_result);
				
		    return $json_objects;
        }

        function getAdressenEMail($AdressenRowguid = null,$EMail = null)
	    {
		    global $beyondSW_jsonKey;

            //
            // Output Records:
            //----------
            //1.) Vorname
            //2.) Nachname
            //3.) AdressenEMailRowguid
            //4.) EMail
            //----------

            //
            // No Output Parameters
            //


		    $soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		    $soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);

		    if($AdressenRowguid != null)
		    {
			    $soap_params["AdressenRowguid"] = $AdressenRowguid;
		    }
		    if($EMail != null)
		    {
			    $soap_params["EMail"] = $EMail;
		    }
		    $soap_result = $soap_client->getAdressenEMail(array('para' => json_encode($soap_params)))->getAdressenEMailResult;

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
	
		$soap_client = new SoapClient('https://aod.beyond-sw.ch/json/jsonAdressen.asmx?WSDL');
		
		$soap_params = array('key' => $this->getKey(), 'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP);
		
		$soap_result = $soap_client->getDBUrl(array('para' => json_encode($soap_params)))->getDBUrlResult;
		
		$DBUrl=  json_decode($soap_result);
				
		return $DBUrl;
	}
}

?>