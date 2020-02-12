<?php


use SilverStripe\ORM\DataObject;
use Symbiote\QueuedJobs\Services\AbstractQueuedJob;
use Symbiote\QueuedJobs\Services\QueuedJob;
use SilverStripe\ORM\DB;
use SilverStripe\Assets\Folder;
use SilverStripe\Assets\File;
use SilverStripe\ORM\GroupedList;
use SilverStripe\ORM\ManyManyList;
use SilverStripe\SiteConfig\SiteConfig;

class AccountDesactivationJob extends AbstractQueuedJob implements QueuedJob
{
    protected $date;

    protected $config;

    protected $expiration;

    public function getConfig(){
        return $this->config;
    }

    public function getDate(){
        return $this->date;
    }

    public function getExpiration(){
        return $this->expiration;
    }

    /**
     * @param DataObject $rootNodeID
     */
    public function __construct()
    {   
  
        $today = new \DateTime();
        $today = $today->setTimestamp(strtotime('today midnight'));
        $this->date = $today;
        $this->config = SiteConfig::current_site_config();
        $expiration = new \DateTime();
        $expiration = $expiration->setTimestamp(strtotime('today midnight'));
        $expiration->modify('+5 days');
        $this->expiration = $expiration;
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
            "Send emails to Customers for contract expiration"
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
        print_r($this->getExpiration()->format('Y-m-d H:i:s')."\n");
        //All active orde expiring tomorrow and not yet confirmed
        //1. expire today
        $orders1 = ShopOrder::get()->filter(['isActive' =>  1,'EndValidity:LessThan' => $this->getDate()->format('Y-m-d H:i:s')]);
        $orders2 = ShopOrder::get()->filter(['isActive' =>  1,'EndValidity:GreaterThanOrEqual' => $this->getDate()->format('Y-m-d H:i:s'), 'EndValidity:LessThan' => $this->getExpiration()->format('Y-m-d H:i:s')]);
        print_r('missions1:'."\n");
        print_r($orders1->count());
        print_r("\n");
        $result = ob_get_clean();
        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-email.txt", $result);
        $this->Step1 = $orders1;
        $this->totalProcess1 = $orders1->count();

        $this->Step2 = $orders2;
        $this->totalProcess2 = $orders2->count();

        $this->currentStep = 0;
        $this->currentProcess = 1;
        $this->currentStepProcess1 = 1;
        $this->currentStepProcess2 = 1;
        $this->totalProcess = 1;
        $this->totalSteps =  $this->totalProcess1 + $this->totalProcess2 /* + $this->totalProcess3 + $this->totalProcess4 + $this->totalProcess5 + $this->totalProcess6*/;
 
    }

    /**
     * Lets process a single node, and publish it if necessary
     */
    public function process()
    {

        // we need to always increment! This is important, because if we don't then our container
        // that executes around us thinks that the job has died, and will stop it running.
       
        $process = $this->currentProcess;
        $process1 = $this->currentStepProcess1;
        $process2 = $this->currentStepProcess2;

        //6 Processes
        //1. Desactivation Email
        //2. Reminder Email 5 days before Contract expiration

        if ($process == 1){
            
            $orders1 = $this->Step1;
            if ($orders1->count() > 0){
                
                foreach ($orders1 as $order) {
                    $order->deactivate();
                    $email = ShopOrderEmail::create($this->getConfig(),$order,$this->getConfig()->Email,$order->Email,$this->getConfig()->DesactivationEmailSubject,$this->getConfig()->DesactivationEmailBody);
                    $email->send();
                    $this->Step1 = $orders1->exclude('ID',$order->ID);
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

        if ($process == 2){
            
            $orders2 = $this->Step2;
            if ($orders2->count() > 0){
                
                foreach ($orders1 as $order) {
                    $email = ShopOrderEmail::create($this->getConfig(),$order,$this->getConfig()->Email,$order->Email,$this->getConfig()->CloseToDesactivationEmailSubject,$this->getConfig()->CloseToDesactivationEmailBody);
                    $email->send();
                    $this->Step2 = $orders2->exclude('ID',$order->ID);
                    $this->currentStepProcess2++;
                }
                
                if ($process2 == $this->totalProcess2){
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
         $this->currentStep++;
    }
}
