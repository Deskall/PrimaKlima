<?php


use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\StaticPublishQueue\Contract\StaticallyPublishable;
use SilverStripe\StaticPublishQueue\Extension\Publishable\PublishableSiteTree;
use SilverStripe\StaticPublishQueue\Job;
use SilverStripe\StaticPublishQueue\Publisher;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Core\Environment;

/**
 * Adds all pages to the queue for caching. Best implemented on a cron via StaticCacheFullBuildTask.
 */
class DeskallStaticCacheFullBuildJob extends Job
{
    /**
     * @return string
     */
    public function getTitle()
    {
        return 'Generate static pages for all URLs (Deskall Version)';
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return md5(static::class);
    }

    public function setup()
    {
        parent::setup();
        $this->URLsToProcess = $this->getAllLivePageURLs();
        $this->URLsToCleanUp = [];
        $this->totalSteps = ceil(count($this->URLsToProcess) / self::config()->get('chunk_size'));
        $this->addMessage(sprintf('Building %s URLS', count($this->URLsToProcess)));
        $this->addMessage(var_export(array_keys($this->URLsToProcess), true));
    }

    /**
     * Do some processing yourself!
     */
    public function process()
    {
        Environment::increaseMemoryLimitTo();
        $chunkSize = self::config()->get('chunk_size');
        $count = 0;
        $ProcessedURLs = [];
        $URLsToProcess = $this->getAllLivePageURLs();
        foreach ($this->URLsToProcess as $url => $priority) {
            if (++$count > $chunkSize) {
                break;
            }
            $meta = Publisher::singleton()->publishURL($url, true);
            if (!empty($meta['success'])) {
                $ProcessedURLs[$url] = $url;
                unset($URLsToProcess[$url]);
            }
        }
        $this->ProcessedURLs = $ProcessedURLs;
        $this->URLsToProcess = $URLsToProcess;
        if (empty($this->URLsToProcess)) {
            $trimSlashes = function ($value) {
                return trim($value, '/');
            };
            $this->publishedURLs = array_map($trimSlashes, Publisher::singleton()->getPublishedURLs());
            if (is_array($this->ProcessedURLs)){
                $this->ProcessedURLs = array_map($trimSlashes, $this->ProcessedURLs);
                $this->URLsToCleanUp = array_diff($this->publishedURLs, $this->ProcessedURLs);
            }

            if ($this->URLsToCleanUp){
               foreach ($this->URLsToCleanUp as $staleURL) {
                    $purgeMeta = Publisher::singleton()->purgeURL($staleURL);
                    if (!empty($purgeMeta['success'])) {
                        unset($this->URLsToCleanUp[$staleURL]);
                    }
                } 
            } 
        };
        $this->isComplete = empty($this->URLsToProcess) && empty($this->URLsToCleanUp);
    }

    /**
     *
     * @return array
     */
    protected function getAllLivePageURLs()
    {
        $urls = [];
        $this->extend('beforeGetAllLivePageURLs', $urls);
        $livePages = Versioned::get_by_stage(SiteTree::class, Versioned::LIVE);
        foreach ($livePages as $page) {
            if ($page->hasExtension(PublishableSiteTree::class) || $page instanceof StaticallyPublishable) {
                $urls = array_merge($urls, $page->urlsToCache());
            }
        }

        $this->extend('afterGetAllLivePageURLs', $urls);
        // @TODO look here when integrating subsites
        // if (class_exists(Subsite::class)) {
        //     Subsite::disable_subsite_filter(true);
        // }
        return $urls;
    }
}