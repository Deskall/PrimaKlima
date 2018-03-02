<?php

use SilverStripe\ORM\DataExtension;
use SilverStripe\Security\Member;
use SilverStripe\Security\DefaultAdminService;

class MemberExtension extends DataExtension
{

    private static $default_members = [
        '0' => [
            'FirstName' => 'Daniel',
            'Surname' => 'Wirz',
            'Email' => 'daniel.wirz@deskall.ch',
            'Password' => 'deskall24$'
        ],
        '1' => [
            'FirstName' => 'Rasmus',
            'Surname' => 'Frei',
            'Email' => 'rasmus.frei@deskall.ch',
            'Password' => 'deskall24$'
        ],
        '2' => [
            'FirstName' => 'Ulla',
            'Surname' => 'Frei',
            'Email' => 'ulla.frei@deskall.ch',
            'Password' => 'deskall24$'
        ],
    ];

    /** create all deskall accounts on dev/build **/
    public function requireDefaultRecords()
    {
        //Groupd and admin already created
        parent::requireDefaultRecords();

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
                $adminGroup = DefaultAdminService::findOrCreateDefaultAdmin();
                $member->inGroup($adminGroup);
            }
        }
    }
}