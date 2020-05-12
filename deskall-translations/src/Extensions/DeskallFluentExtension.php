<?php 


use TractorCow\Fluent\Extension\FluentExtension;
use TractorCow\Fluent\State\FluentState;
use SilverStripe\ORM\DataObject;

class DeskallFluentExtension extends FluentExtension 
{

  /**
  * Return the localised value for a given field and a given locale
  */
  public function getLocalisedValue($field, $locale){
    if ($field && $locale){
      $id = $this->owner->ID;
      $class = $this->owner->ClassName;
      $localizedValue = FluentState::singleton()->withState(function (FluentState $newState) use ($id,$class,$field,$locale) {
          $newState->setLocale($locale);
          $obj = DataObject::get($class)->byID($id);
          if ($obj && $obj->hasDatabaseField($field)){
            return $obj->{$field};
          }
      });
    }
  }
  
}