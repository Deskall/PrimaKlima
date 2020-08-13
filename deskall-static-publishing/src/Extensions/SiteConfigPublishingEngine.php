<?php

use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\Core\Environment;
use SilverStripe\StaticPublishQueue\Contract\StaticPublishingTrigger;
use SilverStripe\StaticPublishQueue\Extension\Publishable\PublishableSiteTree;
use SilverStripe\StaticPublishQueue\Job\DeleteStaticCacheJob;
use SilverStripe\StaticPublishQueue\Job\StaticCacheFullBuildJob;
use Symbiote\QueuedJobs\Services\QueuedJobService;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Control\Director;

/**
 * This extension couples to the StaticallyPublishable and StaticPublishingTrigger implementations
 * on the SiteConfig object and makes sure the actual change to SiteCOnfig is triggered/enqueued.
 *
 */
class SiteConfigPublishingEngine extends DataExtension
{
    

    public function onAfterWrite()
    {
        $this->rebuildCss();
        $this->flushChanges();
    }

    public function rebuildCss(){

        $url = Director::absoluteBaseUrl()."/themes/standard/css/main.min.css";

        $req = curl_init($url);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($req);
    }

    /**
     * Execute URL deletions, enqueue URL updates.
     */
    public function flushChanges()
    {
        $queue = QueuedJobService::singleton();
        $job = new DeskallStaticCacheFullBuildJob();
        $jobData = new \stdClass();
        $job->setJobData(0, 0, false, $jobData, []);
        $queue->queueJob($job);
    }
}
