<?php
use DNADesign\Elemental\Models\BaseElement;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\ORM\ArrayList;

class TopJobBlock extends BaseElement implements Searchable{


	public function Jobs(){

		$AllAdvertisements = EmployerAdvertisement::get()->filter(array(
			'isPaid' => true, 
			'State'  => 'live'
		))->sort('RAND()');

		$NonFlatRateAds = $AllAdvertisements->filter(array(
			'PackageID' => 2,
			'StartDate:LessThanOrEqual' => date("Y-m-d"),
			'EndDate:GreaterThanOrEqual' => date("Y-m-d"),
		))->sort('RAND()');

		$FlatRateAds = $AllAdvertisements->filter(array(
			'PackageID' => 3,
			'StartDate:LessThanOrEqual' => date("Y-m-d"),
			'Employer.FlatrateEndDate:GreaterThanOrEqual' => date("Y-m-d"),
		))->sort('RAND()');


		$Advertisements = new ArrayList;

		foreach( $NonFlatRateAds as $ad){$Advertisements->push($ad);}
		foreach( $FlatRateAds as $ad){$Advertisements->push($ad);};







		return $Advertisements->sort('RAND()');
	}





}