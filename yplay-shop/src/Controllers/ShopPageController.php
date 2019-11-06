<?php



class ShopPageController extends PageController
{

   public function init(){
      
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      if (!$cart ){
         ob_start();
                  print_r('ici');
                  $result = ob_get_clean();
                  file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
         return $this->redirect($this->ConfiguratorPage()->Link(), 302);
      }

      parent::init();
   }
}