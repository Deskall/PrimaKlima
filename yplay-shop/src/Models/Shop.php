<?php
use SilverStripe\ORM\DataObject;

class Shop extends DataObject{

	private static $singular_name = 'Shop';
	private static $plural_name = 'Shops';

	private static $db = [
		'Title' => 'Varchar',
		'AdresseTitle' => 'Varchar',
		'Adresse' => 'Varchar',
		'PLZ' => 'Varchar',
		'City' => 'Varchar',
		'Offnungszeiten' => 'HTMLText',
		'Lat' => 'Decimal',
		'Lng' => 'Decimal',
		'Ref' => 'Int'
	];

	private static $default_sort = ['Title' => 'ASC'];

	private static $summary_fields = ['Title','AdresseTitle','Adresse','PLZ','City'];

	public function fieldLabels($includerelations = true){
		$labels = parent::fieldLabels($includerelations);

		$labels['Title'] = _t(__CLASS__.'.Title','Shop Titel');
		$labels['AdresseTitle'] = _t(__CLASS__.'.AdresseTitle','Adresse Titel');
		$labels['Adresse'] = _t(__CLASS__.'.Adresse','Adresse');
		$labels['PLZ'] = _t(__CLASS__.'.PLZ','PLZ');
		$labels['City'] = _t(__CLASS__.'.City','Stadt');
		$labels['Offnungszeiten'] = _t(__CLASS__.'.Offnungszeiten','Öffnungszeiten');

		return $labels;
	}

	public function getCMSFields(){
		$fields = parent::getCMSFields();
		$fields->removeByName('Lat');
		$fields->removeByName('Lng');
		$fields->removeByName('Ref');
		return $fields;
	}

	public function onBeforeWrite(){
		parent::onBeforeWrite();
		if ($this->isChanged()){
			$this->geolocalise();
		}
	}

	 public function geolocalise(){
        $address = $this->Adresse.', '.$this->PLZ.' '.$this->City.' schweiz';
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&key=AIzaSyA2DzCjeU3-MRVYWG2hwRxFMfMNPhwuFyU');
        $output= json_decode($geocode);
        if ($output->results[0]){
            $this->Lat = $output->results[0]->geometry->location->lat;
           $this->Lng = $output->results[0]->geometry->location->lng;
        }
        
    }

    public function getInfoWindow(){
    	$html = '<div><strong>'.$this->Title.'</strong><br/>'.
        '<p class="uk-margin-small-bottom">'.$this->AdresseTitle.'<br/>'.
            $this->Adresse.'<br/>'.
            $this->PLZ.' '.$this->City.'</p>'.
            '<p><a href="#shop-'.$this->ID.'" data-uk-scroll="offset:100">Details</a></p>';

        return $html;
    }

}