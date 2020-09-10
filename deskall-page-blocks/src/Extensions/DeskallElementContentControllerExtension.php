<?php


use DNADesign\Elemental\Models\ElementalArea;
use DNADesign\Elemental\Extensions\ElementalAreasExtension;
use SilverStripe\Core\Extension;
use DNADesign\Elemental\Models\BaseElement;

class DeskallElementContentControllerExtension extends Extension
{
    /**
     * @var array
     */
    private static $allowed_actions = array(
        'handleElement',
    );

    public function handleElement()
    {
        $id = $this->owner->getRequest()->param('ID');

        if (!$id) {
            user_error('No element ID supplied', E_USER_ERROR);
            return false;
        }
        $element = BaseElement::get()->byId($id);
         if (!$element) {
            user_error('No element found', E_USER_ERROR);
            return false;
        }
        /** @var SiteTree $elementOwner */
        $elementOwner = $this->owner->data();

        $elementalAreaRelations = $this->owner->getElementalRelations();

        if (!$elementalAreaRelations) {
            user_error(get_class($this->owner) . ' has no ElementalArea relationships', E_USER_ERROR);
            return false;
        }

        // If children block we loop until we find last parent
        while ($element->isChildren()){
            $element = $element->Parent();
        }
        foreach ($elementalAreaRelations as $elementalAreaRelation) {
            $element = $elementOwner->$elementalAreaRelation()->Elements()
                ->filter('ID', $id)
                ->First();

            if ($element) {
                return $element->getController();
            }
        }

        user_error('Element $id not found for this page', E_USER_ERROR);
        return false;
    }
}
