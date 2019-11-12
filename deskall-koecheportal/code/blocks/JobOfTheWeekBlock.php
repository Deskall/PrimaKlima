<?php
use DNADesign\Elemental\Models\BaseElement;
use g4b0\SearchableDataObjects\Searchable;
use SilverStripe\Forms\NumericField;

class JobOfTheWeekBlock extends BaseElement implements Searchable{

	private static $db = array(
		'NumOfJobs' => 'Int',
	);



	public function getCMSFields()
	{
		$fields = parent::getCMSFields();



		$fields->addFieldToTab('Root.Main', NumericField::create('NumOfJobs', _t('Block.NumOfJobs', 'NumOfJobs')));


		return $fields;
	}





	public function Jobs(){

		$Advertisements = EmployerAdvertisement::get()->filter(array(
			'isPaid' => true, 
			'State'  => 'live',
			'PackageID' => 3,
			'JobOfTheWeekdEndDate:GreaterThanOrEqual' =>  date("Y-m-d"),
		))->sort('StartDate')->Limit( $this->NumOfJobs );

		$JobOfTheWeekAdvertisements = new ArrayList;


		foreach( $Advertisements as $ad){$JobOfTheWeekAdvertisements->push($ad);}


		if( $this->NumOfJobs > sizeof( $JobOfTheWeekAdvertisements->toArray() ) ){

			$NewAdds = EmployerAdvertisement::get()->where("\"JobOfTheWeekdEndDate\" IS NULL OR \"JobOfTheWeekdEndDate\" = ''")

			->filter(array(
				'isPaid' => true, 
				'State'  => 'live',
				'PackageID' => 3,
				'EndDate:GreaterThanOrEqual' =>  date("Y-m-d"),

			))
			->sort('StartDate ASC')->Limit( $this->NumOfJobs - sizeof( $Advertisements->toArray() ) );

			foreach ($NewAdds->toArray() as $Ad) {
				$date = new DateTime($this->StartDate);
				$date->modify("+ 7 days");
				$Ad->JobOfTheWeekdEndDate =  $date->format("Y-m-d");
				$Ad->write();
				$JobOfTheWeekAdvertisements->push( $Ad );
			}
		}

		if( $this->NumOfJobs > sizeof( $JobOfTheWeekAdvertisements->toArray() ) ){

			$NewAdds = EmployerAdvertisement::get()->filter(array(
				'isPaid' => true, 
				'State'  => 'live',
				'PackageID' => 3,
				'EndDate:GreaterThanOrEqual' =>  date("Y-m-d"),

			))
			->sort('StartDate ASC')->Limit( $this->NumOfJobs - sizeof( $Advertisements->toArray() ) );

			foreach ($NewAdds->toArray() as $Ad) {
				$date = new DateTime($this->StartDate);
				$date->modify("+ 7 days");
				$Ad->JobOfTheWeekdEndDate =  $date->format("Y-m-d");
				$Ad->write();
				$JobOfTheWeekAdvertisements->push( $Ad );
			}


		}





		return $JobOfTheWeekAdvertisements->Limit($this->NumOfJobs)->sort('RAND()');
	}



 public function getSummary()
    {
        return DBField::create_field('HTMLText', $this->HTML)->Summary(20);
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Jobs der Woche');
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