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
        Requirements::css("css/toast-ui/tui-image-editor.css");
        Requirements::javascript("javascript/toast-ui/tui-image-editor.js");

        $image = isset($context['Record']) ? $context['Record'] : null;
        if ($image && $image->appCategory() === 'image') {
            $fields->insertBefore(
                'Title',
                LiteralField::create('EditButton','<button id="edit-image" data-id="'.$image->ID.'">'._t('Image.Edit','Bild bearbeiten').'</button>')
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
