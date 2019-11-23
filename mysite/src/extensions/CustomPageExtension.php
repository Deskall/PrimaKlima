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
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class CustomPageExtension extends DataExtension
{
    private static $has_many = ['MenuSections' => MenuSection::class, 'LateralSections' => LateralSection::class];

    private static $owns = ['MenuSections', 'LateralSections'];

    public function updateCMSFields(FieldList $fields){
        $fields->removeByName('MenuSections');
        if ($this->owner->ShowInMainMenu){
            $fields->addFieldToTab('Root.Menu',
                GridField::create('MenuSections','Menu Sektionen',$this->owner->MenuSections()->filter('ClassName',MenuSection::class),GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction()))
            );
        }

        $fields->removeByName('LateralSections');
        $fields->addFieldToTab('Root.Sidebar',
             GridField::create('LateralSections','Sidebar Menu Sektionen',$this->owner->LateralSections(),GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction()))
        );
        
    }

    public function ConfiguratorPage(){
        return ConfiguratorPage::get()->first();
    }

    public function ShopPage(){
        return ShopPage::get()->first();
    }

    public function ativeMenuSections(){
        return $this->MenuSections()->filter(['ClassName' => MenuSection::class, 'isVisible' => 1]);
    }
}