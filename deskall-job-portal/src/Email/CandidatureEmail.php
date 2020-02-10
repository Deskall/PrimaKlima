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

class CandidatureEmail extends Email
{
    /**
     * @var Mission|null
     */
    private $candidature = null;

    /**
     * @var config
     */
    private $config = null;

   

    /**
     * @param CookConfig $config
     * @param Mission $mission
     */
    public function __construct(JobPortalConfig $config,$candidature,$sender,$receiver,$subject,$body)
    {
        parent::__construct();

        $this->config = $config;
        $this->candidature = $candidature;


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
        $candidature = $this->getCandidature();
        $config = $this->getConfig();

        /**
         * @var \SilverStripe\ORM\FieldType\DBDatetime $createdDateObj
         */
        $createdDateObj = $candidature->obj('Created');

        $loginPage = MemberProfilePage::get()->first();

        $absoluteBaseURL = $this->BaseURL();
        $variables = array(
            '$SiteName'       => SiteConfig::current_site_config()->Title,
            '$LoginLink'      => Controller::join_links(
                $absoluteBaseURL,
                $loginPage->Link()
            ),
            '$Candidature.Data' => $candidature->renderWith('Emails/CandidatureData'),
            '$CandidatProfilLink' => $candidature->Link()
        );
        
        foreach (array('Content' , 'ContentRefusal' , 'Status') as $field) {
            $variables["\$Candidature.$field"] = $candidature->$field;
        }
        foreach (array('Title') as $method) {
            $variables["\$Customer.$method"] = $candidature->Mission()->$Customer()->{$method}();
        }
        foreach (array('Title') as $method) {
            $variables["\$Candidat.$method"] = $candidature->$Candidat()->{$method}();
        }
        foreach (array('Title','Nummer') as $field) {
            $variables["\$Mission.$field"] = $candidature->$Mission()->$field;
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
    public function getCandidature()
    {
        return $this->candidature;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}