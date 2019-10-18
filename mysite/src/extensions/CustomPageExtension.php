<?php
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Subsites\State\SubsiteState;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class CustomPageExtension extends DataExtension
{
    private static $has_many = ['MenuSections' => MenuSection::class, 'LateralSections' => LateralSection::class];

    private static $owns = ['MenuSections', 'LateralSections'];

    public function updateCMSFields(FieldList $fields){
        $fields->removeByName('MenuSections');
        if ($this->owner->ShowInMainMenu){
            $fields->addFieldToTab('Root.Menu',
                GridField::create('MenuSections','Menu Sektionen',$this->owner->MenuSections(),GridFieldConfig_RecordEditor::create())
            );
        }

        $fields->removeByName('LateralSections');
        $fields->addFieldToTab('Root.Sidebar',
             GridField::create('LateralSections','Sidebar Menu Sektionen',$this->owner->LateralSections(),GridFieldConfig_RecordEditor::create())
        );
        
       
    }
}