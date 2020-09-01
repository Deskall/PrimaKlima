<?php 

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;

class DeskallUploadImageExtension extends Extension
{


    public function onAfterLoadIntoFile($file){
        //Publish
        $file->publishSingle();
        if (Environment::getEnv('APP_OPTIMISE_TINY') && !$file->Optimised){
            //Optimise via TinyPNG API
            ob_start();
                        print_r('ici');
                        $result = ob_get_clean();
                        file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt", $result);
            $this->OptimiseImage(Director::absoluteURL($$file->getSourceURL()), $_SERVER['DOCUMENT_ROOT'].$file->getSourceURL());
            $file->Optimised = 1;
            $file->write();
            $file->publishSingle();
        }
    }


    //Optimise with tynigPNG

    public function OptimiseImage($url,$path){
        $optimiser = new DeskallImageOptimiser();
        $optimiser->Optimise($url,$path);
    }


}