<?php 

namespace BAK\Products;

use HeaderSlide;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TreeDropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\EmailField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\CMS\Model\SiteTree;

class BAKSliderBlockExtension extends DataExtension 
{

  public function HeaderSlide(){
   return HeaderSlide::get()->first();
  }

  public function styledTitle($string){
    return str_replace("On","<span>On</span>",$string);
  }

  
}