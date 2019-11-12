<?php
use DNADesign\Elemental\Models\BaseElement;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\FieldType\DBField;

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


	 public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Topjob Block');
    }

    /************* SEARCHABLE FUNCTIONS ******************/


        /**
         * Filter array
         * eg. array('Disabled' => 0);
         * @return array
         */
        public static function getSearchFilter() {
            return array();
        }

        /**
         * FilterAny array (optional)
         * eg. array('Disabled' => 0, 'Override' => 1);
         * @return array
         */
        public static function getSearchFilterAny() {
            return array();
        }


        /**
         * Fields that compose the Title
         * eg. array('Title', 'Subtitle');
         * @return array
         */
        public function getTitleFields() {
            return array('Title');
        }

        /**
         * Fields that compose the Content
         * eg. array('Teaser', 'Content');
         * @return array
         */
        public function getContentFields() {
            return array('HTML');
        }
    /************ END SEARCHABLE ***************************/


}