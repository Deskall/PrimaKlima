<?php

use SilverStripe\ORM\DataExtension;


class DeskallShopPageExtension extends DataExtension
{
    public function ShopPage(){
        return ShopPage::get()->first();
    }
}