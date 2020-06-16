<?php



use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\DropdownField;

use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldToolbarHeader;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use Symbiote\GridFieldExtensions\GridFieldTitleHeader;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\ORM\GroupedList;

class ProfilParameter extends JobParameter
{
    private static $db = [
      'isGroup' => 'Boolean(0)',
      'groupValuesAZ' => 'Boolean(0)',
      'Weight' => 'Decimal'
    ];

    private static $singular_name = "Profil Parameter";
    private static $plural_name = "Profil Parameter";

    private static $has_one = [
        'Parent' => ProfilParameter::class
    ];

    private static $has_many = [
        'Children' => ProfilParameter::class
    ];

    private static $cascade_duplicates = [
      'Children'
    ];

    private static $cascade_deletes = [
      'Children'
    ];

    private static $summary_fields = [
       'Title',
       'Weight'
    ];


    public function fieldLabels($includerelation = true){
	    $labels = parent::fieldLabels($includerelation);

	    $labels['Parent'] = _t(__CLASS__.'.Parent','Haupt Parameter');
	    $labels['Children'] = _t(__CLASS__.'.Children','Parameters');
	    $labels['isGroup'] = _t(__CLASS__.'.isGroup','Grupp?');
	    $labels['groupValuesAZ'] = _t(__CLASS__.'.groupValuesAZ','Werte alphabetisch gruppieren?');
      $labels['Weight'] = _t(__CLASS__.'.Weight','% Gewicht');
	  

	    return $labels;
    }

   

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        //Weight
        if ($this->Weight == 0){
          if ($this->Parent()->exists()){
            $children = $this->Parent()->Children();
            $i = $children->count();
            $p = 100;
            foreach ($children as $child) {
              if ($child->Weight > 0){
                $p -= $child->Weight; 
                $i--;
              }
             
            }
            $this->Weight = $p / $i;
          }
        }
       
    }

    public function onAfterWrite()
    {
       
        parent::onAfterWrite();
       
    }

    public function relativeWeight(){
      $weight = $this->Weight / 100;
      $parent = $this->Parent();
      while($parent->exists()){
        $weight = $weight * ($parent->weight / 100);
        $parent = $parent->Parent();
      }
      return $weight;
    }



    public function getCMSFields()
    {
       $fields = parent::getCMSFields();
       $fields->removeByName('ParentID');
       $fields->removeByName('Children');
       $fields->removeByName('Values');
      
       if ($this->ID > 0){
       	$fields->fieldByName('Root.Main.FieldType')->hideIf('isGroup')->isChecked()->end();
       	$fields->fieldByName('Root.Main.Required')->hideIf('isGroup')->isChecked()->end();
       	if ($this->isGroup){
       		$fields->removeByName('groupValuesAZ');
       		$config = 
       		 GridFieldConfig_RecordEditor::create()
       		 ->addComponent(new GridFieldDuplicateAction())
       		 ->addComponent(new GridFieldOrderableRows('Sort'))
       		 ->addComponent(new GridFieldShowHideAction());

       		 $parametersField = new GridField('Children',_t(__CLASS__.'.Children','Parameters'),$this->Children(),$config);
       		 $fields->addFieldToTab('Root.Main',$parametersField);
       	}
       	else{
       		$config = 
       		 GridFieldConfig::create()
       		 ->addComponent(new GridFieldButtonRow('before'))
       		 ->addComponent(new GridFieldToolbarHeader())
       		 ->addComponent(new GridFieldTitleHeader())
       		 ->addComponent(new GridFieldEditableColumns())
       		 ->addComponent(new GridFieldDeleteAction())
       		 ->addComponent(new GridFieldAddNewInlineButton())
       		 ->addComponent(new GridFieldOrderableRows('Sort'));
       		 if (singleton('JobParameterValue')->hasExtension('Activable')){
       		      $config->addComponent(new GridFieldShowHideAction());
       		 }

       		 $valuesField = new GridField('Values',_t(__CLASS__.'.Values','Werte'),$this->Values(),$config);
       		 $fields->addFieldToTab('Root.Main',$valuesField);
       	}
       }
       return $fields;
    }

    public function GroupedValues(){
    	return GroupedList::create($this->Values()->sort('Title'));
    }


}