<?php

use SilverStripe\CMS\Controllers\ContentController;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\FieldType\DBHTMLText;

class PortfolioController extends ContentController
{

    private static $allowed_actions = ['fetchReference'];

    private static $url_handlers = [
        'detail/$ID' => 'fetchReference'
    ];


    public function fetchReference(HTTPRequest $request){
        $id = $request->param('ID');
        $ref = PortfolioClient::get()->byId($id);
        if ($ref){
            return $ref->renderWith('Includes/PortfolioClient');
        }
       
        return DBHTMLText::create()->setValue('<p>Referenz nicht gefunden...</p>');
    }

    
}
