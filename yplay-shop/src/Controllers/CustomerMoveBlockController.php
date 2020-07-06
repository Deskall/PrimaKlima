<?php

use SilverStripe\Control\HTTPRequest;
use SilverStripe\View\Requirements;
use DNADesign\Elemental\Controllers\ElementController;

class CustomerMoveBlockController extends ElementController
{
    private static $allowed_actions = ['CheckPartnerForCode'];

    private static $url_handlers = [
        'partner-finden/$Code' => 'CheckPartnerForCode'
    ];


    /**
     * Renders the managed {@link BaseElement} wrapped with the current
     * {@link ElementController}.
     *
     * @return string HTML
     */
    public function forTemplate()
    {
        $defaultStyles = $this->config()->get('default_styles');
        if ($this->config()->get('include_default_styles') && !empty($defaultStyles)) {
            foreach ($defaultStyles as $stylePath) {
                Requirements::css($stylePath);
            }
        }
        $defaultScripts = $this->config()->get('default_scripts');
         if (!empty($defaultScripts)) {
            foreach ($defaultScripts as $jsPath) {
                Requirements::javascript($jsPath);
            }
        }

        $template = $this->element->config()->get('controller_template');

        return $this->renderWith([
            'type' => 'Layout',
            $template
        ]);
    }

    public function CheckPartnerForCode(HTTPRequest $request){
        $code = trim($request->param('Code'));
        if ($code){
            $plz = PostalCode::get()->filter('Code',$code)->first();
            if ($plz){
                $shop = $plz->Shop();
                if ($shop){
                    return json_encode(['shop' => $shop]);
                }
                return json_encode(['message' => 'Es gibt keine Partner für diese Region']);
            }
            return json_encode(['message' => 'Unbekannte Region']);
        }
        return json_encode(['message' => 'Unbekannte Region']);
    }

}