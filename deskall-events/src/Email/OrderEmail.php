<?php


use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Security;
use SilverStripe\Security\Group;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Email\Email;
use SilverStripe\ORM\FieldType\DBHTMLText;

class OrderEmail extends Email
{
    /**
     * @var order|null
     */
    private $Order = null;

    /**
     * @var config
     */
    private $config = null;

   
    /**
     * @param EventConfig $config
     * @param OrderDate $Order
     */
    public function __construct(EventConfig $config,$Order,$sender,$receiver,$subject,$body)
    {
        parent::__construct();

        $this->config = $config;
        $this->Order = $Order;


        $this->setFrom($sender);
        if ($receiver){
            $this->setTo($receiver);
        }
        
        $this->setSubject($this->getParsedString($subject));
        $html = new DBHTMLText();
        $html->setValue($this->getParsedString($body));
     
        $Body = $this->renderWith('Emails/base_email',array('Subject' => $this->getParsedString($subject),'Lead' => '', 'Body' => $html, 'Footer' => '', 'SiteConfig' => SiteConfig::current_site_config()));
        $this->setBody($Body);
    }


    /**
     * Replaces variables inside an email template according to {@link TEMPLATE_NOTE}.
     *
     * @param string $string
     * @return string
     */
    public function getParsedString($string)
    {
        $Order = $this->getOrder();
        $config = $this->getConfig();

        /**
         * @var \SilverStripe\ORM\FieldType\DBDatetime $createdDateObj
         */
        $createdDateObj = $Order->obj('Created');

        $absoluteBaseURL = $this->BaseURL();
        $variables = array(
            '$SiteName'       => SiteConfig::current_site_config()->Title,
            '$LoginLink'      => Controller::join_links(
                $absoluteBaseURL,
                singleton(Security::class)->Link('login')
            ),
            '$Customer.printTitle' => $Order->Participant()->getTitle(),
            '$Order.Created' => $createdDateObj->Nice(),
            '$Order.Data' => $Order->renderWith('Emails/OrderData'),
            '$Event.Title' => $Order->Date()->Event()->Title,
            '$Event.Data' => $Order->renderWith('Emails/EventData')
        );
        
        foreach (array('Company' , 'Email' , 'Address' , 'PostalCode' , 'City' , 'Country', 'Phone', 'Price' ) as $field) {
            $variables["\$Order.$field"] = $Order->$field;
        }

        $this->extend('updateEmailVariables', $variables);

        return str_replace(array_keys($variables), array_values($variables), $string);
    }

    public function BaseURL()
    {
        $absoluteBaseURL = parent::BaseURL();
        $this->extend('updateBaseURL', $absoluteBaseURL);
        return $absoluteBaseURL;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->Order;
    }

    /**
     * @return EventConfig
     */
    public function getConfig()
    {
        return $this->config;
    }
}