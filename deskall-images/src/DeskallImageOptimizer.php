<?php

use SilverStripe\Core\Environment;

class DeskallImageOptimiser {
	public function getApiKey(){
		return Environment::getEnv('APP_TINYPNG_APIKEY');
	}

	public function Optimise($url, $path){
		try {
    		\Tinify\setKey($this->getApiKey());
			$source = \Tinify\fromUrl($url);
			$source->toFile($path);
		} catch(\Tinify\AccountException $e) {
		    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-tiny-image.txt","\n"."account: " . $e->getMessage(), FILE_APPEND);
		    // Verify your API key and account limit.
		} catch(\Tinify\ClientException $e) {
		    // Check your source image and request options.
		    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-tiny-image.txt","\n"."client: " . $e->getMessage(), FILE_APPEND);
		} catch(\Tinify\ServerException $e) {
		    // Temporary issue with the Tinify API.
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-tiny-image.txt","\n"."tiny server: " . $e->getMessage(), FILE_APPEND);
		} catch(\Tinify\ConnectionException $e) {
		    // A network connection error occurred.
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-tiny-image.txt","\n"."connection: " . $e->getMessage(), FILE_APPEND);
		} catch(Exception $e) {
		    // Something else went wrong, unrelated to the Tinify API.
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log-tiny-image.txt","\n"."other: " . $e->getMessage(), FILE_APPEND);
		}
	}
} 