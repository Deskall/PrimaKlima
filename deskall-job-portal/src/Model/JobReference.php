<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\TextField;

class JobReference extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'Subtitle' => 'Varchar',
        'HourPay' => 'Varchar',
        'HourPayCustomer' => 'Varchar'
    );

    private static $singular_name = "Beruf";
    private static $plural_name = "Berufe";


    private static $has_many = [
        'Options' => JobReferenceOption::class
    ];

    private static $summary_fields = [
        'Title',
        'HourPay',
        'HourPayCustomer'
    ];


    public function fieldLabels($includerelation = true){
    $labels = parent::fieldLabels($includerelation);
    $labels['Title'] = _t(__CLASS__.'.Title','Beruf');
    $labels['Subtitle'] = _t(__CLASS__.'.Subtitle','Zusatz');
    $labels['HourPay'] = _t(__CLASS__.'.HourPay','Stundensatz (Koch)');
    $labels['HourPayCustomer'] = _t(__CLASS__.'.HourPayCustomer','Stundensatz (Für Kunde im Angebot)');

    return $labels;
    }

    public function FullTitle(){
        $title = $this->Title;
        if ($this->Subtitle){
            $title .= " (".$this->Subtitle.")";
        }
        return $title;
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
       
    }

    public function onAfterWrite()
    {
       
        parent::onAfterWrite();
       
    }



    public function getCMSFields()
    {
       $fields = parent::getCMSFields();
       $fields->removeByName('Options');
       
       if ($this->ID > 0){
        $config = 
            GridFieldConfig::create()
            ->addComponent(new GridFieldToolbarHeader())
            ->addComponent(new GridFieldTitleHeader())
             ->addComponent(new GridFieldButtonRow())
            ->addComponent(new GridFieldEditableColumns())
            ->addComponent(new GridFieldAddNewInlineButton());
            
            $config->getComponentByType(GridFieldEditableColumns::class)->setDisplayFields(array(
                
                'Title' => array(
                    'title' => 'Titel',
                    'callback' => function($record, $column, $grid) {
                        return TextField::create($column);
                    }
                ),
                'HourPay' => array(
                    'title' => 'Stundensatz (Koch)',
                    'callback' => function($record, $column, $grid) {
                        $field = TextField::create($column);
                        return $field;
                    }
                ),
                'HourPayCustomer' => array(
                    'title' => 'Stundensatz (Kunde)',
                    'callback' => function($record, $column, $grid) {
                        $field = TextField::create($column);
                        return $field;
                    }
                )
            ));
        $fields->addFieldToTab('Root.Main',new GridField('Options',_t(__CLASS__.'.Options','Optionen'),$this->Options(),$config));
       }

       return $fields;
    }


}