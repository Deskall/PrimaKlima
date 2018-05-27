<?php

require_once "/themes/standard/css/less/lessc.inc.php";

use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\Core\Environment;
use SilverStripe\StaticPublishQueue\Contract\StaticPublishingTrigger;
use SilverStripe\StaticPublishQueue\Extension\Publishable\PublishableSiteTree;
use SilverStripe\StaticPublishQueue\Job\DeleteStaticCacheJob;
use SilverStripe\StaticPublishQueue\Job\StaticCacheFullBuildJob;
use Symbiote\QueuedJobs\Services\QueuedJobService;
use SilverStripe\ORM\DataExtension;

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
      
        $css_compiled = $this->autoCompileLess($_SERVER['DOCUMENT_ROOT']."/themes/standard/css/main.less", $_SERVER['DOCUMENT_ROOT']."/themes/standard/css/main.min.css");

        if($css_compiled){
            // set correct paths
            $css_compiled = str_replace("url('/fonts","url('/themes/standard/fonts'");
            $css_compiled = str_replace($_SERVER['DOCUMENT_ROOT']."/themes/images/backgrounds/","/themes/standard/css/src/images/backgrounds/",$css_compiled);
           

            // save files
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/themes/standard/css/main.min.css",$css_compiled);
        }
    }

    function autoCompileLess($inputFile, $outputFile) {
      // load the cache
      $cacheFile = $_SERVER['DOCUMENT_ROOT']."/themes/standard/css/cache/main.less.cache";

      if (file_exists($cacheFile)) {
        $cache = unserialize(file_get_contents($cacheFile));
      } else {
        $cache = $inputFile;
      }

      $less = new lessc;


      $less->setFormatter("compressed");
      $newCache = $less->cachedCompile($cache);

      if (!is_array($cache) || $newCache["updated"] > $cache["updated"]) {
        file_put_contents($cacheFile, serialize($newCache));
        $css_compiled = $newCache['compiled'];
        return $css_compiled;
      }

      return false;
    }

    /**
     * Execute URL deletions, enqueue URL updates.
     */
    public function flushChanges()
    {
        $queue = QueuedJobService::singleton();
        $job = new StaticCacheFullBuildJob();
        $jobData = new \stdClass();
        $job->setJobData(0, 0, false, $jobData, []);
        $queue->queueJob($job);
    }
}
