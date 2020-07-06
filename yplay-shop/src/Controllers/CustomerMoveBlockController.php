<?php

use SilverStripe\Control;\HTTPRequest;
use SilverStripe\View\Requirements;

class CustomerMoveBlockController extends BlockController
{
    private static $allowed_actions = ['CheckPartnerForCode'];

    private static $url_handlers = [
        'partner-finden/$Code' => 'CheckPartnerForCode'
    ];

    public function forTemplate(){
        Requirements::javascript('yplay-shop/javascript/customermove.js');
        return parent::forTemplate();
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