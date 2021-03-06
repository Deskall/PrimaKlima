<?php
use SilverStripe\Core\Environment;

class DeskallImageOptimiser {

	public function Optimise($url, $path){
		$key = Environment::getEnv('APP_TINYPNG_APIKEY');
		try {
    		\Tinify\setKey($key);
			$source = \Tinify\fromUrl($url);
			$source->toFile($path);
		} catch(\Tinify\AccountException $e) {
		    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","\n"."account: " . $e->getMessage(), FILE_APPEND);
		    // Verify your API key and account limit.
		} catch(\Tinify\ClientException $e) {
		    // Check your source image and request options.
		    file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","\n"."client: " . $e->getMessage(), FILE_APPEND);
		} catch(\Tinify\ServerException $e) {
		    // Temporary issue with the Tinify API.
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","\n"."tiny server: " . $e->getMessage(), FILE_APPEND);
		} catch(\Tinify\ConnectionException $e) {
		    // A network connection error occurred.
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","\n"."connection: " . $e->getMessage(), FILE_APPEND);
		} catch(Exception $e) {
		    // Something else went wrong, unrelated to the Tinify API.
		     file_put_contents($_SERVER['DOCUMENT_ROOT']."/log.txt","\n"."other: " . $e->getMessage(), FILE_APPEND);
		}
	}
} 