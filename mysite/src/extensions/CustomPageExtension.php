<?php
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Subsites\State\SubsiteState;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class CustomPageExtension extends DataExtension
{

    private static $many_many = [ 'LateralSections' => LateralSection::class];

    private static $owns = ['LateralSections'];

    public function updateCMSFields(FieldList $fields){
        $fields->removeByName('LateralSections');
        $fields->addFieldToTab('Root.Sidebar',
             GridField::create('LateralSections','Sidebar Menu Sektionen',$this->owner->LateralSections(),GridFieldConfig_RelationEditor::create()->addComponent(new GridFieldOrderableRows('Sort'))->addComponent(new GridFieldShowHideAction())->addComponent(new GridFieldDeleteAction()))
        );
        
    }

    public function ConfiguratorPage(){
        return ConfiguratorPage::get()->first();
    }

    public function ShopPage(){
        return ShopPage::get()->first();
    }
}