<?php


use SilverStripe\Core\Extension;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\View\Requirements;

/**
 * Asset Form Factory extension.
 * Extends the CMS detail form to allow Description.
 *
 * @extends Extension
 */
class DeskallImageAssetFormFactoryExtension extends Extension
{

    /**
     * 
     */
    public function updateFormFields(FieldList $fields, $controller, $formName, $context)
    {

        $image = isset($context['Record']) ? $context['Record'] : null;
        if ($image && $image->appCategory() === 'image') {
            
            $fields->insertBefore(
                'Title',
                 EditImageField::create('Edit','Edit')->setTemplate('EditImageField')
            );
            $fields->insertAfter(
                'Title',
                TextareaField::create('Description',_t('Image.Description','Beschreibung'))
                    ->setDescription(_t('Image.DescriptionLabel','wird im Front End als alt Tag angezeigt.'))
            );
        }
        
        if ($image->getExtension() == "svg"){
            $fields->removeByName('FocusPoint');
        }
    }
}
