<?php 

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\ORM\DataExtension;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldButtonRow;
use SilverStripe\AssetAdmin\Forms\UploadField;
use SilverStripe\ORM\FieldType\DBField;
use SilverStripe\Assets\Image;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use Symbiote\GridFieldExtensions\GridFieldAddNewInlineButton;
use Symbiote\GridFieldExtensions\GridFieldEditableColumns;

class SiteConfigExtension extends DataExtension 
{
  private static $has_many = [
    'Blocks' => FooterBlock::class
  ];

  private static $has_one = [
    'DefaultSlide' => Image::class
  ];

  public function updateCMSFields(FieldList $fields) {
    
    $FooterLinksField = new GridField(
        'Blocks',
        'Blocks',
        $this->owner->Blocks(),
        GridFieldConfig_RecordEditor::create()->addComponents(new GridFieldOrderableRows('SortOrder'))
        ->addComponent(new GridFieldShowHideAction())
    );
    $fields->addFieldToTab("Root.Footer", $FooterLinksField);
    $fields->addFieldToTab("Root.Default", $fields->fieldByName('Root.Main.DefaultSlide'));
  }

  public function activeFooterBlocks(){
    return $this->owner->Blocks()->filter('isVisible',1);
  }

}