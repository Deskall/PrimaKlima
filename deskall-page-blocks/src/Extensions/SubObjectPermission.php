<?php


use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Permission;


class SubObjectPermission extends DataExtension {

/************** PERMISSIONS *********************/
    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     * @return boolean
     */
    public function canView($member = null)
    {


        if ($this->owner->hasMethod('getPage')) {
            if ($page = $this->owner->getPage()) {
                return $page->canView($member);
            }
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     *
     * @return boolean
     */
    public function canEdit($member = null)
    {


        if ($this->owner->hasMethod('getPage')) {
            if ($page = $this->owner->getPage()) {
                return $page->canEdit($member);
            }
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * Uses archive not delete so that current stage is respected i.e if a
     * element is not published, then it can be deleted by someone who doesn't
     * have publishing permissions.
     *
     * @param Member $member
     *
     * @return boolean
     */
    public function canDelete($member = null)
    {

        if ($this->owner->hasMethod('getPage')) {
            if ($page = $this->owner->getPage()) {
                return $page->canArchive($member);
            }
        }

        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

    /**
     * Basic permissions, defaults to page perms where possible.
     *
     * @param Member $member
     * @param array $context
     *
     * @return boolean
     */
    public function canCreate($member = null, $context = array())
    {


        return (Permission::check('CMS_ACCESS', 'any', $member)) ? true : null;
    }

/************** END PERMISSIONS *****************/
}