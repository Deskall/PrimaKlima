<?php
use SilverStripe\ORM\DataObject;
use SilverStripe\Assets\Image;
use SilverStripe\Assets\File;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class EventDate extends DataObject{

    private static $singular_name = 'Termin';

    private static $plural_name = 'Termine';

    private static $db = [
        'Title' => 'Text',
        'Description' => 'HTMLText',
        'Price' => 'Currency'
    ];

    private static $has_one = [
    	'Event' => Event::class
    ];

    private static $has_many = [
        'Orders' => Order::class
    ];

    private static $many_many = [
        'Participants' => Participant::class
    ];

    private static $many_many_extraFields = [
        'Participants' => ['paid' => 'Boolean(0)']
    ];


    private static $extensions = [
        'Activable',
        'Sortable'
    ];

    private static $summary_fields = [
        'Date',
        'City',
        'Price',
        'Places',
        'Participants.count' => ['title' => 'Teilnehmer'],
        'ConfirmedParticipants' => ['title' => 'Teilnehmer (bezahlt)']
    ];

    function fieldLabels($includerelations = true) {
        $labels = parent::fieldLabels($includerelations);
     
        $labels['Date'] = _t(__CLASS__.'.Date','Datum');
        $labels['City'] = _t(__CLASS__.'.City','Ort');
        $labels['Places'] = _t(__CLASS__.'.Places','Plätze zur Verfügung');
        $labels['isOpen'] = _t(__CLASS__.'.isOpen','ist Anmeldung möglich?');
        $labels['isFull'] = _t(__CLASS__.'.isFull','ist ausgebucht?');
        $labels['Price'] = _t(__CLASS__.'.Price','Preis');
        $labels['Main'] = _t(__CLASS__.'.Main','Haupt');
        $labels['Orders'] = _t(__CLASS__.'.Participants','Teilnehmer');
     
        return $labels;
    }


    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->removeByName('Participants');
        $fields->FieldByName('Root.Main')->setTitle('Termin Angaben');
        $fields->FieldByName('Root.Orders.Orders')->getConfig()
        ->removeComponentsByType([
            GridFieldEditButton::class,
            GridFieldAddNewButton::class,
            GridFieldAddExistingAutocompleter::class
        ])
        ->addComponent(new GridFieldDeleteAction())->addComponent(new GridFieldPaidAction());
        // $grid = $fields->FieldByName('Root.Participants.Participants');
        // $config = $grid->getConfig();
        // $columns = $config->getComponentByType(GridFieldDataColumns::class)->setDisplayFields([
        //     'Title' => ['title' => 'Name'],
        //     'printAddress' => ['title' => 'Adresse'],
        //     'paid' => ['title' => 'Bezahlt?']
        // ]);
        return $fields;
    }

    public function getConfirmedParticipants(){
        $num = $this->Participants()->filter('paid',1)->count();
        return DBField::create_field('Int',$num);
    }

    public function RegisterLink(){
        return 'seminare/anmeldung/'.$this->Event()->URLSegment.'/'.$this->ID;
    }

    public function getOrderPrice(){
        setlocale(LC_MONETARY, 'de_DE');
        return DBField::create_field('Varchar',money_format('%i',$this->Price));
    }

    public function getOrderPriceNetto(){
        $price = $this->Price * 100 / 107.7;
        setlocale(LC_MONETARY, 'de_DE');
        return DBField::create_field('Varchar',money_format('%i',$price));
    }

    public function getOrderMwSt(){
        $price = $this->Price - ($this->Price * 100 / 107.7);
        setlocale(LC_MONETARY, 'de_DE');
        return DBField::create_field('Varchar',money_format('%i',$price));
    }
}
