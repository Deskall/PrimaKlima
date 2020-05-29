<?php

namespace Bak\Products\Controllers;

use PageController;
use HeaderSlide;
use SilverStripe\Core\Convert;
use SilverStripe\Control\Email\Email;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use SilverStripe\CMS\Model\SiteTree;
use Bak\Products\Models\Product;
use Bak\Products\Models\ProductCategory;
use Bak\Products\Models\ProductUseArea;
use Bak\Products\Models\ProductUsage;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ORM\FieldType\DBHTMLText;

class ProductOverviewPageController extends PageController 
{

    public function init(){
        parent::init();
        Requirements::javascript('bak-products/javascript/handlebars.min.js');
        Requirements::javascript('bak-products/javascript/bak-products.js');
    }

    private static $allowed_actions = array(
        'category',
        'application',
        'detail',
        'videos',
        'SendProductForm',
        'all'
    );

    private static $url_handlers = array (
        'detalle/$Product!' => 'detail',
        'categoria/$Category' => 'category',
        'category/$Category' => 'category',
        'kategorie/$Category' => 'category',
        'uso/$UsageArea/$Usage' => 'application',
        'anwendung/$UsageArea/$Usage' => 'application',
        'application/$UsageArea/$Usage' => 'application'
    );

    public function getCategories(){
        return ProductCategory::get();
    }

    public function getUseArea(){
        return ProductUseArea::get();
    }

    public function all(){
        $products = Product::get();
        $productList = array();

        foreach ($products as $product) {

            $tmp =  array();

            if( $product->MainImage()->Link() != "/assets/" ){
                if ($product->MainImage()->exists()){
                    $tmp['image'] = $product->MainImage()->Pad(210,150)->Link();
                }
            }
            $cat = '';
            foreach( $product->Categories() as $category ){
                $cat .= $category->Link()." ";
            }
            $tmp['categories'] = $cat;

            $use = '';
            foreach( $product->Usages() as $usage ){
               $use .= $usage->Link()." ";
            }
            $tmp['usages'] = $use;
            $tmp['link'] = $product->Link();

            $tmp['number'] = $product->Number;
            $tmp['name'] = $product->Name;
            $tmp['lead'] = $product->Lead;
            $tmp['description'] = DBHTMLText::create()->setValue($product->Description)->limitWordCount(30);
            $tmp['linkText'] = _t('Main.ZUMPRODUKT','Zum Produkt');
            $tmp['numberText'] = _t('ProductPage.NUMMER','Best.-Nr.');

        
            array_push($productList, $tmp);
        }
       

        $categories = ProductCategory::get();
        $categoriesList = array();
       
        foreach ($categories as $category) {

            $tmp =  array();
            $tmp['title'] = $category->Title;
            $tmp['description'] = $category->Description;

            $tmp['metatitle'] = $category->printMetaTitle();
            $tmp['metadescription'] = $category->printMetaDescription();

            array_push($categoriesList, $tmp);
        }

        $usages = ProductUsage::get();
        $usagesList = array();
        
        foreach ($usages as $usage) {

            $tmp =  array();
            $tmp['title'] = $usage->Title;
            $tmp['description'] = $usage->Description;
            $tmp['metatitle'] = $usage->printMetaTitle();
            $tmp['metadescription'] = $usage->printMetaDescription();

            array_push($usagesList, $tmp);
        }
        return json_encode(array('products' => $productList, 'categories' => $categoriesList, 'usages' => $usagesList));
    }

    public function index(){
        return ['ShowCategories' => true];
    }


    public function category(HTTPRequest $request){

        if ($request->param('Category')){
            $category = ProductCategory::get()->filter('URLSegment',$request->param('Category'))->First();
            if(!$category) {
                return $this->httpError(404,'Kategorie nicht gefunden.');
            }
            else{
                return array(
                    'SelectedCategory' => $category,
                    'showProducts' => true,
                    'MetaTitle' => $category->printMetaTitle(),
                    'MetaTags' => DBHTMLText::create()->setValue($category->getMetaTags())
                );
            }
        }
     

            $tags = '<meta name="generator" content="SilverStripe - http://silverstripe.org"><meta http-equiv="Content-type" content="text/html; charset=utf-8">';
            $tags .= '<meta name="description" content="'._t('ProductPage.CATEGORIES','Produkt Kategorien').'">';
            $tags .= $this->renderWith('FluentCategory_MetaTags');

            return array(
                'ShowCategories' => true,
                'Title' => $this->Title.' - '._t('ProductPage.CATEGORIES','Kategorien'),
                'MetaTitle' => _t('ProductPage.CATEGORIES','Produkt Kategorien'),
                'MetaTags' =>  DBHTMLText::create()->setValue($tags),
                'isCategoryOverview' => true
            );

        
    }


    public function application(HTTPRequest $request ){
        if($request->param('UsageArea')){
            $usage = ProductUsage::get()->filter('URLSegment',$request->param('UsageArea').'/'.$request->param('Usage'))->First();
            if(!$usage) {
                return $this->httpError(404,_t('BAK.ProductNotFound','Produkt nicht gefunden.'));
            }
            return array(
                'SelectedUsage' => $usage,
                'showProducts' => true,
                'Locale' => $this->Locale,
                'MetaTitle' => $usage->printMetaTitle(),
                'MetaTags' => DBHTMLText::create()->setValue($usage->getMetaTags())
            );
            
        }else{
            $tags = '<meta name="generator" content="SilverStripe - http://silverstripe.org"><meta http-equiv="Content-type" content="text/html; charset=utf-8">';
            $tags .= '<meta name="description" content="'._t('ProductPage.ANWENDUNG','Produkt Anwendungen').'">';
            $tags .= $this->renderWith('FluentUsage_MetaTags');

            
            return array(
                'ShowUsages' => true,
                'Locale' => $this->Locale,
                'Title' => $this->Title.' - '._t('ProductPage.ANWENDUNG','Anwendungen'),
                'MetaTitle' => _t('ProductPage.ANWENDUNG','Produkt Anwendungen'),
                'MetaTags' =>  DBHTMLText::create()->setValue($tags),
                'isUsageOverview' => true
            );
        }

    }



    public function detail(HTTPRequest $request ){
        
        $product = Product::get()->filter('URLSegment',$request->param('ID'))->first();

        if(!$product) {
            return $this->httpError(404,_t('BAK.ProductNotFound','Produkt nicht gefunden.'));
        }
        return array (
            'Product' => $product,
            'Title' => $product->Name,
            'MetaTitle' => $product->getProductMetaTitle(),
            'MetaTags' => DBHTMLText::create()->setValue($product->ProductMetaTags()),
            'StructuredData' => $product->StructuredData(),
            'HeaderSlide' => HeaderSlide::get()->first(),
            'Locales' => $product->Locales()
        );

    }


    function SendProductForm($data) {

        //Recaptcha validation
        if (!array_key_exists('g-recaptcha-response', $_POST) || empty($_POST['g-recaptcha-response'])) {
          return $this->redirectBack();
        }

        $response = $this->recaptchaHTTPPost($_POST['g-recaptcha-response']);
        $response = json_decode($response, true);


        if ($response['success'] != 'true') {
          return $this->redirectBack();
        }
        
        $Product = Product::get()->byId(intval($_POST['ID']));
        // Read Data

        $contents = array(
            'de_DE' => array(
                'address' => 'Personalien',
                'name' => 'Name',
                'firma' => 'Firma',
                'str' => 'Adresse',
                'ort' => 'PLZ / Ort',
                'land' => 'Land',
                'email' => 'E-Mail',
                'phone' => 'Telefon',
                'products' => 'Produkte',
                'sendme' => 'Senden Sie mir',
                'message' => 'Nachricht'

            ),
            'en_US' => array(
                'address' => 'Personal data',
                'name' => 'Name',
                'firma' => 'Company',
                'str' => 'Address',
                'ort' => 'ZIP Code / City',
                'land' => 'Country',
                'email' => 'E-Mail',
                'phone' => 'Telephone',
                'products' => 'Products',
                'sendme' => 'Please send me',
                'message' => 'Message',
            ),
           'es_ES' => array(
              'address' => 'Información personal',
              'name' => 'Nombre',
              'firma' => 'Empresa',
              'str' => 'Calle',
              'ort' => 'Código postal / Ciudad',
              'land' => 'país',
              'email' => 'Correo electrónico',
              'phone' => 'Teléfono',
              'products' => 'Productos',
              'sendme' => 'Por favor envíame',
              'message' => 'Mensaje',
          )
        );

        // address
        $address = '<p><strong>'.$contents[$this->Locale]['address'].': </strong>'."<br/>";
        $address .= $contents[$this->Locale]['name'].': '.$_POST['name']."<br/>";
        if (isset($_POST['firma'])){
             $address .= $contents[$this->Locale]['firma'].': '.$_POST['firma']."<br/>";
        }
       
       // $address .= $contents[$this->Locale]['str'].': '.$_POST['address']."<br/>";
       // $address .= $contents[$this->Locale]['ort'].': '.$_POST['ort']."<br/>";
        $address .= $contents[$this->Locale]['land'].': '.$_POST['land']."<br/>";
        $address .= $contents[$this->Locale]['email'].': '.$_POST['email']."<br/>";
        if (isset($_POST['telephone'])){
            $address .= $contents[$this->Locale]['phone'].': '.$_POST['telephone']."</p>";
        }
        // products
        if( $_POST['products'] ){
            $products = '<p><strong>'.$contents[$this->Locale]['products'].': </strong>'."<br/>";
            $products .= implode ( "<br/>" , $_POST['products'] )."</p>";
        }

        // data to send
        if( $_POST['send'] ){
            $send = '<p><strong>'.$contents[$this->Locale]['sendme'].': </strong>'."<br/>";
            $send .= implode ( "<br/>" , $_POST['send'] )."</p>";
        }      

        // data to send
        if( $_POST['message'] ){
            $message = '<p><strong>'.$contents[$this->Locale]['message'].': </strong>'."<br/>";
            $message .= nl2br($_POST['message'])."</p>";
        }

        $config = SiteConfig::current_site_config(); 
        

        // send email
        $body = '<html>
            <body>
                <h2>'.$config->SubjectEmail.'</h2>
                <p>'.$config->ContentEmail.'</p>

                '.$address.'
                '.$products.'
                '.$send.'
                '.$message.'

            </body>
        </html>';



        // send confirmation

        $bodyConfirmation = '<html>
            <body>
                <h2>'.$config->SubjectEmailConfirmation.'</h2>
                <p>'.$config->ContentEmailConfirmation.'</p>

                '.$address.'
                '.$products.'
                '.$send.'
                '.$message.'

            </body>
        </html>';

        if( $_POST['email'] ){
            $confirmation = new Email( $config->EmailSentFrom , $_POST['email'] , $config->SubjectEmailConfirmation, $bodyConfirmation);
            $email = new Email( $_POST['email'] ,  $config->ReceiverEmail, $config->SubjectEmail, $body);

            $confirmation->send();
            $email->send();
        }

        // do redirect
        ($config->ConfirmationPage()) ? $this->redirect($config->ConfirmationPage()->Link()) : $this->redirectBack() ;

    }
}
//     public function recaptchaHTTPPost($responseStr)
//     {
//         $postVars = array(
//             'secret'   => '6LcBbrwUAAAAAOlhEKzbVV-yIKUnF05RkUwCVimW',
//             'remoteip' => $_SERVER['REMOTE_ADDR'],
//             'response' => $responseStr,
//         );
//         $client = $this->getHTTPClient();
//         $response = $client->post('https://www.google.com/recaptcha/api/siteverify', $postVars);

//         return $response->getBody();
//     }


//     public function setHTTPClient($client)
//     {
//         $this->client = $client;
//         return $this;
//     }


//     public function getHTTPClient()
//     {
//         if (!$this->client) {
//             $this->client = new RecaptchaField_HTTPClient();
//         }

//         return $this->client;
//     }

// }


//   class RecaptchaField_HTTPClient extends Object
//   {

//       *
//        * @param String $url
//        * @param $postVars
//        * @return String HTTPResponse
       
//       public function post($url, $postVars)
//       {
//           $ch = curl_init($url);
          
//           curl_setopt($ch, CURLOPT_TIMEOUT, 10);
//           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//           curl_setopt($ch, CURLOPT_USERAGENT, 'reCAPTCHA/PHP');
//           // we need application/x-www-form-urlencoded
//           curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postVars));
//           $response = curl_exec($ch);

//           if (class_exists('HTTPResponse')) {
//               $responseObj = new HTTPResponse();
//           } else {
//               // 2.3 backwards compat
//               $responseObj = new HttpResponse();
//           }
//           $responseObj->setBody($response); // 2.2. compat
//           $responseObj->addHeader('Content-Type', 'application/json');
//           return $responseObj;
//       }
//   }

