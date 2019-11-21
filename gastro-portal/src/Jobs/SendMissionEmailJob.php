<?php


use SilverStripe\ORM\DataObject;
use Symbiote\QueuedJobs\Services\AbstractQueuedJob;
use Symbiote\QueuedJobs\Services\QueuedJob;
use SilverStripe\ORM\DB;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use SilverStripe\ORM\GroupedList;
use SilverStripe\ORM\ManyManyList;

/**
 * An example queued job
 *
 * Use this as an example of how you can write your own jobs
 *
 * @author Marcus Nyeholt <marcus@symbiote.com.au>
 * @license BSD http://silverstripe.org/bsd-license/
 */
class SendMissionEmailJob extends AbstractQueuedJob implements QueuedJob
{
    /**
     * @param DataObject $rootNodeID
     */
    public function __construct()
    {   
  
        $this->Date = new \DateTime();
        $this->config = CookConfig::get()->first();
        $expirationOffer = new \DateTime();
        $dayBeforeExpiration = intval($this->config->OfferValidity) - 1;
        $modify = '-'.$dayBeforeExpiration.' days';
         file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $modify);
        $expirationOffer->modify($modify);
        $this->expirationOffer = $expirationOffer;
        
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
            "Send emails to administrator and stakeholders regarding offer and contract expiration"
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
        $config = $this->config;
        
        ob_start();
        print_r('start setup -------------------------'."\n");
        print_r($this->expirationOffer->format('Y-m-d H:i:s')."\n");
        //All mission expiring tomorrow and not yet confirmed
        $missions1 = Mission::get()->filter(['SentDate:LessThanOrEqual' => $this->expirationOffer->format('Y-m-d H:i:s'), 'Status:not' => 'sentToCook'])->sort('Created');
        print_r('missions1:'."\n");
        print_r($missions1->count());
        print_r("\n");
        $result = ob_get_clean();
        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-email.txt", $result);
        $this->Step1 = $missions1;
        $this->totalProcess1 = $missions1->count();

        $this->currentProcess = 1;
        $this->currentStepProcess1 = 1;
        $this->totalProcess = 1;
        $this->totalSteps =  $this->totalProcess1 /* + $this->totalProcess2 + $this->totalProcess3 + $this->totalProcess4 + $this->totalProcess5 + $this->totalProcess6*/;
 



    }

    /**
     * Lets process a single node, and publish it if necessary
     */
    public function process()
    {

        // we need to always increment! This is important, because if we don't then our container
        // that executes around us thinks that the job has died, and will stop it running.
        $this->currentStep++;
        $start = $this->Date;
        $process = $this->currentProcess;
        $process1 = $this->currentStepProcess1;

        //6 Processes
        //1. Reminder Email 1 day before Offer expiration
        //2. Reminder Email 1 hour before Contract expiration
        //3. Archive Offer not accepted
        //4. Archive cnadidature expired and reopen mission for selection
        //5. Daily mail to Admin
        //6. Daily mail to Cooks

        if ($process == 1){
            
            $missions1 = $this->Step1;
             //1. Upload stakeholders
            if ($missions1->count() > 0){
                $template = AutoEmail::get()->byId(1);
                foreach ($missions1 as $mission) {
                    $email = $template->createMail($mission->renderWith('Emails/MissionData'),$mission, $mission->Customer()->Member());
                    $email->addAttachment(dirname(__FILE__).'/../../..'.$mission->OfferFile()->getURL(),'Angebot.pdf');
                    $email->send();
                    $this->Step1 = $missions1->exclude('ID',$mission->ID);
                    $this->currentStepProcess1++;
                }
                
                if ($process1 == $this->totalProcess1){
                    $this->currentProcess++;
                }
            }
            else{
                $this->currentProcess++;
            }
        }

      
        if ($this->currentStep == $this->totalSteps){
            $this->isComplete = true;
            
            file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-email.txt", "\n"."completed", FILE_APPEND);

            return;
        }
    }
}
