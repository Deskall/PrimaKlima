<?php


use SilverStripe\ORM\DataObject;
use Symbiote\QueuedJobs\Services\AbstractQueuedJob;
use Symbiote\QueuedJobs\Services\QueuedJob;
use SilverStripe\ORM\DB;
use SilverStripe\Assets\Folder;


/**
 * An example queued job
 *
 * Use this as an example of how you can write your own jobs
 *
 * @author Marcus Nyeholt <marcus@symbiote.com.au>
 * @license BSD http://silverstripe.org/bsd-license/
 */
class CleanTmpFolderJob extends AbstractQueuedJob implements QueuedJob
{
    /**
     * @param DataObject $rootNodeID
     */
    public function __construct()
    {

    }

    protected function getFolder()
    {
        return Folder::find_or_make('Secure/tmp');
    }

    /**
     * Defines the title of the job
     *
     * @return string
     */
    public function getTitle()
    {
       

        return _t(
            __CLASS__ . '.Title',
            "Delete files in temporary folder"
        );
    }

    /**
     * Indicate to the system which queue we think we should be in based
     * on how many objects we're going to touch on while processing.
     *
     * We want to make sure we also set how many steps we think we might need to take to
     * process everything - note that this does not need to be 100% accurate, but it's nice
     * to give a reasonable approximation
     *
     * @return int
     */
    public function getJobType()
    {
        $this->totalSteps = 'Lots';
        return QueuedJob::QUEUED;
    }

    /**
     * This is called immediately before a job begins - it gives you a chance
     * to initialise job data and make sure everything's good to go
     *
     * What we're doing in our case is to queue up the list of items we know we need to
     * process still (it's not everything - just the ones we know at the moment)
     *
     * When we go through, we'll constantly add and remove from this queue, meaning
     * we never overload it with content
     */
    public function setup()
    {
        if (!$this->getFolder() || !$this->getFolder()->hasChildren()) {
            // we're missing for some reason!
            $this->isComplete = true;
            $this->remainingChildren = array();
            return;
        }
        $remainingChildren = $this->getFolder()->myChildren();
        $this->remainingChildren = $remainingChildren;

        // we reset this to 1; this is because we only know for sure about 1 item remaining
        // as time goes by, this will increase as we discover more items that need processing
        $this->totalSteps = $remainingChildren->count();
    }

    /**
     * Lets process a single node, and publish it if necessary
     */
    public function process()
    {
        $remainingChildren = $this->remainingChildren;

        // if there's no more, we're done!
        if (!count($remainingChildren)) {
            $this->isComplete = true;
            return;
        }

        // we need to always increment! This is important, because if we don't then our container
        // that executes around us thinks that the job has died, and will stop it running.
        $this->currentStep++;

        // lets process our first item - note that we take it off the list of things left to do
        $file = $remainingChildren->first();

        if ($file) {
            // delete it
            $file->File->deleteFile();
            DB::prepared_query('DELETE FROM "File" WHERE "File"."ID" = ?', array($file->ID));
            $file->delete();
            $file->destroy();
            unset($file);
        }

        // and now we store the new list of remaining children
        $this->remainingChildren = $remainingChildren;

        if (!count($remainingChildren)) {
            $this->isComplete = true;
            return;
        }
    }
}
