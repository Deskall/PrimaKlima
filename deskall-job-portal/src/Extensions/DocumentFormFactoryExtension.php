<?php


use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Security\Group;
use SilverStripe\Forms\TextareaField;

/**
 *
 * @extends Extension
 */
class DocumentFormFactoryExtension extends Extension
{


    public function updateFormFields(FieldList $fields, $controller, $formName, $context)
    {
        
        $file = isset($context['Record']) ? $context['Record'] : null;
        if ($file ) {
            if ($file->RootFolder() && $file->RootFolder()->Name == "Secure"){
                 $fields->insertAfter(
                    'Name',
                    TextareaField::create('Description',_t("File.Description","Beschreibung"))
                );

                $fields->insertAfter(
                    'EditorGroups',
                    ListboxField::create('Readers',_t("File.ShareWithPartners","Teilen Sie diese Datei mit folgenden Mitarbeitern"), $file->PossibleReaders()->map('ID','Title')->toArray(), $file->Readers())
                );
              
                $fields->removeByName('EditorGroups');
                $fields->removeByName('ViewerGroups');
                $fields->removeByName('CanViewType');
                $fields->removeByName('CanEditType');
            }
      
        }
    }

}
