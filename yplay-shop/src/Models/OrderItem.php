<?php
use SilverStripe\ORM\DataObject;

class OrderItem extends DataObject {

    private static $singular_name = "Artikel";
    private static $plural_name = "Artikeln";

    private static $db = array(
        'Type' => 'Varchar(255)',
        'Title' => 'Varchar(255)',
        'SaleTitle' => 'Varchar(255)',
        'SaleAddon' => 'HTMLText',
        'Quantity' => 'Int',
        'SubTitle' => 'Varchar(255)',
        'MonthlyPrice' => 'Currency',
        'UniquePrice' => 'Currency',
        'UniquePriceLabel' => 'Varchar',
        'ActivationPrice' => 'Currency',
        'ActivationPriceLabel' => 'Varchar',
        'CreatedFromAdmin' => 'Boolean(0)'
    );

    private static $has_one = array(
        'Order' => ShopOrder::class,
        'Package' => Package::class,
        'Product' => Product::class
    );

    private static $summary_fields = array(
        'NiceType' => 'Typ',
        'Title' => 'Titel',
        'MonthlyPrice' => 'Monatlicherpreis',
        'UniquePrice' => 'Einmaligerpreis',
        'ActivationPrice' => 'Aufschaltgebühr',
        'Quantity' => 'Anzahl'
    );



    public function ShopConfig(){
        return ShopConfig::get()->first();
    }

    public function NiceType(){
        switch($this->Type){
            case "Product":
             return "Produkt";
            break;
            case "Package":
             return "Paket";
            break;
            case "Accessory":
             return "Zubehör";
            case "SmartCard":
             return "SmartCard";
            case "PayTV":
             return "PayTV";
            break;
            case "Fee":
             return "Gebühr";
            break;
            case "OffProduct":
             return "Entfernt Produkt";
            break;
        }
    }

    public function getPrice(){
        return floatval($this->MonthlyPrice*$this->Quantity);
    }

    public function totalUniquePrice(){
        return floatval($this->UniquePrice*$this->Quantity);
    }

    public function createFromProduct($product,$quantity = 1,$included = false,$customer = null){
        $this->Type = "Product";
        $this->ProductID = $product->ID;
        $this->Title = $product->Title;
        $this->SubTitle = $product->SubTitle;
        $this->MonthlyPrice = $product->getMonthlyPrice();
        $this->UniquePrice = $product->getPriceUnique();
        $this->ActivationPrice = $product->getFees();
        $this->UniquePriceLabel = $product->UniquePriceLabel;
        $this->ActivationPriceLabel = $product->ActivationPriceLabel;
        $this->Quantity = $quantity;
        $this->write();
    }

    public function removeFromPackage($product){
        $this->Type = "OffProduct";
        $this->ProductID = $product->ID;
        $this->Title = $product->Title;
        $this->SubTitle = $product->SubTitle;
        $this->MonthlyPrice = - $product->getMonthlyPrice();
        $this->UniquePrice = - $product->getPriceUnique();
        $this->ActivationPrice = - $product->getFees();
        $this->Quantity = 1;
        $this->write();
    }

    public function createFromPayTV($product){
        $this->Type = "PayTV";
        $this->PayTVPackageID = $product->ID;
        $this->Title = $product->Title;
        $this->SubTitle = $product->SubTitle;
        $this->MonthlyPrice = $product->getMonthlyPrice();
        $this->Quantity = 1;
        $this->write();
    }

    public function createFromSmartCard($product){
        $this->Type = "SmartCard";
        $this->ProductSmartCardOptionID = $product->ID;
        $this->Title = $product->Title;
        $this->SubTitle = $product->SubTitle;
        $this->UniquePrice = $product->getPriceUnique();
        $this->Quantity = 1;
        $this->write();
    }

    public function createFromPackage($package,$customer = null){
        $this->Type = "Package";
        $this->PackageID = $package->ID;
        $this->Title = $package->Title;
        $this->SaleTitle = $package->SaleTitle;
        $this->SaleAddon = $package->SaleAddon;
        $this->SubTitle = $package->SubTitle;
        $this->MonthlyPrice = $package->getMonthlyPrice();
        $this->UniquePrice = $package->getPriceUnique();
        $this->UniquePriceLabel = $package->UniquePriceLabel;
        $this->ActivationPrice = $package->getFees();
        $this->ActivationPriceLabel = $package->ActivationPriceLabel;
        $this->Quantity = 1;
        $this->write();
    }

     public function createFromAccessory($accessory, $quantity){
        $this->Type = "Accessory";
        $this->AccessoryID = $accessory->ID;
        $this->Title = $accessory->Title;
        $this->SubTitle = $accessory->SubTitle;
        if ($accessory->MonthlyPrice > 0){
           $this->MonthlyPrice = $accessory->FrontendPrice();
        }
        else {
            $this->UniquePrice = $accessory->FrontendPrice();
        }
        $this->Quantity = $quantity;
        $this->write();
    }

    public function htmlEscaped($var){
        return strip_tags($var);
    }

    // public function getCMSFields(){
    //     $fields = FieldList::create();
    //     $fields->push($type = DropdownField::create('Type','Art des Artikel',array ('Package' => 'Pakete','Product' => 'Produkt','Accessory' => 'Zubehör','AccessoryMultiple' => 'Zubehöre (mehrere)','SmartCard' => 'SmartCard','PayTV' => 'PayTV Pakete', 'OffProduct' => 'Artikel entfernen'))->setEmptyString('Bitte Art auswählen'));
    //     $fields->push(HiddenField::create('CreatedFromAdmin')->setValue(true));
    //      if($this->OrderID > 0 && $this->Type){
    //         //if already a package we block adding another one
    //         if ($this->Order()->Items()->filter('Type','Package')->count() > 0){
    //             $source = $type->getSource();
    //             unset( $source['Package']);
    //             $type->setSource($source);
    //         }

    //         $connectionType = $this->Order()->Connectiontype;
    //         if (!$connectionType && $this->Order()->TVConnection){
    //             $connectionType = ($this->Order()->TVConnection == "GlasfaserDose") ? "FTTH" : "COAX";
    //         }
    //         $subsiteID = $this->Order()->SubsiteID;
    //         $packages = ($connectionType) ? Package::get()->filter(array('Availability' => array('Immer',$connectionType), 'SubsiteID' => $subsiteID)) : Package::get()->filter(array('SubsiteID' => array(0,$subsiteID))) ;
    //         if ($this->Type == "OffProduct"){
    //             if ($this->Order()->Items()->filter('Type','Package')->count() > 0){
    //                 $ids = array();
    //                 foreach ($this->Order()->Items()->filter('Type','Package') as $item) {
    //                     $ids = ManyManyList::create('Product','Package_Products','ProductID','PackageID',array('Alterable' => 'Boolean(0)','Active' => 'Boolean(0)'))->filter(array('Alterable' => true, 'Active' => true, 'PackageID' => $item->PackageID))->column('ID');
    //                 }
    //                 $products = Product::get()->filter('ID',$ids);
    //             }
    //         }
    //         else{
    //             $assignedProducts = $this->Order()->Items()->filter('Type','Product')->column('ProductID');
    //             $products = Product::get()->filter(array('Availability' => array('beide',$connectionType), 'SubsiteID' => $subsiteID))->exclude('ID',$assignedProducts);

    //             //Filtering partner only product/package if relevant
    //             if (Member::currentUser() && Member::currentUser()->inGroup('partner-ligh')){
    //                 $toExcludeId = ManyManyList::create('Product','Product_Members','ProductID','MemberID')->column('ID');
    //                 $toIncludeId = ManyManyList::create('Product','Product_Members','ProductID','MemberID')->filter('MemberID',Member::currentUser()->ID)->column('ID');
    //                 $ids = array_diff($toExcludeId, $toIncludeId);
    //                 $products = (count($ids) > 0) ? $products->exclude('ID',$ids) : null;

    //                 $toExcludeId = ManyManyList::create('Package','Package_Members','PackageID','MemberID')->column('ID');
    //                 $toIncludeId = ManyManyList::create('Package','Package_Members','PackageID','MemberID')->filter('MemberID',Member::currentUser()->ID)->column('ID');
    //                 $ids = array_diff($toExcludeId, $toIncludeId);
    //                 $packages = (count($ids) > 0) ? $packages->exclude('ID',$ids) : null;

    //             }
    //         }

    //         if ( $packages ){
    //             //Removing flashcable only product if not relevant
    //             if (Subsite::currentSubsiteID() > 0 || Member::currentUser()->inGroup('partner-ligh')){
    //                 $packages = $packages->exclude('onlyForMainSite',1);
    //             }
    //             $packages = $packages->sort('SortOrder')->map('ID','Title');
    //         }
    //         if ($products){
    //             if (Subsite::currentSubsiteID() > 0 || Member::currentUser()->inGroup('partner-ligh')){
    //                 $products = $products->exclude('onlyForMainSite',1);
    //             }
    //             $products = $products->sort('SortOrder')->map('ID','Title');
    //         }
    //         $accessories = ProductAccessory::get()->filter(array('Availability' => array('beide',$connectionType)))->sort('SortOrder');

    //         $PayTVPackages = ProductPayTVPackage::get()->sort('SortOrder');
    //         $SmartCardOptions = ProductSmartCardOption::get()->sort('SortOrder');
    //         $fields->push($packageFields = DropdownField::create('PackageID','Pakete',$packages)->setEmptyString('Bitte Pakete auswählen'));
    //         $fields->push($productFields = DropdownField::create('ProductID','Produkt',$products)->setEmptyString('Bitte Produkt auswählen'));
    //         $fields->push($accessoryFields = DependentDropDownField::create('AccessoryID','Zubehör', array('OrderItem','getAccessories'))->setDepends($type)->setEmptyString('Bitte Zubehör auswählen'));
    //         $fields->push($paytvFields = DropdownField::create('PayTVPackageID','PayTV Pakete',$PayTVPackages->map('ID','Title'))->setEmptyString('Bitte PayTV Pakete auswählen'));
    //         $fields->push($smartcardOptionFields = DropdownField::create('ProductSmartCardOptionID','SmartCard Option',$SmartCardOptions->map('ID','Title'))->setEmptyString('Bitte SmartCard Option auswählen'));
    //         $fields->push($quantity = NumericField::create('Quantity','Anzahl')->setValue(1));
           

    //       //  $fields->push($smartcardFields = GridField::create('PayTVPackageID','PayTV Pakete',$PayTVPackages)->setEmptyString('Bitte PayTV Pakete auswählen'));

    //         $packageFields->displayIf('Type')->isEqualTo('Package');
    //         $productFields->displayIf('Type')->isEqualTo('Product')->orIf('Type')->isEqualTo('OffProduct');
    //         $smartcardOptionFields->displayIf('Type')->isEqualTo('SmartCard');
    //         $accessoryFields->displayIf('Type')->isEqualTo('Accessory')->orIf('Type')->isEqualTo('AccessoryMultiple');
    //         $quantity->displayIf('Type')->isEqualTo('AccessoryMultiple');
    //         $paytvFields->displayIf('Type')->isEqualTo('PayTV');
    //     }
    //     return $fields;
    // }

    public function onBeforeWrite(){
        parent::onBeforeWrite();
        if ($this->CreatedFromAdmin){
            switch ($this->Type) {
                case 'Package':
                    $this->Title = $this->Package()->Title;
                    $this->SubTitle = $this->Package()->SubTitle;
                    $this->MonthlyPrice = $this->Package()->getMonthlyPrice();
                    $this->UniquePrice = $this->Package()->getPriceUnique();
                    if (!$this->Order()->ExistingCustomer){
                        $this->UniquePrice += $this->Package()->getFees();
                    }
                    $this->Quantity = 1;
                    if(!$this->Order()->Title){
                        $this->Order()->Title = $this->Package()->Title;
                    }
                    break;
                case 'Product':
                    $this->Title = $this->Product()->Title;
                    $this->SubTitle = $this->Product()->SubTitle;
                    $this->MonthlyPrice = $this->Product()->getMonthlyPrice();
                    $this->UniquePrice = $this->Product()->getPriceUnique();
                    if (!$this->Order()->ExistingCustomer){
                        $this->UniquePrice += $this->Product()->getFees();
                    }
                    $this->Quantity = 1;
                    //Related Products
                    if($this->ID > 0){
                        if($this->Product()->RelatedProducts()){
                            foreach ($this->Product()->RelatedProducts() as $product) {
                                $item = new OrderItem();
                                $item->createFromProduct($product);
                                $this->Order()->Items()->add($item);
                            }
                        }
                        //Related Accessories
                        if($this->Product()->RelatedAccessories()){
                            foreach ($this->Product()->RelatedAccessories() as $accessory) {
                                $item = new OrderItem();
                                $item->createFromAccessory($accessory);
                                $this->Order()->Items()->add($item);
                            }
                        }
                    }
                    break;
                case 'Accessory':
                    $this->Title = $this->Accessory()->Title;
                    $this->SubTitle = $this->Accessory()->SubTitle;
                    $this->MonthlyPrice = ($this->Accessory()->MonthlyPrice) ? $this->Accessory()->FrontendPrice() : 0;
                    $this->UniquePrice = ($this->Accessory()->MonthlyPrice) ? 0 : $this->Accessory()->FrontendPrice();
                    $this->Quantity = 1;
                    break;
                case 'AccessoryMultiple':
                    $this->Title = $this->Accessory()->Title." * ".$this->Quantity;
                    $this->SubTitle = $this->Accessory()->SubTitle;
                    $this->MonthlyPrice = ($this->Accessory()->MonthlyPrice) ? $this->Accessory()->FrontendPrice() * $this->Quantity : 0;
                    $this->UniquePrice = ($this->Accessory()->MonthlyPrice) ? 0 : $this->Accessory()->FrontendPrice() * $this->Quantity;
                    break;
                case 'SmartCard':
                    $this->Title = $this->ProductSmartCardOption()->Title;
                    $this->SubTitle = $this->ProductSmartCardOption()->SubTitle;
                    $this->UniquePrice = ($this->ProductSmartCardOption()->Price > 0) ? $this->ProductSmartCardOption()->Price : 0;
                    $this->Quantity = 1;
                    break;
                case 'PayTV':
                    $this->Title = $this->PayTVPackage()->Title;
                    $this->SubTitle = $this->PayTVPackage()->SubTitle;
                    $this->MonthlyPrice = ($this->PayTVPackage()->MonthlyPrice > 0) ? $this->PayTVPackage()->MonthlyPrice : 0;
                    $this->Quantity = 1;
                    break;
                case 'OffProduct':
                    $this->Title = $this->Product()->Title;
                    $this->SubTitle = $this->Product()->SubTitle;
                    $this->MonthlyPrice = - $this->Product()->getMonthlyPrice();
                    $this->UniquePrice = - $this->Product()->getPriceUnique();
                    $this->Quantity = 1;
                    break;
                default:
                    # code...
                    break;
            }
        }
        // if($this->ID > 0 && $this->ProductID && $this->Product()->getFees() && $this->Type != "OffProduct"){
        //     foreach ($this->Product()->getFees() as $fee) {
        //         $item = new OrderItem();
        //         $item->Type = "Fee";
        //         $item->Title = $fee->Title. " - " .$this->Product()->Title ;
        //         $item->UniquePrice = $fee->Price;
        //         $item->write();
        //         $this->Order()->Items()->add($item);
        //     }
        // }
    }

    public function onAfterWrite(){
        
       
        parent::onAfterWrite();
    }

    public function onAfterDelete(){
       
        parent::onAfterDelete();
    }


    // public static function getAccessories($value){
    //     switch($value){
    //       case "Accessory":
    //       $accessories = ProductAccessory::get()->sort('SortOrder')->map('ID','Title')->toArray();
    //       break;
    //       case "AccessoryMultiple":
    //       $accessories = ProductAccessory::get()->filter('canBeMultiple' , 1)->sort('SortOrder')->map('ID','Title')->toArray();
    //       break;
    //       default:
    //       $accessories = null;
    //     }
    //     return $accessories;
    //   }

    //User Rights
    // public function canCreate($member = null){
    //     $member = Member::CurrentUser();
    //     return true;
    // }


    // public function canView($member = null){
    //     $member = Member::CurrentUser();
    //     return $member->hasCustomerRights($this->Order()) || $member->hasPartnerLightRights($this->Order());
    // }

    // public function canEdit($member = null){
    //     $member = Member::CurrentUser();
    //     return $member->hasCustomerRights($this->Order()) || $member->hasPartnerLightRights($this->Order());
    // }

    // public function canDelete($member = null){
    //     $member = Member::CurrentUser();
    //   if($this->Status == "approvedByOwner"){
    //     return false;
    //   }
    //   return $member->hasCustomerRights($this->Order()) || $member->hasPartnerLightRights($this->Order());
    // }

}

