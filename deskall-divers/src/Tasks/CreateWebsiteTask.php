<?php

 use SilverStripe\i18n\i18n;

use SilverStripe\Control\Director;
use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\Connect\TempDatabase;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use SilverStripe\Security\Member;
use SilverStripe\Security\Group;

use SilverStripe\CMS\Controllers\RootURLController;
use SilverStripe\Versioned\Versioned;
use SilverStripe\CMS\Model\RedirectorPage;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ErrorPage\ErrorPage;



/**
 * 
 * Task who creates simple sitetree structure with standard blocks.
 */
class CreateWebsiteTask extends BuildTask
{

    private static $segment = 'CreateWebsiteTask';

    private static $default_members = [
        '1' => [
            'FirstName' => 'Guillaume',
            'Surname' => 'Pacilly',
            'Email' => 'guillaume.pacilly@deskall.ch',
            'Password' => 'deskall24$'
        ],
        '2' => [
            'FirstName' => 'Rasmus',
            'Surname' => 'Frei',
            'Email' => 'rasmus.frei@deskall.ch',
            'Password' => 'deskall24$'
        ],
        '3' => [
            'FirstName' => 'Ulla',
            'Surname' => 'Frei',
            'Email' => 'ulla.frei@deskall.ch',
            'Password' => 'deskall24$'
        ],
        '4' => [
            'FirstName' => 'Rahel',
            'Surname' => 'Beyli',
            'Email' => 'rahel.beyli@deskall.ch',
            'Password' => 'deskall24$'
        ],
        '5' => [
            'FirstName' => 'Sonja',
            'Surname' => 'Degen',
            'Email' => 'sonja.degen@deskall.ch',
            'Password' => 'deskall24$'
        ],
    ];

    protected $title = 'Create Website';

    protected $description = 'Creates simple sitetree structure with standard blocks';

    public function run($request)
    {

        //CREATE THE USERS
        $adminGroup = Group::get()->filter('Code','administrators')->first();
        foreach (static::$default_members as $key => $entry) {
         
            // Find member
            $member = Member::get()
                ->filter('Email', $entry['Email'])
                ->first();

            if (!$member){
                $member = new Member();
                $member->FirstName = $entry['FirstName'];
                $member->Surname = $entry['Surname'];
                $member->Email = $entry['Email'];
                $member->Password = $entry['Password'];
                $member->write();

                $adminGroup
                ->DirectMembers()
                ->add($member);
            }
        }
        singleton(ErrorPage::class)->requireDefaultRecords();
        //Create the Pages
        if (!SiteTree::get_by_link(RootURLController::config()->default_homepage_link)) {
            $homepage = new HomePage();
            $homepage->Title = 'Home';
            $homepage->URLSegment = RootURLController::config()->default_homepage_link;
            $homepage->Sort = 1;
            $homepage->write();
            $homepage->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE);
            $homepage->flushCache();
        }

       if(!Page::get()->filter('URLSegment','ueber-uns')->first()){
            $aboutus = new Page();
            $aboutus->Title = 'Über uns';
            $aboutus->Sort = 2;
            $aboutus->write();
            $aboutus->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE);
            $aboutus->flushCache();
        }
        if(!Page::get()->filter('URLSegment','kontakt')->first()){
            $contactus = new Page();
            $contactus->Title = 'Kontakt';
            $contactus->Sort = 3;
            $contactus->write();
            $contactus->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE);
            $contactus->flushCache();
        }

        //Services Page
        if(!RedirectorPage::get()->filter('URLSegment','services')->first()){
            $services = new RedirectorPage();
            $services->Title = 'Services';
            $services->ShowInMenus = 0;
            $services->ShowInSearch = 0;
            $services->Sort = 4;
            $services->write();
           
            
            //Impressum Page
            $imp = new Page();
            $imp->Title = 'Impressum';
            $imp->Sort = 1;
            $imp->ParentID = $services->ID;
            $imp->write();
            //Create blocks
            $impb1 = new TextBlock();
            $impb1->ParentID = $imp->ElementalAreaID;
            $impb1->Sort = 2;
            $impb1->Title = 'Verantwortlich für den Inhalt.';
            $impb1->write();
            $impb2 = new TextBlock();
            $impb2->ParentID = $imp->ElementalAreaID;
            $impb2->Sort = 3;
            $impb2->Title = 'Konzept und Realisation des Internetauftrittes';
            $impb2->HTML = '<p><strong>Deskall Kommunikation</strong><br>4663 Aarburg</p><p><a href="https://www.deskall.ch/" target="_blank">deskall.ch</a></p>';
            $impb2->write();

            $impb3 = new TextBlock();
            $impb3->ParentID = $imp->ElementalAreaID;
            $impb3->Sort = 3;
            $impb3->Title = 'Datenschutzerklärung';
            $impb3->HTML = '<p>Wir erheben und verwenden Ihre personen­be­zogenen Daten ausschliesslich im Rahmen der Bestim­mungen des Datenschutz­rechts der Schweiz. Im Folgenden unterrichten wir Sie über Art, Umfang und Zwecke der Erhebung und Verwendung personen­be­zogener Daten. Sie können diese Unterrichtung jederzeit auf unserer Webseite abrufen.</p><h3>Datenüber­mittlung und -protokol­lierung zu system­in­ternen und statis­tischen Zwecken</h3><p>Ihr Internet-Browser übermittelt beim Zugriff auf unsere Webseite aus technischen Gründen automatisch Daten an unseren Webserver. Es handelt sich dabei unter anderem um Datum und Uhrzeit des Zugriffs, URL der verwei­senden Webseite, abgerufene Datei, Menge der gesendeten Daten, Browsertyp und -version, Betriebs­system sowie Ihre IP-Adresse. Diese Daten werden getrennt von anderen Daten, die Sie im Rahmen der Nutzung unseres Angebotes eingeben haben, gespeichert. Eine Zuordnung dieser Daten zu einer bestimmten Person ist uns nicht möglich. Diese Daten werden zu statis­tischen Zwecken ausgewertet und im Anschluss gelöscht.</p><h3>Bestandsdaten</h3><p>Sofern zwischen Ihnen und uns ein Vertrags­ver­hältnis begründet, inhaltlich ausgestaltet oder geändert werden soll, erheben und verwenden wir personen­be­zogene Daten von Ihnen, soweit dies zu diesen Zwecken erforderlich ist.<br>Auf Anordnung der zuständigen Stellen dürfen wir im Einzelfall Auskunft über diese Daten (Bestandsdaten) erteilen, soweit dies für Zwecke der Strafver­folgung, zur Gefahren­abwehr, zur Erfüllung der gesetz­lichen Aufgaben der Verfas­sungs­schutz­be­hörden oder des Militä­rischen Abschirm­dienstes oder zur Durchsetzung der Rechte am geistigen Eigentum erforderlich ist.</p><h3>Nutzungsdaten</h3><p>Wir erheben und verwenden personen­be­zogene Daten von Ihnen, soweit dies erforderlich ist, um die Inanspruchnahme unseres Internet­an­gebotes zu ermöglichen oder abzurechnen (Nutzungsdaten). Dazu gehören insbesondere Merkmale zu Ihrer Identi­fi­kation und Angaben zu Beginn und Ende sowie des Umfangs der Nutzung unseres Angebotes.<br>Für Zwecke der Werbung, der Marktfor­schung und zur bedarfs­ge­rechten Gestaltung unseres Internet­an­gebotes dürfen wir bei Verwendung von Pseudonymen Nutzungs­profile erstellen. Sie haben das Recht, dieser Verwendung Ihrer Daten zu widersprechen. Die Nutzungs­profile dürfen wir nicht mit Daten über den Träger des Pseudonyms zusammen­führen.<br>Auf Anordnung der zuständigen Stellen dürfen wir im Einzelfall Auskunft über diese Daten (Bestandsdaten) erteilen, soweit dies für Zwecke der Strafver­folgung, zur Gefahren­abwehr, zur Erfüllung der gesetz­lichen Aufgaben der Verfas­sungs­schutz­be­hörden oder des Militä­rischen Abschirm­dienstes oder zur Durchsetzung der Rechte am geistigen Eigentum erforderlich ist.</p><h3>Cookies</h3><p>Um den Funkti­ons­umfang unseres Internet­an­gebotes zu erweitern und die Nutzung für Sie komfor­tabler zu gestalten, verwenden wir so genannte «Cookies». Mit Hilfe dieser «Cookies» können bei dem Aufruf unserer Webseite Daten auf Ihrem Rechner gespeichert werden. Sie haben die Möglichkeit, das Abspeichern von Cookies auf Ihrem Rechner durch entspre­chende Einstel­lungen in Ihrem Browser zu verhindern. Hierdurch könnte allerdings der Funkti­ons­umfang unseres Angebotes eingeschränkt werden.</p><h3>Daten-Erhebung durch Nutzung von Google-Analytics</h3><p>Unsere Webseite benutzt Google-Analytics, einen Webana­ly­se­dienst, der Google inc. Google-Analytics verwendet sogenannte «Cookies». Dabei handelt es sich um Textdateien, die auf Ihrem Computer gespeichert werden und die eine Analyse ihrer Benutzung der Website ermöglicht. Erfasst werden beispielsweise Informa­tionen zum Betriebs­system, zum Browser, Ihrer IP-Adresse, Ihrer von Ihnen zuvor aufgerufenen Webseite (Referrer-URL) sowie Datum und Uhrzeit Ihres Besuchs auf unserer Webseite. Die durch diese Textdatei erzeugten Informa­tionen über die Benutzung unserer Webseite werden an einen Server von Google in den USA übertragen und dort gespeichert. Google wird diese Information benutzen, um Ihre Nutzung unserer Webseite auszuwerten, um Reports über die Websei­ten­ak­tivität für die Websei­ten­be­treiber zusammen zu stellen und um weitere mit der Websei­ten­nutzung und der Internet­nutzung verbundenen Dienst­leis­tungen zu erbringen. Sofern dies gesetzlich vorgeschrieben ist oder soweit Dritte diese Daten im Auftrag von Google verarbeiten, wird Google diese Information auch an diese Dritten weitergeben. Diese Nutzung erfolgt anonymisiert oder pseudony­misiert. Nähere Informa­tionen darüber finden Sie direkt bei Google:&nbsp;<a href="http://www.google.com/intl/de/privacypolicy.html#information" target="_blank">http://​www.​google.​com/​intl/​de/​pri​vacy​poli​cy.​html#​information</a></p><h3>Google benutzt das DoubleClick DART-Cookie</h3><p>Nutzer können die Verwendung des DART-Cookies deakti­vieren, indem sie die Daten-schutz­be­stim­mungen des Werbenetzwerks und Content-Werbenetzwerks von Google aufrufen.<br>Dabei werden keinerlei unmittelbare persönliche Daten des Nutzers gespeichert, sondern nur die Internet­pro­tokoll–Adresse. Diese Informa­tionen dienen dazu, Sie bei Ihrem nächsten Besuch auf unseren Websites automatisch wieder­zu­er­kennen und Ihnen die Navigation zu erleichtern. Cookies erlauben es uns beispielsweise, eine Website Ihren Interessen anzupassen oder Ihr Kennwort zu speichern, damit Sie es nicht jedes Mal neu eingeben müssen.</p><h3>Auskunftsrecht</h3><p>Als Nutzer unseres Internet­an­gebotes haben Sie das Recht, von uns Auskunft über die zu Ihrer Person oder zu Ihrem Pseudonym gespei­cherten Daten zu verlangen. Auf Ihr Verlangen kann die Auskunft auch elektronisch erteilt werden.</p>';
            $impb3->write();

            $imp->publishRecursive();
            $imp->flushCache();

            //Sitemap Page
            $sp = new Page();
            $sp->Title = _t(__CLASS__.'.SITEMAPTITLE', 'Sitemap');
            $sp->Sort = 2;

            $sp->ParentID = $services->ID;
            $sp->write();
            //Create Sitemap block
            $spb = new SitemapBlock();
            $spb->ParentID = $sp->ElementalAreaID;
            $spb->Sort = 2;
            $spb->write();
            $sp->publishRecursive();
            $sp->flushCache();

            $services->LinkToID = $sp->ID;
            $services->write();
            $services->publishRecursive();
            $services->flushCache();
        }

        echo "Done.";
    }
}
