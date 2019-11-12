<?php

use SilverStripe\ORM\DataObject;
use SilverStripe\Security\Member;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\Email\Email;
use SilverStripe\Security\MemberAuthenticator\MemberLoginForm;
use SilverStripe\Security\Security;
use SilverStripe\Security\Permission;
use SilverStripe\Control\Director;

class PackageOrder_Controller extends PageController {


	private static $allowed_actions = array ('neworder', 'verifycoupon', 'invoice');


	public function verifycoupon(HTTPRequest $request) {
		$Coupon = Coupon::get()->Filter(array(
			'Code' => $_POST['coupon'],
			'Count:GreaterThan' => 1
		))->First();

		if( $Coupon && $Coupon->ID > 0 ){

			$Package = DataObject::get_by_id( 'Package', $_POST['packageID'] );

			if( $Package->isFlatrate ){

				$PackageOption = DataObject::get_by_id( 'PackageOption', $_POST['optionID'] );
				$Price = $PackageOption->Price;
				$Duration =  $PackageOption->Title__de_DE;

			}else{
				$Price = $Package->GetFinalPrice();
				$Duration =  0;
			}
			

			if( $Coupon->AmountType == 'relative' ){
				$ReducedPrice = $Price * ( 100 - $Coupon->Amount ) / 100;
			}else{
				$ReducedPrice = $Price - $Coupon->Amount;
			}

			echo json_encode( array(
				'type' => 'success', 
				'data' => array(
					'Title'	=> $Package->Title__de_DE , 
					'Duration'	=> $Duration,
					'Price'	=> $Price,
					'Reduction'	=> $Coupon->NiceAmount(),
					'ReducedPrice' => $ReducedPrice
				),
				'msg' => 'Gutschein-Reduktion erlogreich angewandt'
			));

		}else{
			echo json_encode( array(
				'type' => 'error',
				'msg' => 'Gutschein bereits verwendet.'
			));
		}
	}





	public function neworder(  ){

		$Package = DataObject::get_by_id( 'Package', $_POST['packageID'] );
		$order = PackageOrder::create();
		$employer = Security::getCurrentUser();
		$order->EmployerID = $employer->ID;
		$order->Title = $Package->Title__de_DE;
		$order->Content = '<p><strong>Paket '.$Package->Title__de_DE.'</strong></p>';

		if(  array_key_exists( 'coupon' , $_POST )  ){
			$Coupon = Coupon::get()->Filter(array(
				'Code' => $_POST['coupon'],
				'Count:GreaterThan' => 1
			))->First();
		}else{
			$Coupon = false;
		}


		if( $Coupon && $Coupon->ID > 0 ){

			$order->CouponID = $Coupon->ID;
			$Coupon->Count--;
			$Coupon->write();

			if( $Package->isFlatrate ){
				$PackageOption = DataObject::get_by_id( 'PackageOption', $_POST['optionID'] );
				$order->isFlatrate = true;
				$order->RunTime = $PackageOption->RunTime;
				$order->RunTimeCurrency = $PackageOption->RunTimeCurrency;
				$order->RunTimeTitle = $PackageOption->Title__de_DE;
				$order->Content .= '<p>Anzeigen-Flatrate für '.$PackageOption->Title__de_DE.'</p>';

				if( $Coupon->AmountType == 'relative' ){
					$ReducedPrice = $PackageOption->Price * ( 100 - $Coupon->Amount ) / 100;
				}else{
					$ReducedPrice = $PackageOption->Price - $Coupon->Amount;
				}

				$order->PriceOrig = $PackageOption->Price;

				$order->Price = $ReducedPrice;
				$order->Content.='<p>Paket-Preis: '.$PackageOption->Price.' €</p>';
				$order->Content.='<p>Abzüglich Gutschein-Reduktion von '.$Coupon->NiceAmount().'</p>';
				$order->Content.='<p>Total: '.$ReducedPrice.' €</p>';	
				$order->Price = $ReducedPrice;

			}else{
				if( $Package->NumOfAds > 1){
					$order->Content .= '<p>'.$Package->NumOfAds.' Anzeigen mit einer Laufzeit von je '.$Package->RunTimeTitle__de_DE.'</p>';
				}else{
					$order->Content .= '<p>'.$Package->NumOfAds.' Anzeige mit einer Laufzeit von '.$Package->RunTimeTitle__de_DE.'</p>';
				}

				$order->Content.='<p>Paket-Preis: '.$Package->GetFinalPrice().' €</p>';
				$order->Content.='<p>Abzüglich Gutschein-Reduktion von '.$Coupon->NiceAmount().'</p>';

				if( $Coupon->AmountType == 'relative' ){
					$ReducedPrice = $Package->GetFinalPrice() * ( 100 - $Coupon->Amount ) / 100;
				}else{
					$ReducedPrice = $Package->GetFinalPrice() - $Coupon->Amount;
				}

				$order->PriceOrig = $Package->GetFinalPrice();

				$order->Content.='<p>Total: '.$ReducedPrice.' €</p>';		

	 			$order->NumOfAds = $Package->NumOfAds;
				$order->Price = $ReducedPrice;
				$order->RunTime = $Package->RunTime;
				$order->RunTimeCurrency = $Package->RunTimeCurrency;
				$order->RunTimeTitle = $Package->RunTimeTitle__de_DE;

			}

		}else{
			if( $Package->isFlatrate ){
				$PackageOption = DataObject::get_by_id( 'PackageOption', $_POST['optionID'] );
				$order->isFlatrate = true;
				$order->Price = $PackageOption->Price;
				$order->RunTime = $PackageOption->RunTime;
				$order->RunTimeCurrency = $PackageOption->RunTimeCurrency;
				$order->RunTimeTitle = $PackageOption->Title__de_DE;
				$order->Content .= '<p>Anzeigen-Flatrate für '.$PackageOption->Title__de_DE.'</p>';

			}else{
				if( $Package->NumOfAds > 1){
					$order->Content .= '<p>'.$Package->NumOfAds.' Anzeigen mit einer Laufzeit von je '.$Package->RunTimeTitle__de_DE.'</p>';
				}else{
					$order->Content .= '<p>'.$Package->NumOfAds.' Anzeige mit einer Laufzeit von '.$Package->RunTimeTitle__de_DE.'</p>';
				}

	 			$order->NumOfAds = $Package->NumOfAds;
				$order->Price = $Package->GetFinalPrice();
				$order->RunTime = $Package->RunTime;
				$order->RunTimeCurrency = $Package->RunTimeCurrency;
				$order->RunTimeTitle = $Package->RunTimeTitle__de_DE;
			}
		}

		$order->PackageID = $Package->ID;

		$order->write();

		$pdf = $this->generatePDF( $order );




		$config = SiteConfig::current_site_config(); 	

		$body = '<html>
			<body>
				<h2>'.$config->SubjectEmail.'</h2>
				'.$order->Content.'
			</body>
		</html>';

		$email = new Email( $config->EmailSentFrom , $config->ReceiverEmail, $config->SubjectEmail, $body);
		$email->addCustomHeader('Reply-To',$employer->Email );
		$email->attachFileFromString( $pdf->Output('S'), 'rechnung-'.$order->ID.'.pdf' );
		$email->send();

		$bodyConfirmation = '<html>
			<body>
				<h2>'.$config->SubjectEmailConfirmation.'</h2>
				<p>'.nl2br($config->ContentEmailConfirmation).'</p>
				'.$order->Content.'
			</body>
		</html>';

		$confirmation = new Email( $config->EmailSentFrom , $employer->Email, $config->SubjectEmailConfirmation, $bodyConfirmation);
		$confirmation->attachFileFromString( $pdf->Output('S'), 'rechnung-'.$order->ID.'.pdf' );
		$confirmation->send();






		$response = array(
			'type' => 'success',
			'msg'  => '<p>Ihre Bestellung wurde erfolgreich verschickt. Wir senden Ihnen in Kürze die Rechnung zu.</p><p>Herzlichen Dank</p>'
		);

		echo json_encode($response);


	}



	private function generatePDF( $Order ){
		require_once(Director::baseFolder().'/fpdf/fpdf.php');
		require_once(Director::baseFolder().'/fpdi/fpdi.php');
		require_once(Director::baseFolder().'/fpdf/TableHTML.php');

		$pdf = new FPDI();

		$src = Director::baseFolder()."/pdftmpl/rechnung.pdf";
		$pageCount = $pdf->setSourceFile($src);

		$pdf->SetFont('helvetica', 'B', 9 );

		$pdf->AddPage();
		$templateId = $pdf->importPage(1);
		$pdf->useTemplate($templateId);


		$x0 = 18;
		$y0 = 30;

		$row = 0;
		$lineheight = 5;

		if( $Order->Employer()->Company ){
			$pdf->Text( $x0 , $y0 + $row * $lineheight, utf8_decode($Order->Employer()->Company ) );		
			$row++;			
		}

		if( $Order->Employer()->AddressStreet ){
			$pdf->Text( $x0 , $y0 + $row * $lineheight, utf8_decode( $Order->Employer()->AddressStreet ) );		
			$row++;			
		}

		if( $Order->Employer()->AddressPostalCode || $Order->Employer()->AddressPlace ){
			$strAddr = utf8_decode( $Order->Employer()->AddressPostalCode );

			if( $Order->Employer()->AddressPlace ){
				$strAddr .= ' '.utf8_decode( $Order->Employer()->AddressPlace );
			}

			$pdf->Text( $x0 , $y0 + $row * $lineheight, $strAddr );		
			$row++;			
		}


		$pdf->SetXY( $x0, 70 );
		$pdf->Cell( 50, 10, 'Rechnung', 0, 0, 'L' );
		$pdf->SetXY( $x0, 70 );
		$pdf->Cell( 50, 10, $Order->generateOrderNumber(), 0, 0, 'R' );

		$pdf->SetXY( $x0, 75 );
		$pdf->Cell( 50, 10, 'Datum', 0, 0, 'L' );
		$pdf->SetXY( $x0, 75 );
		$pdf->Cell( 50, 10, date('d.m.Y', strtotime($Order->Created)) , 0, 0, 'R' );

		$pdf->SetXY( $x0, 80 );
		$pdf->Cell( 50, 10, 'Kundennummer', 0, 0, 'L' );
		$pdf->SetXY( $x0, 80 );
		$pdf->Cell( 50, 10, $Order->Employer()->generateClientNumber() , 0, 0, 'R' );


		if( $Order->CouponID > 0 ){
			$pdf->SetXY( $x0, 100 );
			$pdf->Cell( 90, 10, 'Paket '.$Order->Title, 0, 0, 'C' );

			$pdf->SetXY( $x0 + 85, 100 );
			$pdf->Cell( 27, 10, $Order->PriceOrig.' EUR' , 0, 0, 'R' );

			$pdf->SetXY( $x0 + 85 + 27, 100 );
			$pdf->Cell( 25, 10, 1 , 0, 0, 'C' );

			$pdf->SetXY( $x0 + 85 + 27 + 25, 100 );
			$pdf->Cell( 25, 10, $Order->PriceOrig.' EUR' , 0, 0, 'R' );	

			$pdf->SetXY( $x0, 105 );
			if( $Order->Coupon()->AmountType == 'relative' ){
				$type = '%';
			}else{
				$type = 'EUR';
			}

			$pdf->Cell( 90, 10, utf8_decode( 'Abzüglich Gutschein-Reduktion von '.$Order->Coupon()->Amount.' '.$type ), 0, 0, 'C' );

			$pdf->SetXY( $x0 + 85 + 27 + 25, 105 );
			$pdf->Cell( 25, 10, $Order->Price.' EUR' , 0, 0, 'R' );	

		}else{

			$pdf->SetXY( $x0, 100 );
			$pdf->Cell( 90, 10, 'Paket '.$Order->Title, 0, 0, 'C' );

			$pdf->SetXY( $x0 + 85, 100 );
			$pdf->Cell( 27, 10, $Order->Price.' EUR' , 0, 0, 'R' );

			$pdf->SetXY( $x0 + 85 + 27, 100 );
			$pdf->Cell( 25, 10, 1 , 0, 0, 'C' );

			$pdf->SetXY( $x0 + 85 + 27 + 25, 100 );
			$pdf->Cell( 25, 10, $Order->Price.' EUR' , 0, 0, 'R' );	
		}


		$pdf->SetXY( $x0 + 85 + 27 + 25, 126.5 );
		$pdf->Cell( 25, 10, $Order->Price.' EUR' , 0, 0, 'R' );		

		$pdf->SetXY( $x0 + 85 + 27 + 25, 131.5 );
		$pdf->Cell( 25, 10, $Order->Price.' EUR' , 0, 0, 'R' );		

		$pdf->SetXY( $x0 + 85 + 27 + 25, 141.5 );
		$pdf->Cell( 25, 10, $Order->Price.' EUR' , 0, 0, 'R' );	

		return $pdf;
	}






	public function invoice( HTTPRequest $request ){
		$Order = DataObject::get_by_id("PackageOrder", $request->params()['ID'] );
		$Employer = Security::getCurrentUser();

		if( $Order && $Order->ID > 0 && ( Permission::check('ADMIN') || $Order->EmployerID == $Employer->ID ) ){
			$pdf = $this->generatePDF( $Order );
        	$pdf->Output('I');

		}else{
			$this->httpError(404);
		}


	}





}