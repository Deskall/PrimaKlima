<?php


use SilverStripe\Security\Member;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Security\Security;
use SilverStripe\Security\Group;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Email\Email;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Control\Director;
/**
 * An email sent to the user with a link to validate and activate their account.
 *
 * @package silverstripe-memberprofiles
 */
class MissionEmail extends Email
{
    /**
     * @var Mission|null
     */
    private $mission = null;

    /**
     * @var config
     */
    private $config = null;

   

    /**
     * @param CookConfig $config
     * @param Mission $mission
     */
    public function __construct(CookConfig $config,$mission,$sender,$receiver,$subject,$body)
    {
        parent::__construct();

        $this->config = $config;
        $this->mission = $mission;


        $this->setFrom($sender);
        if ($receiver){
            $this->setTo($receiver);
        }
        
        $this->setSubject($this->getParsedString($subject));
        $body .= $config->EmailSignature;

        $html = new DBHTMLText();
        $html->setValue($this->getParsedString($body));

        $Body = $this->renderWith('emails/base_email',array('Subject' => $this->getParsedString($subject),'Lead' => '', 'Body' => $html, 'Footer' => '', 'SiteConfig' => SiteConfig::current_site_config()));
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
        $mission = $this->getMission();
        $config = $this->getConfig();

        /**
         * @var \SilverStripe\ORM\FieldType\DBDatetime $createdDateObj
         */
        $createdDateObj = $mission->obj('Created');

        $page = MemberProfilePage::get()->filter('GroupID',Group::get()->filter('Code','mietkoeche')->first()->ID)->first();

        $absoluteBaseURL = $this->BaseURL();
        $variables = array(
            '$SiteName'       => SiteConfig::current_site_config()->Title,
            '$LoginLink'      => Controller::join_links(
                $absoluteBaseURL,
                singleton(Security::class)->Link('login')
            ),
            '$ConfirmLink'    => Controller::join_links(
                $absoluteBaseURL,
                'angebot/bestaetigung/',
                $mission->ID,
                "?key={$mission->OfferKey}"
            ),
            '$LostPasswordLink' => Controller::join_links(
                $absoluteBaseURL,
                singleton(Security::class)->Link('lostpassword')
            ),
            '$Mission.Created' => $createdDateObj->Nice(),
            '$AccountLink' => $page->AbsoluteLink(),
            '$Mission.Data' => $mission->renderWith('Emails/MissionData'),
            '$Offer.Data' => $mission->renderWith('Emails/OfferData'),
            '$Offer.Validity' => $config->OfferValidityText,
            '$Customer.Data' => $mission->renderWith('Emails/CustomerData'),
            '$Cook.Title' => $mission->CookTitle(),
            '$Cook.Name' => ucfirst($mission->Cook()->Member()->FirstName)." ".ucfirst($mission->Cook()->Member()->Surname),
            '$Customer.Title' => $mission->CustomerTitle(),
            '$Cook.ApprovalLink' => $mission->CookApprovalLink(),
            '$MissionLink' => $mission->OfferFile()->AbsoluteLink(),
            '$AGBLink' => Director::AbsoluteURL('services/agb/')
        );
        
        foreach (array('Company' , 'Email' , 'Address' , 'PostalCode' , 'City' , 'Country', 'Phone', 'Fax', 'URL', 'Title' , 'Place' , 'Start', 'End', 'Access', 'HourPay' , 'Position' , 'TransportCost' , 'CostAndHousing' , 'Others', 'Status' , 'AdminComments', 'Price' ) as $field) {
            $variables["\$Mission.$field"] = $mission->$field;
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
     * @return Mission
     */
    public function getMission()
    {
        return $this->mission;
    }

    /**
     * @return CookConfig
     */
    public function getConfig()
    {
        return $this->config;
    }
}