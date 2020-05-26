<?php
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\OptionsetField;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\DateField;
use SilverStripe\i18n\i18n;
use SilverStripe\Forms\RequiredFields;
use SilverStripe\View\Requirements;
use SilverStripe\ORM\ValidationException;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Security;
use SilverStripe\Security\Member;
use SilverStripe\Security\IdentityStore;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Control\Director;
use SilverStripe\Security\MemberAuthenticator\MemberLoginForm;
use SilverStripe\Security\MemberAuthenticator\MemberAuthenticator;
use UndefinedOffset\NoCaptcha\Forms\NocaptchaField;
use SilverStripe\ORM\FieldType\DBHTMLText;

class ShopController extends PageController{
	private static $allowed_actions = ['Category','Product','getActiveCart','updateCart','removeFromCart','updateCartData', 'updateCartSummary'];

	private static $url_handlers = [
		'kategorie//$URLSegment' => 'Category',
		'produkt//$URLSegment' => 'Product',
	];

	public function init(){
		parent::init();
		
	}

	public function Category(HTTPRequest $request){

		$URLSegment = $request->param('URLSegment');
		if ($URLSegment){
			$category = ProductCategory::get()->filter('URLSegment',$URLSegment)->first();
			if ($category){
				return ['Title' => $category->Title, 'Category' => $category, 'ExtraCSSClass' => 'blau', 'activeCart' => $this->getActiveCartObject() ];
			}
		}
		return $this->httpError(404);
	}

	public function Product(HTTPRequest $request){
		Requirements::javascript("deskall-shop/javascript/shop.js");
		$URLSegment = $request->param('URLSegment');
		if ($URLSegment){
			$product = Product::get()->filter('URLSegment',$URLSegment)->first();
			if ($product){
				return ['Title' => $product->Title, 'Product' => $product, 'ExtraCSSClass' => 'blau', 'SiteConfig' => SiteConfig::current_site_config(), 'activeCart' => $this->getActiveCartObject() ];
			}
		}
		return $this->httpError(404);
	}

	public function getActiveCart(){
	   $id = $this->getRequest()->getSession()->get('shopcart_id');
	   $cart = null;
	   if ($id){
	      $cart = ShopCart::get()->byId($id);
	   }
	   $cart = ($cart) ? $cart : new ShopCart();
	   $cart->write();
	   $this->getRequest()->getSession()->set('shopcart_id',$cart->ID);
	   
	   return $cart->renderWith('Includes/ShopCart');
	}

	public function getActiveCartObject(){
	   $id = $this->getRequest()->getSession()->get('shopcart_id');
	   $cart = null;
	   if ($id){
	      $cart = ShopCart::get()->byId($id);
	   }
	   $cart = ($cart) ? $cart : new ShopCart();
	   $cart->write();
	   $this->getRequest()->getSession()->set('shopcart_id',$cart->ID);
	   
	   return $cart;
	}

	public function updateCart(HTTPRequest $request){
	   $id = $this->getRequest()->getSession()->get('shopcart_id');
	   if ($id){
	      $cart = ShopCart::get()->byId($id);
	      	if ($cart){
				$productID = $request->postVar('productID');
				$variantID = $request->postVar('varianteID');
			   	if ($productID){
				   	$product = Product::get()->byId($productID);
				   	if ($product){
				   		$quantity = ($request->postVar('quantity')) ? $request->postVar('quantity') : 1;
				   		$sort = $p->SortOrder;
				   		//check if already in cart
				   		if ($p = $cart->Products()->filter(['ID' => $productID, 'VariantID' => $variantID])->first()){
				   			//Context: if Webshop, we simply add 1, else we are in Checkout and must respect the quantity given
				   			if ($request->postVar('context') && $request->postVar('context') == 'webshop'){
				   				$quantity = $p->Quantity + $quantity;
				   			}
				   		}else{
				   			$sort = $cart->Products()->count() + 1;
				   		}
				   		if ($variantID > 0){
				   			$variant = ProductVariant::get()->byId($variantID);
				   			if ($variant){
				   				$cart->Products()->add($product,['Quantity' => $quantity, 'SortOrder' => $sort, 'Subtotal' => $variant->Price * $quantity, 'VariantID' => $variantID]);
				   			}
				   		}
				   		else{
				   			$cart->Products()->add($product,['Quantity' => $quantity, 'SortOrder' => $sort, 'Subtotal' => $product->Price * $quantity]);
				   		}
				   		$cart->write();
				   	}
				}
				return ($request->postVar('context') && $request->postVar('context') == "checkout") ? $cart->renderWith('Includes/ShopCartCheckout') : $cart->renderWith('Includes/ShopCartProducts');
		    }
		}
	}

	 public function updateCartData(){
      //retrieve cart in session
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      $form = $this->getRequest()->postVar('form');
     
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
      // $cart = ShopCart::get()->last();

      if ($cart && $form ){
         $data = array();
         parse_str($form, $data);
         $cart->update($data);
         if (!isset($data['DeliverySameAddress'])){
         	$cart->DeliverySameAddress = 0;
         }
         $cart->write();

         return $cart->renderWith('Includes/ShopCartSummary');
      }

      return;
      
   } 

   public function updateCartSummary(){
      //retrieve cart in session
      $id = $this->getRequest()->getSession()->get('shopcart_id');
      
      $cart = null;
      if ($id){
         $cart = ShopCart::get()->byId($id);
      }
   		// $cart = ShopCart::get()->last();
      if ($cart ){
         return $cart->renderWith('Includes/ShopCartSummary');
      }

      return;
      
   } 

	public function removeFromCart(HTTPRequest $request){
	   $id = $this->getRequest()->getSession()->get('shopcart_id');
	 
	   if ($id){
	      $cart = ShopCart::get()->byId($id);
	      	if ($cart){
				$productID = $request->postVar('productID');
			   	if ($productID){
				   	$product = Product::get()->byId($productID);
				   	if ($product){
				   		$cart->Products()->remove($product);
				   		$cart->write();
				   	}
				}
				return $cart->renderWith('Includes/ShopCartCheckout');
		    }
		}
	}
}