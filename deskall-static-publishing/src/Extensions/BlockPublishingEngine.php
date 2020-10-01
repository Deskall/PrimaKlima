<?php

use SilverStripe\CMS\Model\SiteTreeExtension;
use SilverStripe\Core\Environment;
use SilverStripe\StaticPublishQueue\Contract\StaticPublishingTrigger;
use SilverStripe\StaticPublishQueue\Extension\Publishable\PublishableSiteTree;
use SilverStripe\StaticPublishQueue\Job\DeleteStaticCacheJob;
use SilverStripe\StaticPublishQueue\Job\GenerateStaticCacheJob;
use Symbiote\QueuedJobs\Services\QueuedJobService;
use SilverStripe\ORM\DataExtension;

/**
 * This extension couples to the StaticallyPublishable and StaticPublishingTrigger implementations
 * on the SiteTree objects and makes sure the actual change to SiteTree is triggered/enqueued.
 *
 * Provides the following information as a context to StaticPublishingTrigger:
 * * action - name of the executed action: publish or unpublish
 *
 * @see PublishableSiteTree
 */
class BlockPublishingEngine extends DataExtension
{
    /**
     * Queues the urls to be flushed into the queue.
     *
     * @var array
     */
    private $toUpdate = array();

    /**
     * Queues the urls to be deleted as part of a next flush operation.
     *
     * @var array
     */
    private $toDelete = array();

    /**
     * @return array
     */
    public function getToUpdate()
    {
        return $this->toUpdate;
    }

    /**
     * @return array
     */
    public function getToDelete()
    {
        return $this->toDelete;
    }

    /**
     * @param array $toUpdate
     * @return $this
     */
    public function setToUpdate($toUpdate)
    {
        $this->toUpdate = $toUpdate;
        return $this;
    }

    /**
     * @param $toDelete
     * @return $this
     */
    public function setToDelete($toDelete)
    {
        $this->toDelete = $toDelete;
        return $this;
    }

    /**
     * @param \SilverStripe\CMS\Model\SiteTree|null $original
     */
    public function onAfterPublish()
    {
        
        $context = [
            'action' => 'publish',
        ];
        $this->collectChanges($context);
        $this->flushChanges();
    }

    public function onBeforeUnpublish()
    {
        $context = array(
            'action' => 'unpublish'
        );
        $this->collectChanges($context);
    }

    public function onAfterUnpublish()
    {
        $this->flushChanges();
    }

    /**
     * Collect all changes for the given context.
     *
     * @param array $context
     */
    public function collectChanges($context)
    {
        Environment::increaseMemoryLimitTo();
        Environment::increaseTimeLimitTo();

        if ($this->getOwner()->hasExtension(PublishableBlock::class)
            || $this->getOwner() instanceof StaticPublishingTrigger
        ) {
            $toUpdate = $this->getOwner()->objectsToUpdate($context);
            $this->setToUpdate($toUpdate);

            $toDelete = $this->getOwner()->objectsToDelete($context);
            $this->setToDelete($toDelete);
        }
    }

    /**
     * Execute URL deletions, enqueue URL updates.
     */
    public function flushChanges()
    {
        ob_start();
                    print_r('flushChanges');
                    $result = ob_get_clean();
                    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
        $queue = QueuedJobService::singleton();
        if (!empty($this->toUpdate)) {
            foreach ($this->toUpdate as $queueItem) {
                if ($queueItem){
                    $job = new GenerateStaticCacheJob();
                    $jobData = new \stdClass();
                    $urls = $queueItem->urlsToCache();
                    ksort($urls);
                    $jobData->URLsToProcess = $urls;

                    $job->setJobData(0, 0, false, $jobData, [
                        'Building URLs: ' . var_export(array_keys($jobData->URLsToProcess), true)
                    ]);
                    $queue->queueJob($job);
                }
            }
            $this->toUpdate = array();
        }

        if (!empty($this->toDelete)) {
            foreach ($this->toDelete as $queueItem) {
                $job = new DeleteStaticCacheJob();

                $jobData = new \stdClass();
                $urls = $queueItem->urlsToCache();
                ksort($urls);
                $jobData->URLsToProcess = $urls;

                $job->setJobData(0, 0, false, $jobData, [
                    'Purging URLs: ' . var_export(array_keys($jobData->URLsToProcess), true)
                ]);

                $queue->queueJob($job);
            }
            $this->toDelete = array();
        }
    }
}