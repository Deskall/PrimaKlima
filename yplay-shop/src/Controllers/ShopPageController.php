<?php



class ShopPageController extends PageController
{

   public function onBeforeInit(){
      parent::onBeforeInit();
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      if (!$cart ){
         return $this->redirect($this->ConfiguratorPage()->Link());
      }
   }
}