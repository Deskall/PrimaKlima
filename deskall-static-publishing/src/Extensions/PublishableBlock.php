<?php


use SilverStripe\CMS\Model\RedirectorPage;
use SilverStripe\CMS\Model\VirtualPage;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataExtension;
use SilverStripe\StaticPublishQueue\Contract\StaticallyPublishable;
use SilverStripe\StaticPublishQueue\Contract\StaticPublishingTrigger;

/**
 * Bare-bones impelmentation of a publishable page.
 *
 * You can override this either by implementing one of the interfaces the class directly, or by applying
 * an extension via the config system ordering (inject your extension "before" the PublishableSiteTree).
 *
 * @TODO: re-implement optional publishing of all the ancestors up to the root? Currently it only republishes the parent
 *
 * @see SiteTreePublishingEngine
 */
class PublishableBlock extends DataExtension implements StaticallyPublishable, StaticPublishingTrigger
{

    // public function getMyVirtualPages()
    // {
    //     return VirtualPage::get()->filter(['CopyContentFrom.ID' => $this->owner->ID]);
    // }

    /**
     * @param array $context
     * @return array
     */
    public function objectsToUpdate($context)
    {  
        ob_start();
                    print_r($this->getOwner()->ID);
                    $result = ob_get_clean();
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
        $list = [];
        if ($this->getOwner() instanceof BaseElement ){
            $page = $this->getOwner()->getRealPage();
        }
        else{
            $page = $this->getOwner()->getPage();
        }
        switch ($context['action']) {
            case 'publish':
            // Trigger refresh of the page itself.
                $list[] = $page;
            // Refresh the parent.
                if ($page->ParentID) {
                    $list[] = $page->Parent();
                }

                // Refresh related virtual pages.
                // $virtuals = $this->getOwner()->getMyVirtualPages();
                // if ($virtuals->exists()) {
                //     foreach ($virtuals as $virtual) {
                //         $list[] = $virtual;
                //     }
                // }
                // break;

            case 'unpublish':
                // Refresh the parent
                if ($page->ParentID) {
                    $list[] = $page->Parent();
                }
                break;
        }
        return $list;
    }

    /**
     * @param array $context
     * @return array
     */
    public function objectsToDelete($context)
    {
        $list = [];
        switch ($context['action']) {
            case 'unpublish':
                // Trigger cache removal for this page.
                $list[] = $this->getOwner();

                // Trigger removal of the related virtual pages.
                // $virtuals = $this->getOwner()->getMyVirtualPages();
                // if ($virtuals->exists()) {
                //     foreach ($virtuals as $virtual) {
                //         $list[] = $virtual;
                //     }
                // }
                break;
        }
        return $list;
    }

    /**
     * The only URL belonging to this object is it's own URL.
     */
    public function urlsToCache()
    {
        return [Director::absoluteURL($this->getOwner()->getPage()->Link()) => 0];
    }
}