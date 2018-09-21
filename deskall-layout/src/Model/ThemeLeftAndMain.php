<?php

use SilverStripe\Admin\LeftAndMainExtension;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Director;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationResult;
use SilverStripe\Versioned\RecursivePublishable;
use SilverStripe\View\ArrayData;
use SilverStripe\View\Requirements;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Admin\AdminRootController;
use SilverStripe\Admin\CMSMenu;
use SilverStripe\CMS\Controllers\CMSPagesController;
use SilverStripe\CMS\Controllers\CMSPageEditController;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Convert;
use SilverStripe\Security\Member;
use SilverStripe\Security\Permission;
use SilverStripe\Security\Security;
use SilverStripe\Subsites\Controller\SubsiteXHRController;
use SilverStripe\Subsites\Model\Subsite;
use SilverStripe\Subsites\State\SubsiteState;

class ThemeLeftAndMain extends LeftAndMainExtension 
{
    /**
     * @var string
     */
    private static $url_segment = 'design';

    /**
     * @var string
     */
    private static $url_rule = '/$Action/$ID/$OtherID';

    /**
     * @var int
     */
    private static $menu_priority = -1;

    /**
     * @var string
     */
    private static $menu_title = 'Design';

    /**
     * @var string
     */
    private static $menu_icon_class = 'font-icon-block-banner';

    /**
     * @var string
     */
    private static $tree_class = SiteConfig::class;

    /**
     * @var array
     */
    private static $required_permission_codes = array('EDIT_SITECONFIG');

    public function onBeforeInit()
    {
        $request = Controller::curr()->getRequest();
        $session = $request->getSession();

        $state = SubsiteState::singleton();

        // FIRST, check if we need to change subsites due to the URL.

        // Catch forced subsite changes that need to cause CMS reloads.
        if ($request->getVar('SubsiteID') !== null) {
            // Clear current page when subsite changes (or is set for the first time)
            if ($state->getSubsiteIdWasChanged()) {
                // sessionNamespace() is protected - see for info
                $override = $this->owner->config()->get('session_namespace');
                $sessionNamespace = $override ? $override : get_class($this->owner);
                $session->clear($sessionNamespace . '.currentPage');
            }

            // Context: Subsite ID has already been set to the state via InitStateMiddleware

            // If the user cannot view the current page, redirect to the admin landing section
            if (!$this->owner->canView()) {
                return $this->owner->redirect(AdminRootController::config()->get('url_base') . '/');
            }

            $currentController = Controller::curr();
            if ($currentController instanceof CMSPageEditController) {
                /** @var SiteTree $page */
                $page = $currentController->currentPage();

                // If the page exists but doesn't belong to the requested subsite, redirect to admin/pages which
                // will show a list of the requested subsite's pages
                $currentSubsiteId = $request->getVar('SubsiteID');
                if ($page && (int) $page->SubsiteID !== (int) $currentSubsiteId) {
                    return $this->owner->redirect(CMSPagesController::singleton()->Link());
                }

                // Page does belong to the current subsite, so remove the query string parameter and refresh the page
                // Remove the subsiteID parameter and redirect back to the current URL again
                $request->offsetSet('SubsiteID', null);
                return $this->owner->redirect($request->getURL(true));
            }

            // Redirect back to the default admin URL
            return $this->owner->redirect($request->getURL());
        }

        // Automatically redirect the session to appropriate subsite when requesting a record.
        // This is needed to properly initialise the session in situations where someone opens the CMS via a link.
        $record = $this->owner->currentPage();
        if ($record
            && isset($record->SubsiteID, $this->owner->urlParams['ID'])
            && is_numeric($record->SubsiteID)
            && $this->shouldChangeSubsite(
                get_class($this->owner),
                $record->SubsiteID,
                SubsiteState::singleton()->getSubsiteId()
            )
        ) {
            // Update current subsite
            $canViewElsewhere = SubsiteState::singleton()->withState(function ($newState) use ($record) {
                $newState->setSubsiteId($record->SubsiteID);

                return (bool) $this->owner->canView(Security::getCurrentUser());
            });

            if ($canViewElsewhere) {
                // Redirect to clear the current page
                return $this->owner->redirect(
                    Controller::join_links($this->owner->Link('show'), $record->ID, '?SubsiteID=' . $record->SubsiteID)
                );
            }
            // Redirect to the default CMS section
            return $this->owner->redirect(AdminRootController::config()->get('url_base') . '/');
        }

        // SECOND, check if we need to change subsites due to lack of permissions.

        if (!$this->owner->canAccess()) {
            $member = Security::getCurrentUser();

            // Current section is not accessible, try at least to stick to the same subsite.
            $menu = CMSMenu::get_menu_items();
            foreach ($menu as $candidate) {
                if ($candidate->controller && $candidate->controller != get_class($this->owner)) {
                    $accessibleSites = singleton($candidate->controller)->sectionSites(true, 'Main site', $member);
                    if ($accessibleSites->count()
                        && $accessibleSites->find('ID', SubsiteState::singleton()->getSubsiteId())
                    ) {
                        // Section is accessible, redirect there.
                        return $this->owner->redirect(singleton($candidate->controller)->Link());
                    }
                }
            }

            // If no section is available, look for other accessible subsites.
            foreach ($menu as $candidate) {
                if ($candidate->controller) {
                    $accessibleSites = singleton($candidate->controller)->sectionSites(true, 'Main site', $member);
                    if ($accessibleSites->count()) {
                        Subsite::changeSubsite($accessibleSites->First()->ID);
                        return $this->owner->redirect(singleton($candidate->controller)->Link());
                    }
                }
            }

            // We have not found any accessible section or subsite. User should be denied access.
            return Security::permissionFailure($this->owner);
        }

        // Current site is accessible. Allow through.
        return;
    }


    /**
     * Initialises the {@link SiteConfig} controller.
     */
    public function init()
    {
        parent::init();
        if (class_exists(SiteTree::class)) {
            Requirements::javascript('silverstripe/cms: client/dist/js/bundle.js');
        }
    }

    /**
     * @param null $id Not used.
     * @param null $fields Not used.
     *
     * @return Form
     */
    public function getEditForm($id = null, $fields = null)
    {
        $siteConfig = SiteConfig::current_site_config();
        $fields = $siteConfig->getLayoutFields();

        // Tell the CMS what URL the preview should show
        $home = Director::absoluteBaseURL();
        $fields->push(new HiddenField('PreviewURL', 'Preview URL', $home));

        // Added in-line to the form, but plucked into different view by LeftAndMain.Preview.js upon load
        /** @skipUpgrade */
        $fields->push($navField = new LiteralField('SilverStripeNavigator', $this->getSilverStripeNavigator()));
        $navField->setAllowHTML(true);

        // Retrieve validator, if one has been setup (e.g. via data extensions).
        if ($siteConfig->hasMethod("getCMSValidator")) {
            $validator = $siteConfig->getCMSValidator();
        } else {
            $validator = null;
        }

        $actions = $siteConfig->getCMSActions();
        $negotiator = $this->getResponseNegotiator();
        /** @var Form $form */
        $form = Form::create(
            $this,
            'EditForm',
            $fields,
            $actions,
            $validator
        )->setHTMLID('Form_EditForm');
        $form->setValidationResponseCallback(function (ValidationResult $errors) use ($negotiator, $form) {
            $request = $this->getRequest();
            if ($request->isAjax() && $negotiator) {
                $result = $form->forTemplate();
                return $negotiator->respond($request, array(
                    'CurrentForm' => function () use ($result) {
                        return $result;
                    }
                ));
            }
        });
        $form->addExtraClass('flexbox-area-grow fill-height cms-content cms-edit-form');
        $form->setAttribute('data-pjax-fragment', 'CurrentForm');

        if ($form->Fields()->hasTabSet()) {
            $form->Fields()->findOrMakeTab('Root')->setTemplate('SilverStripe\\Forms\\CMSTabSet');
        }
        $form->setHTMLID('Form_EditForm');
        $form->loadDataFrom($siteConfig);
        $form->setTemplate($this->getTemplatesWithSuffix('_EditForm'));

        // Use <button> to allow full jQuery UI styling
        $actions = $actions->dataFields();
        if ($actions) {
            /** @var FormAction $action */
            foreach ($actions as $action) {
                $action->setUseButtonTag(true);
            }
        }

        $this->extend('updateEditForm', $form);

        return $form;
    }

    /**
     * Save the current sites {@link SiteConfig} into the database.
     *
     * @param array $data
     * @param Form $form
     * @return String
     */
    public function save_siteconfig($data, $form)
    {
        $data = $form->getData();
        $siteConfig = DataObject::get_by_id(SiteConfig::class, $data['ID']);
        $form->saveInto($siteConfig);
        $siteConfig->write();
        if ($siteConfig->hasExtension(RecursivePublishable::class)) {
            $siteConfig->publishRecursive();
        }
        $this->response->addHeader('X-Status', rawurlencode(_t(LeftAndMain::class . '.SAVEDUP', 'Saved.')));
        return $form->forTemplate();
    }


    public function Breadcrumbs($unlinked = false)
    {
        return new ArrayList(array(
            new ArrayData(array(
                'Title' => static::menu_title(),
                'Link' => $this->Link()
            ))
        ));
    }
}
