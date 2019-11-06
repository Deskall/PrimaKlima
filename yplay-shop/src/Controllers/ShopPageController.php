<?php



class ShopPageController extends PageController
{

   public function init(){
      parent::init();
      //redirect if empty cart
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      if (!$cart ){
         return $this->redirect($this->ConfiguratorPage()->Link(), 302);
      }
   }
}