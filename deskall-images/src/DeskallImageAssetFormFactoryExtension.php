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
            Requirements::css("deskall-images/css/toast-ui/tui-image-editor.min.css");
            Requirements::javascript("deskall-images/javascript/toast-ui/tui-image-editor.min.js");
            
            $fields->insertBefore(
                'Title',
                 EditImageField::create('Edit','<button id="edit-image" data-id="'.$image->ID.'">'._t('Image.Edit','Bild bearbeiten').'</button>')
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
