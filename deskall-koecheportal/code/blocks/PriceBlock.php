<?php
use DNADesign\Elemental\Models\BaseElement;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\NumericField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;

class PriceBlock extends BaseElement implements Searchable{

	private static $db = array(
		'Lead' => 'HTMLText',
	);


	public function getCMSFields()
	{
		$fields = parent::getCMSFields();



		$fields->addFieldToTab('Root.Main', HTMLEditorField::create('Lead', _t('TextBlock.Lead', 'Lead'))->setRows(10) );
		$this->extend('updateCMSFields', $fields);

		return $fields;
	}



	public function PackageData() {


		$Packages = Package::get();
		$featuresSRC = array();

		foreach ( PackageConfigItem::get() as $feature ) {
			$featuresSRC[ 'ftr-'.$feature->ID ] = $feature->Title__de_DE;
		}


		$data = new ArrayList([
			new ArrayData([
				'Title' 	=> '',
				'RunTime' 	=> 'Laufzeit',
				'NumOfAds'	=> 'Anzahl Stelleninserate',
				'Features'  => PackageConfigItem::get()
			]),
		]);

		foreach ($Packages as $Package ) {

			$Features = new ArrayList();

			$linked_featrues = array();
			foreach ($Package->Features() as $feature ) {
				array_push($linked_featrues, $feature->ID );
			}

			foreach ($featuresSRC as $featrueKey => $featrueVal ) {
				if( in_array(intval(substr($featrueKey, 4)), $linked_featrues ) ){
					$Features->push( new ArrayData(array(
						'Title__de_DE' => 'y'
					)));
				}else{
					$Features->push( new ArrayData(array(
						'Title__de_DE' => 'n'
					)));
				}
			}

			
			if( $Package->PackegeOptions() ){
				$PriceOptions = new ArrayList();

				foreach ( $Package->PackegeOptions() as $Option ) {
					$PriceOptions->push(new ArrayData(array(
						'Title' => $Option->Title__de_DE,
						'Price' => $Option->Price,
					)));
				}
			}else{
				$PriceOptions = [];
			}





			$data->push(
				new ArrayData(array(
					'Title' 	=> $Package->Title__de_DE,
					'PackageCode' 	=> strtolower( $Package->Title__de_DE ),
					'RunTime' 	=> $Package->RunTimeTitle__de_DE,	
					'NumOfAds'	=> $Package->NumOfAdsTitle__de_DE,
					'Features'  => $Features,
					'Price'		=> $Package->GetFinalPrice(),
					'PriceOptions'  => $PriceOptions,
				))
			);
		}




//		$data = new ArrayList([
//			new ArrayData([
//				'title' 	=> '',
//				'duration' 	=> 'Laufzeit',
//				'num'		=> 'Anzahl Stellen inserat',
//			]),
//			new ArrayData([
//				'title' 	=> $Packages[0]->TItle__de_DE,
//				'duration' 	=> '6 Wochen',
//				'num'		=> '1 Anzeige',
//			]),
//			new ArrayData([
//				'title' 	=> 'Silber',
//				'duration' 	=> '6 Wochen',
//			]),
//			new ArrayData([
//				'title' 	=> 'Gold',
//				'duration' 	=> '3 Monate, 6 MOnate oder 12 Monate',
//				'num'		=> 'Unbegrenzt',
//			]),
//
//		]);






		return $data;



	}


}

